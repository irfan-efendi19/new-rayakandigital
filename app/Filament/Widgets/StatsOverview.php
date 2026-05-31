<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Invitation;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $revenue = Subscription::where('payment_status', 'settlement')->sum('amount');
        
        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($revenue, 0, ',', '.'))
                ->description('Total completed payments')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Total Users', User::count())
                ->description('Registered accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('Total Invitations', Invitation::count())
                ->description('Active invitations')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->color('warning'),
        ];
    }
}
