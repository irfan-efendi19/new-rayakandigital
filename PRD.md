# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: PERBAIKAN SKEMA TIER HARGA & RESTRUKTURISASI DASHBOARD USER
**Versi:** 2.3 (Spesifikasi Paket per Objek Undangan - Laravel 13, Filament v3, & Tailwind CSS)  
**Tanggal:** 15 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI PERUBAHAN & ATURAN BISNIS (BUSINESS REVISIONS)

### 1.1 Deskripsi Perubahan
Sistem mengubah cakupan (*scope*) pembatasan fitur dari yang sebelumnya berbasis akun pengguna (*Per-User Subscription*) menjadi **Berbasis Tiap Undangan (*Per-Invitation Subscription*)**. Implementasi ini memungkinkan satu pengguna terdaftar untuk membuat dan mengelola beberapa undangan digital sekaligus dengan tingkat level paket (Tier Harga) yang berbeda (misalnya: User A memiliki *Undangan Pernikahan* dengan paket **Gold**, dan *Undangan Khitanan* dengan paket **Bronze**).

### 1.2 Aturan Bisnis Baru (New Business Rules)
1. **Isolasi Fitur Tingkat Undangan:** Validasi hak akses fitur (`Feature Gatekeeper`) dievaluasi langsung terhadap ID undangan yang sedang diakses atau disunting, bukan dari status akun *session* user yang login.
2. **Pembersihan UI Profil (Profile UI Cleansing):** Keterangan, *badge*, atau informasi tier harga pada halaman pengaturan profil pengguna (*User Profile Settings*) wajib **dihapus sepenuhnya** untuk menghindari kerancuan hak akses.
3. **Kontekstualisasi Grid Undangan:** Setiap kartu atau baris data undangan pada halaman utama dashboard pengguna wajib menampilkan *badge* nama paket yang aktif (*Bronze, Silver, Gold*) secara eksplisif beserta masa berlakunya jika ada.

---

## 2. BLUEPRINT REFRAKTORISASI DATABASE (MIGRATION STAGE)

Memastikan relasi kunci asing paket harga (`pricing_tier_id`) berada di dalam lingkup tabel `invitations` (Sudah benar dan dipertegas), serta memastikan tidak ada kolom paket yang tertinggal di tabel `users`.

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Memastikan kolom pricing_tier_id berada di tabel invitations (mengunci relasi per objek undangan)
        if (Schema::hasTable('invitations') && !Schema::hasColumn('invitations', 'pricing_tier_id')) {
            Schema::table('invitations', function (Blueprint $table) {
                $table->foreignId('pricing_tier_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('pricing_tiers')
                    ->onDelete('set null');
            });
        }

        // 2. Pembersihan: Hapus kolom tier dari tabel users jika sebelumnya pernah dibuat
        if (Schema::hasColumn('users', 'pricing_tier_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['pricing_tier_id']);
                $table->dropColumn('pricing_tier_id');
            });
        }
    }

    public function down(): void
    {
        // Jalur rollback jika diperlukan rekonstruksi ulang struktur database
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'pricing_tier_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('pricing_tier_id')->nullable()->constrained('pricing_tiers');
            });
        }
    }
};