# PRODUCT REQUIREMENT DOCUMENT (PRD) - HOTFIX VISIBILITAS FITUR
## Modul: Dynamic Feature Switch Button (User Control Layer)
**Versi:** 1.0 (Spesifikasi Khusus - Laravel 13 & PHP 8.4 Optimized)  
**Tanggal:** 1 Juni 2026  
**Status:** Approved  
**Target Komponen:** Database Migrations, Edit Invitation View, Invitation Controller, & Client Theme View  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS

### 1.1 Deskripsi Fitur
Memberikan kendali penuh kepada pengguna (Tenant/Pemilik Undangan) melalui tombol geser (*Toggle Switch Button*) pada halaman Edit Undangan. Fitur ini berfungsi untuk menampilkan atau menyembunyikan bagian/fitur tertentu secara dinamis pada halaman depan undangan yang diakses oleh tamu.

### 1.2 Cakupan Fitur Utama yang Dikontrol
1. **Fitur QR Check-In:** Menampilkan atau menyembunyikan kode QR unik tamu pada halaman undangan.
2. **Fitur Buku Tamu / Komentar:** Menampilkan atau menyembunyikan kolom ucapan dan doa restu di bagian bawah undangan.

### 1.3 Aturan Bisnis (Business Rules)
* **Default State:** Saat pertama kali paket aktif, semua switch bernilai `true` (1), yang berarti fitur otomatis tampil.
* **Isolasi Mutasi:** Perubahan status switch hanya berlaku pada entitas undangan terkait (`invitation_id`) dan tidak memengaruhi undangan lain milik user yang sama.
* **Clean Code Rendering:** Jika status switch bernilai `false` (0), maka komponen tersebut harus **dihilangkan sepenuhnya dari struktur kode HTML** halaman tamu (bukan sekadar disembunyikan menggunakan CSS `display:none`) demi menghemat performa kueri basis data dan keamanan data.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION)

Jalankan skrip migrasi berikut untuk menambahkan kolom kontrol visibilitas pada tabel `invitations`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            // Menambahkan kolom boolean untuk kontrol visual fitur
            $table->boolean('show_qr_checkin')->default(true)->after('expired_at');
            $table->boolean('show_comments')->default(true)->after('show_qr_checkin');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['show_qr_checkin', 'show_comments']);
        });
    }
};