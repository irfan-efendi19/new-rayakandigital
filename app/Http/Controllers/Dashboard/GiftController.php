<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GiftController extends Controller
{
    public function update(Request $request, Invitation $invitation, ImageCompressionService $compressor)
    {
        Gate::authorize('update', $invitation);

        if (! $invitation->canUseGift()) {
            return back()->with('error', 'Fitur Kado Digital memerlukan minimal paket Silver.');
        }

        $maxAccounts = $invitation->maxGiftAccounts();

        $validated = $request->validate([
            'gift_banks' => 'nullable|array',
            'gift_banks.*.bank_name' => 'required|string|max:255',
            'gift_banks.*.account_number' => 'required|string|max:50',
            'gift_banks.*.account_holder' => 'nullable|string|max:255',
            'gift_ewallets' => 'nullable|array',
            'gift_ewallets.*.wallet_name' => 'required|string|max:255',
            'gift_ewallets.*.wallet_number' => 'required|string|max:50',
            'gift_qris_image' => 'nullable|image',
        ]);

        if (!$request->has('gift_banks')) {
            $validated['gift_banks'] = [];
        }

        if (!$request->has('gift_ewallets')) {
            $validated['gift_ewallets'] = [];
        }

        $totalAccounts = count($validated['gift_banks']) + count($validated['gift_ewallets']);

        if ($totalAccounts > $maxAccounts) {
            return back()->with('error', 'Maksimal ' . $maxAccounts . ' akun kado digital untuk paket Anda.');
        }

        if ($request->hasFile('gift_qris_image')) {
            $validated['gift_qris_image'] = $compressor->compress(
                $request->file('gift_qris_image'),
                'qris/' . $invitation->id
            );
        }

        $invitation->update($validated);

        return back()->with('success', 'Informasi kado digital berhasil disimpan.');
    }
}
