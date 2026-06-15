<?php

namespace App\Filament\Resources\ThemeCategories;

use App\Filament\Resources\ThemeCategories\Pages\CreateThemeCategory;
use App\Filament\Resources\ThemeCategories\Pages\EditThemeCategory;
use App\Filament\Resources\ThemeCategories\Pages\ListThemeCategories;
use App\Filament\Resources\ThemeCategories\Schemas\ThemeCategoryForm;
use App\Filament\Resources\ThemeCategories\Tables\ThemeCategoriesTable;
use App\Models\ThemeCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ThemeCategoryResource extends Resource
{
    protected static ?string $model = ThemeCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'Kategori Tema';

    protected static ?string $pluralLabel = 'Kategori Tema';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Tema';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'theme-categories';

    public static function form(Schema $schema): Schema
    {
        return ThemeCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThemeCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListThemeCategories::route('/'),
            'create' => CreateThemeCategory::route('/create'),
            'edit' => EditThemeCategory::route('/{record}/edit'),
        ];
    }
}
