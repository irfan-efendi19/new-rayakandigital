<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GiftController extends Controller
{
    public function update(Request $request, Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        if (! $invitation->canUseGift()) {
            return back()->with('error', 'Fitur Kado Digital memerlukan minimal paket Silver.');
        }

        $validated = $request->validate([
            'gift_bank_name' => 'nullable|string|max:255',
            'gift_bank_account' => 'nullable|string|max:50',
            'gift_bank_holder' => 'nullable|string|max:255',
            'gift_ewallet_name' => 'nullable|string|max:255',
            'gift_ewallet_number' => 'nullable|string|max:50',
            'gift_qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gift_qris_image')) {
            $validated['gift_qris_image'] = $request->file('gift_qris_image')
                ->store('qris/' . $invitation->id, 'public');
        }

        $invitation->update($validated);

        return back()->with('success', 'Informasi kado digital berhasil disimpan.');
    }
}
