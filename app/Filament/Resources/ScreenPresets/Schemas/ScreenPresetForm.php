<?php

namespace App\Filament\Resources\ScreenPresets\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ScreenPresetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Preset')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, string $state, Set $set): void {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->label('Slug (Identifier Unik)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Digunakan sebagai nilai selected_theme. Contoh: midnight-gold'),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->nullable()
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),

                FileUpload::make('zip_file')
                    ->label('Paket Template (ZIP)')
                    ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                    ->disk('public')
                    ->directory('temp_screen_preset_uploads')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->hidden(fn (string $operation): bool => $operation !== 'create')
                    ->helperText('Upload file ZIP yang berisi index.html, css/style.css, js/main.js, dan folder assets/.')
                    ->columnSpanFull(),

                FileUpload::make('zip_file_edit')
                    ->label('Ganti Paket Template (ZIP)')
                    ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                    ->disk('public')
                    ->directory('temp_screen_preset_uploads')
                    ->hidden(fn (string $operation): bool => $operation !== 'edit')
                    ->helperText('Biarkan kosong jika tidak ingin mengubah template. Upload ZIP baru hanya jika ingin mengganti.')
                    ->columnSpanFull(),

                FileUpload::make('thumbnail_image')
                    ->label('Thumbnail Preview')
                    ->image()
                    ->disk('public')
                    ->directory('screen-presets/thumbnails')
                    ->imagePreviewHeight('200')
                    ->nullable()
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
