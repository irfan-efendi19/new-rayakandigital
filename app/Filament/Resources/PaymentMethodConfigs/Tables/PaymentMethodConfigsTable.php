<?php

namespace App\Filament\Resources\PaymentMethodConfigs\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentMethodConfigsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('active_method')
                    ->label('Metode Aktif')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual_bank' => 'warning',
                        'midtrans' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'manual_bank' => 'Bank Manual',
                        'midtrans' => 'Midtrans Gateway',
                    }),
                TextColumn::make('manual_bank_name')
                    ->label('Bank'),
                TextColumn::make('admin_whatsapp_number')
                    ->label('No. WA Admin'),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
