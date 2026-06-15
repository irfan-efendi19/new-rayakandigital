<?php

namespace App\Filament\Resources\Themes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ThemesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('themeCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                \Filament\Tables\Columns\TextColumn::make('view_path')
                    ->searchable(),
                \Filament\Tables\Columns\IconColumn::make('is_premium')
                    ->boolean()
                    ->sortable(),
                \Filament\Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('is_premium')
                    ->label('Tipe')
                    ->options([
                        true => 'Premium',
                        false => 'Reguler',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('is_active')
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
