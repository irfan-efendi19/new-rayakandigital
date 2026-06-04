<?php

namespace App\Services;

use App\Models\Order;
use App\Models\WhatsappGatewaySetting;
use Illuminate\Support\Facades\Http;

class WhatsAppNotificationService
{
    public function sendActivationConfirmation(Order $order): bool
    {
        $user = $order->user;
        $phone = $user->phone ?? null;

        if (! $phone) {
            return false;
        }

        $packageLabel = ucfirst($order->package_type);
        $message = sprintf(
            "Halo %s,\n\nSelamat! Paket %s Anda sudah aktif dan siap digunakan.\n\nDetail Pesanan:\n* ID Invoice: %s\n* Paket: %s\n\nSilakan buka undangan Anda dan sebarkan ke tamu undangan.\n\nTerima kasih telah menggunakan Rayakan Digital.",
            $user->name,
            $packageLabel,
            $order->invoice_id,
            $packageLabel
        );

        return $this->send($phone, $message);
    }

    public function send(string $phoneNumber, string $message): bool
    {
        $gateway = WhatsappGatewaySetting::active()->first();

        if ($gateway) {
            return $this->sendViaGateway($phoneNumber, $message, $gateway);
        }

        $apiUrl = config('services.whatsapp.api_url');
        $apiKey = config('services.whatsapp.api_key');

        if (empty($apiUrl) || empty($apiKey)) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'target' => $this->normalizePhone($phoneNumber),
                'message' => $message,
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            report($e);

            return false;
        }
    }

    public function sendViaGateway(string $phoneNumber, string $message, WhatsappGatewaySetting $gateway): bool
    {
        try {
            $payload = [
                'message' => $message,
            ];

            if ($gateway->provider_name === 'fonnte') {
                $payload['target'] = preg_replace('/[^0-9]/', '', $phoneNumber);
                $payload['countryCode'] = '62';

                if ($gateway->delay_seconds > 0) {
                    $payload['delay'] = $gateway->delay_seconds;
                }

                $response = Http::withHeaders([
                    'Authorization' => $gateway->api_token,
                ])->asForm()->post(
                    $this->resolveApiUrl($gateway),
                    $payload
                );
            } else {
                $payload['phone'] = $this->normalizePhone($phoneNumber);
                $headers = [
                    'Authorization' => 'Bearer ' . $gateway->api_token,
                    'Content-Type' => 'application/json',
                ];

                if ($gateway->device_id) {
                    $payload['device_id'] = $gateway->device_id;
                }

                $response = Http::withHeaders($headers)->post(
                    $this->resolveApiUrl($gateway),
                    $payload
                );
            }

            $body = $response->body();
            $json = $response->json();

            $success = $response->successful()
                && (!isset($json['status']) || $json['status'] === true);

            if (!$success) {
                logger()->warning('WhatsApp API request failed', [
                    'provider' => $gateway->provider_name,
                    'url' => $gateway->api_url,
                    'status' => $response->status(),
                    'response' => $body,
                ]);
                throw new \RuntimeException("API returned status {$response->status()}: {$body}");
            }

            return true;
        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 2) === '62') {
            return $phone;
        }

        if (strlen($phone) > 0 && $phone[0] === '0') {
            return '62' . substr($phone, 1);
        }

        return $phone;
    }

    private function resolveApiUrl(WhatsappGatewaySetting $gateway): string
    {
        $url = $gateway->api_url ?: $this->defaultApiUrl($gateway->provider_name);

        $url = rtrim($url, '/');

        if ($gateway->provider_name === 'fonnte' && !str_contains($url, '/send')) {
            $url .= '/send';
        }

        return $url;
    }

    private function defaultApiUrl(?string $provider): string
    {
        return match ($provider) {
            'fonnte' => 'https://api.fonnte.com/send',
            'wablas' => 'https://pati.wablas.com/api/send-message',
            default => '',
        };
    }
}
