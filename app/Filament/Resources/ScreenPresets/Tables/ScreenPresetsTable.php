<?php

namespace App\Filament\Resources\ScreenPresets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ScreenPresetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_image')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->height(60)
                    ->width(60)
                    ->defaultImageUrl(asset('img/thumnail.jpg')),

                TextColumn::make('name')
                    ->label('Nama Preset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('zip_path')
                    ->label('File ZIP')
                    ->icon('heroicon-o-archive-box')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn (?string $state): string => $state ? 'Yes' : 'No (HTML langsung)'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        true => 'Aktif',
                        false => 'Nonaktif',
                    ]),
            ])
            ->defaultSort('name')
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
