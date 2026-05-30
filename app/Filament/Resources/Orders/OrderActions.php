<?php

namespace App\Filament\Resources\Orders;

use App\Models\Order;
use App\Models\Subscription;
use App\Services\WhatsAppNotificationService;
use Filament\Notifications\Notification;

class OrderActions
{
    public static function activate(Order $order): void
    {
        $order->update([
            'payment_status' => 'success',
            'verified_by' => auth()->id(),
            'payment_method_used' => 'manual_bank',
        ]);

        $user = $order->user;
        $tier = $order->package_type;
        $durationDays = config('midtrans.duration_days.' . $tier);

        $existingSubscription = Subscription::where('user_id', $user->id)
            ->where('payment_status', 'settlement')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if ($existingSubscription) {
            $existingSubscription->update([
                'tier' => $tier,
                'expires_at' => $durationDays ? now()->addDays($durationDays) : null,
            ]);
        } else {
            Subscription::create([
                'user_id' => $user->id,
                'tier' => $tier,
                'midtrans_order_id' => $order->order_id,
                'payment_status' => 'settlement',
                'amount' => $order->gross_amount,
                'starts_at' => now(),
                'expires_at' => $durationDays ? now()->addDays($durationDays) : null,
            ]);
        }

        $whatsapp = app(WhatsAppNotificationService::class);
        $whatsapp->sendActivationConfirmation($order);

        Notification::make()
            ->title('Pesanan berhasil diaktifkan!')
            ->body('Paket ' . ucfirst($tier) . ' untuk ' . $user->name . ' telah aktif.')
            ->success()
            ->send();
    }
}
