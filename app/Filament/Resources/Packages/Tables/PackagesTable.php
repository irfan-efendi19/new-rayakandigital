<?php

namespace App\Filament\Resources\Packages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('package_code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                TextColumn::make('package_name')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('active_period_days')
                    ->label('Masa Aktif')
                    ->formatStateUsing(fn ($state) => $state === 0 ? 'Seumur Hidup' : $state . ' Hari')
                    ->sortable(),
                IconColumn::make('is_visible')
                    ->label('Tampil')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_popular')
                    ->label('Populer')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('features_count')
                    ->label('Fasilitas')
                    ->counts('features')
                    ->sortable(),
            ])
            ->filters([])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
