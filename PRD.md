# PRODUCT REQUIREMENT DOCUMENT (PRD) - UPDATE VISUAL KATALOG
## Modul: Filter Tab Kategori Tema Dinamis (Pilihan Tema Grid Filter)
**Versi:** 1.2 (Spesifikasi Frontend & Query - Laravel 13 & Tailwind CSS)  
**Tanggal:** 2 Juni 2026  
**Status:** Approved  
**Target Komponen:** Landing Page View (Katalog), AJAX Controller, & Badge Count Real-Time  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Fitur ini mengimplementasikan antarmuka tombol pill/tab filter di atas grid katalog *landing page*. Pengguna dapat mengeklik kategori tertentu (misal: *Special, Luxury, 3D Motion, Art, Interaktif, Tema Adat, Tanpa Foto*) untuk menyaring daftar tema berasio 9:16 secara instan tanpa perlu memuat ulang seluruh halaman (*zero-refresh filtering*).

### 1.2 Aturan Bisnis (Business Rules)
1. **Badge Count Dinamis:** Setiap tombol kategori wajib menampilkan angka penanda (badge) yang menunjukkan jumlah total tema aktif di dalam kategori tersebut secara akurat (Contoh: `SPECIAL 13`, `LUXURY 6`).
2. **State Aktif (Visual Cue):** Tombol kategori yang sedang dipilih wajib berubah warna menjadi solid (Warna Teal/Emerald sesuai desain) sementara tombol lainnya tetap berstatus *outline/ghost button*.
3. **Mekanisme Penyaringan Fast-Switching:** Proses perpindahan filter direkomendasikan menggunakan JavaScript (Alpine.js / Vanilla JS dataset) untuk performa instan, atau AJAX fetching jika total aset tema sudah melebihi 100 item.

---

## 2. OPTIMALISASI BACKEND QUERY (LARAVEL 13)

Gunakan *Eager Loading* disertai fungsi `withCount()` pada controller *landing page* Anda agar angka badge pada tombol kategori terhitung otomatis dan efisien tanpa membebani performa database:

```php
namespace App\Http\Controllers;

use App\Models\ThemeCategory;
use App\Models\Theme;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori beserta jumlah total tema yang aktif di dalamnya
        $categories = ThemeCategory::withCount('themes')->get();

        // Mengambil seluruh master data tema berelasi untuk di-render di catalog grid
        $themes = Theme::with('category')->where('is_active', true)->get();

        return view('landing_page', compact('categories', 'themes'));
    }
}