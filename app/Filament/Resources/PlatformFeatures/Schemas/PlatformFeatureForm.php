<?php

namespace App\Filament\Resources\PlatformFeatures\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PlatformFeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('feature_key')
                    ->label('Feature Key')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->helperText('Contoh: qr_checkin, wa_sender, digital_gift'),
                TextInput::make('feature_name')
                    ->label('Nama Fasilitas')
                    ->required()
                    ->maxLength(100),
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
