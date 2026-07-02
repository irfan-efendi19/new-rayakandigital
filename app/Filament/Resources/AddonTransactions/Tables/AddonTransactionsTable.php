<?php

namespace App\Filament\Resources\AddonTransactions\Tables;

use App\Filament\Resources\AddonTransactions\AddonTransactionResource;
use App\Models\AddonTransaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;

class AddonTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_order_id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('invitation.title')
                    ->label('Undangan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('addon.name')
                    ->label('Add-On')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual_bank' => 'warning',
                        'midtrans' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'manual_bank' => 'Bank Manual',
                        'midtrans' => 'Midtrans',
                        default => $state ?? '-',
                    })
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'verifying' => 'info',
                        'settlement' => 'success',
                        'deny' => 'danger',
                        'expire' => 'gray',
                        'cancel' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'verifying' => 'Verifying (WA)',
                        'settlement' => 'Settlement',
                        'deny' => 'Denied',
                        'expire' => 'Expired',
                        'cancel' => 'Canceled',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label('Dibayar')
                    ->dateTime()
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
                        'settlement' => 'Settlement',
                        'deny' => 'Denied',
                        'expire' => 'Expired',
                        'cancel' => 'Canceled',
                    ]),
                SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'midtrans' => 'Midtrans',
                        'manual_bank' => 'Bank Manual',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationMode(PaginationMode::Simple)
            ->recordActions([
                Action::make('confirm_settlement')
                    ->label('Konfirmasi & Aktifkan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (AddonTransaction $record): bool =>
                        $record->payment_status === 'verifying' && $record->payment_method === 'manual_bank'
                    )
                    ->action(function (AddonTransaction $record) {
                        \App\Filament\Resources\AddonTransactions\AddonTransactionActions::confirmAndActivate($record);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pembayaran Add-On')
                    ->modalDescription(fn (AddonTransaction $record): string =>
                        'Pastikan dana Rp' . number_format((int) $record->amount, 0, ',', '.') . ' sudah masuk ke rekening. Add-on akan langsung aktif untuk undangan ini.'
                    )
                    ->modalSubmitActionLabel('Ya, Konfirmasi & Aktifkan'),
                Action::make('view')
                    ->label('Lihat Detail')
                    ->url(fn (AddonTransaction $record): string => AddonTransactionResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([]);
    }
}
