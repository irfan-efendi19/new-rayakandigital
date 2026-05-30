<?php

namespace App\Filament\Resources\SystemConfigs\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SystemConfigsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('demo_duration_days')
                    ->label('Durasi Trial (Hari)')
                    ->sortable(),
                TextColumn::make('demo_grace_period_days')
                    ->label('Masa Tenggang (Hari)')
                    ->sortable(),
                TextColumn::make('whatsapp_number')
                    ->label('No. WhatsApp')
                    ->searchable(),
                TextColumn::make('bank_name')
                    ->label('Bank')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Terakhir Diperbarui')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                // No delete action
            ]);
    }
}
