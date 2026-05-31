<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function notification(Request $request, MidtransService $midtransService)
    {
        $payload = $request->all();

        $subscription = $midtransService->handleNotification($payload);

        if (! $subscription) {
            return response()->json(['status' => 'error', 'message' => 'Subscription not found'], 404);
        }

        return response()->json(['status' => 'ok']);
    }

    public function finish(Request $request, MidtransService $midtransService)
    {
        $orderId = $request->query('order_id');

        if ($orderId) {
            $subscription = Subscription::where('midtrans_order_id', $orderId)->first();

            if ($subscription && $subscription->payment_status === 'settlement') {
                return redirect()->route('dashboard')
                    ->with('success', 'Pembayaran berhasil! Paket ' . ucfirst($subscription->tier) . ' Anda sudah aktif.');
            }

            if ($subscription && $subscription->payment_status === 'pending') {
                $updated = $midtransService->checkTransactionStatus($orderId);

                if ($updated && $updated->payment_status === 'settlement') {
                    return redirect()->route('dashboard')
                        ->with('success', 'Pembayaran berhasil! Paket ' . ucfirst($updated->tier) . ' Anda sudah aktif.');
                }
            }
        }

        return redirect()->route('dashboard')
            ->with('info', 'Pembayaran sedang diproses. Fitur premium akan aktif setelah pembayaran dikonfirmasi.');
    }
}
