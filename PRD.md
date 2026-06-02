# Product Requirements Document (PRD)

## 1. Ringkasan
Pembaruan struktur implementasi untuk:
- **Halaman Landing Page** → `resources/views/landing_page.blade.php`
- **Halaman Semua Tema (Catalog Page)** → `resources/views/all_themes.blade.php`

Tujuan: Menyatukan masing-masing halaman ke dalam satu berkas Blade tunggal dengan gaya visual tombol filter sesuai referensi, serta grid portrait 9:16 yang dikendalikan instan menggunakan Alpine.js.

---

## 2. Tujuan Produk
- Menyederhanakan struktur file Blade agar lebih mudah dikelola.
- Memberikan pengalaman pengguna yang konsisten dengan filter interaktif.
- Menampilkan grid tema portrait (9:16) dengan layout responsif.
- Memanfaatkan Alpine.js untuk interaksi instan tanpa reload.

---

## 3. Lingkup
### 3.1 Landing Page
- File: `landing_page.blade.php`
- Konten:
  - Hero section (judul, deskripsi singkat, CTA).
  - Tombol filter kategori (visual sesuai referensi).
  - Grid tema portrait 9:16.
  - Integrasi Alpine.js untuk filter instan.

### 3.2 Catalog Page
- File: `all_themes.blade.php`
- Konten:
  - Header dengan judul "Semua Tema".
  - Tombol filter kategori (konsisten dengan Landing Page).
  - Grid tema portrait 9:16.
  - Alpine.js untuk filter instan.

---

## 4. Fitur Utama
- **Filter Button Styling**: Tombol filter dengan gaya visual sesuai referensi gambar (rounded, hover effect, active state).
- **Grid Layout**: 
  - Portrait ratio 9:16.
  - Responsive (Tailwind CSS).
  - Minimal 3 kolom pada desktop, 2 kolom tablet, 1 kolom mobile.
- **Alpine.js Integration**:
  - State management untuk filter.
  - Instan toggle kategori tanpa reload.
  - Animasi transisi sederhana (fade/scale).

---

## 5. Implementasi Teknis
### 5.1 Struktur File
- `resources/views/landing_page.blade.php`
- `resources/views/all_themes.blade.php`

### 5.2 Contoh Blade (Landing Page)
```blade
<div x-data="{ filter: 'all' }">
    <!-- Tombol Filter -->
    <div class="flex gap-2 mb-4">
        <button 
            :class="filter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200'" 
            @click="filter = 'all'">
            Semua
        </button>
        <button 
            :class="filter === 'tema1' ? 'bg-blue-600 text-white' : 'bg-gray-200'" 
            @click="filter = 'tema1'">
            Tema 1
        </button>
        <!-- Tambahkan tombol lain sesuai kategori -->
    </div>

    <!-- Grid Tema -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <template x-for="item in items" :key="item.id">
            <div 
                x-show="filter === 'all' || item.category === filter"
                class="aspect-[9/16] bg-gray-100 rounded shadow">
                <img :src="item.image" alt="" class="w-full h-full object-cover rounded">
            </div>
        </template>
    </div>
</div>
