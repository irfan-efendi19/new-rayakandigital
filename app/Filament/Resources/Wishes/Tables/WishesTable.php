<?php

namespace App\Filament\Resources\Wishes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Table;

class WishesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('invitation.title')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->searchable(),
                \Filament\Tables\Columns\IconColumn::make('is_hidden')
                    ->boolean()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('is_hidden')
                    ->label('Visibilitas')
                    ->options([
                        true => 'Tersembunyi',
                        false => 'Tampil',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationMode(PaginationMode::Simple)
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
