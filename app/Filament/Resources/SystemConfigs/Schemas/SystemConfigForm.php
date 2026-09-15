<?php

namespace App\Filament\Resources\SystemConfigs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SystemConfigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Reseller & Affiliate')
                    ->description('Komisi dihitung dari harga paket setelah diskon. Diskon default berlaku untuk kupon mitra yang baru dibuat.')
                    ->schema([
                        TextInput::make('affiliate_commission_rate')->label('Komisi global (%)')
                            ->numeric()->minValue(0)->maxValue(100)->step(0.01)->required()->default(10),
                        TextInput::make('affiliate_discount_rate')->label('Diskon kupon mitra baru (%)')
                            ->numeric()->minValue(0.01)->maxValue(100)->step(0.01)->required()->default(5),
                        TextInput::make('affiliate_minimum_payout')->label('Minimum pencairan (Rp)')
                            ->integer()->minValue(1)->required()->default(50000),
                    ]),
                Section::make('Pengaturan Trial')
                    ->schema([
                        TextInput::make('demo_duration_days')
                            ->label('Durasi Trial Demo (Hari)')
                            ->integer()
                            ->required()
                            ->default(3)
                            ->minValue(1),
                        TextInput::make('demo_grace_period_days')
                            ->label('Masa Tenggang Grace Period (Hari)')
                            ->integer()
                            ->required()
                            ->default(30)
                            ->minValue(0),
                    ]),
                Section::make('Kuota WA Blast (Global)')
                    ->description('Batas maksimum pesan WhatsApp blast per undangan. Berlaku untuk semua undangan sekaligus.')
                    ->schema([
                        TextInput::make('wa_blast_quota_limit')
                            ->label('Kuota WA Blast Global')
                            ->integer()
                            ->minValue(0)
                            ->placeholder('Kosongkan untuk tidak terbatas')
                            ->helperText('Maksimum jumlah pesan blast yang boleh dikirim setiap undangan. Kosongkan agar unlimited.')
                            ->nullable(),
                    ]),
                Section::make('WhatsApp & Bank (Verifikasi Manual)')
                    ->schema([
                        TextInput::make('whatsapp_number')
                            ->label('Nomor WhatsApp Platform')
                            ->placeholder('6281234567890')
                            ->helperText('Nomor tujuan untuk redirect bukti transfer. Gunakan format internasional tanpa +.')
                            ->maxLength(20)
                            ->nullable(),
                        TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->placeholder('BCA / Mandiri / BRI / dll')
                            ->maxLength(100)
                            ->nullable(),
                        TextInput::make('bank_account_number')
                            ->label('Nomor Rekening')
                            ->placeholder('1234567890')
                            ->maxLength(50)
                            ->nullable(),
                        TextInput::make('bank_account_holder')
                            ->label('Atas Nama Rekening')
                            ->placeholder('PT Rayakan Digital Indonesia')
                            ->maxLength(100)
                            ->nullable(),
                    ]),
            ]);
    }
}
