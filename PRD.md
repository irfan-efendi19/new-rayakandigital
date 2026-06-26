# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: FITUR UBAH POSISI URUTAN MEMPELAI (BRIDE & GROOM POSITION SWAPPER)
**Versi:** 8.0 (Spesifikasi Fleksibilitas Tata Letak - Laravel 13 & Tailwind CSS)  
**Tanggal:** 26 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Setiap pasangan memiliki preferensi yang berbeda mengenai tata letak penulisan nama di halaman depan undangan mereka. Beberapa adat atau keinginan pribadi menghendaki nama mempelai pria muncul di urutan pertama, sedangkan yang lain menghendaki nama mempelai wanita terlebih dahulu. Fitur **Ubah Posisi Mempelai** menyediakan satu tombol pintas (*quick swap*) di halaman `/edit` agar pengguna dapat menukar urutan visual urutan mempelai secara instan tanpa perlu menghapus dan menulis ulang profil masing-masing mempelai.

### 1.2 Aturan Bisnis (Position Swap Business Rules)
1. **Penyimpanan State Urutan (Order State Retention):** Sistem wajib mencatat variabel penanda urutan aktif di database menggunakan kolom `bride_groom_order`.
   * Nilai `male_first`: Mempelai Pria di atas/kiri, Mempelai Wanita di bawah/kanan.
   * Nilai `female_first`: Mempelai Wanita di atas/kiri, Mempelai Pria di bawah/kanan.
2. **Pertukaran Instan Sisi Klien (Client-Side Real-Time Swap):** Saat tombol *"Tukar Posisi"* diklik pada dashboard, susunan form input data mempelai (Foto, Nama, Profil Orang Tua) harus langsung berpindah posisi secara visual memanfaatkan reaktivitas Alpine.js.
3. **Sinkronisasi Generator Teks Otomatis:** Perubahan urutan ini harus secara otomatis memengaruhi urutan variabel gabungan pada sistem, seperti teks default di *WhatsApp Template* (`{{nama_pengantin}}`) dan judul meta tags SEO halaman web.

---

## 2. BLUEPRINT ARSITEKTUR DATABASE (MIGRATION PATCH)

Tambahkan kolom kontrol urutan visual pada tabel `invitations`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            // Default 'male_first' (Pria dahulu baru Wanita)
            $table->enum('bride_groom_order', ['male_first', 'female_first'])->default('male_first')->after('guest_categories_json');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('bride_groom_order');
        });
    }
};