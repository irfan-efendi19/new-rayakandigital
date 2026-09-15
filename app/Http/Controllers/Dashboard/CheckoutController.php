<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Package;
use App\Models\PaymentMethodConfig;
use App\Services\DokuService;
use App\Services\MidtransService;
use App\Services\PaymentRoutingService;
use App\Services\PromotionService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index(Request $request, PaymentRoutingService $routing, PromotionService $promotions)
    {
        $user = $request->user();
        $activeMethod = $routing->activeMethod();
        $packages = Package::with('features')->where('is_visible', true)
            ->where('package_code', '!=', 'free')->orderBy('sort_order')->get();
        $invitationId = $request->query('invitation_id');
        $invitation = $invitationId
            ? ($user->isAdmin() ? Invitation::find($invitationId) : $user->invitations()->find($invitationId))
            : $user->invitations()->first();
        abort_if($invitationId && ! $invitation, 404);
        $currentTier = $invitation?->currentTier() ?? 'free';
        $methodConfig = PaymentMethodConfig::getActive();
        $clientKey = $methodConfig?->isMidtrans() && filled($methodConfig->midtrans_client_key)
            ? $methodConfig->midtrans_client_key : config('midtrans.client_key');
        $dokuConfigured = $routing->isDoku() && app(DokuService::class)->isDokuConfigured();
        $promotionCatalog = $promotions->catalog($packages, $request);

        return response()->view('dashboard.checkout.index', compact(
            'currentTier', 'packages', 'activeMethod', 'clientKey', 'invitation', 'dokuConfigured', 'promotionCatalog',
        ))->header('Cache-Control', 'private, no-store');
    }

    public function process(CheckoutRequest $request, MidtransService $midtrans, PaymentRoutingService $routing, PromotionService $promotions)
    {
        $validated = $request->validated();
        $user = $request->user();
        $invitationId = $validated['invitation_id'] ?? $user->invitations()->first()?->id;
        $invitation = $invitationId
            ? ($user->isAdmin() ? Invitation::find($invitationId) : $user->invitations()->find($invitationId))
            : null;
        abort_if($invitationId && ! $invitation, 403);

        if (! $invitation) {
            throw ValidationException::withMessages(['invitation_id' => 'Buat undangan terlebih dahulu sebelum memilih paket.']);
        }

        $package = Package::where('package_code', $validated['tier'])->where('is_visible', true)->firstOrFail();
        $currentTier = $invitation->currentTier();
        $currentRank = Package::where('package_code', $currentTier)->value('sort_order') ?? -1;

        if ($currentRank >= $package->sort_order) {
            throw ValidationException::withMessages(['tier' => 'Undangan ini sudah memiliki paket yang setara atau lebih tinggi.']);
        }

        $order = $promotions->createOrder($request, $package, $invitation->id, $routing->activeMethod());

        if ((int) $order->gross_amount === 0) {
            app(DokuService::class)->processSuccessOrder($order);
            $url = route('dashboard.invitations.show', $invitation);

            return $request->expectsJson() ? response()->json(['redirect_url' => $url]) : redirect($url)->with('success', 'Paket berhasil diaktifkan dengan promo.');
        }

        if ($routing->isMidtrans()) {
            return $this->processMidtrans($order, $midtrans);
        }

        if ($routing->isDoku()) {
            return $this->processDoku($order, app(DokuService::class));
        }

        return redirect()->route('dashboard.payment.invoice', ['order' => $order->order_id])
            ->with('success', 'Silakan lakukan pembayaran dan kirim bukti transfer via WhatsApp.');
    }

    protected function processMidtrans(Order $order, MidtransService $midtrans)
    {
        if (! $order->snap_token) {
            $result = $midtrans->createSnapToken($order->user, $order->package_type, $order);
            $order->update(['snap_token' => $result['snap_token']]);
        }

        if ($midtrans->isSimulationMode()) {
            $midtrans->simulatePayment($order->order_id, (int) $order->gross_amount);
        }

        return response()->json(['snap_token' => $order->snap_token, 'order_id' => $order->order_id]);
    }

    protected function processDoku(Order $order, DokuService $doku)
    {
        $url = $order->snap_token ?: ($doku->isDokuConfigured() ? $doku->createCheckoutUrl($order) : null);
        if ($url) {
            session(['doku_pending_order' => $order->order_id]);

            return redirect()->away($url);
        }

        return redirect()->route('dashboard.checkout', ['invitation_id' => $order->invitation_id])
            ->with('error', 'Gagal memproses pembayaran DOKU. Silakan coba lagi; pesanan dan harga promo Anda tetap tersimpan.');
    }
}
