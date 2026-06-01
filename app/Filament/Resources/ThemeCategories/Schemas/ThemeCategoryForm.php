<?php

namespace App\Filament\Resources\ThemeCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ThemeCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('slug')
                    ->label('Slug')
                    ->helperText('Auto-generated from name if left empty.')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('description')
                    ->label('Description')
                    ->maxLength(255),
            ]);
    }
}
