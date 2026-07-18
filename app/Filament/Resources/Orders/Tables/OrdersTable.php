<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_id')
                    ->label('Invoice ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('package_type')
                    ->label('Paket')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'silver' => 'gray',
                        'gold' => 'warning',
                        'platinum' => 'purple',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                TextColumn::make('gross_amount')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('unique_code')
                    ->label('Kode Unik')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_with_code_raw')
                    ->label('Total Transfer')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'verifying' => 'info',
                        'success' => 'success',
                        'failed' => 'danger',
                        'expired' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'verifying' => 'Verifying (WA)',
                        'success' => 'Success',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('payment_method_used')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual_bank' => 'warning',
                        'midtrans' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'manual_bank' => 'Bank Manual',
                        'midtrans' => 'Midtrans',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->label('Filter Status')
                    ->options([
                        'pending' => 'Pending',
                        'verifying' => 'Verifying (WA)',
                        'success' => 'Success',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                    ]),
                SelectFilter::make('payment_method_used')
                    ->label('Metode Pembayaran')
                    ->options([
                        'manual_bank' => 'Bank Manual',
                        'midtrans' => 'Midtrans',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationMode(PaginationMode::Simple)
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
            ])
            ->bulkActions([]);
    }
}

