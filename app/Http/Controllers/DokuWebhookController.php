<?php

namespace App\Http\Controllers;

use App\Models\AddonTransaction;
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
            'session_addon' => session('doku_pending_addon'),
        ]);

        $invoiceNumber = $request->query('invoice_number')
            ?? $request->query('invoice')
            ?? $request->query('order_id')
            ?? session('doku_pending_order');

        $addonReferenceId = $request->query('reference_order_id')
            ?? session('doku_pending_addon');

        $order = null;
        $addonTransaction = null;

        if ($invoiceNumber) {
            $order = Order::where('order_id', $invoiceNumber)->first();
        }

        if (!$order && $addonReferenceId) {
            $addonTransaction = AddonTransaction::where('reference_order_id', $addonReferenceId)->first();
        }

        session()->forget(['doku_pending_order', 'doku_pending_addon']);

        $orderSuccess = $order && $order->payment_status === 'success';
        $addonSuccess = $addonTransaction && $addonTransaction->payment_status === 'settlement';

        logger()->info('DOKU callback processed', [
            'order_id' => $order?->order_id,
            'addon_id' => $addonTransaction?->reference_order_id,
            'order_status' => $order?->payment_status,
            'addon_status' => $addonTransaction?->payment_status,
            'order_success' => $orderSuccess,
            'addon_success' => $addonSuccess,
        ]);

        if ($orderSuccess) {
            if ($order->invitation) {
                return redirect()->route('dashboard.invitations.show', $order->invitation)
                    ->with('success', 'Pembayaran berhasil! Paket sudah aktif.');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Pembayaran berhasil!');
        }

        if ($addonSuccess) {
            if ($addonTransaction->invitation) {
                return redirect()->route('dashboard.invitations.addons.index', $addonTransaction->invitation)
                    ->with('success', 'Pembayaran berhasil! Add-on sudah aktif.');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Pembayaran berhasil!');
        }

        return redirect()->route('login')
            ->with('info', 'Pembayaran sedang diproses. Silakan cek kembali nanti.');
    }
}
