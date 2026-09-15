# Product Requirement Document (PRD)

## Fitur Promo & Diskon

**Platform:** Rayakan Digital
**Versi Dokumen:** v2.0
**Status:** In Review
**Target Rilis:** Q4 2026
**Penulis PRD:** Product Management Team
**Revisi dari:** v1.0 — Penghapusan fitur auto-apply & tombol hapus promo, pemisahan logika Promo Otomatis vs. Voucher Manual.

---

## 1. Ringkasan Eksekutif & Latar Belakang

**Rayakan Digital** menyediakan platform manajemen pernikahan 8 pilar serta generator web undangan digital. Untuk memicu peningkatan konversi pembelian paket Premium/B2C, diperlukan mekanisme pemasaran berbasis _Fear of Missing Out (FOMO)_ dan _urgency pricing_.

Fitur **Promo & Diskon** mengelola dua jenis kampanye diskon dengan perilaku tampilan yang berbeda:

| Jenis Promo | Kode Voucher | Tampilan |
| --- | --- | --- |
| **Promo Otomatis** | KOSONG (nullable) | Landing Page — Sticky Bar + Countdown Timer + harga terpotong otomatis |
| **Voucher Manual** | TERISI | Checkout Page — User input kode secara manual |

---

## 2. Tujuan Produk & Metrik Keberhasilan

- **Peningkatan Conversion Rate (CR):** Meningkatkan rasio konversi pengunjung Landing Page ke pembayar paket sebesar 25%.
- **Meningkatkan Urgensi Pembelian:** Mengurangi rata-rata _time-to-checkout_ hingga 40% melalui Countdown Timer real-time.
- **Fleksibilitas Promosi:** Memungkinkan tim Marketing meluncurkan kampanye diskon tanpa campur tangan developer.

---

## 3. User Persona & Target Pengguna

- **Calon Pengantin (End User):** Mencari penawaran paket planner/undangan digital hemat dengan kejelasan masa berlaku harga.
- **Tim Admin / Marketing (Internal):** Membutuhkan CMS dashboard untuk mengatur skema diskon, periode timer, batas pemakaian, dan memantau performa kupon.

---

## 4. Detail Spesifikasi Fitur

### 4.1. Modul Admin — Pengaturan Promo (CMS Dashboard)

#### 4.1.1. Form Input Promo

| Field | Tipe | Wajib | Keterangan |
| --- | --- | --- | --- |
| `title` | `VARCHAR(150)` | ✅ | Nama/label internal promo |
| `code` | `VARCHAR(50) UNIQUE NULL` | ❌ **Opsional** | Kosong = Promo Otomatis. Terisi = Voucher Manual |
| `discount_type` | `ENUM('PERCENTAGE', 'FIXED')` | ✅ | Tipe potongan harga |
| `discount_value` | `DECIMAL(12,2)` | ✅ | Nilai diskon (persen atau nominal) |
| `max_discount_amount` | `DECIMAL(12,2) NULL` | ❌ | Batas maksimal potongan (untuk tipe PERCENTAGE) |
| `min_order_amount` | `DECIMAL(12,2)` | ❌ | Minimum nominal transaksi, default `0` |
| `timer_type` | `ENUM('STATIC', 'EVERGREEN')` | ✅ | Jenis timer (hanya relevan untuk Promo Otomatis) |
| `start_time` | `TIMESTAMP NULL` | ❌ | Tanggal & jam mulai (STATIC) |
| `end_time` | `TIMESTAMP NULL` | ❌ | Tanggal & jam selesai (STATIC) |
| `evergreen_duration_minutes` | `INT NULL` | ❌ | Durasi timer per sesi user (EVERGREEN) |
| `usage_limit` | `INT NULL` | ❌ | Batas total stok pemakaian promo |
| `is_active` | `BOOLEAN` | ✅ | Status aktif/nonaktif promo |

> **Catatan Field `code` (Kode Voucher):**
> - Field ini bersifat **opsional (nullable)**. Admin tidak diwajibkan mengisi kode voucher.
> - Jika dibiarkan **kosong** → sistem memperlakukan promo sebagai **Promo Otomatis**.
> - Jika **diisi** → sistem memperlakukan promo sebagai **Voucher Manual**.

#### 4.1.2. Fitur yang TIDAK Diimplementasikan

> ⛔ Fitur-fitur berikut **dihapus** dan tidak boleh ada di antarmuka manapun:
> - **"Gunakan Promo Terbaik" (Auto-Apply Best Promo):** Tidak ada tombol atau logika otomatis yang memilih & menerapkan promo terbaik untuk user.
> - **Tombol Hapus Promo:** Tidak tersedia tombol untuk menghapus/membatalkan promo yang sudah diterapkan pada sesi checkout user.

