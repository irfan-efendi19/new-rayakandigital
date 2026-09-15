<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliateCommission;
use App\Models\AffiliateLink;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\SystemConfig;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AffiliateService
{
    public function settings(): array
    {
        $config = SystemConfig::query()->orderBy('id')->first();

        return [
            'commission_rate' => $config?->affiliate_commission_rate ?? 10,
            'discount_rate' => $config?->affiliate_discount_rate ?? 20,
            'minimum_payout' => (int) ($config?->affiliate_minimum_payout ?? 50000),
        ];
    }

    public function apply(User $user, array $data): Affiliate
    {
        return DB::transaction(function () use ($user, $data) {
            User::query()->lockForUpdate()->findOrFail($user->id);
            if ($user->affiliate()->exists()) {
                throw ValidationException::withMessages(['business_name' => 'Pendaftaran mitra Anda sudah tercatat.']);
            }

            $affiliate = $user->affiliate()->create($data);
            $affiliate->links()->create([
                'slug' => 'mitra-'.Str::lower(Str::random(12)),
                'label' => 'Link utama', 'destination' => 'home',
            ]);

            return $affiliate;
        }, 3);
    }

    public function review(Affiliate $affiliate, User $admin, array $data): void
    {
        abort_unless($admin->isAdmin() && ! $admin->is_banned, 403);
        DB::transaction(function () use ($affiliate, $admin, $data) {
            $affiliate = Affiliate::query()->lockForUpdate()->findOrFail($affiliate->id);
            $affiliate->update([...$data, 'reviewed_by' => $admin->id, 'reviewed_at' => now()]);
            if ($affiliate->status === 'approved' && ! $affiliate->promotion()->exists()) {
                $affiliate->promotion()->create([
                    'title' => Str::limit('Promo mitra '.$affiliate->business_name, 150, ''),
                    'code' => 'MITRA-'.Str::upper(Str::random(12)),
                    'discount_type' => 'PERCENTAGE', 'discount_value' => $this->settings()['discount_rate'],
                    'timer_type' => 'STATIC', 'start_time' => now(), 'end_time' => now()->addYear(),
                    'is_active' => true,
                ]);
            }
        }, 3);
    }

    public function rate(Affiliate $affiliate): string
    {
        $affiliate->loadMissing('tier');

        return (string) ($affiliate->commission_rate ?? $affiliate->tier?->commission_rate ?? $this->settings()['commission_rate']);
    }

    public function attribution(Request $request, ?int $promotionId): array
    {
        $promotion = $promotionId ? Promotion::find($promotionId) : null;
        $affiliate = $promotion?->affiliate_id
            ? Affiliate::query()->eligible()->find($promotion->affiliate_id) : null;
        $link = null;

        if (! $promotion?->affiliate_id) {
            $referral = $request->session()->get('affiliate_referral');
            if (! is_array($referral)) {
                $referral = json_decode((string) $request->cookie('affiliate_referral', ''), true);
            }
            if (is_array($referral) && is_numeric($referral['expires_at'] ?? null)
                && (int) $referral['expires_at'] > now()->timestamp) {
                $link = AffiliateLink::query()->with('affiliate')
                    ->whereHas('affiliate', fn ($query) => $query->eligible())
                    ->find($referral['link_id'] ?? null);
                $affiliate = $link?->affiliate;
            }
        }

        if (! $affiliate || $affiliate->user_id === $request->user()?->id) {
            return [];
        }

        return [
            'affiliate_id' => $affiliate->id,
            'affiliate_link_id' => $link?->id,
            'affiliate_commission_rate' => $this->rate($affiliate),
        ];
    }

    public function syncCommission(Order $order): void
    {
        if (! $order->affiliate_id) {
            return;
        }

        DB::transaction(function () use ($order) {
            $order = Order::query()->lockForUpdate()->findOrFail($order->id);
            $affiliate = Affiliate::query()->lockForUpdate()->findOrFail($order->affiliate_id);
            if ($order->payment_status !== 'success') {
                if (in_array($order->payment_status, ['failed', 'expired', 'refunded'])) {
                    AffiliateCommission::where('order_id', $order->id)->update(['status' => 'void']);
                }

                return;
            }

            $sale = max(0, (int) $order->gross_amount);
            if ($affiliate->user_id === $order->user_id || $sale === 0 || $order->affiliate_commission_rate === null) {
                return;
            }
            $basisPoints = (int) round((float) $order->affiliate_commission_rate * 100);
            $amount = intdiv($sale * max(0, min(10000, $basisPoints)), 10000);

            AffiliateCommission::updateOrCreate(['order_id' => $order->id], [
                'affiliate_id' => $affiliate->id, 'sale_amount' => $sale,
                'rate' => $order->affiliate_commission_rate, 'amount' => $amount, 'status' => 'earned',
            ]);
        }, 3);
    }

    public function balance(Affiliate $affiliate): array
    {
        $earned = (int) $affiliate->commissions()->where('status', 'earned')->sum('amount');
        $reserved = (int) $affiliate->payouts()->whereIn('status', ['pending', 'approved'])->sum('amount');
        $paid = (int) $affiliate->payouts()->where('status', 'paid')->sum('amount');

        return ['earned' => $earned, 'reserved' => $reserved, 'paid' => $paid, 'available' => $earned - $reserved - $paid];
    }
}
