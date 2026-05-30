<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Select::make('role')
                    ->options([
                        'user' => 'Standard User',
                        'admin' => 'Administrator',
                    ])
                    ->required()
                    ->default('user'),
                Toggle::make('is_banned')
                    ->label('Ban User')
                    ->helperText('Banned users cannot access the tenant dashboard.'),
            ]);
    }
}
