<?php

namespace App\Filament\Resources\ThemeCategories\Schemas;

use App\Models\ThemeCategory;
use App\Support\UniqueSlugGenerator;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
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
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, string $state, Set $set): void {
                        if ($operation === 'create') {
                            $set('slug', UniqueSlugGenerator::generate(ThemeCategory::class, $state));
                        }
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('description')
                    ->label('Description')
                    ->maxLength(255),
            ]);
    }
}
