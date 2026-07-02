<?php

namespace App\Filament\Resources\AddonTransactions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class AddonTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('reference_order_id')
                    ->label('Reference Order ID')
                    ->disabled()
                    ->maxLength(100),
                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'verifying' => 'Verifying (WA)',
                        'settlement' => 'Settlement',
                        'deny' => 'Deny',
                        'expire' => 'Expire',
                        'cancel' => 'Cancel',
                    ])
                    ->required(),
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'midtrans' => 'Midtrans',
                        'manual_bank' => 'Bank Manual',
                    ])
                    ->nullable(),
                TextInput::make('amount')
                    ->label('Total Harga')
                    ->disabled()
                    ->numeric()
                    ->prefix('Rp'),
                DateTimePicker::make('paid_at')
                    ->label('Waktu Dibayar')
                    ->disabled(),
            ]);
    }
}
