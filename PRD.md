# Generator PRD Infinite Scroll Katalog Tema
prd_infinite_scroll = """# Product Requirement Document (PRD)
## Fitur Infinite Scroll & Cursor Pagination Katalog Tema
**Platform:** Rayakan Digital  
**Versi Document:** v1.0  
**Status:** Proposed / Ready for Dev  
**Target Rilis:** Q4 2026  
**Penulis PRD:** Product & Engineering Team  

---

## 1. Ringkasan Eksekutif & Latar Belakang

### 1.1. Masalah
Halaman `/semua-tema` saat ini menggunakan navigasi halaman bernomor (*numbered pagination*). Mekanisme ini memicu *user friction* karena pengguna harus mengeklik nomor halaman secara manual, yang menyebabkan reload halaman berulang kali dan menurunkan pengalaman eksplorasi katalog tema.

### 1.2. Solusi
Mengganti sistem navigasi halaman tradisional dengan **Infinite Scroll** menggunakan **Intersection Observer API** di sisi *frontend* dan **Cursor Pagination** di sisi *backend* Laravel. Solusi ini memungkinkan tema baru dimuat secara otomatis dan *seamless* ketika pengguna mendekati bagian bawah halaman tanpa mengorbankan performa database.

---

## 2. Fitur Utama & Spesifikasi Teknis

### 2.1. Backend (Laravel Engine)
* **Cursor Pagination Integration:** Mengubah query `paginate()` menjadi `cursorPaginate(12)` untuk menghindari query `OFFSET` SQL yang lambat saat data membesar.
* **AJAX Partial Rendering:** Menyediakan *response JSON* yang berisi komponen HTML partial (`themes._item_list`) beserta penanda *cursor* berikutnya (`next_cursor`) dan status ketersediaan data (`has_more`).

### 2.2. Frontend (JavaScript Vanilla & Intersection Observer)
* **Seamless Loading Trigger:** Menggunakan `Intersection Observer API` dengan `rootMargin: '200px'` untuk memicu pemuatan data sebelum pengguna menyentuh dasar halaman.
* **Loading State & Feedback:** Menampilkan indikator animasi *spinner* saat proses pengambilan data berlangsung.
* **End of Data Handling:** Menampilkan pesan informatif ketika seluruh katalog tema telah dimuat.
* **Lazy Loading Media:** Penerapan atribut `loading="lazy"` pada gambar thumbnail tema untuk efisiensi konsumsi memori browser.

---

## 3. Spesifikasi Antarmuka & UX Flow

```text
[Pengguna Melakukan Scroll pada Katalog Tema]
                     │
                     ▼
  [Intersection Observer Mendeteksi Sentinel]
                     │
                     ▼
  [Tampilkan Spinner Loading di Bagian Bawah]
                     │
                     ▼
  [Fetch Data via AJAX: /semua-tema?cursor=xxx]
                     │
       ┌─────────────┴─────────────┐
       ▼                           ▼
[Data Ditemukan]             [Data Habis]
       │                           │
       ▼                           ▼
Append Item ke Grid        Tampilkan Pesan
& Update Next Cursor       "Semua tema telah ditampilkan"