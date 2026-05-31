# PRODUCT REQUIREMENT DOCUMENT (PRD) EXTENSION
## Modul: Multi-Event Dynamic Scheduler (Menu Waktu & Tempat - Laravel 13)
**Versi:** 2.5 (Dioptimalkan untuk Laravel 13 Core, PHP 8.4, & Eloquent Polymorphic/HasMany)  
**Tanggal:** 1 Juni 2026  
**Status:** Approved  

---

## 1. Ringkasan Eksekutif & Refaktor Fitur (Executive Summary)

Pada versi sebelumnya, sistem hanya menyediakan satu set input kaku (*hardcoded*) untuk elemen waktu dan tempat (hanya mengakomodasi Akad dan Resepsi dalam satu blok tetap). 

Perbaikan ini merefaktur komponen tersebut menjadi struktur **Multi-Event (Multi-Acara)**. Pengguna (Tenant) kini dapat menambah, menyusun, dan menghapus acara sesuka hati secara dinamis (misal: menambahkan acara "Pengajian", "Akad Nikah", "Resepsi Hari H", hingga "Acara Ngunduh Mantu") langsung melalui satu pintu dasbor menu Waktu & Tempat.

---

## 2. Alur Pengguna & Arsitektur Dinamis (User Interface Flow)

Sistem memanfaatkan komponen *dynamic form repeater* pada sisi frontend (`Inertia.js / Vue 3`) untuk memproses penambahan baris acara secara asinkron.

[ Dasbor User: Menu Waktu & Tempat ]
│
├──> Menampilkan Daftar Acara yang Sudah Ada (Looping Card)
│
├──> [ Tombol: "+ Tambah Acara Baru" ]
│          │
│          ▼
│    Memunculkan Form Blok Kosong Baru (Nama Acara, Tanggal, Jam, Lokasi, Map)
│
└──> [ Tombol: "Simpan Semua Perubahan" ]
│
▼
[ Payload Dikirim via Axios/Inertia ]
│
▼
[ Backend: Validasi & Upsert di DB ]


---

## 3. Kebutuhan Fungsional (Functional Requirements)

### 3.1 Sisi Penyewa: Dasbor Edit Waktu & Tempat (Tenant Dynamic Form)
* **FR-EVT-TNT-01 (Dynamic Event Repeater):** Menyediakan tombol `+ Tambah Acara` yang secara dinamis memunculkan baris formulir baru tanpa memuat ulang halaman.
* **FR-EVT-TNT-02 (Event Detail Fields):** Setiap blok acara wajib memiliki input fields berikut:
  * **Nama Acara:** Dropdown pilihan (Akad, Resepsi, Pengajian, Unduh Mantu) atau opsi *Custom Text* (misal: "Upacara Adat Panggih").
  * **Tanggal & Waktu:** Input tanggal, jam mulai, dan jam selesai (atau centang "Sampai Selesai").
  * **Tempat / Lokasi:** Input teks nama gedung/kediaman beserta alamat lengkap.
  * **Peta Digital:** Input URL tautan *Google Maps Embed / Share Link* untuk merender peta interaktif di sisi halaman undangan tamu.
* **FR-EVT-TNT-03 (Delete & Reorder Event):** Pengguna dapat menghapus blok acara tertentu jika terjadi pembatalan acara, atau mengurutkan posisi acara (mana yang tampil lebih atas di undangan).

### 3.2 Sisi Halaman Undangan Tamu (Frontend Invitation Rendering)
* **FR-EVT-INV-01 (Looping Event Display):** Halaman undangan pernikahan (sisi tamu) akan membaca seluruh acara yang aktif di database dan merendernya dalam bentuk susunan lini masa (*Timeline View*) atau kartu-kartu informasi yang rapi sesuai urutan kronologis waktu.
* **FR-EVT-INV-02 (Countdown Integration):** Fitur hitung mundur (*Countdown Timer*) di halaman depan undangan otomatis merujuk pada waktu pelaksanaan dari **Acara Pertama** (Urutan Kronologis Terawal).

---

## 4. Struktur Tabel Database Tambahan (Database Schema Migration)

Untuk mendukung banyak acara di bawah satu undangan, data waktu dan tempat dipisahkan dari tabel induk `invitations` ke dalam tabel tersendiri bernama `invitation_events` (*One-to-Many Relationship*).

```sql
-- 1. Menghapus kolom waktu & tempat yang kaku di tabel utama (Proses Pembersihan Data Lama)
-- ALTER TABLE invitations DROP COLUMN akad_date, DROP COLUMN resepsi_date, dst.

-- 2. Membuat tabel baru untuk menampung multi-acara dinamis
CREATE TABLE invitation_events (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    invitation_id BIGINT NOT NULL,
    event_title VARCHAR(100) NOT NULL,    -- 'Akad Nikah', 'Resepsi', 'Unduh Mantu'
    event_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NULL,                   -- Jika kosong/null diartikan "Selesai"
    is_until_finished BOOLEAN DEFAULT false,
    place_name VARCHAR(150) NOT NULL,     -- 'Gedung Serbaguna Grand City'
    place_address TEXT NOT NULL,          -- 'Jl. Raya Gubeng No. 12, Surabaya'
    google_maps_url TEXT NULL,            -- URL untuk tombol petunjuk arah Navigasi
    sort_order INT DEFAULT 0,             -- Untuk mengatur urutan tampilan acara
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (invitation_id) REFERENCES invitations(id) ON DELETE CASCADE,
    INDEX idx_event_chronology (invitation_id, event_date, start_time)
);