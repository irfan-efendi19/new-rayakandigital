<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffiliatePayouts\Pages\ListAffiliatePayouts;
use App\Models\AffiliatePayout;
use App\Services\AffiliatePayoutService;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AffiliatePayoutResource extends AffiliateResource
{
    protected static ?string $model = AffiliatePayout::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Pencairan Komisi';

    protected static ?string $modelLabel = 'Pencairan';

    protected static ?string $pluralModelLabel = 'Pencairan Komisi';

    public static function getEloquentQuery(): Builder
    {
        return AffiliatePayout::query()->with('affiliate');
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->label('ID')->sortable(),
            TextColumn::make('affiliate.business_name')->label('Mitra')->searchable(),
            TextColumn::make('amount')->label('Nominal')->money('IDR', locale: 'id'),
            TextColumn::make('bank_name')->label('Bank'),
            TextColumn::make('bank_account_number')->label('Rekening')->copyable(),
            TextColumn::make('bank_account_holder')->label('Atas nama'),
            TextColumn::make('status')->label('Status')->badge()->formatStateUsing(fn ($state) => AffiliatePayout::STATUSES[$state] ?? $state),
            TextColumn::make('transfer_reference')->label('Referensi transfer')->placeholder('Belum ditransfer'),
            TextColumn::make('review_note')->label('Catatan')->limit(50),
            TextColumn::make('created_at')->label('Diajukan')->dateTime('d M Y H:i')->sortable(),
            TextColumn::make('paid_at')->label('Ditransfer')->dateTime('d M Y H:i'),
        ])->filters([SelectFilter::make('status')->options(AffiliatePayout::STATUSES)])
            ->recordActions([
                Action::make('approve')->label('Setujui')->color('success')->requiresConfirmation()
                    ->modalDescription('Saldo tetap dicadangkan. Lakukan transfer manual ke rekening yang tercatat, lalu tandai sudah ditransfer.')
                    ->visible(fn (AffiliatePayout $record) => $record->status === 'pending')
                    ->action(fn (AffiliatePayout $record) => app(AffiliatePayoutService::class)->process($record, auth()->user(), 'approved')),
                Action::make('pay')->label('Sudah ditransfer')->color('success')
                    ->visible(fn (AffiliatePayout $record) => $record->status === 'approved')
                    ->modalDescription('Catat hanya setelah transfer bank berhasil. Tindakan ini mencatat transfer manual.')
                    ->schema([
                        TextInput::make('transfer_reference')->label('Referensi / nomor bukti transfer')->required()->maxLength(150),
                        Textarea::make('review_note')->label('Catatan')->maxLength(2000),
                    ])->action(fn (AffiliatePayout $record, array $data) => app(AffiliatePayoutService::class)
                    ->process($record, auth()->user(), 'paid', $data['review_note'] ?? null, $data['transfer_reference'])),
                Action::make('reject')->label('Tolak')->color('danger')
                    ->visible(fn (AffiliatePayout $record) => in_array($record->status, ['pending', 'approved']))
                    ->schema([Textarea::make('review_note')->label('Alasan penolakan')->required()->maxLength(2000)])
                    ->action(fn (AffiliatePayout $record, array $data) => app(AffiliatePayoutService::class)
                        ->process($record, auth()->user(), 'rejected', $data['review_note'])),
            ])->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return ['index' => ListAffiliatePayouts::route('/')];
    }
}
