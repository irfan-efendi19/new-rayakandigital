<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class WeddingPlannerItem extends Model
{
    public const CATEGORIES = [
        'CALENDAR',
        'CHECKLIST',
        'ENGAGEMENT',
        'PRE_WEDDING',
        'SESERAHAN',
        'ADMINISTRATION',
        'BUDGET',
        'VENDOR',
    ];

    public const STATUSES = [
        'PENDING',
        'IN_PROGRESS',
        'COMPLETED',
        'CANCELLED',
    ];

    public const VENDOR_TYPES = [
        'VENUE' => 'Venue',
        'CATERING' => 'Makanan',
        'MUA' => 'MUA',
        'TRANSPORT' => 'Transportasi',
        'CEREMONY' => 'Ceremony',
        'DOCUMENTATION' => 'Dokumentasi',
        'OTHER' => 'Lain-lain',
    ];

    public const PRE_WEDDING_ITEMS = [
        'Make up',
        'Hairdo',
        'Nail art',
        'Baju pria',
        'Baju wanita',
        'Aksesoris',
        'Photografer',
        'Videografer',
        'Transport',
        'Lokasi',
    ];

    public const ENGAGEMENT_ITEMS = [
        'VENUE' => ['Dekor', 'Tenda'],
        'DOCUMENTATION' => ['Photografer', 'Videografer / WCC'],
        'MAKEUP' => ['Make up', 'Soflens', 'Nail art'],
        'CLOTHING' => ['Kain', 'Batik pria', 'Dress wanita'],
        'CATERING' => ['Snack', 'Catering'],
        'HANTARAN' => ['Seserahan', 'Hantaran (makanan)'],
        'OTHER' => ['MC', 'Bucket', 'Transport'],
    ];

    public const ENGAGEMENT_GROUP_LABELS = [
        'VENUE' => 'Venue',
        'DOCUMENTATION' => 'Dokumentasi',
        'MAKEUP' => 'Make Up',
        'CLOTHING' => 'Pakaian',
        'CATERING' => 'Konsumsi',
        'HANTARAN' => 'Seserahan & Hantaran',
        'OTHER' => 'Lain-lain',
    ];

    /**
     * Preset seserahan dibagi per pihak: PRIA (calon pengantin pria) dan
     * WANITA (calon pengantin wanita). Masing-masing item disimpan dengan
     * subcategory = 'PRIA' | 'WANITA'.
     *
     * @var array<string, array<int, string>>
     */
    public const SESERAHAN_ITEMS = [
        'PRIA' => [
            'Hantaran',
            'Alat sholat (mukena & sajadah)',
            'Al-Qur\'an',
            'Parfum',
            'Jam tangan',
            'Tas',
            'Sepatu',
            'Perhiasan',
        ],
        'WANITA' => [
            'Kosmetik set',
            'Skincare set',
            'Set pakaian muslim',
            'Mukena',
            'Parfum',
            'Tas',
            'Sepatu',
            'Perhiasan',
            'Kue hantaran',
        ],
    ];

    /**
     * Label grup seserahan berdasarkan subcategory.
     *
     * @var array<string, string>
     */
    public const SESERAHAN_PARTIES = [
        'PRIA' => 'Seserahan Pria',
        'WANITA' => 'Seserahan Wanita',
    ];

    protected $fillable = [
        'user_id',
        'category',
        'subcategory',
        'vendor_type',
        'title',
        'description',
        'estimated_cost',
        'actual_cost',
        'paid_amount',
        'cost_pria',
        'cost_wanita',
        'vendor_contact',
        'event_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'estimated_cost' => 'decimal:2',
            'actual_cost' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'cost_pria' => 'decimal:2',
            'cost_wanita' => 'decimal:2',
            'event_date' => 'datetime',
            'status' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isFinancialCategory(): bool
    {
        return in_array($this->category, ['BUDGET', 'VENDOR']);
    }

    public function getRemainingBalanceAttribute(): float
    {
        return (float) $this->actual_cost - (float) $this->paid_amount;
    }

    /**
     * Membuat preset item persiapan pre-wedding (10 item), rencana
     * pertunangan (17 item di 7 kategori), dan seserahan (17 item
     * terbagi dalam 2 kelompok pihak: PRIA & WANITA) untuk seorang pengguna.
     *
     * Idempotent: item yang sudah ada pada kategori terkait tidak
     * di-duplikasi sehingga data pengguna tetap dipertahankan.
     */
    public static function initializePresets(User $user): void
    {
        DB::transaction(function () use ($user) {
            if (! self::where('user_id', $user->id)->where('category', 'PRE_WEDDING')->exists()) {
                foreach (self::PRE_WEDDING_ITEMS as $title) {
                    self::create([
                        'user_id' => $user->id,
                        'category' => 'PRE_WEDDING',
                        'title' => $title,
                        'status' => 'PENDING',
                    ]);
                }
            }

            if (! self::where('user_id', $user->id)->where('category', 'ENGAGEMENT')->exists()) {
                foreach (self::ENGAGEMENT_ITEMS as $group => $titles) {
                    foreach ($titles as $title) {
                        self::create([
                            'user_id' => $user->id,
                            'category' => 'ENGAGEMENT',
                            'subcategory' => $group,
                            'title' => $title,
                            'status' => 'PENDING',
                        ]);
                    }
                }
            }

            // Tata ulang item seserahan lama (versi flat tanpa subcategory)
            // ke kelompok pihak yang sesuai berdasarkan judul preset.
            self::where('user_id', $user->id)
                ->where('category', 'SESERAHAN')
                ->whereNull('subcategory')
                ->get()
                ->each(function (self $item) {
                    if (in_array($item->title, self::SESERAHAN_ITEMS['PRIA'], true)) {
                        $item->subcategory = 'PRIA';
                    } elseif (in_array($item->title, self::SESERAHAN_ITEMS['WANITA'], true)) {
                        $item->subcategory = 'WANITA';
                    } else {
                        return;
                    }
                    $item->save();
                });

            // Seed preset seserahan per pihak. Sebuah pihak hanya di-seed bila
            // belum memiliki item seserahan sama sekali, sehingga daftar item
            // yang sudah disusun pengguna tidak ditimpa maupun diduplikasi.
            foreach (self::SESERAHAN_ITEMS as $party => $titles) {
                if (self::where('user_id', $user->id)
                    ->where('category', 'SESERAHAN')
                    ->where('subcategory', $party)
                    ->exists()) {
                    continue;
                }

                foreach ($titles as $title) {
                    self::create([
                        'user_id' => $user->id,
                        'category' => 'SESERAHAN',
                        'subcategory' => $party,
                        'title' => $title,
                        'status' => 'PENDING',
                    ]);
                }
            }
        });
    }
}
