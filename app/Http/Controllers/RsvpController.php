<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RsvpController extends Controller
{
    public function store(Request $request, Invitation $invitation)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'attendance' => 'required|in:attending,not_attending,uncertain',
            'pax' => 'required|integer|min:1|max:50',
        ]);

        if ($invitation->isRsvpPaxLimited()) {
            $maxPaxPerGuest = $invitation->max_pax_per_guest ?? 2;

            if ($validated['pax'] > $maxPaxPerGuest) {
                throw ValidationException::withMessages([
                    'pax' => 'Jumlah rombongan maksimal ' . $maxPaxPerGuest . ' orang per tamu.',
                ]);
            }

            if ($validated['attendance'] === 'attending') {
                $currentTotal = $invitation->totalAcceptedPax();
                $remaining = $invitation->remainingGlobalQuota();

                if ($remaining <= 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maaf, kuota kehadiran sudah penuh. Silakan hubungi pemilik undangan.',
                    ], 422);
                }

                if ($validated['pax'] > $remaining) {
                    throw ValidationException::withMessages([
                        'pax' => 'Sisa kuota hanya ' . $remaining . ' orang. Silakan kurangi jumlah rombongan.',
                    ]);
                }
            }
        }

        $existing = $invitation->rsvps()->where('guest_name', $validated['guest_name'])->first();

        if ($existing) {
            $existing->update($validated);
        } else {
            $invitation->rsvps()->create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas konfirmasi kehadiran Anda.',
        ]);
    }
}
