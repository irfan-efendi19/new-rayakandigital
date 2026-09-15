<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarketingAssets\Pages\ManageMarketingAssets;
use App\Models\MarketingAsset;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MarketingAssetResource extends AffiliateResource
{
    protected static ?string $model = MarketingAsset::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Marketing Kit';

    protected static ?string $modelLabel = 'Aset promosi';

    protected static ?string $pluralModelLabel = 'Marketing Kit';

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
        return MarketingAsset::query();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul')->required()->maxLength(150),
            Select::make('category')->label('Jenis aset')->options(MarketingAsset::CATEGORIES)->required(),
            Textarea::make('description')->label('Petunjuk penggunaan')->maxLength(2000),
            FileUpload::make('file_path')->label('File promosi')->disk('local')->directory('marketing-kit')
                ->visibility('private')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                ->maxSize(10240)->required(),
            Toggle::make('is_active')->label('Tampilkan ke mitra')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->label('Aset')->searchable(),
            TextColumn::make('category')->label('Jenis')->formatStateUsing(fn ($state) => MarketingAsset::CATEGORIES[$state] ?? $state),
            IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->recordActions([EditAction::make()])->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return ['index' => ManageMarketingAssets::route('/')];
    }
}
