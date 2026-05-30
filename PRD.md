PRODUCT REQUIREMENT DOCUMENT (PRD) EXTENSION
## Module: Integrated WhatsApp Sender & Centralized API Gateway (Laravel 13 System)
**Version:** 2.1 (Optimized for Laravel 13 Core, PHP 8.4, & Redis Queue)  
**Date:** May 31, 2026  
**Status:** Approved  

---

## 1. Arsitektur Komponen & Arus Integrasi (System Architecture)

Sistem ini memisahkan antara **konfigurasi mesin pengirim (Admin)** dengan **eksekusi pengiriman pesan (User/Tenant)** untuk menjaga keamanan kredensial API Key platform.

[ Dashboard Tenant (User) ] ──> Pilih Daftar Tamu ──> Klik "Kirim via WA"
│
▼
[ Laravel 13 Core System ] <── Ambil API Key Terenkripsi dari DB Admin
│
├──> Validasi Sisa Kuota Paket Tenant (Laravel Pennant)
├──> Generate Pesan Kustom & Tautan Unik QR Code
│
▼
[ Laravel Horizon / Redis Queue ] ──( Asinkronus Asinkronus )──> [ API WhatsApp Gateway ]
│
▼
[ Handphone Tamu ]


---

## 2. Kebutuhan Fungsional (Functional Requirements)

### 2.1 Sisi Admin: Pengaturan Pusat Server WA Sender (Admin Panel)
* **FR-WAG-ADM-01 (Gateway Credentials Manager):** Halaman khusus Super Admin untuk mengatur penyedia layanan *WhatsApp Gateway* (misal: Fonnte, Wablas, Ruangguru WA, atau Server Node.js kustom sendiri).
* **FR-WAG-ADM-02 (Secure API Key Storage):** Menyediakan kolom input untuk `API URL`, `API Key / Token Key`, dan `Device ID`. Seluruh data ini wajib disimpan ke database menggunakan fitur enkripsi bawaan Laravel 13 (`Crypt::encryptString`).
* **FR-WAG-ADM-03 (Global Rate Limiting & Delay):** Admin dapat mengatur jeda waktu antar pesan (*delay interval*, contoh: 2-5 detik acak) untuk mencegah nomor WhatsApp gateway terblokir oleh sistem anti-spam WhatsApp.
* **FR-WAG-ADM-04 (Global Analytics Monitor):** Grafik pemantauan status pengiriman pesan secara global (Total Pesan Terkirim, Gagal, dan Mengantre).

### 2.2 Sisi Penyewa: Dasbor Pengiriman Undangan (User/Tenant Dashboard)
* **FR-WAG-TNT-01 (WhatsApp Blast Control Panel):** Pengguna memiliki halaman khusus untuk mengelola pengiriman pesan. Menampilkan daftar tamu, nomor WhatsApp, status pengiriman (`Pending`, `Sent`, `Failed`), dan tombol aksi.
* **FR-WAG-TNT-02 (Custom Text Template):** Pengguna dapat menyusun draf teks undangan sendiri menggunakan variabel dinamis yang disediakan sistem, seperti:
  * `{nama_tamu}` -> Otomatis berubah menjadi nama tamu spesifik.
  * `{tautan_undangan}` -> Otomatis memuat URL unik undangan beserta parameter nama.
  * `{qrcode_link}` -> Tautan langsung menuju gambar QR Code check-in (khusus Paket Gold).
* **FR-WAG-TNT-03 (Bulk Queue Sending):** Pengguna dapat memilih banyak tamu sekaligus (*checkbox*) dan menekan tombol "Kirim Undangan Massal". Sistem akan mendaftarkan permintaan tersebut ke dalam sistem antrean (*Queue Task*).
* **FR-WAG-TNT-04 (Quota Enforcement per Tier):** Menggunakan `Laravel Pennant`, sistem membatasi kuota pengiriman WhatsApp blast berdasarkan paket (misal: Silver maks 100 pesan, Gold Unlimited/Sesuai Jumlah Tamu).

---

## 3. Penanganan Antrean Pengiriman (High-Performance Queue Management)

Karena pengiriman pesan massal membutuhkan waktu dan sensitif terhadap pemblokiran, proses pengiriman **wajib berjalan di latar belakang** menggunakan Laravel Horizon dan Redis.

* **FR-WAG-QUE-01 (Asynchronous Job Batching):** Saat user mengirim 200 pesan, aplikasi tidak boleh memuat ulang atau *loading* lama. Sistem langsung memasukkan pesan ke antrean Redis, dan memunculkan notifikasi: *"Pesanan pengiriman sedang diproses di latar belakang"*.
* **FR-WAG-QUE-02 (Auto Failure Retry):** Jika API Gateway mengembalikan status gagal akibat server sibuk, sistem Laravel akan menjadwalkan ulang (*auto-retry*) pekerjaan tersebut 5 menit kemudian.

---

## 4. Struktur Tabel Database Tambahan (Database Schema Migration)

```sql
-- 1. Tabel Konfigurasi API Server WA oleh Admin
CREATE TABLE whatsapp_gateway_settings (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    provider_name VARCHAR(50) NOT NULL, -- Contoh: 'fonnte', 'wablas', 'custom'
    api_url TEXT NOT NULL,
    api_token TEXT NOT NULL,           -- Wajib terenkripsi di tingkat aplikasi
    device_id VARCHAR(100) NULL,
    delay_seconds INT DEFAULT 3,       -- Jeda anti-spam
    is_active BOOLEAN DEFAULT false,
    updated_at TIMESTAMP NULL
);

-- 2. Mengaitkan log pengiriman pesan massal per tamu undangan
CREATE TABLE whatsapp_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    invitation_id BIGINT NOT NULL,
    guest_id BIGINT NOT NULL,
    message_content TEXT NOT NULL,
    status ENUM('pending', 'queued', 'sent', 'failed') DEFAULT 'pending',
    error_message TEXT NULL,          -- Menyimpan alasan jika pengiriman gagal
    sent_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (invitation_id) REFERENCES invitations(id) ON DELETE CASCADE,
    FOREIGN KEY (guest_id) REFERENCES invitation_guests(id) ON DELETE CASCADE,
    INDEX idx_wa_log_status (invitation_id, status)
);