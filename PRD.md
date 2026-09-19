# Product Requirement Document (PRD)

## Bug Fix: Persistence Pilih Tema Landing Page via Google OAuth

**Platform:** Rayakan Digital  
**Versi Document:** v1.0  
**Status:** Proposed / Ready for Dev  
**Target Rilis:** Sprint Q4 2026  
**Penulis PRD:** Product Management & Engineering Team

---

## 1. Latar Belakang & Masalah (Problem Statement)

### 1.1. Masalah

Saat pengguna memilih tema undangan/website langsung di Landing Page lalu memilih opsi pendaftaran **"Sign Up / Sign In dengan Google"**, tema yang telah dipilih tidak tersimpan ke profil pengguna setelah proses autentikasi selesai. Pengguna harus memilih ulang tema dari awal di Halaman Dashboard.

### 1.2. Akar Penyebab (Root Cause)

Proses OAuth Google melakukan _redirect_ (pengalihan halaman) ke server eksternal Google. _State_ lokal browser/JavaScript yang menyimpan ID tema pilihan pengguna ter-reset, dan callback handler OAuth (`/auth/google/callback`) tidak menerima parameter ID tema untuk disimpan ke database pengguna baru.

---

## 2. Tujuan & Metrik Keberhasilan

- **User Experience (UX):** Menghilangkan _friction_ pada alur _onboarding_ pengguna baru.
- **Success Metric:** 100% pengguna baru yang mendaftar via Google OAuth setelah memilih tema di Landing Page akan langsung melihat tema pilihannya terpasang otomatis di Dashboard.

---

## 3. Spesifikasi Teknis & Aturan Bisnis

### 3.1. Alur Teknis (Technical Solution)

Solusi menggunakan mekanisme parameter **`state` pada OAuth 2.0** untuk meneruskan data ID tema secara aman menembus alur _redirect_ Google.

1. **Client-Side (Landing Page):**
    - Saat pengguna mengeklik salah satu tema di Landing Page, simpan `theme_id` ke dalam memori/URL parameter.
    - Saat pengguna mengeklik tombol "Sign Up dengan Google", sertakan `theme_id` ke endpoint inisiasi login.

2. **Backend (OAuth Controller):**
    - Endpoint inisiasi OAuth menyisipkan `theme_id` ke dalam payload parameter `state` yang dikirimkan ke Google Auth Server.
    - Google Auth Server mengembalikan payload `state` tersebut secara utuh ke Callback URL (`/api/v1/auth/google/callback`).

3. **Backend Callback Handler:**
    - Ambil `theme_id` dari parameter `state`.
    - Jika registrasi pengguna baru (`User::create` / `updateOrCreate`), set kolom `theme_id` pada tabel `users` / `weddings` sesuai nilai dari `state`.
    - Jika `theme_id` kosong/null, gunakan `default_theme_id`.

---

### 3.2. User Flow
