<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use App\Models\WhatsappGatewaySetting;
use App\Models\WhatsappLog;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WhatsAppBlastController extends Controller
{
    public function send(Request $request, Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'guest_ids' => 'required|array',
            'guest_ids.*' => 'exists:guests,id',
        ]);

        $guests = Guest::with('invitation')
            ->whereIn('id', $validated['guest_ids'])
            ->where('invitation_id', $invitation->id)
            ->where(function ($q) {
                $q->whereNotNull('whatsapp_number')->orWhereNotNull('phone');
            })
            ->get();

        if ($guests->isEmpty()) {
            return back()->with('error', 'Tidak ada tamu dengan nomor telepon yang dipilih.');
        }

        $gateway = WhatsappGatewaySetting::active()->first();

        if (!$gateway) {
            return back()->with('error', 'Tidak ada gateway WhatsApp aktif. Konfigurasi di admin terlebih dahulu.');
        }

        $service = app(WhatsAppNotificationService::class);
        $sent = 0;
        $failed = 0;

        foreach ($guests as $guest) {
            $message = $invitation->parseWhatsappTemplate($guest);

            $log = WhatsappLog::create([
                'invitation_id' => $invitation->id,
                'guest_id' => $guest->id,
                'message_content' => $message,
                'status' => 'pending',
            ]);

            try {
                $service->sendViaGateway($guest->whatsapp_number ?? $guest->phone, $message, $gateway);

                $log->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
                $sent++;
            } catch (\Throwable $e) {
                $log->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
                $failed++;
            }

            if (count($guests) > 1) {
                usleep(300000);
            }
        }

        $msg = "{$sent} pesan berhasil dikirim.";
        if ($failed > 0) {
            $msg .= " {$failed} pesan gagal.";
        }

        return back()->with('success', $msg);
    }

    public function sendSingle(Request $request, Invitation $invitation, Guest $guest)
    {
        Gate::authorize('update', $invitation);

        if (!$guest->whatsapp_number && !$guest->phone) {
            return back()->with('error', 'Tamu ini tidak memiliki nomor telepon.');
        }

        if (!$guest->relationLoaded('invitation')) {
            $guest->load('invitation');
        }

        $gateway = WhatsappGatewaySetting::active()->first();

        if (!$gateway) {
            return back()->with('error', 'Tidak ada gateway WhatsApp aktif. Konfigurasi di admin terlebih dahulu.');
        }

        $message = $invitation->parseWhatsappTemplate($guest);

        $log = WhatsappLog::create([
            'invitation_id' => $invitation->id,
            'guest_id' => $guest->id,
            'message_content' => $message,
            'status' => 'pending',
        ]);

        try {
            app(WhatsAppNotificationService::class)
                ->sendViaGateway($guest->whatsapp_number ?? $guest->phone, $message, $gateway);

            $log->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return back()->with('success', "Pesan WA untuk {$guest->name} berhasil dikirim.");
        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            return back()->with('error', "Gagal: {$e->getMessage()}");
        }
    }

    public function logs(Request $request, Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        $logs = WhatsappLog::where('invitation_id', $invitation->id)
            ->with('guest')
            ->latest()
            ->paginate(20);

        return view('dashboard.whatsapp.logs', compact('invitation', 'logs'));
    }

    public function template(Request $request, Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'wa_template_enabled' => 'boolean',
            'wa_message_template' => 'nullable|string',
        ]);

        $invitation->update(array_merge($validated, ['is_active' => true]));

        return back()->with('success', 'Template pesan WhatsApp berhasil diperbarui.');
    }
}
