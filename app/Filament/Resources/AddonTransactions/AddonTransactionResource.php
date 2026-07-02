<?php

namespace App\Filament\Resources\AddonTransactions;

use App\Filament\Resources\AddonTransactions\Pages\ListAddonTransactions;
use App\Filament\Resources\AddonTransactions\Pages\ViewAddonTransaction;
use App\Filament\Resources\AddonTransactions\Schemas\AddonTransactionForm;
use App\Filament\Resources\AddonTransactions\Tables\AddonTransactionsTable;
use App\Models\AddonTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AddonTransactionResource extends Resource
{
    protected static ?string $model = AddonTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?string $navigationLabel = 'Transaksi Add-On';

    protected static ?string $pluralLabel = 'Transaksi Add-On';

    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi & Pembayaran';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AddonTransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddonTransactionsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['invitation', 'addon']);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAddonTransactions::route('/'),
            'view' => ViewAddonTransaction::route('/{record}'),
        ];
    }
}
