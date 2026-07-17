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
        $status = $request->query('status', 'unknown');
        $invoiceNumber = $request->query('invoice_number');

        if ($invoiceNumber) {
            $order = Order::where('order_id', $invoiceNumber)->first();

            if ($order && $order->payment_status === 'success') {
                return redirect()->route('dashboard.payment.doku.invoice', $order)
                    ->with('success', 'Pembayaran berhasil!');
            }

            if ($order && $status === 'SUCCESS' && $order->payment_status === 'pending') {
                $dokuService->processSuccessOrder($order);

                return redirect()->route('dashboard.payment.doku.invoice', $order)
                    ->with('success', 'Pembayaran berhasil!');
            }
        }

        if ($status === 'SUCCESS') {
            return redirect()->route('dashboard')
                ->with('success', 'Pembayaran berhasil diproses.');
        }

        return redirect()->route('dashboard')
            ->with('info', 'Pembayaran sedang diproses. Silakan tunggu konfirmasi.');
    }
}
