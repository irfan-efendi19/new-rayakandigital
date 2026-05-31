# PRODUCT REQUIREMENT DOCUMENT (PRD) EXTENSION
## Modul: Auto-Resolving Duplicate Guest Names & Unique Link Generator
**Versi:** 2.4 (Dioptimalkan untuk Laravel 13 Core & Pemrosesan Database Cepat)  
**Tanggal:** 31 Mei 2026  
**Status:** Approved  

---

## 1. Masalah & Latar Belakang (Problem Statement)

Saat pengantin (Tenant) mengimpor daftar tamu secara massal atau menambahkannya satu per satu, sering kali terdapat nama tamu yang sama persis (Contoh: "Budi Santoso" rekan kerja dan "Budi Santoso" sepupu). 

Jika sistem menghasilkan link hanya berdasarkan nama tamu secara mentah (contoh: `domain.com/budi-ani?to=budi-santoso`), maka:
1. Data RSVP, ucapan, dan scan QR Code Check-In antara kedua tamu tersebut akan **bertabrakan** karena menggunakan identitas *link query* yang sama.
2. Sistem tidak dapat membedakan keluarga mana yang hadir di meja penerima tamu.

---

## 2. Mekanisme Resolusi Otomatis (Technical Solution Workflow)

Sistem Laravel 13 akan menerapkan fungsi sanitasi otomatis menggunakan kombinasi **Slug Helper** dan **Increment String/Random Suffix Counter** di tingkat database sebelum tautan tamu disimpan.

### Alur Kerja Sistem (System Logic):
1. User memasukkan nama tamu baru: `Budi Santoso`.
2. Sistem mengubah nama tersebut menjadi format URL slug dasar: `budi-santoso`.
3. Sistem memeriksa apakah di dalam undangan (`invitation_id`) yang sama sudah ada nama slug `budi-santoso`.
4. **Kondisi A (Belum Ada):** Link disimpan sebagai `budi-santoso`.
5. **Kondisi B (Sudah Ada / Duplikat):** Sistem secara otomatis menambahkan kode unik berupa angka counter progresif atau potongan string pendek di belakangnya.
   * Duplikat ke-2 menjadi: `budi-santoso-2`
   * Duplikat ke-3 menjadi: `budi-santoso-3`
   * *Opsi Alternatif Admin:* Jika ingin terlihat lebih acak dan profesional tanpa angka berurutan, sistem bisa menambahkan 3 digit alfanumerik acak, contoh: `budi-santoso-x7b`.

---

## 3. Kebutuhan Fungsional (Functional Requirements)

### 3.1 Sisi Penyewa: Dasbor Daftar Tamu (Tenant Guest Management)
* **FR-GST-DUP-01 (Seamless Bulk Import):** Saat pengguna mengunggah file Excel berisi 500 tamu dan terdapat 5 nama "Ahmad", proses impor tidak boleh gagal/eror. Sistem harus sukses memasukkan semua data dengan otomatis membedakan tautan belakangnya di latar belakang.
* **FR-GST-DUP-02 (Link Transparency):** Di tabel daftar tamu dasbor user, kolom "Link Undangan" harus menampilkan link yang sudah disanitasi secara akurat (Contoh: Tamu 1: `...&to=budi-santoso`, Tamu 2: `...&to=budi-santoso-2`) sehingga saat diklik tombol "Kirim WA", teks yang terkirim tidak keliru.

### 3.2 Sisi Penerima Tamu: Validasi QR Code & RSVP
* **FR-GST-DUP-03 (Unique QR Payload):** QR Code untuk masing-masing tamu duplikat akan merujuk pada `guest_uuid` mereka yang berbeda. Saat di-scan, data yang ditarik adalah spesifik milik "Budi Santoso 2", sehingga status kehadiran tidak tertukar.

---

## 4. Struktur Tabel Database Tambahan (Database Schema Migration Update)

Kita perlu memperbarui dan memastikan kolom pelacakan tautan tamu pada tabel `invitation_guests` memiliki aturan indeks yang ketat berbasis kombinasi `invitation_id` dan `guest_slug`.

```sql
-- Memperbarui tabel invitation_guests untuk menambahkan kolom slug khusus tamu
ALTER TABLE invitation_guests ADD COLUMN guest_slug VARCHAR(150) NOT NULL AFTER guest_name;

-- Membuat indeks unik gabungan (Composite Unique Index)
-- Aturan: Nama slug tamu boleh sama di seluruh website, tetapi HARUS UNIK di dalam satu undangan yang sama.
ALTER TABLE invitation_guests ADD UNIQUE idx_unique_guest_per_invitation (invitation_id, guest_slug);