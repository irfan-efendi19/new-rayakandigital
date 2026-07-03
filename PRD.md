# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: DYNAMIC PREVIEW DATA PER TEMA (THEME-SPECIFIC DEMO DATA ENGINE)
**Versi:** 18.0 (Spesifikasi Isolasi Data Pratinjau Tema & Integrasi Form Filament v3 - Laravel 13)  
**Tanggal:** 3 Juli 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Saat calon pelanggan menjelajahi katalog tema di website utama, mereka dapat mengklik tombol "Preview Tema" untuk melihat bagaimana tema tersebut terlihat saat diisi data. Sebelumnya, sistem menggunakan satu data tiruan (*mock data*) global yang kaku untuk semua jenis tema. 

Fitur **Dynamic Preview Data** memberikan kemampuan bagi Admin melalui panel **Filament v3** untuk menyuntikkan data tiruan khusus (Nama Pengantin, Foto Hero, Tanggal Acara Tiruan) yang terikat langsung pada masing-masing entitas Tema (`themes`). Dengan demikian, tema bernuansa Tradisional akan menampilkan contoh nama & foto adat, sementara tema Modern akan menampilkan visual yang relevan.

### 1.2 Aturan Bisnis (Theme Preview Business Rules)
1. **Isolasi Data Terikat (Theme Binding):** Setiap tema wajib memiliki satu baris data pratinjau independen. Jika data pratinjau spesifik belum diisi oleh Admin, sistem harus beralih (*fallback*) ke data contoh default platform agar halaman preview tidak kosong (*Null Pointer Safeguard*).
2. **Kemandirian URL Preview:** URL untuk melihat pratinjau tema diatur menggunakan struktur slug tema khusus, contoh: `platform.id/themes/{theme_slug}/preview`.
3. **Pengendalian Gambar Kreatif:** Foto-foto contoh pratinjau tema (seperti foto mempelai pria/wanita) dikelola menggunakan *Filament File Upload* dan disimpan secara teratur pada folder `storage/app/public/theme_previews/`.

---

## 2. BLUEPRINT ARSITEKTUR DATABASE (MIGRATION SCHEMA)

Ubah tabel `themes` atau buat tabel relasi baru `theme_preview_data` untuk mengisolasi informasi demo:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_preview_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained('themes')->onDelete('cascade');
            
            // Komponen Data Mempelai Pria (Groom)
            $table->string('groom_full_name')->default('Mochammad Irfan');
            $table->string('groom_short_name')->default('Irfan');
            $table->string('groom_father_name')->nullable();
            $table->string('groom_mother_name')->nullable();
            
            // Komponen Data Mempelai Wanita (Bride)
            $table->string('bride_full_name')->default('Siti Salsabila');
            $table->string('bride_short_name')->default('Sasa');
            $table->string('bride_father_name')->nullable();
            $table->string('bride_mother_name')->nullable();
            
            // Aset Gambar Spesifik Tema
            $table->string('hero_image_path')->nullable(); // Foto utama bertema khusus
            $table->string('bg_music_path')->nullable();   // Backsound musik yang cocok dengan tema
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_preview_data');
    }
};