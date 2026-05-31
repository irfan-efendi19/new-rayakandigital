<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsappMessage;
use App\Models\Guest;
use App\Models\Invitation;
use App\Models\WhatsappLog;
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

        $guests = Guest::whereIn('id', $validated['guest_ids'])
            ->where('invitation_id', $invitation->id)
            ->whereNotNull('phone')
            ->get();

        if ($guests->isEmpty()) {
            return back()->with('error', 'Tidak ada tamu dengan nomor telepon yang dipilih.');
        }

        $dispatched = 0;
        foreach ($guests as $guest) {
            $message = $invitation->parseWhatsappTemplate($guest);

            $log = WhatsappLog::create([
                'invitation_id' => $invitation->id,
                'guest_id' => $guest->id,
                'message_content' => $message,
                'status' => 'pending',
            ]);

            SendWhatsappMessage::dispatch($log, $invitation, $guest, $message)
                ->delay(now()->addSeconds($dispatched * 3));

            $dispatched++;
        }

        return back()->with('success', "{$dispatched} pesan sedang diproses di latar belakang.");
    }

    public function sendSingle(Request $request, Invitation $invitation, Guest $guest)
    {
        Gate::authorize('update', $invitation);

        if (!$guest->phone) {
            return back()->with('error', 'Tamu ini tidak memiliki nomor telepon.');
        }

        $message = $invitation->parseWhatsappTemplate($guest);

        $log = WhatsappLog::create([
            'invitation_id' => $invitation->id,
            'guest_id' => $guest->id,
            'message_content' => $message,
            'status' => 'pending',
        ]);

        SendWhatsappMessage::dispatch($log, $invitation, $guest, $message);

        return back()->with('success', "Pesan WA untuk {$guest->name} sedang diproses.");
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

        $invitation->update($validated);

        return back()->with('success', 'Template pesan WhatsApp berhasil diperbarui.');
    }
}
