# Product Requirement Document (PRD)

## SYSTEM SPECIFICATION: WEDDING PLANNER & ORGANIZER SYSTEM

| Atribut               | Detail                                                                |
| :-------------------- | :-------------------------------------------------------------------- |
| **Status**            | Approved / Living Document                                            |
| **Penulis**           | Mochammad Irfan Efendi                                                |
| **Tanggal Pembuatan** | 10 Agustus 2026                                                       |
| **Target Komponen**   | Dashboard User (Pengantin/WO), Database Schema, PDF Export Engine     |
| **Arsitektur Utama**  | **8-Pillar Wedding Planner, Financial Tracker, Event Rundown Engine** |

---

## 1. DESKRIPSI & OBJECTIVE SYSTEM

Sistem ini dirancang khusus sebagai platform perencanaan dan manajemen pernikahan (_wedding planner & organizer_) mandiri bagi calon pengantin maupun Wedding Organizer (WO).

Sistem memfasilitasi pengorganisasian seluruh alur kerja persiapan pernikahan dari H-12 bulan hingga Hari H yang terbagi ke dalam **8 Pilar Utama**:

1. **Calendar:** Management lini masa dan jadwal agenda penting.
2. **Checklist:** _To-do list_ persiapan berdasarkan periode waktu.
3. **Engagement:** Perencanaan acara lamaran dan daftar keluarga.
4. **Pre-Wedding:** Konsep, lokasi, jadwal, dan perlengkapan _pre-wedding_.
5. **Seserahan:** Inventarisasi boks hantaran dan status pembelian barang.
6. **Administrasi:** Tracking berkas nikah KUA / Catatan Sipil & kesehatan (suntik TT).
7. **Budget:** Manajemen kalkulasi estimasi vs realisasi pengeluaran dan status pelunasan.
8. **Vendor:** Direktori kontak vendor, nomor kontrak, DP, dan jadwal pelunasan.

---

## 2. USER JOURNEY & ALUR SISTEM

```text
                     ┌──────────────────────────────────────────────┐
                     │          DASHBOARD USER / PENGANTIN          │
                     └──────────────────────┬───────────────────────┘
                                            │
           ┌────────────────────────────────┴────────────────────────┐
           ▼                                                         ▼
┌────────────────────────────┐                             ┌───────────────────┐
│     Manajemen 8 Modul      │                             │   Rundown Hari H  │
│ (Calendar, Budget, etc.)   │                             │  (Time Schedule)  │
└──────────┬─────────────────┘                             └─────────┬─────────┘
           │                                                         │
           └────────────────────────────────┬────────────────────────┘
                                            │
                                            ▼
                               ┌─────────────────────────┐
                               │   Export PDF & Cetak    │
                               │   (Rundown & Budget)    │
                               └─────────────────────────┘
```

---

## 3. SPESIFIKASI SKEMA DATABASE

### 3.1 Master Planner Items

```sql
-- ==========================================
-- MODUL WEDDING PLANNER (8 PILAR UTAMA)
-- ==========================================

CREATE TABLE wedding_planner_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    category ENUM(
        'CALENDAR',
        'CHECKLIST',
        'ENGAGEMENT',
        'PRE_WEDDING',
        'SESERAHAN',
        'ADMINISTRATION',
        'BUDGET',
        'VENDOR'
    ) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,

    -- Finance & Vendor Attributes (Khusus BUDGET & VENDOR)
    estimated_cost DECIMAL(12,2) DEFAULT 0,
    actual_cost DECIMAL(12,2) DEFAULT 0,
    paid_amount DECIMAL(12,2) DEFAULT 0,
    vendor_contact VARCHAR(100) NULL,

    -- Status & Schedule Attributes
    event_date DATETIME NULL,
    status ENUM(
        'PENDING',
        'IN_PROGRESS',
        'COMPLETED',
        'CANCELLED'
    ) DEFAULT 'PENDING',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
```

### 3.2 Rundown Acara Hari H

```sql
CREATE TABLE wedding_rundowns (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    time_start TIME NOT NULL,
    time_end TIME NULL,
    activity_name VARCHAR(255) NOT NULL,
    person_in_charge VARCHAR(100) NULL,
    notes TEXT NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
```

---

## 4. IMPLEMENTASI BACKEND & FRONTEND

### 4.1 Dashboard Controller

