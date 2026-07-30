<?php

namespace App\Filament\Resources\WaSettings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WaSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('invitation_title')
                    ->label('Judul Undangan')
                    ->content(fn ($record) => $record?->invitation?->title ?? '-'),

                Placeholder::make('user_name')
                    ->label('Nama Pemilik')
                    ->content(fn ($record) => $record?->user?->name ?? $record?->invitation?->user?->name ?? '-'),

                TextInput::make('phone_number')
                    ->label('Nomor WhatsApp (diisi user)')
                    ->disabled()
                    ->columnSpanFull(),

                TextInput::make('fonnte_token')
                    ->label('Fonnte API Token (diisi Admin)')
                    ->password()
                    ->revealable()
                    ->required()
                    ->placeholder('Masukkan API Token Fonnte untuk nomor ini')
                    ->helperText('Token ini berasal dari dashboard Fonnte untuk device nomor tersebut.'),

                Select::make('status')
                    ->label('Status Verifikasi')
                    ->options([
                        'PENDING_VERIFICATION' => 'Pending Verification',
                        'READY_TO_PAIR' => 'Ready to Pair (Token Valid)',
                        'PAIRING' => 'Pairing (Menunggu Scan QR)',
                        'CONNECTED' => 'Connected',
                        'REJECTED' => 'Rejected',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state === 'READY_TO_PAIR' || $state === 'CONNECTED') {
                            $set('verified_at', now());
                        }
                    }),

                Textarea::make('admin_notes')
                    ->label('Catatan Admin (Opsional)')
                    ->placeholder('Isi alasan jika ditolak, atau catatan lainnya...')
                    ->rows(3)
                    ->columnSpanFull(),

                DateTimePicker::make('verified_at')
                    ->label('Tanggal Diverifikasi')
                    ->nullable()
                    ->displayFormat('d M Y H:i'),
            ]);
    }
}
