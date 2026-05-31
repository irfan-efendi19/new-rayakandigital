<?php

namespace App\Filament\Resources\WhatsappGatewaySettings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class WhatsappGatewaySettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('provider_name')
                    ->label('Provider Name')
                    ->options([
                        'fonnte' => 'Fonnte',
                        'wablas' => 'Wablas',
                        'custom' => 'Custom Server',
                    ])
                    ->required(),
                Textarea::make('api_url')
                    ->label('API URL')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('api_token')
                    ->label('API Key / Token')
                    ->password()
                    ->revealable()
                    ->required(),
                TextInput::make('device_id')
                    ->label('Device ID')
                    ->helperText('Optional — only if provider requires a device ID'),
                TextInput::make('delay_seconds')
                    ->label('Delay Interval (seconds)')
                    ->numeric()
                    ->default(3)
                    ->minValue(1)
                    ->maxValue(60)
                    ->required()
                    ->helperText('Interval between messages to prevent spam blocking'),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(false),
            ]);
    }
}
