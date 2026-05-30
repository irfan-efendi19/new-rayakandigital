<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use App\Models\PaymentMethodConfig;
use App\Services\MidtransService;
use App\Services\PaymentRoutingService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request, PaymentRoutingService $routing)
    {
        $user = $request->user();
        $currentTier = $user->currentTier();
        $activeMethod = $routing->activeMethod();
        $packages = Package::with('features')
            ->where('is_visible', true)
            ->where('package_code', '!=', 'free')
            ->orderBy('sort_order')
            ->get();

        return view('dashboard.checkout.index', compact('currentTier', 'packages', 'activeMethod'));
    }

    public function process(Request $request, MidtransService $midtransService, PaymentRoutingService $routing)
    {
        $validated = $request->validate([
            'tier' => 'required|string|exists:packages,package_code',
            'invitation_id' => 'nullable|exists:invitations,id',
        ]);

        $user = $request->user();
        $tier = $validated['tier'];

        $currentTier = $user->currentTier();
        $tierRank = Package::where('is_visible', true)->pluck('sort_order', 'package_code');

        $currentRank = $tierRank[$currentTier] ?? -1;
        $selectedRank = $tierRank[$tier] ?? -1;

        if ($currentRank >= $selectedRank) {
            return back()->with('info', 'Anda sudah memiliki paket ' . ucfirst($currentTier) . ' yang setara atau lebih tinggi.');
        }

        $invitationId = $validated['invitation_id'] ?? $user->invitations()->first()?->id;

        if ($routing->isMidtrans()) {
            return $this->processMidtrans($user, $tier, $invitationId, $midtransService);
        }

        return $this->processManualBank($user, $tier, $invitationId, $midtransService);
    }

    protected function processMidtrans($user, $tier, $invitationId, MidtransService $midtransService)
    {
        $result = $midtransService->createSnapToken($user, $tier);

        $order = Order::create([
            'order_id' => $result['order_id'],
            'user_id' => $user->id,
            'invitation_id' => $invitationId,
            'package_type' => $tier,
            'payment_method_used' => 'midtrans',
            'gross_amount' => $result['gross_amount'] ?? $midtransService->getPrice($tier),
            'payment_status' => 'pending',
            'payment_gateway_used' => $midtransService->isSimulationMode() ? null : 'midtrans',
            'snap_token' => $result['snap_token'] ?? null,
        ]);

        if ($midtransService->isSimulationMode()) {
            $midtransService->simulatePayment($result['order_id']);
            $order->update(['payment_status' => 'success']);

            return redirect()->route('dashboard')
                ->with('success', 'Paket ' . ucfirst($tier) . ' berhasil diaktifkan! (Mode Simulasi)');
        }

        return response()->json([
            'snap_token' => $result['snap_token'],
            'order_id' => $result['order_id'],
        ]);
    }

    protected function processManualBank($user, $tier, $invitationId, MidtransService $midtransService)
    {
        $price = $midtransService->getPrice($tier);
        $uniqueCode = Order::generateUniqueCode();

        $order = Order::create([
            'order_id' => 'INV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
            'user_id' => $user->id,
            'invitation_id' => $invitationId,
            'package_type' => $tier,
            'payment_method_used' => 'manual_bank',
            'gross_amount' => $price,
            'unique_code' => $uniqueCode,
            'payment_status' => 'pending',
            'payment_gateway_used' => 'manual_bank',
            'is_manual_whatsapp' => true,
        ]);

        return redirect()->route('dashboard.payment.invoice', $order)
            ->with('success', 'Silakan lakukan pembayaran dan kirim bukti transfer via WhatsApp.');
    }
}
