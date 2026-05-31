<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersByStatusChart extends ChartWidget
{
    protected ?string $heading = 'Status Pesanan';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 6;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
        return [
            '7d' => '7 Hari',
            '30d' => '30 Hari',
            '90d' => '90 Hari',
            'all' => 'Semua',
        ];
    }

    protected function getData(): array
    {
        $days = match ($this->filter) {
            '7d' => 7,
            '90d' => 90,
            'all' => null,
            default => 30,
        };

        $query = Order::query();
        if ($days) {
            $query->where('created_at', '>=', now()->subDays($days));
        }

        $statuses = (clone $query)
            ->selectRaw('payment_status, COUNT(*) as total')
            ->groupBy('payment_status')
            ->orderByDesc('total')
            ->pluck('total', 'payment_status');

        $labels = [
            'pending' => 'Pending',
            'verifying' => 'Verifying',
            'success' => 'Success',
            'failed' => 'Failed',
            'expired' => 'Expired',
        ];

        $colors = [
            'pending' => '#f59e0b',
            'verifying' => '#3b82f6',
            'success' => '#10b981',
            'failed' => '#ef4444',
            'expired' => '#6b7280',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan',
                    'data' => collect($labels)->map(fn ($_, $key) => $statuses[$key] ?? 0)->values()->toArray(),
                    'backgroundColor' => collect($colors)->only(array_keys($labels))->values()->toArray(),
                    'borderRadius' => 4,
                ],
            ],
            'labels' => collect($labels)->values()->toArray(),
        ];
    }
}
