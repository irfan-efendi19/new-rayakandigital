<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\Order;
use App\Models\Package;
use App\Models\PaymentMethodConfig;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DokuService
{
    protected ?PaymentMethodConfig $methodConfig = null;

    protected string $clientId;

    protected string $secretKey;

    protected bool $isProduction;

    public function __construct()
    {
        $this->clientId = config('doku.client_id', '');
        $this->secretKey = config('doku.secret_key', '');
        $this->isProduction = config('doku.environment') === 'production';

        try {
            $this->methodConfig = PaymentMethodConfig::where('active_method', 'doku')->first();
            if ($this->methodConfig) {
                $this->clientId = $this->methodConfig->doku_client_id ?? $this->clientId;
                $this->secretKey = $this->methodConfig->doku_secret_key ?? $this->secretKey;
                $this->isProduction = ($this->methodConfig->doku_environment === 'production') ?: $this->isProduction;
            }
        } catch (\Throwable) {
            // Fallback to config defaults
        }
    }

    /**
     * Check whether DOKU is properly configured.
     */
    public function isDokuConfigured(): bool
    {
        $cfg = $this->methodConfig ?? null;

        if ($cfg) {
            return ! empty($cfg->doku_client_id) && ! empty($cfg->doku_secret_key);
        }

        return ! empty(config('doku.client_id')) && ! empty(config('doku.secret_key'));
    }

    /**
     * Generate DOKU Checkout URL for an Order
     */
    public function createCheckoutUrl(Order $order): ?string
    {
        $url = $this->isProduction
            ? 'https://api.doku.com/checkout/v1/payment'
            : 'https://api-sandbox.doku.com/checkout/v1/payment';

        $requestId = (string) Str::uuid();
        $timestamp = gmdate("Y-m-d\TH:i:s\Z");
        $targetPath = '/checkout/v1/payment';

        $payload = [
            'order' => [
                'amount' => $order->gross_amount + $order->unique_code,
                'invoice_number' => $order->order_id,
                'currency' => 'IDR',
                'callback_url' => route('dashboard'), // URL to redirect after payment
            ],
            'payment' => [
                'payment_due_date' => 120, // 2 hours
            ],
            'customer' => [
                'name' => substr(preg_replace('/[^A-Za-z0-9 ]/', '', $order->user->name), 0, 50),
                'email' => $order->user->email,
            ],
        ];

        $signature = $this->generateSignature($payload, $requestId, $timestamp, $targetPath);

        $response = Http::withHeaders([
            'Client-Id' => $this->clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => $signature,
        ])->post($url, $payload);

        if ($response->successful()) {
            $responseData = $response->json();
            $paymentUrl = $responseData['response']['payment']['url'] ?? null;

            if ($paymentUrl) {
                // We'll store the URL in snap_token so it can be resumed if needed
                $order->update([
                    'snap_token' => $paymentUrl,
                    'payment_gateway_used' => 'doku',
                ]);

                return $paymentUrl;
            }
        }

        Log::error('DOKU Checkout URL generation failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }

    /**
     * Handle DOKU Checkout Webhook Notification
     */
    public function handleNotification(Request $request): ?Order
    {
        // 1. Validasi Signature
        $isValid = $this->verifySignature($request);
        if (! $isValid) {
            Log::error('DOKU Signature Verification Failed', ['headers' => $request->headers->all(), 'body' => $request->getContent()]);

            return null;
        }

        $payload = $request->all();
        $orderId = $payload['order']['invoice_number'] ?? null;

        if (! $orderId) {
            return null;
        }

        $order = Order::where('order_id', $orderId)->first();
        if (! $order) {
            return null;
        }

        $transactionStatus = $payload['payment']['status'] ?? $payload['transaction']['status'] ?? null;

        if ($transactionStatus === 'SUCCESS') {
            $order->update([
                'payment_status' => 'success',
            ]);

            // Activate the order package logic
            $subscription = Subscription::where('midtrans_order_id', $orderId)->first();
            if ($subscription) {
                $subscription->payment_status = 'settlement';
                $subscription->starts_at = now();
                $package = Package::where('package_code', $subscription->tier)->first();
                $durationDays = $package?->active_period ?? 365;
                $subscription->expires_at = now()->addDays($durationDays);
                $subscription->save();

                if ($order->invitation_id) {
                    $invitation = Invitation::find($order->invitation_id);
                    if ($invitation) {
                        $invitation->tier = $subscription->tier;
                        $invitation->pricing_tier_id = $package?->id;
                        $invitation->expires_at = $subscription->expires_at;
                        $invitation->is_active = true;
                        $invitation->save();
                    }
                }
            }
        } elseif ($transactionStatus === 'FAILED' || $transactionStatus === 'EXPIRED') {
            $order->update([
                'payment_status' => strtolower($transactionStatus),
            ]);
        }

        return $order;
    }

    /**
     * Generate HMAC SHA256 Signature for DOKU
     */
    protected function generateSignature(array $payload, string $requestId, string $timestamp, string $targetPath): string
    {
        $body = json_encode($payload);
        $digest = base64_encode(hash('sha256', $body, true));

        $signatureString = 'Client-Id:'.$this->clientId."\n".
            'Request-Id:'.$requestId."\n".
            'Request-Timestamp:'.$timestamp."\n".
            'Request-Target:'.$targetPath."\n".
            'Digest:'.$digest;

        $signature = base64_encode(hash_hmac('sha256', $signatureString, $this->secretKey, true));

        return 'HMACSHA256='.$signature;
    }

    /**
     * Verify incoming webhook signature
     */
    protected function verifySignature(Request $request): bool
    {
        $incomingSignature = $request->header('Signature');
        if (!$incomingSignature) {
            Log::error('DOKU Webhook: Missing Signature header');
            return false;
        }
        
        $requestId = $request->header('Request-Id', '');
        $timestamp = $request->header('Request-Timestamp', '');
        
        $targetPath = $request->getRequestUri();
        $targetPath = parse_url($targetPath, PHP_URL_PATH);
        
        // Beberapa konfigurasi proxy/staging (Nginx/Apache) bisa mendistorsi getRequestUri.
        // Jika berakhiran /doku/notification, kita pastikan jalurnya baku.
        if (str_ends_with($targetPath, '/doku/notification')) {
            $targetPath = '/doku/notification';
        }
        
        $body = $request->getContent();
        $digest = base64_encode(hash('sha256', $body, true));
        
        $signatureString = "Client-Id:" . $this->clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digest;
            
        $expectedSignature = "HMACSHA256=" . base64_encode(hash_hmac('sha256', $signatureString, $this->secretKey, true));
        
        $isValid = hash_equals($expectedSignature, (string)$incomingSignature);

        if (!$isValid) {
            Log::error('DOKU Webhook Signature Mismatch', [
                'expected' => $expectedSignature,
                'received' => $incomingSignature,
                'signature_string' => $signatureString,
                'client_id' => $this->clientId,
            ]);
        }

        return $isValid;
    }
}
