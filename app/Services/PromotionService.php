<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Package;
use App\Models\Promotion;
use App\Models\PromotionSession;
use App\Models\PromotionUsage;
use App\Models\Subscription;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PromotionService
{
    public function catalog(Collection $packages, Request $request): array
    {
        $promotions = $this->availablePromotions($request);
        $code = $this->code($request);
        $prices = $packages->mapWithKeys(fn (Package $package) => [
            $package->package_code => $this->quote($package, $promotions, $code),
        ]);
        $featured = $prices->filter(fn (array $price) => $price['promotion'] !== null)
            ->sortByDesc('discount_amount')->first();

        return [
            'server_now' => now()->toIso8601String(),
            'prices' => $prices,
            'featured' => $featured,
            'message' => $code && ! $featured ? 'Voucher tidak tersedia, sudah habis, atau tidak memenuhi syarat paket.' : null,
        ];
    }

    public function createOrder(Request $request, Package $package, int $invitationId, string $method): Order
    {
        return DB::transaction(function () use ($request, $package, $invitationId, $method) {
            $user = User::query()->lockForUpdate()->findOrFail($request->user()->id);
            $code = $this->code($request);
            $existing = Order::query()->where('user_id', $user->id)
                ->where('invitation_id', $invitationId)->where('package_type', $package->package_code)
                ->where('payment_method_used', $method)->whereIn('payment_status', ['pending', 'verifying'])
                ->when($code, fn ($query) => $query->where('promotion_code', $code))
                ->when(! $code, fn ($query) => $query->where(function ($query) {
                    $query->whereNull('promotion_id')->orWhereHas('promotion', fn ($query) => $query->whereNull('code'));
                }))
                ->latest('id')->first();

            if ($existing && (! $request->filled('expected_amount') || (int) $existing->gross_amount === $request->integer('expected_amount'))) {
                return $existing;
            }

            $price = $this->quote($package, $this->availablePromotions($request, true), $code);

            if ($code && ! $price['promotion']) {
                throw ValidationException::withMessages(['promotion_code' => 'Voucher tidak tersedia, sudah habis, atau tidak memenuhi syarat paket.']);
            }

            if ($request->filled('expected_amount') && $request->integer('expected_amount') !== $price['amount']) {
                throw ValidationException::withMessages(['promotion_code' => 'Harga atau promo telah berubah. Periksa harga terbaru sebelum melanjutkan.']);
            }

            $order = Order::create([
                'order_id' => 'RD-'.now()->format('Ymd').'-'.$user->id.'-'.Str::upper(Str::random(12)),
                'user_id' => $user->id,
                'invitation_id' => $invitationId,
                'package_type' => $package->package_code,
                'payment_method_used' => $method,
                'payment_gateway_used' => $method,
                'gross_amount' => $price['amount'],
                'original_amount' => $price['original_amount'],
                'discount_amount' => $price['discount_amount'],
                'promotion_id' => $price['promotion']['id'] ?? null,
                'promotion_title' => $price['promotion']['title'] ?? null,
                'promotion_code' => $price['promotion']['code'] ?? null,
                'unique_code' => $method === 'manual_bank' && $price['amount'] > 0 ? Order::generateUniqueCode() : 0,
                'is_manual_whatsapp' => $method === 'manual_bank',
                'payment_status' => 'pending',
            ]);

            if ($price['promotion']) {
                PromotionUsage::create([
                    'promotion_id' => $order->promotion_id, 'user_id' => $user->id,
                    'email' => mb_strtolower($user->email), 'order_id' => $order->id,
                    'discount_applied' => $price['discount_amount'],
                ]);
                Promotion::whereKey($order->promotion_id)->increment('used_count');
            }

            if ($method !== 'manual_bank' || $price['amount'] === 0) {
                Subscription::create([
                    'user_id' => $user->id, 'tier' => $package->package_code,
                    'midtrans_order_id' => $order->order_id, 'payment_status' => 'pending',
                    'amount' => $price['amount'],
                ]);
            }

            return $order;
        }, 3);
    }

    public function release(Order $order): void
    {
        if (! $order->promotion_id) {
            return;
        }

        DB::transaction(function () use ($order) {
            $promotion = Promotion::query()->lockForUpdate()->findOrFail($order->promotion_id);
            $released = PromotionUsage::where('order_id', $order->id)
                ->whereNull('confirmed_at')->whereNull('released_at')->update(['released_at' => now()]);

            if ($released) {
                $promotion->decrement('used_count');
            }
        }, 3);
    }

    private function code(Request $request): ?string
    {
        $code = $request->input('promotion_code');

        return is_string($code) && filled(trim($code)) ? mb_strtoupper(trim($code)) : null;
    }

    private function availablePromotions(Request $request, bool $lock = false): Collection
    {
        $query = Promotion::query()->where('is_active', true)
            ->where(fn ($query) => $query->whereNull('start_time')->orWhere('start_time', '<=', now()))
            ->where(fn ($query) => $query->whereNull('end_time')->orWhere('end_time', '>', now()))
            ->orderBy('id');

        if ($request->user()) {
            $query->withCount(['usages as customer_usage_count' => fn ($query) => $query
                ->whereNull('released_at')->where(fn ($query) => $query
                ->where('user_id', $request->user()->id)
                ->orWhere('email', mb_strtolower($request->user()->email)))]);
        }

        return ($lock ? $query->lockForUpdate() : $query)->get()->filter(function (Promotion $promotion) use ($request) {
            if (($promotion->usage_limit !== null && $promotion->used_count >= $promotion->usage_limit)
                || ($request->user() && $promotion->per_user_limit !== null && $promotion->customer_usage_count >= $promotion->per_user_limit)) {
                return false;
            }

            $deadline = $promotion->end_time;
            if ($promotion->timer_type === 'EVERGREEN') {
                if ($promotion->evergreen_duration_minutes < 1) {
                    return false;
                }

                $expiresAt = $this->evergreenDeadline($promotion, $request);
                $deadline = $deadline && $deadline->lessThan($expiresAt) ? $deadline : $expiresAt;
            }

            $promotion->setAttribute('deadline', $deadline);

            return $deadline && $deadline->isFuture();
        });
    }

    private function evergreenDeadline(Promotion $promotion, Request $request): CarbonImmutable
    {
        if (! $request->session()->has('promotion_visitor')) {
            $request->session()->put('promotion_visitor', (string) Str::uuid());
        }

        $visitor = hash('sha256', $request->session()->get('promotion_visitor'));

        return DB::transaction(function () use ($promotion, $request, $visitor) {
            Promotion::query()->whereKey($promotion->id)->lockForUpdate()->firstOrFail();
            $sessions = PromotionSession::where('promotion_id', $promotion->id)
                ->where(fn ($query) => $query->where('visitor_key', $visitor)
                    ->when($request->user(), fn ($query) => $query->orWhere('user_id', $request->user()->id)))
                ->orderBy('expires_at')->get();
            $deadline = $sessions->first()?->expires_at ?? now()->toImmutable()->addMinutes($promotion->evergreen_duration_minutes);

            PromotionSession::updateOrCreate(
                ['promotion_id' => $promotion->id, 'visitor_key' => $visitor],
                ['expires_at' => $deadline, ...($request->user() ? ['user_id' => $request->user()->id] : [])],
            );

            return $deadline;
        }, 3);
    }

    private function quote(Package $package, Collection $promotions, ?string $code): array
    {
        $amount = (int) $package->price;
        $promotion = $promotions->filter(fn (Promotion $promotion) => ($code ? $promotion->code === $code : $promotion->code === null)
            && $amount > 0 && $amount >= (float) $promotion->min_order_amount
            && (! $promotion->package_ids || in_array($package->id, $promotion->package_ids))
            && $promotion->discountFor($amount) > 0
        )->sortByDesc(fn (Promotion $promotion) => $promotion->discountFor($amount))->first();
        $discount = $promotion?->discountFor($amount) ?? 0;

        return [
            'package_code' => $package->package_code,
            'package_name' => $package->package_name,
            'original_amount' => $amount,
            'discount_amount' => $discount,
            'amount' => $amount - $discount,
            'savings_percent' => $amount > 0 ? (int) floor($discount * 100 / $amount) : 0,
            'promotion' => $promotion ? [
                'id' => $promotion->id, 'title' => $promotion->title, 'code' => $promotion->code,
                'expires_at' => $promotion->getAttribute('deadline')->toIso8601String(),
            ] : null,
        ];
    }
}
