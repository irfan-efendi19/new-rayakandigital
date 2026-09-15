<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Affiliates\Pages\ListAffiliates;
use App\Models\Affiliate;
use App\Models\AffiliateTier;
use App\Services\AffiliateService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AffiliateResource extends Resource
{
    protected static ?string $model = Affiliate::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Kemitraan';

    protected static ?string $navigationLabel = 'Mitra Reseller';

    protected static ?string $modelLabel = 'Mitra';

    protected static ?string $pluralModelLabel = 'Mitra Reseller';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() && ! auth()->user()->is_banned;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'tier', 'promotion']);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('business_name')->label('Usaha / Brand')->searchable(),
            TextColumn::make('user.email')->label('Email')->searchable(),
            TextColumn::make('partner_type')->label('Jenis')->formatStateUsing(fn ($state) => Affiliate::TYPES[$state] ?? $state),
            TextColumn::make('phone')->label('WhatsApp'),
            TextColumn::make('status')->label('Status')->badge()->formatStateUsing(fn ($state) => Affiliate::STATUSES[$state] ?? $state),
            TextColumn::make('tier.name')->label('Tier')->placeholder('Global'),
            TextColumn::make('commission_rate')->label('Komisi kustom (%)')->placeholder('Mengikuti tier / global'),
            TextColumn::make('promotion.code')->label('Kupon')->copyable(),
            TextColumn::make('created_at')->label('Mendaftar')->dateTime('d M Y')->sortable(),
        ])->filters([SelectFilter::make('status')->options(Affiliate::STATUSES)])
            ->recordActions([
                Action::make('review')->label('Verifikasi & komisi')->icon('heroicon-o-pencil-square')
                    ->fillForm(fn (Affiliate $record) => [
                        'status' => $record->status, 'affiliate_tier_id' => $record->affiliate_tier_id,
                        'commission_rate' => $record->commission_rate, 'review_note' => $record->review_note,
                    ])
                    ->schema([
                        Select::make('status')->label('Status mitra')->options(Affiliate::STATUSES)->required(),
                        Select::make('affiliate_tier_id')->label('Tier komisi')->options(fn () => AffiliateTier::pluck('name', 'id'))->nullable(),
                        TextInput::make('commission_rate')->label('Komisi kustom (%)')->numeric()->minValue(0)->maxValue(100)->step(0.01)->nullable()
                            ->helperText('Kosongkan untuk mengikuti tier, atau komisi global jika tier kosong.'),
                        Textarea::make('review_note')->label('Catatan untuk mitra')->maxLength(2000),
                    ])->action(fn (Affiliate $record, array $data) => app(AffiliateService::class)->review($record, auth()->user(), $data)),
            ])->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return ['index' => ListAffiliates::route('/')];
    }
}
