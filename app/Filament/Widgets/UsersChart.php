<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class UsersChart extends ChartWidget
{
    protected ?string $heading = 'Registrasi User';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 3;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            '7d' => '7 Hari',
            '30d' => '30 Hari',
            '90d' => '90 Hari',
            '1y' => '1 Tahun',
            'all' => 'Semua',
        ];
    }

    protected function getData(): array
    {
        $period = match ($this->filter) {
            '7d' => [now()->subDays(7), 'day', 7],
            '90d' => [now()->subDays(90), 'day', 90],
            '1y' => [now()->subYear(), 'month', 12],
            'all' => [Carbon::create(2020), 'month', null],
            default => [now()->subDays(30), 'day', 30],
        };

        [$startDate, $groupBy, $periodCount] = $period;

        $users = User::where('created_at', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(created_at, '" . ($groupBy === 'month' ? '%Y-%m-01' : '%Y-%m-%d') . "') as date")
            ->selectRaw('COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $data = [];

        if ($groupBy === 'month') {
            $periodCount ??= 12;
            for ($i = $periodCount; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $label = $date->translatedFormat('M Y');
                $key = $date->format('Y-m-01');
                $labels[] = $label;
                $data[] = $users[$key] ?? 0;
            }
        } else {
            $periodCount ??= 7;
            for ($i = $periodCount; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $label = $date->translatedFormat('d M');
                $key = $date->format('Y-m-d');
                $labels[] = $label;
                $data[] = $users[$key] ?? 0;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'User Baru',
                    'data' => $data,
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
