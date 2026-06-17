# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: REFRAKTORISASI UI/UX SELEKSI TEMA PADA DASHBOARD USER (HORIZONTAL SLIDE CARD)
**Versi:** 2.8 (Spesifikasi Eksklusif Dashboard Pengguna - Laravel 13 & Tailwind CSS)  
**Tanggal:** 17 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI PERUBAHAN UI/UX & ATURAN BISNIS

### 1.1 Deskripsi Perubahan
Komponen pemilihan tema pada halaman **Edit Undangan** khusus di sisi **Dashboard User** dirombak total. Antarmuka lama yang menggunakan elemen `<select>` dropdown konvensional (kaku dan tidak menampilkan visual) diganti dengan komponen **Katalog Berjalan Horizontal (*Horizontal Scrollable Slide Cards*)**. Hal ini memastikan pengguna dapat melihat representasi nyata dari desain tema sebelum menerapkannya pada undangan mereka.

### 1.2 Aturan Bisnis Komponen (Component Business Rules)
1. **Isolasi Lingkup Tampilan:** Perubahan UI ini **hanya berlaku pada halaman dashboard depan milik user (Client-Side Dashboard)**. Panel kontrol administratif utama tetap menggunakan tata letak standar.
2. **Kelengkapan Informasi per Kartu:** Setiap kartu tema di dalam baris *slide* wajib memuat secara detail:
   * **Foto Sampul (*Thumbnail Portrait*):** Rasio vertikal ketat 9:16 hasil kompresi otomatis `.webp`.
   * **Judul Tema:** Nama komersial desain (misal: *Rustic Autumn*, *Midnight Elegant*).
   * **Lencana Kategori (*Category Badge*):** Penanda rumpun desain (misal: *Modern, Tradisional, Klasik*).
3. **Reaktivitas Pilihan (Active State Glow):** Kartu tema yang sedang aktif/dipilih oleh pengguna wajib mendapatkan indikator visual yang tegas, yaitu *border* hijau brand tebal (`border-brand`), bayangan bersinar (`shadow-md`), dan ikon centang tanda aktif.
4. **Scrollable Slider Responsif:** Baris penampung kartu harus mendukung usapan jari (*touch swipe*) pada layar ponsel dan memiliki sumbu gulir horizontal (`overflow-x-auto snap-x`) yang mulus.

---

## 2. IMPLEMENTASI FRONT-END INTERACTION LAYER (DASHBOARD USER BLADE)

Terapkan struktur kode berikut pada file template edit undangan pengguna (misalnya: `resources/views/dashboard/invitations/edit.blade.php`) menggunakan reaktivitas **Alpine.js** untuk mengikat nilai ID tema sebelum form dikirim ke server.

```html
@php
    // Ambil seluruh daftar master tema yang aktif dari database untuk di-looping
    $themes = \App\Models\Theme::where('is_active', true)->with('category')->get();
@endphp

<!-- COMPONENT WRAPPER DENGAN DEKLARASI DATA ALPINE.JS -->
<div x-data="{ selectedThemeId: {{ $invitation->theme_id ?? 'null' }} }" class="space-y-3">
    
    <!-- Input Tersembunyi untuk Menampung Nilai ID Tema yang Dipilih saat Form Disubmit -->
    <input type="hidden" name="theme_id" :value="selectedThemeId" required>

    <div class="flex flex-col">
        <label class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
            Pilihan Gaya & Tema Visual Undangan
        </label>
        <span class="text-[11px] text-gray-400 mt-0.5">
            Geser horizontal untuk melihat koleksi desain premium. Klik pada kartu gambar untuk memilih tema aktif.
        </span>
    </div>
    
    <!-- CONTAINER SLIDER HORIZONTAL -->
    <div class="flex gap-4 overflow-x-auto py-3 px-1 scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-gray-700 snap-x items-stretch">
        
        @foreach($themes as $theme)
            <!-- CARD TEMA INDIVIDUAL (SNAP TO CONTAINER ON SWIPE) -->
            <div 
                @click="selectedThemeId = {{ $theme->id }}"
                :class="{
                    'border-brand ring-2 ring-brand/20 shadow-md bg-brand-light/10': selectedThemeId === {{ $theme->id }},
                    'border-gray-200 dark:border-gray-700 hover:border-gray-300 bg-white dark:bg-gray-800': selectedThemeId !== {{ $theme->id }}
                }"
                class="w-40 sm:w-48 flex-shrink-0 border rounded-2xl p-2.5 transition-all duration-200 cursor-pointer snap-start relative flex flex-col justify-between select-none"
            >
                <!-- INDIKATOR CENTANG REAKTIF JIKA AKTIF -->
                <div x-show="selectedThemeId === {{ $theme->id }}" class="absolute top-4 right-4 bg-brand text-white rounded-full p-1 z-10 shadow-sm" x-cloak>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- 1. THUMBNAIL FOTO TEMA (RASIO 9:16) -->
                <div class="w-full aspect-[9/16] rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-900 relative">
                    @if($theme->thumbnail_portrait)
                        <img src="{{ asset('storage/' . $theme->thumbnail_portrait) }}" class="w-full h-full object-cover" alt="Pratinjau {{ $theme->name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Preview</div>
                    @endif
                </div>

                <!-- INFO TEKS DETAIL (JUDUL & KATEGORI) -->
                <div class="mt-3 space-y-1">
                    <!-- 2. LENCANA KATEGORI TEMA -->
                    <span class="inline-block text-[9px] font-bold uppercase tracking-wider bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 px-1.5 py-0.5 rounded-md">
                        {{ $theme->category?->name ?? 'Umum' }}
                    </span>

                    <!-- 3. JUDUL TEMA -->
                    <h4 class="text-xs font-bold text-gray-800 dark:text-gray-100 truncate block">
                        {{ $theme->name }}
                    </h4>
                </div>
            </div>
        @endforeach

    </div>
</div>

<style>
    /* Styling pembantu utilitas scrollbar horizontal agar tipis dan estetik */
    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: rgb(226, 232, 240);
        border-radius: 10px;
    }
    .dark .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: rgb(51, 65, 85);
    }
</style>