---

### 4.2. Aturan Logika Berdasarkan Jenis Promo

#### 4.2.1. Promo Otomatis (`code` = NULL / KOSONG)

**Definisi:** Diskon yang berlaku otomatis tanpa memerlukan input kode dari user.

**Aturan Tampilan:**

| Komponen UI | Perilaku |
| --- | --- |
| **Sticky Bar / Announcement Banner** | Muncul di bagian paling atas Landing Page, _sticky_ (mengikuti scroll). Menampilkan teks promo dinamis, Countdown Timer real-time `HH:MM:SS`, dan CTA ("Klaim Sekarang" / "Lihat Paket"). |
| **Hero Section & Kartu Paket** | Harga paket menampilkan **harga coret** (harga normal) + **harga setelah diskon** secara langsung. Badge "Hemat X%" ditampilkan. Tidak ada aksi input dari user. |
| **Countdown Timer** | Ditampilkan secara publik di Landing Page. Berjalan real-time (`HH:MM:SS`). Saat timer habis (`00:00:00`), harga kembali normal dan banner disembunyikan dengan _smooth transition_ tanpa reload. |
| **Checkout Page** | Diskon sudah teraplikasi otomatis. Tidak ada kolom input voucher yang perlu diisi user untuk promo ini. |

**Aturan Bisnis:**
- Hanya **satu** Promo Otomatis yang dapat aktif (`is_active = 1`) pada satu waktu.
- Sistem menampilkan promo berdasarkan status aktif dan periode `start_time`–`end_time` yang valid.
- Promo Otomatis **tidak muncul** sebagai item yang perlu dikonfirmasi user di Checkout (sudah teraplikasi transparan).

---

#### 4.2.2. Voucher Manual (`code` = TERISI)

**Definisi:** Diskon yang hanya aktif setelah user memasukkan kode voucher secara manual.

**Aturan Tampilan:**

| Komponen UI | Perilaku |
| --- | --- |
| **Landing Page** | **Tidak menampilkan** informasi promo ini sama sekali. Tidak ada sticky bar, tidak ada countdown timer publik, tidak ada harga coret otomatis. |
| **Checkout Page** | Terdapat kolom input **"Kode Voucher"**. User wajib mengetikkan kode yang valid secara manual. Setelah kode diverifikasi valid, tampilkan ringkasan potongan harga. |
| **Countdown Timer** | **Tidak ada** timer publik. Penghitungan waktu berlaku voucher (jika ada) hanya bersifat validasi backend (`end_time`), tidak ditampilkan ke user. |

**Aturan Bisnis:**
- Satu kode voucher dapat dibatasi penggunaannya per `user_id` / `email` sesuai `usage_limit`.
- Sistem memvalidasi: kode ada, status aktif, belum kedaluwarsa, belum melewati `usage_limit`, dan memenuhi `min_order_amount`.
- Jika kode tidak valid, tampilkan pesan error yang spesifik (misal: "Kode tidak ditemukan", "Kode sudah kedaluwarsa", "Kode sudah mencapai batas penggunaan").

---

## 5. Arsitektur Database & Skema Tabel

```sql
CREATE TABLE promotions (
    id                         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title                      VARCHAR(150) NOT NULL,
    code                       VARCHAR(50)  UNIQUE NULL,           -- NULL = Promo Otomatis | TERISI = Voucher Manual
    discount_type              ENUM('PERCENTAGE', 'FIXED') NOT NULL DEFAULT 'PERCENTAGE',
    discount_value             DECIMAL(12,2) NOT NULL,
    max_discount_amount        DECIMAL(12,2) NULL,                 -- Batas potongan max (untuk PERCENTAGE)
    min_order_amount           DECIMAL(12,2) DEFAULT 0.00,
    timer_type                 ENUM('STATIC', 'EVERGREEN') NOT NULL DEFAULT 'STATIC',
    start_time                 TIMESTAMP NULL,
    end_time                   TIMESTAMP NULL,
    evergreen_duration_minutes INT NULL,                           -- Digunakan jika timer_type = EVERGREEN
    usage_limit                INT NULL,                           -- NULL = tidak terbatas
    used_count                 INT DEFAULT 0,
    is_active                  TINYINT(1) DEFAULT 1,
    created_at                 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at                 TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE promotion_usages (
    id               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    promotion_id     BIGINT UNSIGNED NOT NULL,
    user_id          BIGINT UNSIGNED NOT NULL,
    order_id         BIGINT UNSIGNED NOT NULL,
    discount_applied DECIMAL(12,2) NOT NULL,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (promotion_id) REFERENCES promotions(id) ON DELETE CASCADE
);
```

---

## 6. User Flow

### 6.1. Promo Otomatis (Kode Voucher KOSONG)

