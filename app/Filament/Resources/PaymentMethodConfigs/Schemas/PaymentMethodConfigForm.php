<?php

namespace App\Filament\Resources\PaymentMethodConfigs\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentMethodConfigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Radio::make('active_method')
                    ->label('Metode Pembayaran Aktif')
                    ->options([
                        'manual_bank' => 'Bank Manual (Transfer + Verifikasi WA)',
                        'midtrans' => 'Automated Gateway (Midtrans)',
                        'doku' => 'DOKU Virtual Account (SNAP API)',
                    ])
                    ->descriptions([
                        'manual_bank' => 'User akan melihat instruksi transfer bank manual dan tombol kirim bukti via WhatsApp. Admin harus memverifikasi pembayaran secara manual.',
                        'midtrans' => 'User akan membayar melalui pop-up Midtrans Snap (QRIS/VA/E-Wallet). Aktivasi berjalan otomatis via webhook.',
                        'doku' => 'User akan memilih bank Virtual Account DOKU (CIMB, Mandiri, BRI, dll). Aktivasi berjalan otomatis via webhook DOKU.',
                    ])
                    ->live()
                    ->required(),

                Section::make('Konfigurasi Bank Manual')
                    ->visible(fn ($get) => $get('active_method') === 'manual_bank')
                    ->schema([
                        TextInput::make('manual_bank_name')
                            ->label('Nama Bank')
                            ->placeholder('BCA / Mandiri / BRI')
                            ->required(fn ($get) => $get('active_method') === 'manual_bank')
                            ->maxLength(50),
                        TextInput::make('manual_account_number')
                            ->label('Nomor Rekening')
                            ->placeholder('1234567890')
                            ->required(fn ($get) => $get('active_method') === 'manual_bank')
                            ->maxLength(50),
                        TextInput::make('manual_account_name')
                            ->label('Atas Nama Rekening')
                            ->placeholder('PT Rayakan Digital Indonesia')
                            ->required(fn ($get) => $get('active_method') === 'manual_bank')
                            ->maxLength(100),
                        TextInput::make('admin_whatsapp_number')
                            ->label('Nomor WhatsApp Admin')
                            ->placeholder('6281234567890')
                            ->helperText('Nomor tujuan redirect bukti transfer. Format internasional tanpa +.')
                            ->required(fn ($get) => $get('active_method') === 'manual_bank')
                            ->maxLength(20),
                    ]),

                Section::make('Konfigurasi Midtrans')
                    ->visible(fn ($get) => $get('active_method') === 'midtrans')
                    ->schema([
                        TextInput::make('midtrans_client_key')
                            ->label('Midtrans Client Key')
                            ->password()
                            ->revealable()
                            ->required(fn ($get) => $get('active_method') === 'midtrans'),
                        TextInput::make('midtrans_server_key')
                            ->label('Midtrans Server Key')
                            ->password()
                            ->revealable()
                            ->required(fn ($get) => $get('active_method') === 'midtrans'),
                        Select::make('midtrans_environment')
                            ->label('Environment')
                            ->options([
                                'sandbox' => 'Sandbox / Staging',
                                'production' => 'Production / Live',
                            ])
                            ->default('sandbox')
                            ->required(fn ($get) => $get('active_method') === 'midtrans'),
                    ]),

                Section::make('Konfigurasi DOKU')
                    ->description('Kredensial dari DOKU Dashboard (https://dashboard.doku.com)')
                    ->visible(fn ($get) => $get('active_method') === 'doku')
                    ->schema([
                        TextInput::make('doku_client_id')
                            ->label('Client ID')
                            ->placeholder('MCH-XXXX-XXXXXXXXXX')
                            ->helperText('Client ID dari DOKU Dashboard → Settings → General Information.')
                            ->required(fn ($get) => $get('active_method') === 'doku'),
                        TextInput::make('doku_secret_key')
                            ->label('Secret Key')
                            ->password()
                            ->revealable()
                            ->helperText('Secret Key dari DOKU Dashboard → Settings → API Keys.')
                            ->required(fn ($get) => $get('active_method') === 'doku'),
                        TextInput::make('doku_private_key')
                            ->label('Private Key (RSA)')
                            ->password()
                            ->revealable()
                            ->helperText('Private Key RSA (format PEM). Generate dari DOKU Dashboard → Settings → Security.')
                            ->required(fn ($get) => $get('active_method') === 'doku'),
                        Select::make('doku_environment')
                            ->label('Environment')
                            ->options([
                                'sandbox' => 'Sandbox / Staging',
                                'production' => 'Production / Live',
                            ])
                            ->default('sandbox')
                            ->required(fn ($get) => $get('active_method') === 'doku'),
                    ]),
            ]);
    }
}
