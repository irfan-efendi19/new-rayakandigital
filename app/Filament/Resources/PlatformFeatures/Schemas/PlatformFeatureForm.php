<?php

namespace App\Filament\Resources\PlatformFeatures\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PlatformFeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('feature_key')
                    ->label('Feature Key')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),
                TextInput::make('feature_name')
                    ->label('Nama Fasilitas')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, string $state, Set $set): void {
                        if ($operation === 'create') {
                            $set('feature_key', Str::slug($state));
                        }
                    }),
                TextInput::make('group_name')
                    ->label('Grup')
                    ->default('Dasar')
                    ->maxLength(50)
                    ->helperText('Pengelompokan visual fitur, misal: Dasar, Multimedia, Interaktif'),
                Textarea::make('description')
                    ->label('Deskripsi'),
            ]);
    }
}
