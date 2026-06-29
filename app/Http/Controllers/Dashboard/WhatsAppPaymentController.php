<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaymentRoutingService;
use Illuminate\Http\Request;

class WhatsAppPaymentController extends Controller
{
    public function showInvoice(Request $request, Order $order, PaymentRoutingService $routing)
    {
        if ($order->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            abort(403);
        }

        return view('dashboard.payment.invoice', compact('order', 'routing'));
    }

    public function sendWhatsApp(Request $request, Order $order, PaymentRoutingService $routing)
    {
        if ($order->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            abort(403);
        }

        if ($order->payment_status !== 'pending') {
            return back()->with('warning', 'Pesanan ini sudah tidak dalam status pending.');
        }

        if (empty($routing->getAdminWhatsappNumber())) {
            return back()->with('warning', 'Nomor WhatsApp platform belum dikonfigurasi oleh admin.');
        }

        $order->update(['payment_status' => 'verifying']);

        $user = $order->user;
        $packageLabel = ucfirst($order->package_type);
        $phone = $routing->getAdminWhatsappNumber();

        $message = sprintf(
            "Halo Admin, saya ingin melakukan konfirmasi pembayaran manual untuk pesanan:\n\n* ID Invoice: %s\n* Nama Pengguna: %s\n* Paket: %s\n* Total Transfer: Rp%s\n\nBerikut saya lampirkan foto bukti transfernya.",
            $order->invoice_id,
            $user->name,
            $packageLabel,
            $order->total_with_code
        );

        $waUrl = 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . urlencode($message);

        return redirect()->away($waUrl);
    }
}
