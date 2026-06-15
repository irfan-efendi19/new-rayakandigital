<?php

namespace App\Filament\Resources\WhatsappGatewaySettings;

use App\Filament\Resources\WhatsappGatewaySettings\Pages\CreateWhatsappGatewaySetting;
use App\Filament\Resources\WhatsappGatewaySettings\Pages\EditWhatsappGatewaySetting;
use App\Filament\Resources\WhatsappGatewaySettings\Pages\ListWhatsappGatewaySettings;
use App\Filament\Resources\WhatsappGatewaySettings\Schemas\WhatsappGatewaySettingForm;
use App\Filament\Resources\WhatsappGatewaySettings\Tables\WhatsappGatewaySettingsTable;
use App\Models\WhatsappGatewaySetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WhatsappGatewaySettingResource extends Resource
{
    protected static ?string $model = WhatsappGatewaySetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'WhatsApp Gateways';

    protected static ?string $pluralLabel = 'WhatsApp Gateways';

    public static function form(Schema $schema): Schema
    {
        return WhatsappGatewaySettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WhatsappGatewaySettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWhatsappGatewaySettings::route('/'),
            'create' => CreateWhatsappGatewaySetting::route('/create'),
            'edit' => EditWhatsappGatewaySetting::route('/{record}/edit'),
        ];
    }
}
