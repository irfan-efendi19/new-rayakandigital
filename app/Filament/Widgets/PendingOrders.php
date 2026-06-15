<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingOrders extends BaseWidget
{
    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 6;

    protected function getTableHeading(): string
    {
        $pending = Order::where('payment_status', 'pending')->count();
        $verifying = Order::where('payment_status', 'verifying')->count();

        return 'Pesanan Menunggu (' . ($pending + $verifying) . ')';
    }

    protected function getTableQuery(): Builder
    {
        return Order::whereIn('payment_status', ['pending', 'verifying']);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('invoice_id')
                ->label('Invoice')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('user.name')
                ->label('Pengguna')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('package_type')
                ->label('Paket')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'silver' => 'gray',
                    'gold' => 'warning',
                    'platinum' => 'purple',
                    default => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            Tables\Columns\TextColumn::make('gross_amount')
                ->label('Total')
                ->money('IDR')
                ->sortable(),
            Tables\Columns\TextColumn::make('payment_status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'verifying' => 'info',
                    default => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'pending' => 'Pending',
                    'verifying' => 'Verifikasi',
                    default => $state,
                })
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTablePollingInterval(): ?string
    {
        return '60s';
    }
}
