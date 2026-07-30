<?php

namespace App\Jobs;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\WhatsappLog;
use App\Services\FonnteService;
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

    public function handle(FonnteService $fonnteService): void
    {
        $this->log->update(['status' => 'queued']);

        $phone = $this->guest->whatsapp_number ?? $this->guest->phone;

        if (! $phone) {
            $this->log->update([
                'status' => 'failed',
                'error_message' => 'Tamu tidak memiliki nomor telepon.',
            ]);

            return;
        }

        // Resolve token: prefer invitation's admin-verified wa_setting token, fallback to user setting
        $waSetting = $this->invitation->waSetting ?? $this->invitation->user?->waSetting;
        $token = ($waSetting && $waSetting->isConnected()) ? $waSetting->fonnte_token : null;

        if (! $token) {
            $this->log->update([
                'status' => 'failed',
                'error_message' => 'WhatsApp Gateway belum terhubung. Harap hubungi admin untuk verifikasi nomor WA Anda.',
            ]);

            return;
        }

        // Random delay 2–5 detik untuk pencegahan spam banning (sesuai PRD)
        sleep(rand(2, 5));

        try {
            $result = $fonnteService->sendMessage($token, $phone, $this->message);

            if ($fonnteService->isSuccessful($result)) {
                $this->log->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } else {
                $reason = $result['reason'] ?? 'Fonnte API tidak mengembalikan status sukses.';
                throw new \RuntimeException($reason);
            }
        } catch (\Throwable $e) {
            $this->log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            $this->fail($e);
        }
    }
}
