# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: SPLIT INVITATION PER EVENT (MULTI-EVENT GUEST ASSIGNMENT SYSTEM)
**Versi:** 13.0 (Spesifikasi Alokasi Sesi Acara, Saringan Akses QR & Dinamisasi Teks WA - Laravel 13 & Tailwind CSS)  
**Tanggal:** 29 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Seringkali penyelenggara pernikahan memecah tamu ke dalam beberapa kloter acara (misal: *Kloter 1: Akad Nikah/Pemberkatan (Khusus Keluarga)*, *Kloter 2: Resepsi Sesi Siang (Rekan Kerja)*, dan *Kloter 3: Resepsi Sesi Malam (Sahabat/VIP)*) untuk mencegah penumpukan kapasitas gedung. 

Fitur **Split Invitation per Event** memungkinkan pengguna memetakan secara spesifik setiap tamu undangan ke satu atau beberapa sub-acara yang mereka kehendaki. Saat tamu membuka link undangan digital atau memindai QR code, sistem hanya akan menampilkan informasi detail waktu, peta lokasi, dan form RSVP untuk rangkaian acara yang dialokasikan khusus untuk dirinya saja.

### 1.2 Aturan Bisnis (Split Event Business Rules)
1. **Pemetaan Relasi Many-to-Many:** Satu baris data tamu (`guests`) dapat dikaitkan dengan satu atau lebih sub-acara (`events`) yang aktif pada paket undangan tersebut.
2. **Kustomisasi Teks Otomatis:** Variabel penanda waktu dan nama acara pada draf pesan kiriman WhatsApp wajib menyesuaikan secara dinamis berdasarkan hasil *split* acara tamu tersebut (Contoh: Tamu kloter akad mendapatkan draf bertuliskan "Akad Nikah", sedangkan kloter resepsi mendapatkan tulisan "Resepsi").
3. **Pemberian Hak Istimewa Admin:** Admin yang sedang dalam mode *impersonate* atau moderasi global memiliki hak penuh untuk mengubah alokasi kloter acara tamu mana pun jika klien meminta bantuan teknis.

---

## 2. BLUEPRINT ARSITEKTUR DATABASE (MIGRATION & PIVOT TABLE)

Gunakan skema tabel pivot untuk menghubungkan data entitas tamu dengan sub-acara secara fleksibel:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pastikan tabel master sub-acara (events) sudah siap
        // Biasanya berisi: id, invitation_id, title (Akad/Resepsi), date, start_time, location_name, dll.

        // 2. Buat Tabel Pivot antara Guests dan Events (Split Bridge Table)
        Schema::create('event_guest', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->timestamps();
            
            // Mencegah duplikasi data mapping yang sama dalam satu tamu
            $table->unique(['guest_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_guest');
    }
};