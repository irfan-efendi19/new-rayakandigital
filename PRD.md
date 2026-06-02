# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: INTEGRASI LARAVEL SOCIALITE PADA LARAVEL BREEZE AUTHENTICATION
**Versi:** 1.5 (Spesifikasi Fitur OAuth - Laravel 13, Laravel Breeze, & Tailwind-Configured)  
**Tanggal:** 3 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Fitur ini mengintegrasikan **Laravel Socialite (OAuth Google)** ke dalam sistem autentikasi **Laravel Breeze** yang sudah ada. Tujuannya adalah mempermudah *user* (pasangan pengantin) untuk mendaftar (*Register*) atau masuk (*Login*) ke dalam dashboard pembuatan undangan digital hanya dengan satu klik menggunakan akun Google mereka.

### 1.2 Aturan Bisnis (Business Rules)
1. **Satu Akun Satu Email:** Jika email Google *user* sudah terdaftar melalui jalur pendaftaran regular (email & password), sistem akan otomatis menghubungkan (*bind*) akun tersebut ke Google OAuth saat *user* mencoba login menggunakan Google.
2. **Password Bypass untuk Akun Sosial:** Pengguna yang mendaftar secara eksklusif via Google akan dibuatkan password acak (*random secure password*) di database. Mereka tidak wajib mengisi password kecuali jika nantinya menggunakan fitur *Forgot Password*.
3. **Penyimpanan Profil:** Foto profil akun Google pengguna wajib ditarik saat registrasi pertama kali dan disimpan ke dalam kolom `avatar` pada tabel `users`.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION)

Jalankan skrip migrasi berikut untuk menambahkan kolom token sosial dan avatar pada tabel `users`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('password')->unique();
            $table->string('google_token')->nullable()->after('google_id');
            $table->string('google_refresh_token')->nullable()->after('google_token');
            $table->string('avatar')->nullable()->after('email'); // Menyimpan URL foto profil Google
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'google_token', 'google_refresh_token', 'avatar']);
        });
    }
};
