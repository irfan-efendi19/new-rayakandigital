<?php

namespace App\Filament\Resources\WaSettings;

use App\Filament\Resources\WaSettings\Pages\EditWaSetting;
use App\Filament\Resources\WaSettings\Pages\ListWaSettings;
use App\Filament\Resources\WaSettings\Schemas\WaSettingForm;
use App\Filament\Resources\WaSettings\Tables\WaSettingsTable;
use App\Models\WaSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WaSettingResource extends Resource
{
    protected static ?string $model = WaSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Verifikasi WhatsApp User';

    protected static ?string $pluralLabel = 'Verifikasi WhatsApp User';

    protected static ?string $modelLabel = 'Pengajuan WA';

    public static function form(Schema $schema): Schema
    {
        return WaSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WaSettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWaSettings::route('/'),
            'edit' => EditWaSetting::route('/{record}/edit'),
        ];
    }
}
