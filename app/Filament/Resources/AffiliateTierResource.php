<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffiliateTiers\Pages\ManageAffiliateTiers;
use App\Models\AffiliateTier;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AffiliateTierResource extends AffiliateResource
{
    protected static ?string $model = AffiliateTier::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Tier Komisi';

    protected static ?string $modelLabel = 'Tier';

    protected static ?string $pluralModelLabel = 'Tier Komisi';

    public static function canCreate(): bool
    {
        return static::canViewAny();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function getEloquentQuery(): Builder
    {
        return AffiliateTier::query();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nama tier')->required()->maxLength(100)->unique(ignoreRecord: true),
            TextInput::make('commission_rate')->label('Komisi (%)')->numeric()->minValue(0)->maxValue(100)->step(0.01)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Tier')->searchable(),
            TextColumn::make('commission_rate')->label('Komisi (%)'),
        ])->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageAffiliateTiers::route('/')];
    }
}
