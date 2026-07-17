<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DokuService;
use Illuminate\Http\Request;

class DokuWebhookController extends Controller
{
    /**
     * Handle incoming DOKU Virtual Account payment notification.
     *
     * DOKU calls this endpoint when a customer successfully pays a VA.
     */
    public function handleWebhook(Request $request, DokuService $dokuService)
    {
        logger()->info('DOKU webhook received', $request->all());

        // Simpan log ke public/doku-log.json agar bisa dilihat via browser
        file_put_contents(public_path('doku-log.json'), json_encode([
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'signature_valid' => $dokuService->testSignature($request), // We need to add testSignature to DokuService to not fail the actual process
        ], JSON_PRETTY_PRINT));

        $order = $dokuService->handleNotification($request);

        if (! $order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Handle DOKU Checkout redirect callback after payment.
     */
    public function callback(Request $request, DokuService $dokuService)
    {
        logger()->info('DOKU callback received', [
            'query' => $request->query->all(),
            'session_order' => session('doku_pending_order'),
        ]);

        $invoiceNumber = $request->query('invoice_number')
            ?? $request->query('invoice')
            ?? $request->query('order_id')
            ?? session('doku_pending_order');

        $order = null;

        if ($invoiceNumber) {
            $order = Order::where('order_id', $invoiceNumber)->first();
        }

        if (!$order) {
            $order = Order::where('payment_method_used', 'doku')
                ->where('payment_status', 'pending')
                ->latest()
                ->first();
        }

        if ($order && $order->payment_status === 'pending') {
            $dokuService->processSuccessOrder($order);
            session()->forget('doku_pending_order');
        }

        logger()->info('DOKU callback processed', [
            'order_id' => $order?->order_id,
            'payment_status' => $order?->payment_status,
            'found' => $order !== null,
        ]);

        return redirect()->route('home')
            ->with(
                $order && $order->payment_status === 'success'
                    ? 'success'
                    : 'info',
                $order && $order->payment_status === 'success'
                    ? 'Pembayaran berhasil! Silakan login untuk melihat detail pesanan.'
                    : 'Pembayaran sedang diproses. Silakan cek kembali nanti.'
            );
    }
}
