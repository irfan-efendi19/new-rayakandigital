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
                    ->dehydrated(false) // Handled automatically during creation
                    ->hidden(fn (string $operation): bool => $operation === 'create')
                    ->helperText('Auto-generated from ZIP extraction.'),
                    
                TextInput::make('thumbnail')
                    ->maxLength(255),
                    
                Toggle::make('is_premium')
                    ->label('Premium Theme'),
                    
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
