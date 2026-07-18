<?php

namespace App\Filament\Resources\ScreenPresets;

use App\Filament\Resources\ScreenPresets\Pages\CreateScreenPreset;
use App\Filament\Resources\ScreenPresets\Pages\EditScreenPreset;
use App\Filament\Resources\ScreenPresets\Pages\ListScreenPresets;
use App\Filament\Resources\ScreenPresets\Schemas\ScreenPresetForm;
use App\Filament\Resources\ScreenPresets\Tables\ScreenPresetsTable;
use App\Models\ScreenPreset;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScreenPresetResource extends Resource
{
    protected static ?string $model = ScreenPreset::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $navigationLabel = 'Preset Layar Sapa';

    protected static ?string $pluralLabel = 'Preset Layar Sapa';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Tema';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ScreenPresetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScreenPresetsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScreenPresets::route('/'),
            'create' => CreateScreenPreset::route('/create'),
            'edit' => EditScreenPreset::route('/{record}/edit'),
        ];
    }
}
