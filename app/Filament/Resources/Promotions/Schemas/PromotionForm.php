<?php

namespace App\Filament\Resources\Promotions\Schemas;

use App\Models\Package;
use App\Models\Promotion;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PromotionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Kampanye & Diskon')->columns(2)->schema([
                TextInput::make('title')->label('Nama Promo')->required()->maxLength(150),
                TextInput::make('code')->label('Kode Voucher')->maxLength(50)
                    ->regex('/^[A-Za-z0-9_-]+$/')->unique(ignoreRecord: true)
                    ->mutateStateForValidationUsing(fn ($state) => filled($state) ? mb_strtoupper(trim($state)) : null)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? mb_strtoupper(trim($state)) : null)
                    ->helperText('Kosongkan = Promo Otomatis (tampil di Landing Page). Isi = Voucher Manual (hanya via input di Checkout).'),
                Select::make('discount_type')->label('Tipe Diskon')->required()->live()
                    ->options(['PERCENTAGE' => 'Persentase (%)', 'FIXED' => 'Potongan nominal (Rp)'])->default('PERCENTAGE'),
                TextInput::make('discount_value')->label('Nilai Diskon')->required()->numeric()
                    ->minValue(fn (Get $get) => $get('discount_type') === 'PERCENTAGE' ? 0.01 : 1)
                    ->maxValue(fn (Get $get) => $get('discount_type') === 'PERCENTAGE' ? 100 : 9999999999),
                TextInput::make('max_discount_amount')->label('Maksimum Potongan')->prefix('Rp')->numeric()->minValue(1)->maxValue(9999999999),
                TextInput::make('min_order_amount')->label('Minimum Pembelian')->prefix('Rp')->numeric()->minValue(0)->maxValue(9999999999)->default(0)->required(),
                Select::make('package_ids')->label('Berlaku untuk Paket')->multiple()->searchable()
                    ->options(fn () => Package::where('is_visible', true)->where('price', '>', 0)->pluck('package_name', 'id'))
                    ->helperText('Kosongkan untuk semua paket berbayar.')->columnSpanFull(),
                Toggle::make('is_active')->label('Aktifkan Promo')->default(true),
            ])->columnSpanFull(),
            Section::make('Jadwal & Countdown')->columns(2)->schema([
                Select::make('timer_type')->label('Jenis Timer')->required()->live()->default('STATIC')
                    ->options(['STATIC' => 'Tanggal mulai & selesai', 'EVERGREEN' => 'Durasi per pengunjung']),
                TextInput::make('evergreen_duration_minutes')->label('Durasi per Pengunjung (Menit)')
                    ->integer()->minValue(1)->maxValue(525600)->default(120)
                    ->visible(fn (Get $get) => $get('timer_type') === 'EVERGREEN')
                    ->required(fn (Get $get) => $get('timer_type') === 'EVERGREEN'),
                DateTimePicker::make('start_time')->label('Mulai (WIB)')->timezone('Asia/Jakarta')->seconds(false)
                    ->required(fn (Get $get) => $get('timer_type') === 'STATIC'),
                DateTimePicker::make('end_time')->label('Selesai (WIB)')->timezone('Asia/Jakarta')->seconds(false)
                    ->after(fn (Get $get) => filled($get('start_time')) ? 'start_time' : null)
                    ->required(fn (Get $get) => $get('timer_type') === 'STATIC')
                    ->helperText('Evergreen dapat memakai batas akhir kampanye. Data disimpan dalam UTC.'),
            ])->columnSpanFull(),
            Section::make('Batas Penggunaan')->columns(2)->schema([
                TextInput::make('usage_limit')->label('Kuota Total')->integer()->maxValue(4294967295)
                    ->minValue(fn (?Promotion $record) => max(1, $record?->used_count ?? 0))
                    ->helperText('Kosong = tanpa batas. Pesanan menunggu pembayaran ikut mencadangkan kuota.'),
                TextInput::make('per_user_limit')->label('Batas per Pengguna / Email')->integer()->minValue(1)->maxValue(4294967295)
                    ->helperText('Kosong = tanpa batas.'),
            ])->columnSpanFull(),
        ]);
    }
}
