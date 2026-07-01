<?php

namespace App\Http\Controllers;

use App\Models\AddonTransaction;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class AddonPaymentController extends Controller
{
    public function finish(Request $request, MidtransService $midtransService)
    {
        $referenceOrderId = $request->query('reference_order_id');

        if ($referenceOrderId) {
            $transaction = AddonTransaction::where('reference_order_id', $referenceOrderId)->first();

            if ($transaction && $transaction->payment_status === 'settlement') {
                $invitation = $transaction->invitation;

                return redirect()->route('dashboard.invitations.addons.index', $invitation)
                    ->with('success', 'Pembayaran berhasil! Add-on "' . $transaction->addon->name . '" sudah aktif.');
            }

            if ($transaction && $transaction->payment_status === 'pending') {
                $midtransService->checkAddonTransactionStatus($referenceOrderId);
                $transaction->refresh();

                if ($transaction->payment_status === 'settlement') {
                    return redirect()->route('dashboard.invitations.addons.index', $transaction->invitation)
                        ->with('success', 'Pembayaran berhasil! Add-on "' . $transaction->addon->name . '" sudah aktif.');
                }
            }
        }

        return redirect()->route('dashboard')
            ->with('info', 'Pembayaran sedang diproses. Add-on akan aktif setelah pembayaran dikonfirmasi.');
    }
}
