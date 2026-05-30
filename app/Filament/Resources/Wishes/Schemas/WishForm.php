<?php

namespace App\Filament\Resources\Wishes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class WishForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('message')
                    ->required()
                    ->maxLength(1000),
                Toggle::make('is_hidden')
                    ->label('Hide from Guestbook'),
            ]);
    }
}
