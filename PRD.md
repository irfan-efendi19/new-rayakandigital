# Product Requirement Document (PRD)

## Refaktorisasi Komponen Tabel Responsif pada User Dashboard

| Atribut               | Detail                            |
| :-------------------- | :-------------------------------- |
| **Status**            | Draf                              |
| **Penulis**           | Irfan                             |
| **Tanggal Pembuatan** | 12 Juli 2026                      |
| **Target Rilis**      | Sprint 3 - Q3 2026                |
| **Platform**          | Web (Mobile Responsive / Desktop) |

---

## 1. Latar Belakang & Masalah

Dashboard pengguna saat ini menggunakan elemen tabel HTML bawaan standar tanpa optimasi tata letak perangkat bergerak. Pada resolusi layar ponsel pintar (lebar kurang dari 768 piksel), komponen tabel memicu kerusakan tata letak (_layout breaking_) berupa _overflow_ horizontal yang memaksa pengguna menggeser seluruh halaman web, bukan hanya area data.

Hal ini menurunkan metrik kenyamanan navigasi pengguna (_User Experience_) dan mempersulit pembacaan data penting seperti riwayat transaksi maupun metrik analitik aplikasi secara cepat.

## 2. Tujuan Fitur

- **Mengeliminasi Kerusakan Tata Letak:** Memastikan area navigasi utama dashboard tetap kokoh di resolusi mobile tanpa adanya kebocoran _overflow_ halaman.
- **Optimasi Keterbacaan Data:** Menyajikan informasi tabular secara adaptif; menggunakan format _stacked card list_ untuk data transaksional dan _smooth scroll container_ untuk kumpulan data multidimensi (analitik).
- **Sentuhan Estetika Premium:** Menerapkan sistem tipografi berbasis monospaced untuk visualisasi data angka demi kemudahan pemindaian informasi visual oleh pengguna.

## 3. Profil Pengguna (User Persona)

Pengguna terdaftar (klien/mahasiswa/pelaku usaha kecil) yang mengakses akun dasbor mereka melalui perangkat seluler pintar untuk memeriksa status transaksi terbaru, melihat analitik performa layanan, atau melakukan aksi manajerial cepat secara _on-the-go_.

---

## 4. Ruang Lingkup Fitur & Persyaratan Fungsional

### FR-01: Pendekatan Komponen Adaptif (Breakpoint System)

Sistem wajib memisahkan perlakuan rendering visual komponen tabel berdasarkan lebar resolusi layar perangkat yang memuatnya:

- **Layar Desktop / Tablet Besar ($\ge$ 768px):** Ditampilkan sebagai struktur grid baris-kolom konvensional (`<table>`, `<thead>`, `<tbody>`).
- **Layar Mobile / Ponsel Pintar (< 768px):**
    - _Tipe Data Transaksional:_ Diubah secara asinkron atau manipulasi CSS menjadi struktur _stacked card_ bertumpuk ke bawah.
    - _Tipe Data Kuantitatif/Matriks:_ Tetap dalam baris memanjang namun terisolasi di dalam _scrollable wrapper container_ independen yang tidak merusak komponen luarnya.

### FR-02: Sistem Label Pseudo-Element Otomatis

Pada mode _stacked card_ mobile, sistem front-end wajib mengekstraksi judul kolom secara dinamis menggunakan atribut HTML5 `data-label="..."` dan menampilkannya di sisi kiri sel data menggunakan CSS `::before` pseudo-element guna menghindari terjadinya redundansi baris kode DOM (_DOM Bloat_).

### FR-03: Dukungan Mode Gelap (Dark Mode Compatibility)

Seluruh palet warna, garis pembatas (_border_), dan tingkat kepekatan warna latar (_background opacity_) pada tabel responsif wajib beradaptasi secara otomatis mengikuti transisi kelas `.dark` pada elemen root aplikasi.

---

## 5. Spesifikasi Teknis & Desain Antarmuka

### A. Tumpukan Teknologi (Tech Stack)

- **Utility CSS Framework:** Tailwind CSS v3.x ke atas.
- **Template Engine:** HTML5 Standard / Laravel Blade Components.

### B. Aturan Penulisan Gaya UI (UI Styling Rules)

1.  **Tipografi Numerik:** Semua kolom yang berisi data numerik (harga, tanggal, kuantitas) wajib menggunakan kelas `font-mono` demi menjaga presisi kerataan vertikal baris teks data.
2.  **Visualisasi Status:** Indikator status (Sukses, Pending, Gagal) dilarang menggunakan warna blok pekat. Wajib menerapkan kombinasi teks gelap di atas latar belakang berkomposisi warna pastel yang lembut (_low-saturation light backgrounds_) yang dilengkapi batas garis tipis (_border_).
3.  **Indikator Geser Mekanis:** Untuk tipe tabel _horizontal scrolling_, sisi kanan container wajib disisipkan efek gradien memudar (_visual fade shadow indicator_) khusus pada resolusi mobile untuk memberi tanda visual taktil bahwa tabel dapat digeser ke samping kanan.

---

## 6. Persyaratan Non-Fungsional (Non-Functional Requirements)

- **Performa Rendering:** Penerapan responsivitas tabel berbasis murni CSS (media queries). Dilarang keras menggunakan _event listener_ berbasis JavaScript (`window.innerWidth`) untuk memanipulasi struktur DOM tabel demi mencegah penurunan skor _Cumulative Layout Shift_ (CLS) pada Google Lighthouse.
- **Aksesibilitas (A11y):** Elemen tabel harus tetap mempertahankan struktur semantik HTML asli (`<table>`, `<td>`, `<th>`) agar pembaca layar (_screen readers_) bagi penyandang disabilitas tetap dapat menginterpretasikan keterkaitan data secara akurat.

---

## 7. Kriteria Penerimaan (Acceptance Criteria)

### Skenario 1: Konversi Tampilan Riwayat Transaksi di Resolusi Mobile

- **Given:** Pengguna membuka halaman dashboard riwayat transaksi menggunakan peramban mobile dengan lebar layar sebesar 390px.
- **When:** Halaman dasbor selesai dimuat secara utuh.
- **Then:** Komponen `<thead>` (baris judul kolom atas) otomatis disembunyikan.
- **And:** Setiap baris transaksi berubah wujud menjadi satu modul kartu independen dengan pembatas garis tipis (`border-gray-100`).
- **And:** Setiap data di dalam kartu menampilkan judul kolom di sebelah kiri (misal: "NOMINAL") dan nilai aktualnya berada rata kanan (misal: "Rp 149.000").

### Skenario 2: Perilaku Geser pada Tabel Data Matriks Analitik

- **Given:** Pengguna memuat tabel ringkasan statistik kunjungan yang memiliki 6 kolom informasi di layar ponsel berukuran lebar 412px.
- **When:** Pengguna menyapu (_swipe_) jari mereka secara horizontal ke arah kiri di atas area data tabel.
- **Then:** Area tabel bergeser dengan halus (_smooth scrolling_) ke arah kanan secara mandiri.
- **And:** Komponen navigasi utama, bilah sisi (_sidebar_), serta kartu metrik bagian atas dasbor tetap diam di posisinya (tidak ikut tergeser atau keluar dari batas layar).
