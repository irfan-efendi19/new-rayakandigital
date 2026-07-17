<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Package;
use App\Models\PaymentMethodConfig;
use App\Models\Subscription;
use App\Services\DokuService;
use App\Services\MidtransService;
use App\Services\PaymentRoutingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request, PaymentRoutingService $routing)
    {
        $user = $request->user();
        $activeMethod = $routing->activeMethod();
        $packages = Package::with('features')
            ->where('is_visible', true)
            ->where('package_code', '!=', 'free')
            ->orderBy('sort_order')
            ->get();

        $invitationId = $request->query('invitation_id');
        $invitation = null;
        if ($invitationId) {
            $invitation = $user->isAdmin()
                ? Invitation::find($invitationId)
                : $user->invitations()->find($invitationId);
            abort_unless($invitation, 404);
        }

        $currentTier = $invitation ? $invitation->currentTier() : 'free';

        $clientKey = config('midtrans.client_key');
        try {
            $methodConfig = PaymentMethodConfig::getActive();
            if ($methodConfig && $methodConfig->isMidtrans() && ! empty($methodConfig->midtrans_client_key)) {
                $clientKey = $methodConfig->midtrans_client_key;
            }
        } catch (\Throwable $e) {
            // fallback
        }

        $dokuConfigured = false;
        if ($routing->isDoku()) {
            $dokuConfigured = app(DokuService::class)->isDokuConfigured();
        }

        return view('dashboard.checkout.index', compact('currentTier', 'packages', 'activeMethod', 'clientKey', 'invitation', 'dokuConfigured'));
    }

    public function process(Request $request, MidtransService $midtransService, PaymentRoutingService $routing)
    {
        $validated = $request->validate([
            'tier' => 'required|string|exists:packages,package_code',
            'invitation_id' => 'nullable|integer|exists:invitations,id',
        ]);

        $user = $request->user();
        $tier = $validated['tier'];
        $isAdmin = $user->isAdmin();

        $invitationId = $validated['invitation_id'] ?? (
            $isAdmin ? Invitation::first()?->id : $user->invitations()->first()?->id
        );

        if ($invitationId) {
            $ownsInvitation = $isAdmin
                ? Invitation::where('id', $invitationId)->exists()
                : $user->invitations()->where('id', $invitationId)->exists();
            abort_if(! $ownsInvitation, 403);
        }

        $invitation = $invitationId ? (
            $isAdmin ? Invitation::find($invitationId) : $user->invitations()->find($invitationId)
        ) : null;
        $currentTier = $invitation ? $invitation->currentTier() : 'free';
        $tierRank = Package::where('is_visible', true)->pluck('sort_order', 'package_code');

        $currentRank = $tierRank[$currentTier] ?? -1;
        $selectedRank = $tierRank[$tier] ?? -1;

        if ($currentRank >= $selectedRank) {
            return back()->with('info', 'Undangan ini sudah memiliki paket '.ucfirst($currentTier).' yang setara atau lebih tinggi.');
        }

        $this->cancelPendingOrders($invitationId, $midtransService);

        if ($routing->isMidtrans()) {
            return $this->processMidtrans($user, $tier, $invitationId, $midtransService);
        }

        if ($routing->isDoku()) {
            $dokuService = app(DokuService::class);

            return $this->processDoku($user, $tier, $invitationId, $dokuService, $request);
        }

        return $this->processManualBank($user, $tier, $invitationId, $midtransService);
    }

    protected function processMidtrans($user, $tier, $invitationId, MidtransService $midtransService)
    {
        $result = $midtransService->createSnapToken($user, $tier);

        $order = DB::transaction(function () use ($result, $user, $tier, $invitationId, $midtransService) {
            return Order::create([
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
        });

        if ($midtransService->isSimulationMode()) {
            $midtransService->simulatePayment($result['order_id']);
            $order->update(['payment_status' => 'success']);
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

        $order = DB::transaction(function () use ($user, $tier, $invitationId, $price, $uniqueCode) {
            return Order::create([
                'order_id' => 'RD-'.now()->format('Ymd').'-'.$user->id.'-'.Str::upper(Str::random(4)),
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
        });

        return redirect()->route('dashboard.payment.invoice', $order)
            ->with('success', 'Silakan lakukan pembayaran dan kirim bukti transfer via WhatsApp.');
    }

    protected function processDoku($user, $tier, $invitationId, DokuService $dokuService, Request $request)
    {
        $midtransService = app(MidtransService::class);
        $price = $midtransService->getPrice($tier);
        $uniqueCode = Order::generateUniqueCode();

        $order = DB::transaction(function () use ($user, $tier, $invitationId, $price) {
            return Order::create([
                'order_id' => 'RD-'.now()->format('Ymd').'-'.$user->id.'-'.Str::upper(Str::random(4)),
                'user_id' => $user->id,
                'invitation_id' => $invitationId,
                'package_type' => $tier,
                'payment_method_used' => 'doku',
                'gross_amount' => $price,
                'unique_code' => 0, // DOKU Checkout does not need unique code
                'payment_status' => 'pending',
                'payment_gateway_used' => 'doku',
            ]);
        });

        // Also create subscription
        Subscription::create([
            'user_id' => $user->id,
            'tier' => $tier,
            'midtrans_order_id' => $order->order_id,
            'payment_status' => 'pending',
            'amount' => $price,
        ]);

        if ($dokuService->isDokuConfigured()) {

            $checkoutUrl = $dokuService->createCheckoutUrl($order);

            if ($checkoutUrl) {
                session(['doku_pending_order' => $order->order_id]);

                return redirect()->away($checkoutUrl);
            }
        }

        // If fails to generate URL, revert to pending
        return redirect()->route('dashboard')
            ->with('error', 'Gagal memproses pembayaran DOKU. Silakan pastikan konfigurasi DOKU sudah benar (Client ID & Secret Key).');
    }

    protected function cancelPendingOrders(?string $invitationId, MidtransService $midtransService): void
    {
        if (! $invitationId) {
            return;
        }

        $oldOrders = Order::where('invitation_id', $invitationId)
            ->whereIn('payment_status', ['pending', 'verifying'])
            ->get();

        foreach ($oldOrders as $oldOrder) {
            if ($oldOrder->payment_method_used === 'midtrans') {
                try {
                    $midtransService->cancelTransaction($oldOrder->order_id);
                } catch (\Throwable $e) {
                    logger()->warning('Gagal cancel order lama di Midtrans: '.$e->getMessage());
                }
            }

            $oldOrder->update(['payment_status' => 'expired']);

            Subscription::where('midtrans_order_id', $oldOrder->order_id)
                ->where('payment_status', 'pending')
                ->update(['payment_status' => 'expire']);
        }
    }
}
