# PRODUCT REQUIREMENT DOCUMENT (PRD) - UPDATE FITUR
## Modul: Pengaturan Kutipan Romantis / Ayat Suci (Wedding Quotes Section)
**Versi:** 1.0 (Spesifikasi Fitur Konten - Laravel 13 & PHP 8.4 Optimized)  
**Tanggal:** 1 Juni 2026  
**Status:** Approved  
**Target Komponen:** Database Schema, Form Edit Dashboard, Controller Storage, & Theme Layout Rendering  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Fitur *Quotes* memberikan fleksibilitas kepada pasangan untuk menyisipkan pesan sakral, kutipan ayat suci (seperti QS. Ar-Rum: 21, Alkitab, atau Weda), maupun kutipan romantis dari tokoh ternama. Kutipan ini akan dirender dengan tipografi yang elegan (font khusus/estetik) pada halaman depan undangan untuk memperkuat nuansa khidmat acara.

### 1.2 Aturan Bisnis (Business Rules)
1. **Struktur Komponen Quotes:** Setiap kutipan wajib terdiri dari 2 kolom input utama:
   * **Isi Kutipan (Quote Content):** Teks panjang berisi rangkaian kalimat mutiara/ayat.
   * **Sumber / Sumber Kutipan (Quote Source):** Kolom teks pendek untuk mencantumkan nama tokoh, buku, atau pasal ayat (Contoh: *"Ar-Rum: 21"* atau *"Kahlil Gibran"*).
2. **Isolasi Data Per Undangan:** Data kutipan disimpan langsung pada tabel utama `invitations` atau diisolasi menggunakan kolom khusus yang terikat pada `invitation_id`.
3. **Format Karakter Aman:** Kolom isi kutipan mendukung penyimpanan simbol, tanda petik, dan baris baru (*line break*) agar layout bait puisi/ayat tetap terjaga rapi saat dirender di halaman depan.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION)

Jalankan skrip migrasi berikut untuk menambahkan kolom penyimpanan kutipan pada tabel `invitations`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            // Kolom teks panjang untuk isi kutipan (nullable jika user tidak ingin mengisi)
            $table->text('quote_content')->nullable()->after('title');
            // Kolom untuk menuliskan sumber kutipan / ayat
            $table->string('quote_source', 150)->nullable()->after('quote_content');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['quote_content', 'quote_source']);
        });
    }
};