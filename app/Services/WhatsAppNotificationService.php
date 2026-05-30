<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;

class WhatsAppNotificationService
{
    public function sendActivationConfirmation(Order $order): bool
    {
        $user = $order->user;
        $phone = $user->phone ?? null;

        if (!$phone) {
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
        $apiUrl = config('services.whatsapp.api_url');
        $apiKey = config('services.whatsapp.api_key');

        if (empty($apiUrl) || empty($apiKey)) {
            return false;
        }

        try {
            $httpClient = new \Illuminate\Http\Client\PendingRequest();
            $response = $httpClient->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'phone' => $phoneNumber,
                'message' => $message,
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }
}
