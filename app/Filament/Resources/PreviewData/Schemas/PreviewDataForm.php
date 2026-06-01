<?php

namespace App\Filament\Resources\PreviewData\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PreviewDataForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Mempelai')
                    ->schema([
                        TextInput::make('bride_name')
                            ->label('Nama Mempelai Wanita')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('groom_name')
                            ->label('Nama Mempelai Pria')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('bride_nickname')
                            ->label('Nama Panggilan Wanita')
                            ->nullable()
                            ->maxLength(100),
                        TextInput::make('groom_nickname')
                            ->label('Nama Panggilan Pria')
                            ->nullable()
                            ->maxLength(100),
                        TextInput::make('bride_parents')
                            ->label('Nama Orang Tua Wanita')
                            ->nullable()
                            ->maxLength(255),
                        TextInput::make('groom_parents')
                            ->label('Nama Orang Tua Pria')
                            ->nullable()
                            ->maxLength(255),
                        TextInput::make('title')
                            ->label('Judul Undangan')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
                Section::make('Waktu & Tempat')
                    ->schema([
                        TextInput::make('event_date_offset_days')
                            ->label('Jarak Hari Acara (dari hari ini)')
                            ->integer()
                            ->required()
                            ->default(60)
                            ->minValue(1)
                            ->helperText('Acara akan ditampilkan mundur X hari dari tanggal sekarang.'),
                        TextInput::make('event_time')
                            ->label('Jam Mulai')
                            ->required()
                            ->maxLength(10),
                        TextInput::make('event_time_end')
                            ->label('Jam Selesai')
                            ->nullable()
                            ->maxLength(10),
                        TextInput::make('venue_name')
                            ->label('Nama Tempat')
                            ->nullable()
                            ->maxLength(255),
                        Textarea::make('venue_address')
                            ->label('Alamat Lengkap')
                            ->nullable()
                            ->rows(2),
                        TextInput::make('venue_maps_url')
                            ->label('Link Google Maps')
                            ->nullable()
                            ->url()
                            ->maxLength(255),
                    ])->columns(2),
                Section::make('Kutipan')
                    ->schema([
                        Textarea::make('quote_content')
                            ->label('Isi Kutipan / Ayat Suci')
                            ->nullable()
                            ->rows(3)
                            ->helperText('Kutipan yang akan ditampilkan di halaman undangan.'),
                        TextInput::make('quote_source')
                            ->label('Sumber Kutipan')
                            ->nullable()
                            ->maxLength(150)
                            ->placeholder('Contoh: QS. Ar-Rum: 21, Kahlil Gibran'),
                    ]),
                Section::make('Cerita Cinta (Timeline)')
                    ->schema([
                        Repeater::make('stories')
                            ->label('Momen Cerita Cinta')
                            ->schema([
                                TextInput::make('story_date')
                                    ->label('Waktu / Tanggal')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Januari 2020, 12 Desember 2025, Tahun 2022'),
                                Textarea::make('story_description')
                                    ->label('Cerita')
                                    ->required()
                                    ->rows(3),
                            ])->addActionLabel('+ Tambah Momen')
                            ->helperText('Tambahkan momen-momen berharga dalam timeline perjalanan cinta Anda.'),
                    ]),
                Section::make('Galeri Foto')
                    ->schema([
                        Textarea::make('gallery_photos')
                            ->label('URL Foto Galeri (satu URL per baris)')
                            ->nullable()
                            ->rows(3)
                            ->helperText('Masukkan URL gambar, satu per baris.')
                            ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n", $state) : ($state ?? ''))
                            ->dehydrateStateUsing(fn ($state) => array_values(array_filter(array_map('trim', explode("\n", $state ?? ''))))),
                    ]),
                Section::make('Kado Digital')
                    ->schema([
                        Repeater::make('gift_banks')
                            ->label('Akun Bank')
                            ->schema([
                                TextInput::make('bank_name')
                                    ->label('Nama Bank')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('account_number')
                                    ->label('Nomor Rekening')
                                    ->required()
                                    ->maxLength(50),
                                TextInput::make('account_holder')
                                    ->label('Atas Nama')
                                    ->nullable()
                                    ->maxLength(100),
                            ])->columns(2)->addActionLabel('+ Tambah Bank'),
                        Repeater::make('gift_ewallets')
                            ->label('Dompet Digital (E-Wallet)')
                            ->schema([
                                TextInput::make('wallet_name')
                                    ->label('Nama E-Wallet')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('GoPay, OVO, Dana, dll.'),
                                TextInput::make('wallet_number')
                                    ->label('Nomor E-Wallet')
                                    ->required()
                                    ->maxLength(50),
                            ])->columns(2)->addActionLabel('+ Tambah E-Wallet'),
                    ]),
                Section::make('Daftar Acara (Multi-Event)')
                    ->schema([
                        Repeater::make('events')
                            ->label('Acara')
                            ->schema([
                                TextInput::make('event_title')
                                    ->label('Nama Acara')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('date_offset_days')
                                    ->label('Offset Hari (dari tanggal utama)')
                                    ->integer()
                                    ->required()
                                    ->default(0)
                                    ->helperText('0 = sama dengan tanggal utama, 1 = H+1, dst.'),
                                TextInput::make('start_time')
                                    ->label('Jam Mulai')
                                    ->required()
                                    ->maxLength(10),
                                TextInput::make('end_time')
                                    ->label('Jam Selesai')
                                    ->nullable()
                                    ->maxLength(10),
                                Toggle::make('is_until_finished')
                                    ->label('Sampai Selesai')
                                    ->default(false),
                                TextInput::make('place_name')
                                    ->label('Nama Tempat')
                                    ->required()
                                    ->maxLength(150),
                                Textarea::make('place_address')
                                    ->label('Alamat')
                                    ->required()
                                    ->rows(2),
                                TextInput::make('google_maps_url')
                                    ->label('Link Google Maps')
                                    ->nullable()
                                    ->url(),
                            ])->columns(2)->addActionLabel('+ Tambah Acara'),
                    ]),
            ]);
    }
}
