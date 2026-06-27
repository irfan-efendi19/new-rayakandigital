<?php

namespace App\Filament\Resources\QuoteTemplates\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuoteTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('label')
                    ->label('Label')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Nama pendek untuk tombol, contoh: Ar-Rum 21'),

                Textarea::make('content')
                    ->label('Konten Kutipan')
                    ->required()
                    ->rows(4)
                    ->helperText('Isi kutipan atau ayat suci lengkap'),

                TextInput::make('source')
                    ->label('Sumber')
                    ->required()
                    ->maxLength(200)
                    ->helperText('Contoh: QS. Ar-Rum: 21, Doa Pernikahan, Kahlil Gibran'),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->helperText('Semakin kecil angka, semakin awal muncul'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
