<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingOrders extends BaseWidget
{
    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 6;

    protected function getTableHeading(): string
    {
        $total = $this->getTableQuery()->count();

        return 'Pesanan Menunggu (' . $total . ')';
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
            Tables\Columns\TextColumn::make('unique_code')
                ->label('Kode Unik')
                ->badge()
                ->color('info')
                ->sortable()
                ->searchable(),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordActions([
                Action::make('activate')
                    ->label('Setujui & Aktifkan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Order $record): bool =>
                        $record->payment_status === 'verifying' && $record->payment_method_used === 'manual_bank'
                    )
                    ->action(function (Order $record) {
                        \App\Filament\Resources\Orders\OrderActions::activate($record);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Setujui & Aktifkan Pesanan')
                    ->modalDescription(fn (Order $record): string =>
                        'Pastikan dana dengan kode unik ' . $record->unique_code . ' sudah masuk ke rekening sebelum mengaktifkan.'
                    )
                    ->modalSubmitActionLabel('Ya, Setujui & Aktifkan'),
                Action::make('view')
                    ->label('Lihat Detail')
                    ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
