<?php

namespace App\Filament\Resources\Promotions\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsagesRelationManager extends RelationManager
{
    protected static string $relationship = 'usages';

    protected static ?string $title = 'Riwayat Penggunaan';

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('order.order_id')->label('Pesanan')->searchable(),
            TextColumn::make('email')->label('Pengguna')->searchable(),
            TextColumn::make('discount_applied')->label('Diskon')->money('IDR', locale: 'id'),
            TextColumn::make('order.payment_status')->label('Pembayaran')->badge(),
            TextColumn::make('created_at')->label('Dicadangkan')->dateTime(timezone: 'Asia/Jakarta'),
            TextColumn::make('confirmed_at')->label('Dibayar')->dateTime(timezone: 'Asia/Jakarta')->placeholder('Belum dibayar'),
            TextColumn::make('released_at')->label('Kuota Dikembalikan')->dateTime(timezone: 'Asia/Jakarta')->placeholder('—'),
        ])->defaultSort('id', 'desc');
    }
}
