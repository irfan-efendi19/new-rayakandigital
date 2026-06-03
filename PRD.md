# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: HAK AKSES KONTROL ADMIN TERPUSAT UNTUK SEMUA UNDANGAN USER
**Versi:** 1.8 (Spesifikasi Administrasi Global & Modifikasi Data User - Laravel 13 & Filament v3)  
**Tanggal:** 3 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Fitur ini memperluas fungsionalitas panel **Admin Filament** dengan memberikan hak otorisasi penuh kepada pengguna dengan peran *Admin* atau *Super Admin* untuk melihat, mengedit, memperbarui, maupun menghapus data undangan digital milik **seluruh pengguna (user/klien)** terdaftar tanpa terkecuali. Fitur ini krusial untuk kebutuhan bantuan teknis (*customer support*), moderasi konten massal, dan perbaikan data dari sisi belakang (*backend*).

### 1.2 Aturan Bisnis (Business Rules)
1. **Otorisasi Berbasis Peran (Role-Based Access):** Pengguna regular (klien) hanya boleh memanipulasi data undangan miliknya sendiri di dashboard user. Hanya pengguna dengan flag `is_admin = true` yang dapat mengakses dan mengubah seluruh data tersebut melalui rute admin panel Filament.
2. **Riwayat Log Perubahan (Audit Trail Audit):** Setiap kali Admin melakukan perubahan pada data undangan milik pengguna, sistem disarankan mencatat siapa admin yang mengubahnya demi menjaga akuntabilitas manajemen data.
3. **Data Owner Attribution Preservation:** Saat admin mengedit undangan seorang user, relasi kepemilikan data (`user_id`) tidak boleh berubah secara tidak sengaja ke akun admin. Data harus tetap merujuk secara absolut ke pemilik asli undangan tersebut.

---

## 2. BLUEPRINT REKAYASA MODEL & POLICIES (LARAVEL 13)

Untuk mengizinkan kontrol penuh dan menghindari isolasi data otomatis bawaan framework, kita perlu memastikan kebijakan keamanan (*Laravel Authorization Policies*) mengizinkan tindakan admin secara global.

### 2.1 Konfigurasi Model Policy (`InvitationPolicy.php`)
Pastikan metode otoritas di dalam file `app/Policies/InvitationPolicy.php` memeriksa apakah pengguna yang masuk memiliki peran admin:

```php
namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;

class InvitationPolicy
{
    /**
     * Metode Penentu Utama (Bypass): Jika user adalah admin, izinkan semua tindakan.
     */
    public function before(User $user, string $ability)
    {
        if ($user->is_admin) { // Mengasumsikan ada kolom boolean atau peran 'is_admin' pada tabel users
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true; // Pengguna biasa dikendalikan di dashboard mereka tersendiri
    }

    public function update(User $user, Invitation $invitation): bool
    {
        // Klien regular hanya bisa mengubah undangan miliknya sendiri
        return $user->id === $invitation->user_id;
    }

    public function delete(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id;
    }
}