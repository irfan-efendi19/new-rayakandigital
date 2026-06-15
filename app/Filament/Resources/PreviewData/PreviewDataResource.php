<?php

namespace App\Filament\Resources\PreviewData;

use App\Filament\Resources\PreviewData\Pages\EditPreviewData;
use App\Filament\Resources\PreviewData\Pages\ListPreviewData;
use App\Filament\Resources\PreviewData\Schemas\PreviewDataForm;
use App\Filament\Resources\PreviewData\Tables\PreviewDataTable;
use App\Models\PreviewData;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PreviewDataResource extends Resource
{
    protected static ?string $model = PreviewData::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedEye;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Preview Data';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return PreviewDataForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreviewDataTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPreviewData::route('/'),
            'edit' => EditPreviewData::route('/{record}/edit'),
        ];
    }
}
