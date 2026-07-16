<?php

namespace App\Console\Commands;

use App\Models\Invitation;
use App\Models\Order;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Console\Command;

class ActivateDokuOrder extends Command
{
    /**
     * Aktivasi manual pesanan DOKU (untuk keperluan testing/admin).
     * Digunakan saat Webhook DOKU tidak bisa diuji secara lokal.
     */
    protected $signature = 'doku:activate {order_id : Order ID yang ingin diaktifkan}';

    protected $description = 'Aktifkan pesanan DOKU secara manual (simulasi webhook sukses)';

    public function handle(): int
    {
        $orderId = $this->argument('order_id');

        $order = Order::where('order_id', $orderId)->first();
        if (! $order) {
            $this->error("Order tidak ditemukan: {$orderId}");

            return self::FAILURE;
        }

        if ($order->payment_method_used !== 'doku') {
            $this->warn("Order ini bukan DOKU (payment_method_used: {$order->payment_method_used}).");
        }

        $this->info("Mengaktifkan order: {$orderId}");

        // Update Order
        $order->update(['payment_status' => 'success']);
        $this->line("✓ Order status → success");

        // Update Subscription
        $subscription = Subscription::where('midtrans_order_id', $orderId)->first();
        if ($subscription) {
            $package = Package::where('package_code', $subscription->tier)->first();
            $durationDays = $package?->active_period_days;

            $subscription->payment_status = 'settlement';
            $subscription->starts_at = now();
            $subscription->expires_at = $durationDays ? now()->addDays($durationDays) : now()->addYear();
            $subscription->save();
            $this->line("✓ Subscription status → settlement (expire: {$subscription->expires_at})");

            // Update Invitation
            if ($order->invitation_id) {
                $invitation = Invitation::find($order->invitation_id);
                if ($invitation) {
                    $invitation->tier = $subscription->tier;
                    $invitation->pricing_tier_id = $package?->id;
                    $invitation->expires_at = $subscription->expires_at;
                    $invitation->is_active = true;
                    $invitation->save();
                    $this->line("✓ Invitation diaktifkan (tier: {$invitation->tier}, expire: {$invitation->expires_at})");
                }
            }
        } else {
            $this->warn("Subscription tidak ditemukan untuk order ini.");
        }

        $this->newLine();
        $this->info('Selesai! Pesanan berhasil diaktifkan.');

        return self::SUCCESS;
    }
}
