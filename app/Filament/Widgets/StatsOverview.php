<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Subscription;
use App\Models\Wish;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $ttl = 300;

        $stats = Cache::remember('filament-dashboard-stats', $ttl, function () {
            $revenue = Subscription::where('payment_status', 'settlement')->sum('amount');
            $pendingOrders = Order::where('payment_status', 'pending')->count();
            $verifyingOrders = Order::where('payment_status', 'verifying')->count();
            $activeInvitations = Invitation::where('is_active', true)->count();
            $totalWishes = Wish::count();
            $totalUsers = User::count();
            $totalInvitations = Invitation::count();

            return compact(
                'revenue', 'pendingOrders', 'verifyingOrders',
                'activeInvitations', 'totalWishes', 'totalUsers', 'totalInvitations'
            );
        });

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($stats['revenue'], 0, ',', '.'))
                ->description('Pembayaran sukses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Pesanan Pending', $stats['pendingOrders'])
                ->description($stats['verifyingOrders'] . ' menunggu verifikasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color($stats['pendingOrders'] > 0 ? 'warning' : 'gray'),

            Stat::make('Undangan Aktif', $stats['activeInvitations'])
                ->description('Dari total ' . $stats['totalInvitations'] . ' undangan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary'),

            Stat::make('Total Pengguna', $stats['totalUsers'])
                ->description('Akun terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Total Undangan', $stats['totalInvitations'])
                ->description('Semua undangan')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),

            Stat::make('Total Ucapan', $stats['totalWishes'])
                ->description('Pesan dari tamu')
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center')
                ->color('gray'),
        ];
    }
}
