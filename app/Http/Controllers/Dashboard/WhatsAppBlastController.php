<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsappMessage;
use App\Models\Guest;
use App\Models\Invitation;
use App\Models\WhatsappLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $waSetting = $invitation->waSetting ?? $invitation->user?->waSetting;

        if (! $waSetting || ! $waSetting->isConnected()) {
            return back()->with('error', 'WhatsApp Gateway belum terhubung. Pastikan nomor WA Anda sudah diverifikasi admin dan berstatus CONNECTED.');
        }

        $reservation = DB::transaction(function () use ($invitation, $guests) {
            $locked = Invitation::whereKey($invitation->id)->lockForUpdate()->first();

            if ($locked->isWaQuotaExhausted()) {
                return null;
            }

            $dispatchable = $guests;
            $skippedCount = 0;
            $remaining = $locked->remainingWaQuota();

            if ($remaining !== null && $guests->count() > $remaining) {
                $skippedCount = $guests->count() - $remaining;
                $dispatchable = $guests->take($remaining);
            }

            $locked->increment('wa_sent_count', $dispatchable->count());

            return compact('dispatchable', 'skippedCount');
        });

        if ($reservation === null) {
            return back()->with('error', 'Kuota WA Blast Habis. Hubungi admin untuk menambah kuota WA Blast Anda.');
        }

        $queuedCount = 0;

        foreach ($reservation['dispatchable'] as $guest) {
            $message = $invitation->parseWhatsappTemplate($guest);

            $log = WhatsappLog::create([
                'invitation_id' => $invitation->id,
                'guest_id' => $guest->id,
                'message_content' => $message,
                'status' => 'pending',
            ]);

            SendWhatsappMessage::dispatch($log, $invitation, $guest, $message);
            $queuedCount++;
        }

        $invitation->refresh();

        $message = "{$queuedCount} pesan WhatsApp berhasil dimasukkan ke dalam antrean pengiriman.";

        if ($reservation['skippedCount'] > 0) {
            $message .= " {$reservation['skippedCount']} tamu dilewati karena kuota tidak mencukupi.";
        }

        $message .= $invitation->hasWaQuotaLimit()
            ? " Sisa kuota: {$invitation->remainingWaQuota()} dari {$invitation->waQuotaLimit()}."
            : ' Kuota WA Blast Anda tidak terbatas.';

        return back()->with('success', $message);
    }

    public function sendSingle(Request $request, Invitation $invitation, Guest $guest)
    {
        Gate::authorize('update', $invitation);

        $phone = $guest->whatsapp_number ?? $guest->phone;

        if (! $phone) {
            return back()->with('error', 'Tamu ini tidak memiliki nomor telepon.');
        }

        if (! $guest->relationLoaded('invitation')) {
            $guest->load('invitation');
        }

        $waSetting = $invitation->waSetting ?? $invitation->user?->waSetting;

        if (! $waSetting || ! $waSetting->isConnected()) {
            return back()->with('error', 'WhatsApp Gateway belum terhubung. Pastikan nomor WA Anda sudah diverifikasi admin dan berstatus CONNECTED.');
        }

        $reservation = DB::transaction(function () use ($invitation) {
            $locked = Invitation::whereKey($invitation->id)->lockForUpdate()->first();

            if ($locked->isWaQuotaExhausted()) {
                return null;
            }

            $locked->increment('wa_sent_count');

            return $locked;
        });

        if ($reservation === null) {
            return back()->with('error', 'Kuota WA Blast Habis. Hubungi admin untuk menambah kuota WA Blast Anda.');
        }

        $message = $invitation->parseWhatsappTemplate($guest);

        $log = WhatsappLog::create([
            'invitation_id' => $invitation->id,
            'guest_id' => $guest->id,
            'message_content' => $message,
            'status' => 'pending',
        ]);

        SendWhatsappMessage::dispatch($log, $invitation, $guest, $message);

        return back()->with('success', "Pesan WA untuk {$guest->name} berhasil dimasukkan ke antrean.");
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
