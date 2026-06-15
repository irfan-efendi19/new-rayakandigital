<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Select::make('tier')
                    ->label('Tier')
                    ->options([
                        'free' => 'Free',
                        'bronze' => 'Bronze',
                        'silver' => 'Silver',
                        'gold' => 'Gold',
                        'platinum' => 'Platinum',
                    ])
                    ->required()
                    ->default('free'),
                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'settlement' => 'Settlement',
                        'expire' => 'Expire',
                        'cancel' => 'Cancel',
                    ])
                    ->required(),
                TextInput::make('amount')
                    ->label('Jumlah (Rp)')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('midtrans_order_id')
                    ->label('Order ID')
                    ->maxLength(255),
                DateTimePicker::make('starts_at')
                    ->label('Mulai'),
                DateTimePicker::make('expires_at')
                    ->label('Berakhir'),
            ]);
    }
}
