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

        $email = filter_var($user->email, FILTER_VALIDATE_EMAIL) ? $user->email : 'user-'.$user->id.'@rayakandigital.com';

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $email,
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

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Throwable $e) {
            logger()->error('Gagal buat Snap token: ' . $e->getMessage());

            return [
                'snap_token' => 'SIMULATION_TOKEN_'.$orderId,
                'order_id' => $orderId,
                'gross_amount' => $price,
                'subscription' => $subscription,
            ];
        }

        return [
            'snap_token' => $snapToken,
            'order_id' => $orderId,
            'gross_amount' => $price,
            'subscription' => $subscription,
        ];
    }

    /**
     * Handle Midtrans webhook notification with signature validation.
     */
    public function handleNotification(array $payload): ?Subscription
    {
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $transactionId = $payload['transaction_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (! $orderId) {
            return null;
        }

        if ($signatureKey !== null) {
            $calculated = hash('sha512', $orderId . $statusCode . $grossAmount . \Midtrans\Config::$serverKey);

            if (! hash_equals($calculated, $signatureKey)) {
                logger()->warning('Midtrans webhook signature mismatch for order: ' . $orderId);

                return null;
            }
        }

        $subscription = Subscription::where('midtrans_order_id', $orderId)->first();

        if (! $subscription) {
            return null;
        }

        $subscription->midtrans_transaction_id = $transactionId;

        $isSettled = $transactionStatus === 'settlement'
            || ($transactionStatus === 'capture' && $fraudStatus === 'accept');

        if ($isSettled) {
            $subscription->payment_status = 'settlement';
            $subscription->starts_at = now();
            $durationDays = $this->getDurationDays($subscription->tier);
            $subscription->expires_at = $durationDays ? now()->addDays($durationDays) : null;
        } elseif ($transactionStatus === 'pending') {
            $subscription->payment_status = 'pending';
        } else {
            $statusMap = [
                'deny' => 'deny',
                'expire' => 'expire',
                'cancel' => 'cancel',
            ];
            $subscription->payment_status = $statusMap[$transactionStatus] ?? 'pending';
        }

        $subscription->save();

        // Sync Order status
        $order = \App\Models\Order::where('order_id', $orderId)->first();
        if ($order) {
            $order->payment_status = match (true) {
                $isSettled => 'success',
                $transactionStatus === 'pending' => 'pending',
                default => 'expired',
            };
            $order->save();
        }

        // Update invitation tier and expiry on successful payment
        if ($isSettled && $order && $order->invitation_id) {
            $invitation = \App\Models\Invitation::find($order->invitation_id);
            if ($invitation) {
                $durationDays = $this->getDurationDays($subscription->tier);
                $invitation->tier = $subscription->tier;
                $invitation->expires_at = $durationDays ? now()->addDays($durationDays) : now()->addYears(1);
                $invitation->is_active = true;
                $invitation->save();
            }
        }

        return $subscription;
    }

    /**
     * Check transaction status directly with Midtrans API and update locally.
     */
    public function checkTransactionStatus(string $orderId): ?Subscription
    {
        if ($this->isSimulationMode()) {
            return null;
        }

        try {
            $status = \Midtrans\Transaction::status($orderId);

            $payload = [
                'order_id' => $status->order_id,
                'transaction_status' => $status->transaction_status,
                'transaction_id' => $status->transaction_id ?? null,
                'status_code' => $status->status_code ?? null,
                'gross_amount' => $status->gross_amount ?? null,
                'signature_key' => $status->signature_key ?? null,
                'fraud_status' => $status->fraud_status ?? null,
            ];

            return $this->handleNotification($payload);
        } catch (\Throwable $e) {
            logger()->warning('Gagal cek status Midtrans: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Cancel a pending transaction at Midtrans.
     */
    public function cancelTransaction(string $orderId): void
    {
        if ($this->isSimulationMode()) {
            return;
        }

        \Midtrans\Transaction::cancel($orderId);
    }

    /**
     * Simulate a successful payment (for development without Midtrans credentials).
     */
    public function simulatePayment(string $orderId, int $grossAmount = 0): ?Subscription
    {
        return $this->handleNotification([
            'order_id' => $orderId,
            'transaction_status' => 'settlement',
            'transaction_id' => 'SIM-'.Str::random(12),
            'status_code' => '200',
            'gross_amount' => (string) $grossAmount,
        ]);
    }
}
