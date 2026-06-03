# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: INTEGRASI VIDEO YOUTUBE & LIVE STREAMING (DASHBOARD CONTROLLED)
**Versi:** 1.6 (Spesifikasi Fitur Konten Video & Toggle Status - Laravel 13, Filament v3, & Alpine.js)  
**Tanggal:** 3 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Fitur ini memungkinkan pasangan pengantin (*user*) untuk menampilkan video dokumentasi pre-wedding ataupun menyematkan siaran langsung (*Live Streaming*) pernikahan dari YouTube langsung di dalam halaman undangan digital mereka. Pengaturan tautan (*link*) video serta kontrol aktif/nonaktif (*toggle switch*) dikelola secara mandiri oleh pengguna melalui dashboard klien, atau dapat dikontrol oleh admin melalui panel **Filament**.

### 1.2 Aturan Bisnis (Business Rules)
1. **Ekstraksi Otomatis ID Video:** Pengguna dapat memasukkan berbagai format URL YouTube (misal: *https://youtu.be/abc123xyz*, *https://youtube.com/watch?v=abc123xyz*, atau *https://youtube.com/live/abc123xyz*). Sistem harus mengekstrak ID video secara otomatis sebelum disimpan ke database untuk kebutuhan render `iframe` embed.
2. **Kontrol Visibilitas Dinamis (Toggle Master):** Terdapat sebuah kolom boolean (`show_video`) yang berfungsi sebagai saklar utama. Jika diset `false`, maka *section* video tidak akan dirender dalam DOM HTML undangan klien (*auto-hide state*).
3. **Optimasi Kecepatan (Lazy Loading):** Pemutaran berkas sematan `iframe` YouTube wajib menggunakan parameter `loading="lazy"` agar tidak menghambat pemuatan elemen esensial teks dan gambar *thumbnail* 9:16 di awal prapemuatan halaman.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION)

Jalankan skrip migrasi berikut untuk menambahkan kolom konfigurasi video YouTube pada tabel `invitations`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('show_video')->default(false)->after('title'); // Saklar Aktif/Nonaktif
            $table->string('youtube_url')->nullable()->after('show_video'); // URL Mentah dari User
            $table->string('youtube_video_id', 50)->nullable()->after('youtube_url'); // ID Hasil Ekstraksi
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['show_video', 'youtube_url', 'youtube_video_id']);
        });
    }
};