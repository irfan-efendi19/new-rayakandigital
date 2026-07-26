<?php

namespace App\Filament\Widgets;

use App\Models\Invitation;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Wish;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

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

            // Sparkline: last 7 days revenue
            $revenueChart = Subscription::where('payment_status', 'settlement')
                ->where('created_at', '>=', now()->subDays(6))
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date, SUM(amount) as total")
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');

            $revenueChartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $revenueChartData[] = (int) ($revenueChart[now()->subDays($i)->format('Y-m-d')] ?? 0);
            }

            // Sparkline: last 7 days new users
            $usersChart = User::where('created_at', '>=', now()->subDays(6))
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date, COUNT(*) as total")
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');

            $usersChartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $usersChartData[] = (int) ($usersChart[now()->subDays($i)->format('Y-m-d')] ?? 0);
            }

            return compact(
                'revenue', 'pendingOrders', 'verifyingOrders',
                'activeInvitations', 'totalWishes', 'totalUsers', 'totalInvitations',
                'revenueChartData', 'usersChartData'
            );
        });

        // Map the renamed keys for chart access
        $stats['revenueChart'] = $stats['revenueChartData'];
        $stats['usersChart'] = $stats['usersChartData'];

        return [
            Stat::make('Total Pendapatan', 'Rp '.number_format($stats['revenue'], 0, ',', '.'))
                ->description('Pembayaran sukses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($stats['revenueChart']),

            Stat::make('Pesanan Pending', $stats['pendingOrders'])
                ->description($stats['verifyingOrders'].' menunggu verifikasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color($stats['pendingOrders'] > 0 ? 'warning' : 'success'),

            Stat::make('Undangan Aktif', $stats['activeInvitations'])
                ->description('Dari total '.$stats['totalInvitations'].' undangan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary'),

            Stat::make('Total Pengguna', $stats['totalUsers'])
                ->description('Akun terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->chart($stats['usersChart']),

            Stat::make('Total Undangan', $stats['totalInvitations'])
                ->description($stats['activeInvitations'].' aktif saat ini')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),

            Stat::make('Total Ucapan', $stats['totalWishes'])
                ->description('Pesan dari tamu undangan')
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center')
                ->color('gray'),
        ];
    }
}
