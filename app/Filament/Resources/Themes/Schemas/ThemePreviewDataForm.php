<?php

namespace App\Filament\Resources\Themes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class ThemePreviewDataForm
{
    public static function section(): Section
    {
        return Section::make('Data Pratinjau Tema')
            ->description('Data demo khusus untuk preview tema ini. Field kosong akan memakai data default platform.')
            ->hidden(fn (string $operation): bool => $operation === 'create')
            ->schema([
                Section::make('Cover & Judul Undangan')
                    ->schema([
                        FileUpload::make('preview_hero_image_path')
                            ->label('Foto Hero / Cover')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions([
                                '9:16' => 'Portrait (9:16)',
                            ])
                            ->imageEditorMode(1)
                            ->imageEditorViewportWidth(360)
                            ->imageEditorViewportHeight(640)
                            ->disk('public')
                            ->directory('theme_previews')
                            ->imagePreviewHeight('200'),
                        TextInput::make('preview_title')
                            ->label('Judul Undangan')
                            ->maxLength(255)
                            ->placeholder('Contoh: Pernikahan Budi & Ani'),
                    ])->columns(2),
                Section::make('Mempelai Wanita')
                    ->schema([
                        FileUpload::make('preview_bride_photo_path')
                            ->label('Foto Mempelai Wanita')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions([
                                '1:1' => 'Square (1:1)',
                            ])
                            ->imageEditorMode(1)
                            ->imageEditorViewportWidth(400)
                            ->imageEditorViewportHeight(400)
                            ->disk('public')
                            ->directory('theme_previews')
                            ->imagePreviewHeight('200'),
                        TextInput::make('preview_bride_full_name')
                            ->label('Nama Lengkap')
                            ->maxLength(255)
                            ->default('Siti Salsabila'),
                        TextInput::make('preview_bride_short_name')
                            ->label('Nama Panggilan')
                            ->maxLength(255)
                            ->default('Sasa'),
                        TextInput::make('preview_bride_father_name')
                            ->label('Nama Ayah')
                            ->maxLength(255),
                        TextInput::make('preview_bride_mother_name')
                            ->label('Nama Ibu')
                            ->maxLength(255),
                    ])->columns(2),
                Section::make('Mempelai Pria')
                    ->schema([
                        FileUpload::make('preview_groom_photo_path')
                            ->label('Foto Mempelai Pria')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions([
                                '1:1' => 'Square (1:1)',
                            ])
                            ->imageEditorMode(1)
                            ->imageEditorViewportWidth(400)
                            ->imageEditorViewportHeight(400)
                            ->disk('public')
                            ->directory('theme_previews')
                            ->imagePreviewHeight('200'),
                        TextInput::make('preview_groom_full_name')
                            ->label('Nama Lengkap')
                            ->maxLength(255)
                            ->default('Mochammad Irfan'),
                        TextInput::make('preview_groom_short_name')
                            ->label('Nama Panggilan')
                            ->maxLength(255)
                            ->default('Irfan'),
                        TextInput::make('preview_groom_father_name')
                            ->label('Nama Ayah')
                            ->maxLength(255),
                        TextInput::make('preview_groom_mother_name')
                            ->label('Nama Ibu')
                            ->maxLength(255),
                    ])->columns(2),
                Section::make('Musik & Video')
                    ->schema([
                        FileUpload::make('preview_bg_music_path')
                            ->label('Musik Latar (MP3)')
                            ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                            ->disk('public')
                            ->directory('theme_previews')
                            ->maxSize(5120),
                        Toggle::make('preview_show_video')
                            ->label('Tampilkan Video YouTube')
                            ->default(false),
                        TextInput::make('preview_youtube_url')
                            ->label('URL Video YouTube')
                            ->nullable()
                            ->url()
                            ->maxLength(255)
                            ->helperText('Contoh: https://youtube.com/watch?v=xxxxx'),
                        TextInput::make('preview_youtube_video_id')
                            ->label('YouTube Video ID')
                            ->nullable()
                            ->maxLength(50)
                            ->helperText('ID video (11 karakter), otomatis terisi dari URL jika kosong.'),
                    ])->columns(2),
                Section::make('Waktu & Tempat')
                    ->schema([
                        TextInput::make('preview_event_date_offset_days')
                            ->label('Jarak Hari Acara (dari hari ini)')
                            ->integer()
                            ->minValue(1)
                            ->helperText('Acara akan ditampilkan mundur X hari dari tanggal sekarang.'),
                        TextInput::make('preview_event_time')
                            ->label('Jam Mulai')
                            ->maxLength(10),
                        TextInput::make('preview_event_time_end')
                            ->label('Jam Selesai')
                            ->nullable()
                            ->maxLength(10),
                        TextInput::make('preview_timezone')
                            ->label('Zona Waktu')
                            ->maxLength(50)
                            ->default('Asia/Jakarta'),
                        TextInput::make('preview_venue_name')
                            ->label('Nama Tempat')
                            ->nullable()
                            ->maxLength(255),
                        Textarea::make('preview_venue_address')
                            ->label('Alamat Lengkap')
                            ->nullable()
                            ->rows(2),
                        TextInput::make('preview_venue_maps_url')
                            ->label('Link Google Maps')
                            ->nullable()
                            ->url()
                            ->maxLength(255),
                    ])->columns(2),
                Section::make('Kutipan')
                    ->schema([
                        Textarea::make('preview_quote_content')
                            ->label('Isi Kutipan / Ayat Suci')
                            ->nullable()
                            ->rows(3)
                            ->helperText('Kutipan yang akan ditampilkan di halaman undangan.'),
                        TextInput::make('preview_quote_source')
                            ->label('Sumber Kutipan')
                            ->nullable()
                            ->maxLength(150)
                            ->placeholder('Contoh: QS. Ar-Rum: 21, Kahlil Gibran'),
                    ]),
                Section::make('Cerita Cinta (Timeline)')
                    ->schema([
                        Repeater::make('preview_stories')
                            ->label('Momen Cerita Cinta')
                            ->schema([
                                TextInput::make('story_date')
                                    ->label('Waktu / Tanggal')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Januari 2020, 12 Desember 2025, Tahun 2022'),
                                TextInput::make('story_title')
                                    ->label('Judul Momen')
                                    ->nullable()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Pertemuan Pertama, Lamaran'),
                                Textarea::make('story_description')
                                    ->label('Cerita')
                                    ->required()
                                    ->rows(3),
                            ])->addActionLabel('+ Tambah Momen')
                            ->helperText('Tambahkan momen-momen berharga dalam timeline perjalanan cinta.'),
                    ]),
                Section::make('Galeri Foto')
                    ->schema([
                        FileUpload::make('preview_gallery_photos')
                            ->label('Foto Galeri')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('theme_previews/gallery')
                            ->imagePreviewHeight('150')
                            ->maxFiles(20),
                    ]),
                Section::make('Kado Digital')
                    ->schema([
                        Repeater::make('preview_gift_banks')
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
                        Repeater::make('preview_gift_ewallets')
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
                        Repeater::make('preview_events')
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
