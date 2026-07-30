<?php

namespace App\Filament\Resources\WaSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WaSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invitation.title')
                    ->label('Undangan')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Tanpa Undangan'),

                TextColumn::make('user.name')
                    ->label('Nama User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone_number')
                    ->label('Nomor WhatsApp')
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'PENDING_VERIFICATION',
                        'info' => 'READY_TO_PAIR',
                        'primary' => 'PAIRING',
                        'success' => 'CONNECTED',
                        'danger' => 'REJECTED',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'PENDING_VERIFICATION' => 'Pending Verifikasi',
                        'READY_TO_PAIR' => 'Siap Pairing',
                        'PAIRING' => 'Pairing',
                        'CONNECTED' => 'Terhubung',
                        'REJECTED' => 'Ditolak',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('verified_at')
                    ->label('Diverifikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('Belum diverifikasi'),

                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'PENDING_VERIFICATION' => 'Pending Verifikasi',
                        'READY_TO_PAIR' => 'Siap Pairing',
                        'PAIRING' => 'Pairing',
                        'CONNECTED' => 'Terhubung',
                        'REJECTED' => 'Ditolak',
                    ]),
            ])
            ->recordActions([
                EditAction::make()->label('Verifikasi'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
