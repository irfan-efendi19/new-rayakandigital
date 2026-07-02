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
                return redirect()->route('dashboard.invitations.addons.index', $transaction->invitation)
                    ->with('success', 'Pembayaran berhasil! Add-on "' . $transaction->addon->name . '" sudah aktif.');
            }

            if ($transaction && $transaction->payment_status === 'pending') {
                if (!$midtransService->isSimulationMode()) {
                    $midtransService->checkAddonTransactionStatus($referenceOrderId);
                    $transaction->refresh();
                }

                if ($transaction->payment_status === 'settlement') {
                    return redirect()->route('dashboard.invitations.addons.index', $transaction->invitation)
                        ->with('success', 'Pembayaran berhasil! Add-on "' . $transaction->addon->name . '" sudah aktif.');
                }

                if ($transaction->payment_status === 'pending' && $transaction->payment_method === 'manual_bank') {
                    return redirect()->route('dashboard.invitations.addons.invoice', [$transaction->invitation, $transaction])
                        ->with('info', 'Silakan lakukan pembayaran dan kirim bukti transfer via WhatsApp.');
                }

                if ($transaction->payment_status === 'pending') {
                    return redirect()->route('dashboard.invitations.addons.index', $transaction->invitation)
                        ->with('info', 'Pembayaran masih menunggu. Silakan coba lagi atau hubungi dukungan.');
                }
            }

            if ($transaction && $transaction->payment_status === 'verifying') {
                return redirect()->route('dashboard.invitations.addons.invoice', [$transaction->invitation, $transaction])
                    ->with('info', 'Bukti transfer sedang diverifikasi oleh admin.');
            }

            if ($transaction && in_array($transaction->payment_status, ['deny', 'expire', 'cancel'])) {
                return redirect()->route('dashboard.invitations.addons.index', $transaction->invitation)
                    ->with('error', 'Pembayaran ' . $transaction->payment_status . '. Silakan coba beli add-on kembali.');
            }
        }

        return redirect()->route('dashboard.invitations.addons.index', $transaction?->invitation)
            ->with('info', 'Pembayaran sedang diproses. Add-on akan aktif setelah pembayaran dikonfirmasi.');
    }
}
