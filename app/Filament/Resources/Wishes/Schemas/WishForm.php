<?php

namespace App\Filament\Resources\Wishes\Schemas;

use Filament\Forms\Components\Select;
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
                Select::make('invitation_id')
                    ->label('Undangan')
                    ->relationship('invitation', 'title')
                    ->searchable()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Textarea::make('message')
                    ->label('Pesan')
                    ->required()
                    ->maxLength(1000),
                Toggle::make('is_hidden')
                    ->label('Sembunyikan dari Buku Tamu'),
            ]);
    }
}
