<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected string $baseUrl = 'https://api.fonnte.com';

    /**
     * Get QR Code for a device using admin-injected token.
     *
     * @return array<string, mixed>
     */
    public function getQrCode(string $adminInjectedToken): array
    {
        $response = Http::timeout(15)
            ->withHeaders([
                'Authorization' => $adminInjectedToken,
            ])
            ->post("{$this->baseUrl}/qr");

        return $response->json() ?? [];
    }

    /**
     * Check device connection status.
     *
     * @return array<string, mixed>
     */
    public function checkDeviceStatus(string $adminInjectedToken): array
    {
        $response = Http::timeout(15)
            ->withHeaders([
                'Authorization' => $adminInjectedToken,
            ])
            ->post("{$this->baseUrl}/device");

        return $response->json() ?? [];
    }

    /**
     * Send a WhatsApp message to a guest.
     *
     * @return array<string, mixed>
     */
    public function sendMessage(string $adminInjectedToken, string $target, string $message, ?string $urlMedia = null): array
    {
        $cleanTarget = preg_replace('/[^0-9]/', '', $target);

        $payload = [
            'target' => $cleanTarget,
            'message' => $message,
            'countryCode' => '62',
        ];

        if ($urlMedia) {
            $payload['url'] = $urlMedia;
        }

        $response = Http::timeout(15)
            ->withHeaders([
                'Authorization' => $adminInjectedToken,
            ])
            ->post("{$this->baseUrl}/send", $payload);

        return $response->json() ?? [];
    }

    /**
     * Determine if a Fonnte API response indicates success.
     *
     * @param  array<string, mixed>  $response
     */
    public function isSuccessful(array $response): bool
    {
        return isset($response['status']) && $response['status'] === true;
    }
}
