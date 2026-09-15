<?php

namespace App\Filament\Resources\Promotions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PromotionsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->label('Promo')->searchable()->sortable(),
            TextColumn::make('code')->label('Voucher')->placeholder('Otomatis')->searchable(),
            TextColumn::make('discount_value')->label('Diskon')->formatStateUsing(fn ($state, $record) => $record->discount_type === 'PERCENTAGE' ? $state.'%' : 'Rp '.number_format((float) $state, 0, ',', '.')),
            TextColumn::make('timer_type')->label('Timer')->badge(),
            TextColumn::make('end_time')->label('Selesai (WIB)')->dateTime('d M Y H:i', timezone: 'Asia/Jakarta')->placeholder('Per pengunjung')->sortable(),
            TextColumn::make('used_count')->label('Terpakai / Dicadangkan')->sortable(),
            TextColumn::make('usage_limit')->label('Kuota')->placeholder('Tanpa batas'),
            TextColumn::make('paid_count')->label('Pembayaran Sukses')->sortable(),
            TextColumn::make('discount_total')->label('Total Diskon Sukses')->money('IDR', locale: 'id'),
            IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->filters([TernaryFilter::make('is_active')->label('Aktif')])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }
}
