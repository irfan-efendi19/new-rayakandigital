<?php

namespace App\Filament\Resources\PlatformFeatures;

use App\Filament\Resources\PlatformFeatures\Pages\CreatePlatformFeature;
use App\Filament\Resources\PlatformFeatures\Pages\EditPlatformFeature;
use App\Filament\Resources\PlatformFeatures\Pages\ListPlatformFeatures;
use App\Filament\Resources\PlatformFeatures\Schemas\PlatformFeatureForm;
use App\Filament\Resources\PlatformFeatures\Tables\PlatformFeaturesTable;
use App\Models\PlatformFeature;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PlatformFeatureResource extends Resource
{
    protected static ?string $model = PlatformFeature::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?string $navigationLabel = 'Fitur Paket';

    protected static ?string $pluralLabel = 'Fitur Paket';

    protected static string|\UnitEnum|null $navigationGroup = 'Paket & Fitur';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PlatformFeatureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlatformFeaturesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlatformFeatures::route('/'),
            'create' => CreatePlatformFeature::route('/create'),
            'edit' => EditPlatformFeature::route('/{record}/edit'),
        ];
    }
}
