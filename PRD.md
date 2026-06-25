# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: PEMBATASAN KUOTA PAX RSVP PER UNDANGAN
**Versi:** 5.0 (Spesifikasi Alokasi Kursi & Manajemen Limitasi Tamu - Laravel 13 & Tailwind CSS)  
**Tanggal:** 25 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Untuk menghindari membeludaknya jumlah kehadiran tamu yang melebihi kapasitas gedung (*overcapacity*) atau kuota katering yang telah dipesan, sistem menyediakan pengaturan **Membatasi Pax RSVP** langsung pada halaman `/edit` undangan milik pengguna. Pemilik undangan dapat menetapkan batas maksimal kuota kehadiran global serta menentukan jumlah maksimal rombongan (pax) yang boleh dibawa oleh setiap satu entitas nama tamu.

### 1.2 Aturan Bisnis (RSVP Gating Business Rules)
1. **Limitasi Dua Lapis (Two-Tier Allocation Limit):**
   * **Maksimal Pax per Tamu (Per-Guest Limit):** Membatasi jumlah maksimal Pax yang bisa dipilih tamu saat mengisi form konfirmasi kehadiran (misal: maksimal hanya bisa memilih membawa 2 orang/pax).
   * **Total Kuota Global Undangan (Global Cap Limit):** Batas total keseluruhan pax yang terkumpul dari semua tamu yang menyatakan hadir. Jika total pax RSVP yang disetujui telah mencapai batas ini, sistem otomatis mengunci form RSVP untuk tamu berikutnya dan mengubah status menjadi *"Kuota Hadir Penuh"*.
2. **Reaktivitas Angka Sisa Kursi:** Sisi *front-end* halaman konfirmasi kehadiran tamu wajib menampilkan kalkulasi dinamis sisa slot kuota yang tersedia (jika diaktifkan oleh pemilik undangan).
3. **Pemberitahuan Penolakan Otomatis:** Tamu yang mencoba memasukkan angka pax melampaui sisa kuota yang tersedia akan langsung ditolak oleh sistem dengan pesan validasi yang informatif.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION PATCH)

Tambahkan kolom limitasi kuota pada tabel `invitations` utama untuk mengontrol jalannya validasi RSVP:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('is_rsvp_pax_limited')->default(false)->after('flower_animation_type'); // Status aktivasi batasan pax
            $table->integer('max_global_pax_quota')->nullable()->after('is_rsvp_pax_limited'); // Total kuota maksimal gedung (misal: 500 pax)
            $table->integer('max_pax_per_guest')->default(2)->after('max_global_pax_quota'); // Batas rombongan per nama tamu (misal: max 2 atau 3 pax)
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['is_rsvp_pax_limited', 'max_global_pax_quota', 'max_pax_per_guest']);
        });
    }
};