# PRODUCT REQUIREMENT DOCUMENT (PRD) - UPDATE VISUAL TEMA (PORTRAIT ONLY)
## Modul: Standardisasi Gambar Thumbnail Tema 9:16 (Landing Page & Admin Filament)
**Versi:** 1.1 (Spesifikasi Eksklusif Portrait - Filament v3 & Laravel 13 Optimized)  
**Tanggal:** 1 Juni 2026  
**Status:** Approved  
**Target Komponen:** Database Schema, Filament Resource Form, Media Storage Layer, & Landing Page View  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Fitur ini memfokuskan standardisasi aset gambar pratinjau (*thumbnail*) tema undangan pernikahan ke dalam satu format tunggal, yaitu **Portrait Mobile (9:16)**. Rasio ini dipilih karena mayoritas tamu mengakses undangan melalui perangkat seluler (*smartphone*), sehingga thumbnail harus mencerminkan tampilan visual asli mobile secara presisi. Aset ini diunggah oleh admin melalui panel **Filament** dan ditampilkan langsung pada katalog **Landing Page**.

### 1.2 Aturan Bisnis (Business Rules)
1. **Satu Tipe Rasio Baku (9:16):** Setiap entitas data tema (`themes`) hanya menyediakan satu kolom unggahan gambar pratinjau yang dikunci kaku pada rasio portrait 9:16 (`thumbnail_portrait`).
2. **Standardisasi File & Kompresi:** Gambar yang diunggah wajib berupa berkas `.webp` atau `.jpg` dengan ukuran maksimal 500 KB untuk menjaga kecepatan pemuatan halaman katalog.
3. **Kesesuaian Desain Kartu:** Pada *landing page*, tata letak kartu katalog akan mengadopsi bingkai portrait vertikal yang konsisten, baik saat diakses melalui perangkat mobile maupun desktop.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION)

Jalankan skrip migrasi berikut untuk menambahkan kolom penyimpanan berkas thumbnail portrait pada tabel `themes`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            // Menampung path berkas thumbnail resolusi Portrait Mobile (9:16)
            $table->string('thumbnail_portrait')->nullable()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_portrait']);
        });
    }
};