```
Admin aktifkan promo (code = NULL)
    │
    ▼
Landing Page load
    ├─► Sticky Bar muncul + Countdown Timer berjalan real-time
    └─► Harga paket tampil: harga coret + harga diskon + badge "Hemat X%"
    │
    ▼
User klik "Lihat Paket" / "Pesan Sekarang"
    │
    ▼
Halaman Checkout
    ├─► Diskon sudah teraplikasi otomatis (transparan)
    └─► Tidak ada kolom input voucher untuk promo ini
```

### 6.2. Voucher Manual (Kode Voucher TERISI)

```
Admin buat voucher (code = "WEDDING2026")
    │
    ▼
Landing Page → Tidak ada tampilan promo apapun
    │
    ▼
User klik "Pesan Sekarang" → Masuk Checkout Page
    │
    ▼
Kolom Input "Kode Voucher" tersedia
    │
    ├─► User ketik kode → Validasi backend
    │       ├─► VALID   → Tampilkan ringkasan potongan harga
    │       └─► INVALID → Tampilkan pesan error spesifik
    │
    ▼
User lanjutkan ke pembayaran
```

---

## 7. Spesifikasi API Endpoint (Backend)

| Method | Endpoint | Deskripsi |
| --- | --- | --- |
| `GET` | `/api/promotions/active-automatic` | Mengambil satu Promo Otomatis yang sedang aktif (untuk Landing Page). Response: data promo + sisa waktu timer dalam detik. |
| `POST` | `/api/promotions/validate-voucher` | Validasi kode voucher manual. Request: `{ code, order_amount }`. Response: detail diskon atau pesan error. |
| `POST` | `/api/promotions/apply` | Menerapkan promo ke order. Atomic transaction untuk mencegah _race condition_ pada `usage_limit`. |

---

## 8. Error Handling & Edge Cases

| Kondisi | Penanganan |
| --- | --- |
| Promo Otomatis aktif lebih dari 1 | Sistem hanya menggunakan promo dengan `start_time` paling baru. Admin diberi peringatan di dashboard. |
| Timer Promo Otomatis habis saat user di Landing Page | Frontend memperbarui tampilan secara otomatis (polling/WebSocket) tanpa reload keras. Harga kembali normal, Sticky Bar disembunyikan. |
| Voucher Manual race condition (banyak user bersamaan) | Gunakan DB atomic transaction + row lock (`SELECT ... FOR UPDATE`) pada `used_count`. |
| User memasukkan kode voucher di Landing Page | Tidak berlaku. Kolom input voucher **hanya tersedia** di Checkout Page. |
| Promo Otomatis & Voucher Manual aktif bersamaan | Tidak saling konflik (beda konteks). Jika user memasukkan kode voucher saat checkout, Voucher Manual **menggantikan** Promo Otomatis. Diskon tidak boleh ditumpuk (_no stacking_). |

---

## 9. Kriteria Penerimaan (Acceptance Criteria)

### Promo Otomatis
- [ ] Jika promo aktif dengan `code = NULL`, Sticky Bar **wajib** muncul di Landing Page.
- [ ] Countdown Timer berjalan real-time dan akurat di Landing Page.
- [ ] Harga paket di Landing Page **langsung terpotong** tanpa aksi apapun dari user.
- [ ] Saat timer habis, Sticky Bar disembunyikan dan harga kembali normal secara _smooth_ tanpa reload.
- [ ] Di Checkout Page, diskon sudah teraplikasi otomatis tanpa kolom input.

### Voucher Manual
- [ ] Promo dengan `code` terisi **tidak menampilkan** apapun di Landing Page (tidak ada sticky bar, tidak ada harga coret, tidak ada countdown publik).
- [ ] Kolom input "Kode Voucher" **hanya tersedia** di Checkout Page.
- [ ] Sistem menampilkan pesan error yang spesifik jika kode tidak valid.
- [ ] Sistem memvalidasi `usage_limit` dengan aman dari race condition.

### Admin
- [ ] Field `code` pada form admin bersifat **opsional** (dapat dikosongkan).
- [ ] Tidak ada tombol atau fitur "Gunakan Promo Terbaik" (auto-apply) di antarmuka manapun.
- [ ] Tidak ada tombol "Hapus Promo" yang diterapkan pada sesi checkout user.

---

## 10. Dependensi & Asumsi

- **Dependensi:** Modul Paket (untuk harga yang akan dipotong), Modul Order/Checkout, Modul Auth (untuk identifikasi user pada `usage_limit`).
- **Asumsi:** Satu user hanya dapat menggunakan satu promo per transaksi (_no stacking_). Voucher Manual dibagikan secara eksklusif via campaign email/WhatsApp oleh tim Marketing.
