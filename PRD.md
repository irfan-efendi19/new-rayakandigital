# PRODUCT REQUIREMENT DOCUMENT (PRD) ADDENDUM

## MODUL: DYNAMIC THEME SELECTOR - LAYAR SAPA & CHECK-IN TAMU

**Versi:** 23.0 (Multi-Theme Welcoming Screen Configuration)  
**Tanggal:** 18 Juli 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi

---

## 1. PENGERTIAN & ALUR FITUR (CONCEPT OVERVIEW)

**Layar Sapa (Welcoming Screen)** adalah halaman khusus penanda kehadiran fisik di lokasi acara. Ketika petugas pendaftaran memindai QR Code tamu atau menginput nama mereka pada sistem _Check-In_, monitor besar yang menghadap ke tamu akan otomatis berubah menampilkan:

1. **Animasi Selamat Datang:** Menyebut nama tamu secara personal (Contoh: _"Selamat Datang, Bapak Ahmad & Keluarga"_).
2. **Slideshow Doa & Ucapan:** Menampilkan kompilasi ucapan/doa dari tamu tersebut yang sebelumnya telah mereka kirimkan melalui undangan digital.

Melalui penambahan modul ini, User dapat menentukan **kombinasi tema visual** yang selaras dengan dekorasi fisik gedung pernikahan mereka (misal: _Rustic, Minimalist Typography, atau Dark Elegant_).

---

## 2. REKAYASA DATABASE (`invitation_themes`)

Kita akan menambahkan tabel baru atau memodifikasi pengaturan layar sapa pada basis data agar mampu menyimpan variasi tema yang dipilih.

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screen_settings', function (Blueprint $table) {
            $table->id();$table->foreignId('invitation_id')->constrained()->onDelete('cascade');

            // Konfigurasi Fitur Layar Sapa
            $table->string('active_theme')->default('minimalist'); // default theme
            $table->json('selected_themes_pool')->nullable(); // Menyimpan daftar tema yang diaktifkan user$table->integer('slideshow_speed')->default(5); // Kecepatan transisi dalam detik
            $table->boolean('show_rsvp_wishes')->default(true); // Tampilkan ucapan/doa tamu di layar$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screen_settings');
    }
};
```
