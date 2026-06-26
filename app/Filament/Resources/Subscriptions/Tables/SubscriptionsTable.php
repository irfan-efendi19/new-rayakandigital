<?php

namespace App\Filament\Resources\Subscriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Table;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('midtrans_order_id')
                    ->label('Order ID')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->colors([
                        'success' => 'settlement',
                        'warning' => 'pending',
                        'danger' => fn ($state) => in_array($state, ['expire', 'cancel']),
                    ])
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'settlement' => 'Settlement',
                        'expire' => 'Expire',
                        'cancel' => 'Cancel',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('tier')
                    ->label('Tier')
                    ->options([
                        'free' => 'Free',
                        'bronze' => 'Bronze',
                        'silver' => 'Silver',
                        'gold' => 'Gold',
                        'platinum' => 'Platinum',
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
