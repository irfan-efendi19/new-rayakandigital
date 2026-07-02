<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\AddonTransaction;
use App\Models\Invitation;
use App\Models\PaymentMethodConfig;
use App\Services\MidtransService;
use App\Services\PaymentRoutingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AddonController extends Controller
{
    public function index(Invitation $invitation, PaymentRoutingService $routing)
    {
        Gate::authorize('view', $invitation);

        $invitation->load('addons');

        $availableAddons = Addon::where('is_available', true)->get();

        $pendingTransactions = AddonTransaction::where('invitation_id', $invitation->id)
            ->whereIn('payment_status', ['pending', 'verifying'])
            ->with('addon')
            ->get()
            ->keyBy('addon_id');

        $paymentMethod = $routing->activeMethod();
        $clientKey = config('midtrans.client_key');

        try {
            $methodConfig = PaymentMethodConfig::getActive();
            if ($methodConfig && $methodConfig->isMidtrans() && !empty($methodConfig->midtrans_client_key)) {
                $clientKey = $methodConfig->midtrans_client_key;
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return view('dashboard.addons.index', compact('invitation', 'availableAddons', 'pendingTransactions', 'paymentMethod', 'clientKey'));
    }

    public function purchase(Request $request, Invitation $invitation, Addon $addon, MidtransService $midtransService, PaymentRoutingService $routing)
    {
        Gate::authorize('update', $invitation);

        $existingPivot = $invitation->addons()->where('addon_id', $addon->id)->first();
        if ($existingPivot) {
            return back()->with('error', 'Add-on sudah dimiliki undangan ini.');
        }

        $referenceOrderId = 'ADDON-' . strtoupper(Str::random(8)) . '-' . $invitation->id . '-' . $addon->id;
        $price = (int) $addon->price;

        $paymentMethod = $routing->activeMethod();

        $transaction = AddonTransaction::create([
            'reference_order_id' => $referenceOrderId,
            'invitation_id' => $invitation->id,
            'addon_id' => $addon->id,
            'amount' => $price,
            'payment_status' => 'pending',
            'payment_method' => $paymentMethod,
        ]);

        if ($paymentMethod === 'midtrans') {
            $email = filter_var($request->user()->email, FILTER_VALIDATE_EMAIL)
                ? $request->user()->email
                : 'user-' . $request->user()->id . '@rayakandigital.com';

            $params = [
                'transaction_details' => [
                    'order_id' => $referenceOrderId,
                    'gross_amount' => $price,
                ],
                'customer_details' => [
                    'first_name' => $request->user()->name,
                    'email' => $email,
                ],
                'item_details' => [
                    [
                        'id' => 'ADDON-' . $addon->id,
                        'price' => $price,
                        'quantity' => 1,
                        'name' => $addon->name . ' - Rayakan Digital',
                    ],
                ],
            ];

            $snapToken = null;
            if (!$midtransService->isSimulationMode()) {
                try {
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                } catch (\Throwable $e) {
                    logger()->error('Gagal buat Snap token untuk addon: ' . $e->getMessage());
                }
            }

            if (!$snapToken) {
                $snapToken = 'SIMULATION_TOKEN_' . $referenceOrderId;
            }

            $transaction->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken,
                'reference_order_id' => $referenceOrderId,
            ]);
        }

        return redirect()->route('dashboard.invitations.addons.invoice', [$invitation, $transaction])
            ->with('success', 'Silakan lakukan pembayaran dan kirim bukti transfer via WhatsApp.');
    }

    public function invoice(Invitation $invitation, AddonTransaction $transaction, PaymentRoutingService $routing)
    {
        Gate::authorize('view', $invitation);

        if ($transaction->invitation_id !== $invitation->id) {
            abort(404);
        }

        if ($transaction->payment_status !== 'pending') {
            return redirect()->route('dashboard.invitations.addons.index', $invitation)
                ->with('info', 'Transaksi ini sudah tidak dalam status pending.');
        }

        return view('dashboard.addons.invoice', compact('invitation', 'transaction', 'routing'));
    }

    public function sendWhatsApp(Request $request, Invitation $invitation, AddonTransaction $transaction, PaymentRoutingService $routing)
    {
        Gate::authorize('update', $invitation);

        if ($transaction->invitation_id !== $invitation->id) {
            abort(404);
        }

        if ($transaction->payment_status !== 'pending') {
            return back()->with('warning', 'Transaksi ini sudah tidak dalam status pending.');
        }

        if (empty($routing->getAdminWhatsappNumber())) {
            return back()->with('warning', 'Nomor WhatsApp platform belum dikonfigurasi oleh admin.');
        }

        $transaction->update(['payment_status' => 'verifying']);

        $user = $request->user();
        $phone = $routing->getAdminWhatsappNumber();

        $message = sprintf(
            "Halo Admin, saya ingin melakukan konfirmasi pembayaran manual untuk pembelian Add-On:\n\n* ID Transaksi: %s\n* Nama Pengguna: %s\n* Add-On: %s\n* Total Transfer: Rp%s\n\nBerikut saya lampirkan foto bukti transfernya.",
            $transaction->reference_order_id,
            $user->name,
            $transaction->addon->name,
            number_format((int) $transaction->amount, 0, ',', '.')
        );

        $waUrl = 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . urlencode($message);

        return redirect()->away($waUrl);
    }

    public function activate(Invitation $invitation, Addon $addon)
    {
        Gate::authorize('update', $invitation);

        $pivot = $invitation->addons()->where('addon_id', $addon->id)->first();

        if (!$pivot) {
            return back()->with('error', 'Add-on belum dimiliki. Silakan lakukan pembelian terlebih dahulu.');
        }

        $invitation->addons()->updateExistingPivot($addon->id, [
            'status_active' => true,
            'activated_at' => now(),
        ]);

        return back()->with('success', 'Add-on berhasil diaktifkan.');
    }

    public function deactivate(Invitation $invitation, Addon $addon)
    {
        Gate::authorize('update', $invitation);

        $invitation->addons()->updateExistingPivot($addon->id, [
            'status_active' => false,
            'activated_at' => null,
        ]);

        return back()->with('success', 'Add-on berhasil dinonaktifkan.');
    }
}
