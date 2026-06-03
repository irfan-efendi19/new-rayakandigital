# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: KONTROL AKSES FITUR BERBASIS TIER HARGA (SUBSCRIPTION FEATURE GATE)
**Versi:** 1.7 (Spesifikasi Manajemen Paket & Hak Akses Fitur - Laravel 13 & Filament v3)  
**Tanggal:** 3 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Fitur ini memberikan kemampuan bagi Admin untuk membuat paket harga (Tier) yang fleksibel (misal: *Bronze, Silver, Gold*) melalui panel **Filament**, menetapkan daftar fitur apa saja yang aktif di masing-masing paket tersebut, dan secara otomatis mengunci atau membuka hak akses fitur pada akun pengguna (*User Invitation Dashboard*) serta membatasi penayangan komponen di halaman depan undangan klien.

### 1.2 Aturan Bisnis (Business Rules)
1. **Daftar Fitur Baku (Feature Registry):** Sistem memiliki daftar fitur bawaan yang didaftarkan sebagai acuan (*Cerita Cinta, Absensi QR, Layar Sapa, Video YouTube, Musik Latar, dll*).
2. **Kontrol Granular:** Setiap Tier Harga memiliki relasi *Many-to-Many* ke tabel fitur, bertindak sebagai saklar izin akses (*Feature Flagging*).
3. **Fallback & Graceful Restriction:** Jika pengguna mencoba mengakses menu fitur yang tidak masuk dalam cakupan tier harganya, sistem di dashboard wajib memunculkan status *locked* (tombol dinonaktifkan/redup) disertai tawaran untuk melakukan *upgrade* paket. Di sisi undangan klien, komponen yang tidak berizin tidak akan dirender oleh sistem.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION)

Buat struktur tabel master paket, tabel fitur, dan tabel pivot relasi antara paket dengan hak akses fitur:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Tabel Tier Paket Harga
        Schema::create('pricing_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Misal: Bronze, Silver, Gold
            $table->string('slug')->unique();
            $table->decimal('price', 12, 2)->default(0.00);
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Master Tabel Registrasi Fitur Aplikasi
        Schema::create('app_features', function (Blueprint $table) {
            $table->id();
            $table->string('feature_key')->unique(); // Kode unik sistem, misal: 'feature_youtube_video', 'feature_qr_checkin'
            $table->string('feature_name'); // Nama pajangan, misal: 'Sematkan Video & Live YouTube'
            $table->string('group_name')->default('Dasar'); // Pengelompokan visual
            $table->timestamps();
        });

        // 3. Tabel Pivot Hubungan Banyak-ke-Banyak (Tier vs Fitur)
        Schema::create('app_feature_pricing_tier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricing_tier_id')->constrained('pricing_tiers')->onDelete('cascade');
            $table->foreignId('app_feature_id')->constrained('app_features')->onDelete('cascade');
        });

        // 4. Menghubungkan Skema Transaksi Undangan Eksisting ke Level Tier Paket
        Schema::table('invitations', function (Blueprint $table) {
            $table->foreignId('pricing_tier_id')
                ->nullable()
                ->after('user_id')
                ->constrained('pricing_tiers')
                ->onDelete('set null'); // Jika paket dihapus admin, undangan tetap aman terdata
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropForeign(['pricing_tier_id']);
            $table->dropColumn('pricing_tier_id');
        });

        Schema::dropIfExists('app_feature_pricing_tier');
        Schema::dropIfExists('app_features');
        Schema::dropIfExists('pricing_tiers');
    }
};