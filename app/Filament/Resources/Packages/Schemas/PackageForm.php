<?php

namespace App\Filament\Resources\Packages\Schemas;

use App\Models\PlatformFeature;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('package_code')
                    ->label('Kode Paket')
                    ->required()
                    ->maxLength(30)
                    ->unique(ignoreRecord: true),
                TextInput::make('package_name')
                    ->label('Nama Paket')
                    ->required()
                    ->maxLength(50),
                TextInput::make('price')
                    ->label('Harga (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->default(0.00),
                TextInput::make('slashed_price')
                    ->label('Harga Coret (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0.00),
                TextInput::make('active_period_days')
                    ->label('Masa Aktif (Hari)')
                    ->numeric()
                    ->required()
                    ->default(30)
                    ->helperText('0 berarti seumur hidup (lifetime)'),
                Textarea::make('description')
                    ->label('Deskripsi Paket')
                    ->columnSpanFull(),
                Toggle::make('is_visible')
                    ->label('Tampilkan di Katalog')
                    ->default(true),
                Toggle::make('is_popular')
                    ->label('Tandai sebagai Populer')
                    ->default(false),
                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
                CheckboxList::make('features')
                    ->label('Fasilitas Paket')
                    ->columnSpanFull()
                    ->columns(2)
                    ->relationship('features', 'feature_name')
                    ->options(PlatformFeature::pluck('feature_name', 'id')),
            ]);
    }
}
