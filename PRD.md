# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: MANAJEMEN KATEGORI TAMU (GUEST CATEGORIZATION SYSTEM)
**Versi:** 6.0 (Spesifikasi Pengelompokan Tamu Dinamis - Laravel 13 & Tailwind CSS)  
**Tanggal:** 25 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Untuk memudahkan penyelenggara acara (pengantin) dalam mengelola ratusan data tamu, sistem menyediakan fitur **Kategori Tamu (*Guest Category Tags*)**. Pengguna dapat membuat, mengubah, dan menghapus label kategori kustom mereka sendiri (misal: *VIP, Keluarga Besar, Teman Kuliah, Rekan Kerja*) langsung melalui halaman `/edit` undangan. Kategori ini akan mengikat setiap baris data tamu dan menjadi parameter filter utama pada sistem pembagian pesan WhatsApp massal.

### 1.2 Aturan Bisnis (Categorization Business Rules)
1. **Dinamis & Kustomizable:** Pengguna bebas mendefinisikan nama kategori baru tanpa batasan jumlah kata, yang akan dikelola menggunakan input berbasis *badge* atau *tags input element*.
2. **Relasi Many-to-One / Many-to-Many:** Satu orang tamu wajib dikaitkan dengan minimal satu kategori (atau bisa jamak jika diizinkan sistem) untuk mempermudah pemetaan segmentasi gaya bahasa template pesan WhatsApp.
3. **Pemberian Warna Visual (Color Coding - Opsional):** Setiap kategori dapat diberikan warna pembeda (*color-coded badge*) untuk memudahkan penandatanganan visual saat membaca daftar manifestasi tamu di dashboard utama.

---

## 2. BLUEPRINT ARSITEKTUR DATABASE (MIGRATION & RELATIONSHIP)

Buat tabel baru `guest_categories` yang berelasi dengan tabel `invitations`, serta tambahkan kolom kunci asing pada tabel `guests`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Master Kategori Tamu per Undangan
        Schema::create('guest_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('name'); // Misal: "Keluarga", "Teman Kantor", "VIP"
            $table->string('color_code')->default('#6b7280'); // Kode warna hex untuk badge UI
            $table->timestamps();
        });

        // 2. Modifikasi tabel guests yang sudah ada untuk menghubungkannya ke kategori
        Schema::table('guests', function (Blueprint $table) {
            $table->foreignId('guest_category_id')->nullable()->after('invitation_id')->constrained('guest_categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropForeign(['guest_category_id']);
            $table->dropColumn('guest_category_id');
        });
        Schema::dropIfExists('guest_categories');
    }
};