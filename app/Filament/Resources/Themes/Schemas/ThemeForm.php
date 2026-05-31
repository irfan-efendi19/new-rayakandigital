<?php

namespace App\Filament\Resources\Themes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class ThemeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('zip_file')
                    ->label('Theme Package (ZIP)')
                    ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                    ->disk('public')
                    ->directory('temp_theme_uploads')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->hidden(fn (string $operation): bool => $operation !== 'create')
                    ->helperText('Upload a ZIP containing index.html and its assets.'),

                TextInput::make('view_path')
                    ->disabled()
                    ->dehydrated(false)
                    ->hidden(fn (string $operation): bool => $operation === 'create')
                    ->helperText('Auto-generated from ZIP extraction.'),

                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatioOptions([
                        '16:9' => 'Landscape (16:9)',
                        '4:3' => 'Standard (4:3)',
                        '1:1' => 'Square (1:1)',
                    ])
                    ->imageEditorMode(1)
                    ->imageEditorViewportWidth(400)
                    ->imageEditorViewportHeight(225)
                    ->disk('public')
                    ->directory('themes/thumbnails')
                    ->imagePreviewHeight('200')
                    ->maxSize(2048)
                    ->columnSpanFull(),

                Toggle::make('is_premium')
                    ->label('Premium Theme'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
