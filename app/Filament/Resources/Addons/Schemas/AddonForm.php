<?php

namespace App\Filament\Resources\Addons\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AddonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Add-On')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Identifier unik untuk add-on. Contoh: addon-digital-gift'),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->nullable(),
                TextInput::make('price')
                    ->label('Harga (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->default(0.00),
                Select::make('icon_identifier')
                    ->label('Ikon')
                    ->options([
                        'heroicon-o-puzzle-piece' => 'Puzzle Piece',
                        'heroicon-o-musical-note' => 'Musik',
                        'heroicon-o-gift' => 'Kado',
                        'heroicon-o-camera' => 'Kamera',
                        'heroicon-o-video-camera' => 'Video',
                        'heroicon-o-chart-bar' => 'Chart',
                        'heroicon-o-star' => 'Star',
                        'heroicon-o-heart' => 'Heart',
                        'heroicon-o-sparkles' => 'Sparkles',
                        'heroicon-o-globe-alt' => 'Globe',
                        'heroicon-o-rocket-launch' => 'Rocket',
                        'heroicon-o-phone' => 'Phone',
                        'heroicon-o-envelope' => 'Envelope',
                        'heroicon-o-map-pin' => 'Map Pin',
                        'heroicon-o-calendar' => 'Calendar',
                        'heroicon-o-user-group' => 'User Group',
                    ])
                    ->default('heroicon-o-puzzle-piece'),
                Toggle::make('is_available')
                    ->label('Tersedia untuk Dibeli')
                    ->helperText('Nonaktifkan untuk menyembunyikan add-on dari katalog pengguna')
                    ->default(true),
            ]);
    }
}
