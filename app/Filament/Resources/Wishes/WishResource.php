<?php

namespace App\Filament\Resources\Wishes;

use App\Filament\Resources\Wishes\Pages\CreateWish;
use App\Filament\Resources\Wishes\Pages\EditWish;
use App\Filament\Resources\Wishes\Pages\ListWishes;
use App\Filament\Resources\Wishes\Schemas\WishForm;
use App\Filament\Resources\Wishes\Tables\WishesTable;
use App\Models\Wish;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WishResource extends Resource
{
    protected static ?string $model = Wish::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static ?string $navigationLabel = 'Ucapan';

    protected static ?string $pluralLabel = 'Ucapan';

    protected static string|\UnitEnum|null $navigationGroup = 'Konten Pengguna';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return WishForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WishesTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['invitation']);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWishes::route('/'),
            'create' => CreateWish::route('/create'),
            'edit' => EditWish::route('/{record}/edit'),
        ];
    }
}
