<?php

namespace App\Jobs;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\WhatsappGatewaySetting;
use App\Models\WhatsappLog;
use App\Services\WhatsAppNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $backoff = 300;

    public function __construct(
        public WhatsappLog $log,
        public Invitation $invitation,
        public Guest $guest,
        public string $message,
    ) {}

    public function handle(WhatsAppNotificationService $service): void
    {
        $this->log->update(['status' => 'queued']);

        $gateway = WhatsappGatewaySetting::active()->first();

        if (!$gateway) {
            $this->log->update([
                'status' => 'failed',
                'error_message' => 'No active WhatsApp gateway configured.',
            ]);
            return;
        }

        $phone = $this->guest->phone;

        if (!$phone) {
            $this->log->update([
                'status' => 'failed',
                'error_message' => 'Guest has no phone number.',
            ]);
            return;
        }

        $sent = $service->sendViaGateway($phone, $this->message, $gateway);

        if ($sent) {
            $this->log->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } else {
            $this->log->update([
                'status' => 'failed',
                'error_message' => 'API request failed.',
            ]);
            $this->fail(new \RuntimeException('WhatsApp API request failed'));
        }
    }
}
