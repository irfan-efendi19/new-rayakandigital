# PRODUCT REQUIREMENT DOCUMENT (PRD) - UPDATE FITUR
## Modul: Dinamis Lini Masa Cerita Cinta (Multi-Item Love Story Timeline)
**Versi:** 2.0 (Spesifikasi Fitur Dinamis - Laravel 13 & PHP 8.4 Optimized)  
**Tanggal:** 1 Juni 2026  
**Status:** Approved  
**Target Komponen:** Database Schema, Dynamic Form Repeater UI, Controller Storage, & Timeline Theme View  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Fitur Cerita Cinta (*Love Story*) digunakan oleh pasangan untuk membagikan momen-momen berharga perjalanan hubungan mereka kepada para tamu undangan (misal: Kisah Pertama Kenal, Momen Lamaran, hingga Hari Pernikahan). 

### 1.2 Aturan Bisnis Baru (Business Rules)
1. **Multi-Item Input (Repeater):** Pengguna dapat menambahkan, mengubah, atau menghapus momen cerita cinta mereka **lebih dari 1 baris (dinamis)** sesuai kebutuhan tanpa batasan jumlah statis.
2. **Struktur Komponen Momen:** Setiap baris cerita wajib memiliki 2 kolom utama:
   * **Waktu:** Kolom teks fleksibel untuk menampung waktu kejadian (Contoh: "Tahun 2022", "Maret 2024", atau "12 Desember 2025").
   * **Keterangan:** Area teks (*textarea*) untuk menjabarkan detail isi cerita pada waktu tersebut.
3. **Isolasi Data Per Undangan:** Data cerita cinta disimpan dan terikat secara eksklusif pada `invitation_id` masing-masing undangan. Perubahan cerita di Undangan A tidak boleh memengaruhi Undangan B milik user yang sama.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION)

Untuk mendukung data yang dinamis (bisa lebih dari satu baris per undangan), struktur data disimpan ke dalam tabel anak terpisah bernama `invitation_stories` dengan relasi *One-to-Many*:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_stories', function (Blueprint $table) {
            $table->id();
            // Menghubungkan cerita secara spesifik ke entitas undangan terkait
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            
            $table->string('story_date'); // Kolom Waktu (Tahun / Bulan / Tanggal teks fleksibel)
            $table->text('story_description'); // Kolom Keterangan / Detail isi cerita
            $table->integer('order_position')->default(0); // Mengatur urutan kronologis penampilan cerita
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_stories');
    }
};