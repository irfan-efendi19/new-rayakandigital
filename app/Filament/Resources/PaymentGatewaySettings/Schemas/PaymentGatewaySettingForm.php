<?php

namespace App\Filament\Resources\PaymentGatewaySettings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PaymentGatewaySettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('provider_name')
                    ->label('Provider Name')
                    ->options([
                        'midtrans' => 'Midtrans',
                        'xendit' => 'Xendit',
                        'stripe' => 'Stripe',
                    ])
                    ->required(),
                TextInput::make('client_key')
                    ->label('Client Key')
                    ->password()
                    ->revealable()
                    ->nullable(),
                TextInput::make('server_key')
                    ->label('Server Key')
                    ->password()
                    ->revealable()
                    ->nullable(),
                TextInput::make('webhook_secret')
                    ->label('Webhook Secret')
                    ->password()
                    ->revealable()
                    ->nullable(),
                Select::make('environment')
                    ->label('Environment')
                    ->options([
                        'sandbox' => 'Sandbox / Staging',
                        'production' => 'Production / Live',
                    ])
                    ->required()
                    ->default('sandbox'),
                Toggle::make('is_active')
                    ->label('Active Status')
                    ->default(false),
            ]);
    }
}
