<?php

namespace App\Filament\Resources\Themes\Schemas;

use App\Models\ThemeCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ThemeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('theme_category_id')
                    ->label('Category')
                    ->relationship('themeCategory', 'name')
                    ->options(ThemeCategory::pluck('name', 'id'))
                    ->nullable(),

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

                FileUpload::make('thumbnail_portrait')
                    ->label('Thumbnail Portrait (9:16)')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatioOptions([
                        '9:16' => 'Portrait Mobile (9:16)',
                    ])
                    ->imageEditorMode(1)
                    ->imageEditorViewportWidth(360)
                    ->imageEditorViewportHeight(640)
                    ->disk('public')
                    ->directory('themes/thumbnails')
                    ->imagePreviewHeight('400')
                    ->columnSpanFull(),

                Toggle::make('is_premium')
                    ->label('Premium Theme'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),

                ThemePreviewDataForm::section(),
            ]);
    }
}
