<?php

namespace App\Filament\Resources\Orders;

use App\Models\Order;
use App\Models\Subscription;
use App\Services\WhatsAppNotificationService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class OrderActions
{
    public static function activate(Order $order): void
    {
        $user = $order->user;
        $tier = $order->package_type;

        DB::beginTransaction();

        try {
            $order->update([
                'payment_status' => 'success',
                'verified_by' => auth()->id(),
            ]);
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

            // Update invitation tier on admin activation
            if ($order->invitation_id) {
                $invitation = $order->invitation;
                if ($invitation) {
                    $package = \App\Models\Package::where('package_code', $tier)->first();
                    $invitation->tier = $tier;
                    $invitation->pricing_tier_id = $package?->id;
                    $invitation->expires_at = $durationDays ? now()->addDays($durationDays) : null;
                    $invitation->is_active = true;
                    $invitation->save();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            Notification::make()
                ->title('Gagal mengaktifkan pesanan!')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->send();

            throw $e;
        }

        try {
            $whatsapp = app(WhatsAppNotificationService::class);
            $whatsapp->sendActivationConfirmation($order);
        } catch (\Throwable $e) {
            report($e);
        }

        Notification::make()
            ->title('Pesanan berhasil diaktifkan!')
            ->body('Paket ' . ucfirst($tier) . ' untuk ' . $user->name . ' telah aktif.')
            ->success()
            ->send();
    }
}
