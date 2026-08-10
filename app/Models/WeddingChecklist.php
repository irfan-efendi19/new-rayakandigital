<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class WeddingChecklist extends Model
{
    /**
     * 9 kategori preset checklist (PRD section 4 & 14).
     *
     * @var array<string, string> code => nama kategori
     */
    public const CATEGORIES = [
        'ADMINISTRATION' => 'Administrasi & Legal',
        'ATTIRE_BEAUTY' => 'Attire & Rias Pengantin',
        'MAHAR_SESERAHAN' => 'Mahar & Seserahan',
        'VENUE_DECOR' => 'Venue & Dekorasi',
        'DOCUMENTATION' => 'Dokumentasi & Media',
        'ENTERTAINMENT' => 'Pengisi Acara & Entertainment',
        'CATERING' => 'Konsumsi & Catering',
        'GUEST_LOGISTICS' => 'Undangan & Logistik Tamu',
        'OPERATIONS' => 'Koordinasi Tim & Operasional',
    ];

    /**
     * 40 preset checklist items (PRD section 4).
     *
     * @var array<string, array<int, string>> code => daftar judul item
     */
    public const PRESETS = [
        'ADMINISTRATION' => [
            'Daftar pernikahan ke KUA',
            'Izin cuti menikah',
        ],
        'ATTIRE_BEAUTY' => [
            'Rias pengantin',
            'Nail art',
            'Henna wedding',
            'Rias orang tua dan besan',
            'Baju pengantin akad',
            'Baju pengantin resepsi',
            'Baju orang tua dan besan',
            'Baju pendamping (pagar ayu)',
        ],
        'MAHAR_SESERAHAN' => [
            'Mahar',
            'Cincin nikah',
            'Kotak cincin',
            'Seserahan',
            'Kotak seserahan',
        ],
        'VENUE_DECOR' => [
            'Dekorasi',
            'Tenda',
        ],
        'DOCUMENTATION' => [
            'Prewedding',
            'Fotografer',
            'Videografer',
            'Wedding Content Creator',
            'Photobooth',
        ],
        'ENTERTAINMENT' => [
            'MC',
            'Tilawah',
            'Sambutan',
            'Hiburan',
        ],
        'CATERING' => [
            'Catering',
            'Snack',
        ],
        'GUEST_LOGISTICS' => [
            'Daftar tamu undangan',
            'Undangan digital',
            'Undangan cetak',
            'Buku tamu',
            'Souvenir',
        ],
        'OPERATIONS' => [
            'WO',
            'Rundown acara',
            'Susunan panitia',
            'Briefing vendor',
            'Briefing keluarga',
            'Bridesmaid',
            'Transport',
        ],
    ];

    /**
     * 18 dokumen persyaratan Administrasi & Legal, masing-masing
     * memiliki 2 checkbox (Pria & Wanita).
     *
     * @var array<int, string>
     */
    public const ADMINISTRATION_DOCUMENTS = [
        'Pendaftaran KUA',
        'FC KTP calon pengantin',
        'FC KTP ke dua orangtua',
        'FC KK (Kartu Keluarga)',
        'FC buku nikah orangtua',
        'FC akta kelahiran',
        'FC ijazah terakhir',
        'FC KTP saksi pihak',
        'Materai 10.000',
        'Pas foto ukuran 2x3, 3x4 dan 4x6 background biru',
        'Surat pengantar dari RT/RW',
        'Surat keterangan sehat',
        'Surat N1, N2, N3, N4 dari kelurahan',
        'Surat N5 (surat izin orangtua) jika pengantin belum berusia 21 tahun',
        'Surat N6 (surat kematian) jika calon pengantin cerai mati',
        'Akta cerai jika calon pengantin cerai hidup',
        'Surat izin dari atasan jika pengantin TNI/POLRI',
        'Lain-lain',
    ];

    protected $fillable = [
        'invitation_id',
        'category_code',
        'category_name',
        'title',
        'description',
        'is_completed',
        'is_completed_pria',
        'is_completed_wanita',
        'is_preset',
        'is_document',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'is_completed_pria' => 'boolean',
            'is_completed_wanita' => 'boolean',
            'is_preset' => 'boolean',
            'is_document' => 'boolean',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function isPreset(): bool
    {
        return $this->is_preset;
    }

    public function isDocument(): bool
    {
        return $this->is_document;
    }

    /**
     * Jumlah checkbox item: dokumen persyaratan = 2 (Pria & Wanita), item lain = 1.
     */
    public function checkboxCount(): int
    {
        return $this->is_document ? 2 : 1;
    }

    /**
     * Jumlah checkbox yang sudah dicentang.
     */
    public function completedCheckboxCount(): int
    {
        if ($this->is_document) {
            return (int) $this->is_completed_pria + (int) $this->is_completed_wanita;
        }

        return $this->is_completed ? 1 : 0;
    }

    /**
     * Membuat preset checklist items (40 preset + 18 dokumen persyaratan)
     * untuk sebuah undangan dalam satu database transaction (PRD section 15).
     *
     * Idempotent: preset lama dan dokumen yang sudah ada tidak di-duplikasi,
     * sehingga undangan yang dibuat sebelum fitur dokumen tetap mendapatkan
     * 18 dokumen persyaratan saat method ini dipanggil lagi.
     */
    public static function initializePresets(Invitation $invitation): void
    {
        DB::transaction(function () use ($invitation) {
            if (! $invitation->checklists()->where('is_preset', true)->where('is_document', false)->exists()) {
                foreach (self::PRESETS as $code => $titles) {
                    foreach ($titles as $title) {
                        $invitation->checklists()->create([
                            'category_code' => $code,
                            'category_name' => self::CATEGORIES[$code],
                            'title' => $title,
                            'is_completed' => false,
                            'is_preset' => true,
                            'is_document' => false,
                        ]);
                    }
                }
            }

            if (! $invitation->checklists()->where('is_document', true)->exists()) {
                foreach (self::ADMINISTRATION_DOCUMENTS as $title) {
                    $invitation->checklists()->create([
                        'category_code' => 'ADMINISTRATION',
                        'category_name' => self::CATEGORIES['ADMINISTRATION'],
                        'title' => $title,
                        'is_completed' => false,
                        'is_completed_pria' => false,
                        'is_completed_wanita' => false,
                        'is_preset' => true,
                        'is_document' => true,
                    ]);
                }
            }
        });
    }
}
