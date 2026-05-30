<?php

namespace App\Filament\Resources\PaymentMethodConfigs;

use App\Filament\Resources\PaymentMethodConfigs\Pages\EditPaymentMethodConfig;
use App\Filament\Resources\PaymentMethodConfigs\Pages\ListPaymentMethodConfigs;
use App\Filament\Resources\PaymentMethodConfigs\Schemas\PaymentMethodConfigForm;
use App\Filament\Resources\PaymentMethodConfigs\Tables\PaymentMethodConfigsTable;
use App\Models\PaymentMethodConfig;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PaymentMethodConfigResource extends Resource
{
    protected static ?string $model = PaymentMethodConfig::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $navigationLabel = 'Payment Routing';

    protected static ?string $pluralLabel = 'Payment Routing';

    protected static string|\UnitEnum|null $navigationGroup = 'Payments';

    protected static ?int $navigationSort = 0;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return PaymentMethodConfigForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentMethodConfigsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPaymentMethodConfigs::route('/'),
            'edit' => EditPaymentMethodConfig::route('/{record}/edit'),
        ];
    }
}
