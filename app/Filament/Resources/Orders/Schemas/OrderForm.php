<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('order_id')
                    ->label('Order ID')
                    ->disabled()
                    ->maxLength(100),
                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'verifying' => 'Verifying (WA)',
                        'success' => 'Success',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                    ])
                    ->required(),
                Select::make('payment_method_used')
                    ->label('Metode Pembayaran')
                    ->options([
                        'manual_bank' => 'Bank Manual',
                        'midtrans' => 'Midtrans',
                    ])
                    ->nullable(),
                TextInput::make('gross_amount')
                    ->label('Total Harga')
                    ->disabled()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('unique_code')
                    ->label('Kode Unik')
                    ->disabled()
                    ->numeric(),
                TextInput::make('package_type')
                    ->label('Paket')
                    ->disabled()
                    ->maxLength(50),
            ]);
    }
}
