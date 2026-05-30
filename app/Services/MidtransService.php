<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Str;

class MidtransService
{
    public function __construct()
    {
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');

        try {
            if (class_exists(\App\Models\PaymentMethodConfig::class)) {
                $methodConfig = \App\Models\PaymentMethodConfig::getActive();
                if ($methodConfig && $methodConfig->isMidtrans() && !empty($methodConfig->midtrans_server_key)) {
                    $serverKey = $methodConfig->midtrans_server_key;
                    $isProduction = $methodConfig->midtrans_environment === 'production';
                }
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        if (empty($serverKey)) {
            try {
                if (class_exists(\App\Models\PaymentGatewaySetting::class)) {
                    $setting = \App\Models\PaymentGatewaySetting::where('provider_name', 'midtrans')
                        ->where('is_active', true)
                        ->first();

                    if ($setting) {
                        $serverKey = $setting->server_key ?? $serverKey;
                        $isProduction = $setting->environment === 'production';
                    }
                }
            } catch (\Throwable $e) {
                // Fallback
            }
        }

        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = $isProduction;
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    public function isSimulationMode(): bool
    {
        return empty(\Midtrans\Config::$serverKey);
    }

    public function getPrice(string $tier): int
    {
        $package = \App\Models\Package::where('package_code', $tier)->first();

        return $package ? (int) $package->price : (int) config('midtrans.pricing.'.$tier, 0);
    }

    public function getDurationDays(string $tier): ?int
    {
        $package = \App\Models\Package::where('package_code', $tier)->first();

        if ($package) {
            return $package->active_period_days > 0 ? $package->active_period_days : null;
        }

        return config('midtrans.duration_days.'.$tier);
    }

    /**
     * Create a Midtrans Snap token for a subscription.
     *
     * @return array{snap_token: string, order_id: string, subscription: Subscription}
     */
    public function createSnapToken(User $user, string $tier): array
    {
        $price = $this->getPrice($tier);
        $orderId = 'RD-'.strtoupper($tier).'-'.$user->id.'-'.Str::random(8);

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'tier' => $tier,
            'midtrans_order_id' => $orderId,
            'payment_status' => 'pending',
            'amount' => $price,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => 'PAKET-'.strtoupper($tier),
                    'price' => $price,
                    'quantity' => 1,
                    'name' => 'Paket '.ucfirst($tier).' - Rayakan Digital',
                ],
            ],
        ];

        // If server key is empty (simulation mode), return a fake token
        if ($this->isSimulationMode()) {
            return [
                'snap_token' => 'SIMULATION_TOKEN_'.$orderId,
                'order_id' => $orderId,
                'gross_amount' => $price,
                'subscription' => $subscription,
            ];
        }

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return [
            'snap_token' => $snapToken,
            'order_id' => $orderId,
            'gross_amount' => $price,
            'subscription' => $subscription,
        ];
    }

    /**
     * Handle Midtrans webhook notification.
     */
    public function handleNotification(array $payload): ?Subscription
    {
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $transactionId = $payload['transaction_id'] ?? null;

        if (! $orderId) {
            return null;
        }

        $subscription = Subscription::where('midtrans_order_id', $orderId)->first();

        if (! $subscription) {
            return null;
        }

        $subscription->midtrans_transaction_id = $transactionId;

        $statusMap = [
            'capture' => 'settlement',
            'settlement' => 'settlement',
            'pending' => 'pending',
            'deny' => 'deny',
            'expire' => 'expire',
            'cancel' => 'cancel',
        ];

        $subscription->payment_status = $statusMap[$transactionStatus] ?? 'pending';

        if ($subscription->payment_status === 'settlement') {
            $subscription->starts_at = now();
            $durationDays = $this->getDurationDays($subscription->tier);
            $subscription->expires_at = $durationDays ? now()->addDays($durationDays) : null;
        }

        $subscription->save();

        // Sync Order status
        $order = \App\Models\Order::where('order_id', $orderId)->first();
        if ($order) {
            $orderStatusMap = [
                'settlement' => 'success',
                'capture' => 'success',
                'pending' => 'pending',
                'deny' => 'failed',
                'expire' => 'expired',
                'cancel' => 'failed',
            ];
            $order->payment_status = $orderStatusMap[$transactionStatus] ?? 'pending';
            $order->save();
        }

        return $subscription;
    }

    /**
     * Simulate a successful payment (for development without Midtrans credentials).
     */
    public function simulatePayment(string $orderId): ?Subscription
    {
        return $this->handleNotification([
            'order_id' => $orderId,
            'transaction_status' => 'settlement',
            'transaction_id' => 'SIM-'.Str::random(12),
        ]);
    }
}
