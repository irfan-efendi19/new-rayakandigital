<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\PromotionUsage;
use App\Services\PromotionService;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if (! $order->promotion_id || ! $order->wasChanged('payment_status')) {
            return;
        }

        if ($order->payment_status === 'success') {
            PromotionUsage::where('order_id', $order->id)->whereNull('confirmed_at')
                ->whereNull('released_at')->update(['confirmed_at' => now()]);
        } elseif ($order->payment_method_used === 'manual_bank' && in_array($order->payment_status, ['failed', 'expired'])) {
            app(PromotionService::class)->release($order);
        }
    }
}
