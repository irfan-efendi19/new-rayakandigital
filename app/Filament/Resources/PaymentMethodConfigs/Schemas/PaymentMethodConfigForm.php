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
                    ])
                    ->descriptions([
                        'manual_bank' => 'User akan melihat instruksi transfer bank manual dan tombol kirim bukti via WhatsApp. Admin harus memverifikasi pembayaran secara manual.',
                        'midtrans' => 'User akan membayar melalui pop-up Midtrans Snap (QRIS/VA/E-Wallet). Aktivasi berjalan otomatis via webhook.',
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
            ]);
    }
}
