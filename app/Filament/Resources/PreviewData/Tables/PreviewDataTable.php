<?php

namespace App\Filament\Resources\PreviewData\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PreviewDataTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('bride_photo')
                    ->label('Foto Wanita')
                    ->disk('public')
                    ->width(50)
                    ->height(50)
                    ->square(),
                ImageColumn::make('groom_photo')
                    ->label('Foto Pria')
                    ->disk('public')
                    ->width(50)
                    ->height(50)
                    ->square(),
                TextColumn::make('bride_name')
                    ->label('Mempelai Wanita')
                    ->searchable(),
                TextColumn::make('groom_name')
                    ->label('Mempelai Pria')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Terakhir Diperbarui')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
