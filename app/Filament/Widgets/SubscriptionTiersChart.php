<?php

namespace App\Filament\Widgets;

use App\Models\Subscription;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class SubscriptionTiersChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Tier Langganan';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 6;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        return Cache::remember('filament-subscription-tiers', 300, function () {
            $tiers = Subscription::active()
                ->selectRaw('tier, COUNT(*) as total')
                ->groupBy('tier')
                ->orderByDesc('total')
                ->pluck('total', 'tier');

            $colors = [
                'free' => '#9ca3af',
                'bronze' => '#d97706',
                'silver' => '#94a3b8',
                'gold' => '#eab308',
                'platinum' => '#6366f1',
            ];

            return [
                'datasets' => [
                    [
                        'data' => $tiers->values()->toArray(),
                        'backgroundColor' => $tiers->keys()->map(fn ($tier) => $colors[$tier] ?? '#6b7280')->toArray(),
                        'borderWidth' => 0,
                    ],
                ],
                'labels' => $tiers->keys()->map(fn ($tier) => ucfirst($tier))->toArray(),
            ];
        });
    }
}
