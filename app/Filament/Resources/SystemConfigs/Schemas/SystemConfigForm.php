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
