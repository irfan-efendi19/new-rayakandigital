# PRODUCT REQUIREMENT DOCUMENT (PRD) EXTENSION
## Module: Tenant Custom URL Slug Editor (Laravel 13 System)
**Version:** 2.3 (Optimized for Laravel 13 Core, PHP 8.4, & Inertia.js/Vue 3)  
**Date:** May 31, 2026  
**Status:** Approved  

---

## 1. Ringkasan Eksekutif & Aturan Bisnis (Executive Summary & Business Rules)

Fitur ini memberikan fleksibilitas kepada pengguna (Tenant) untuk menentukan dan mengubah nama tautan unik undangan mereka sendiri (contoh: dari `domain.com/budi-ani` menjadi `domain.com/budiandanispesial`). 

### Aturan Batasan Sistem (Sistem Constraints):
1. **Unik Secara Global:** Tidak boleh ada dua undangan aktif dengan nama slug yang sama di dalam database.
2. **Karakter Terbuka:** Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung/minus (`-`). Tidak diperbolehkan menggunakan spasi, huruf kapital, atau karakter spesial.

---

## 2. Alur Pengguna & Validasi Real-Time (User Flow & Interface Architecture)

Sistem menggunakan pendekatan komponen reaktif pada dasbor pengguna untuk memastikan slug yang dimasukkan tersedia sebelum form disimpan.

[ Dasbor User: Menu Pengaturan Tautan ]
│
▼
[ Input Nama Slug Baru (e.g., "budi-ani-wedding") ]
│
▼ (Debounce 500ms - Ajax Call via Laravel API)
[ Sistem Cek Ketersediaan Slug di Tabel invitations ]
│
┌─────────┴─────────┐
▼                   ▼
[ Terpakai ]        [ Tersedia ]
│                   │
▼                   ▼
Tampilkan Peringatan   Tombol "Simpan" Aktif
"Link sudah digunakan"     │
▼
[ Klik Simpan / Update ]
│
▼
[ Sistem Update Kolom slug di DB ]


---

## 3. Kebutuhan Fungsional (Functional Requirements)

### 3.1 Sisi Penyewa: Dasbor Pengaturan Tautan (Tenant Link Editor)
* **FR-URL-TNT-01 (Slug Input Form):** Menyediakan kolom input khusus di dasbor dengan teks statis domain di depannya (Contoh: `wedding-invitation.com/ [ input_slug_di_sini ]`).
* **FR-URL-TNT-02 (Real-Time Availability Check):** Menggunakan fungsi *debounce* (jeda ketik 500ms), sistem secara asinkronus memeriksa ke database apakah slug tersebut sudah dipakai akun lain atau belum, lalu menampilkan indikator visual (Centang Hijau atau Silang Merah).
* **FR-URL-TNT-03 (Format Auto-Sanitization):** Sistem secara otomatis mengubah huruf kapital menjadi huruf kecil dan mengubah spasi menjadi tanda hubung (`-`) saat pengguna mengetik, demi menjaga validitas format URL.
* **FR-URL-TNT-04 (Broken Link Warning Popup):** Saat pengguna mengklik tombol "Simpan Perubahan", sistem wajib memunculkan modal konfirmasi peringatan: *"Apakah Anda yakin? Tautan lama Anda tidak akan bisa diakses lagi setelah diubah. Pastikan Anda belum menyebarkan tautan lama ke tamu undangan."*

### 3.2 Sisi Backend: Pengarah Rute Dinamis (Dynamic Routing Handler)
* **FR-URL-SYS-01 (Dynamic Route Binding):** Laravel 13 menangani pemanggilan URL undangan secara dinamis berdasarkan parameter slug terupdate (Contoh rute: `Route::get('/{slug}', [InvitationController::class, 'show'])`).

---

## 4. Struktur Tabel Database Tambahan (Database Schema Migration)

Modul ini memanfaatkan kolom `slug` yang sudah ada pada tabel `invitations` dengan menambahkan indeks pencarian unik agar proses muat halaman undangan tetap cepat.

```sql
-- Memastikan kolom slug memiliki indeks unik dan mendukung pencarian cepat
ALTER TABLE invitations MODIFY COLUMN slug VARCHAR(100) NOT NULL;
ALTER TABLE invitations ADD UNIQUE idx_invitation_slug_unique (slug);

-- (Opsional) Menambahkan kolom pelacak jumlah modifikasi link untuk membatasi penyalahgunaan
ALTER TABLE invitations ADD COLUMN slug_change_count INT DEFAULT 0 AFTER slug;