**File:** `app/Http/Controllers/WeddingPlannerController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\WeddingPlannerItem;
use App\Models\WeddingRundown;
use Illuminate\Http\Request;
use Auth;

class WeddingPlannerController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Fetch seluruh item planner milik user
        $plannerItems = WeddingPlannerItem::where('user_id', $userId)->get();

        $rundowns = WeddingRundown::where('user_id', $userId)
            ->orderBy('time_start', 'asc')
            ->get();

        // Ringkasan Finansial Modul Budget & Vendor
        $budgets = $plannerItems->whereIn('category', ['BUDGET', 'VENDOR']);

        $totalEstimated = $budgets->sum('estimated_cost');
        $totalActual = $budgets->sum('actual_cost');
        $totalPaid = $budgets->sum('paid_amount');

        return view('dashboard.planner.index', compact(
            'plannerItems',
            'rundowns',
            'totalEstimated',
            'totalActual',
            'totalPaid'
        ));
    }
}
```

### 4.2 Tampilan Dashboard Planner

**File:** `resources/views/dashboard/planner/index.blade.php`

```blade
<div class="max-w-7xl mx-auto p-6 space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">
            💍 Wedding Planner & Organizer
        </h2>

        <a href="{{ route('planner.export-pdf') }}"
           class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700">
            📄 Export PDF Rundown & Budget
        </a>
    </div>

    <!-- Financial Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <p class="text-xs text-blue-600 font-semibold uppercase">
                Total Estimasi Anggaran
            </p>
            <p class="text-2xl font-bold text-blue-900">
                Rp {{ number_format($totalEstimated, 0, ',', '.') }}
            </p>
        </div>

        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
            <p class="text-xs text-emerald-600 font-semibold uppercase">
                Total Terbayar (DP/Lunas)
            </p>
            <p class="text-2xl font-bold text-emerald-900">
                Rp {{ number_format($totalPaid, 0, ',', '.') }}
            </p>
        </div>

        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
            <p class="text-xs text-amber-600 font-semibold uppercase">
                Sisa Tagihan Vendor
            </p>
            <p class="text-2xl font-bold text-amber-900">
                Rp {{ number_format($totalActual - $totalPaid, 0, ',', '.') }}
            </p>
        </div>

    </div>

    <!-- Navigation Tabs untuk 8 Pilar Modul -->
    <div class="flex overflow-x-auto space-x-2 border-b pb-2 text-sm font-medium">

        <button class="px-4 py-2 bg-primary text-white rounded-lg">
            📅 Calendar
        </button>

        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            📋 Checklist
        </button>

        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            💍 Engagement
        </button>

        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            📸 Pre-Wedding
        </button>

        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            🎁 Seserahan
        </button>

        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            📜 Administrasi
        </button>

        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            💰 Budget
        </button>

        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            🤝 Vendor
        </button>

    </div>

</div>
```

---

## 5. QA & TESTING MATRICES

| Test ID      | Skenario Testing            | Expected Result                                                                                                 | Status   |
| :----------- | :-------------------------- | :-------------------------------------------------------------------------------------------------------------- | :------- |
| **QA-WP-01** | Input Item Modul Planner    | Item berhasil disimpan ke kategori terkait (misal: Administrasi/Seserahan) dan status diperbarui.               | **PASS** |
| **QA-WP-02** | Pengelolaan Budget & DP     | Nominal `estimated_cost`, `actual_cost`, dan `paid_amount` terakumulasi secara otomatis di ringkasan finansial. | **PASS** |
| **QA-WP-03** | Penyusunan Rundown Acara    | Menginput rentang waktu, nama kegiatan, dan PIC; urutan waktu dirender secara kronologis.                       | **PASS** |
| **QA-WP-04** | Export PDF Rundown & Budget | Sistem memproses file PDF yang siap dicetak untuk kebutuhan panitia/WO di lokasi acara.                         | **PASS** |

---

## 6. RINGKASAN KOMPONEN

| Komponen                  | Fungsi                                                         |
| :------------------------ | :------------------------------------------------------------- |
| **Wedding Planner Items** | Menyimpan seluruh data dari 8 pilar utama.                     |
| **Wedding Rundowns**      | Menyimpan jadwal dan kegiatan Hari H.                          |
| **Financial Tracker**     | Menghitung estimasi, realisasi, pembayaran, dan sisa tagihan.  |
| **Dashboard**             | Menampilkan ringkasan dan akses ke seluruh modul.              |
| **PDF Export Engine**     | Menghasilkan dokumen PDF Rundown dan Budget yang siap dicetak. |

---

## 7. STATUS DOKUMEN

**Status:** Approved / Living Document

Dokumen ini menjadi acuan utama untuk pengembangan modul **Wedding Planner & Organizer System**, termasuk struktur database, dashboard user, financial tracker, event rundown, serta mekanisme export PDF.
