<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DokuPaymentController extends Controller
{
    /**
     * Show DOKU invoice/Virtual Account details.
     */
    public function showInvoice(Order $order, \App\Services\DokuService $dokuService)
    {
        abort_if($order->payment_method_used !== 'doku', 404);
        abort_if($order->user_id !== request()->user()->id && !request()->user()->isAdmin(), 403);

        if ($order->snap_token && filter_var($order->snap_token, FILTER_VALIDATE_URL)) {
            return redirect()->away($order->snap_token);
        }

        $checkoutUrl = $dokuService->createCheckoutUrl($order);
        if ($checkoutUrl) {
            return redirect()->away($checkoutUrl);
        }

        return redirect()->route('dashboard')->with('error', 'Konfigurasi DOKU belum valid atau terjadi masalah jaringan. Silakan hubungi admin.');
    }
}
