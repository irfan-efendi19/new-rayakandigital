# PRODUCT REQUIREMENT DOCUMENT (PRD) - UPDATE FITUR
## Modul: Sistem Manajemen Tamu & Registrasi Berbasis QR Code (QR Check-In & Ticket Printing)
**Versi:** 1.0 (Spesifikasi Fitur Registrasi - Laravel 13 & PHP 8.4 Optimized)  
**Tanggal:** 1 Juni 2026  
**Status:** Approved  
**Target Komponen:** Database Schema, QR Generator, Dashboard Buku Tamu (Scanner UI), & Web Thermal Print Engine  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Sistem ini memodernisasi proses penerimaan tamu pada acara pernikahan. Setiap tamu yang didaftarkan oleh pemilik undangan akan mendapatkan QR Code unik. Di lokasi acara, panitia/penerima tamu dapat membuka halaman dasbor khusus buku tamu untuk memindai QR Code tersebut menggunakan kamera HP/Laptop, memvalidasi kehadiran, dan langsung mencetak tiket fisik (biasanya menggunakan printer thermal) sebagai bukti penukaran souvenir atau nomor meja.

### 1.2 Aturan Bisnis (Business Rules)
1. **Unik per Tamu:** Setiap baris data pada tabel tamu (`guests`) wajib memiliki string unik (`uuid` atau `hash`) yang dienkapsulasi ke dalam bentuk QR Code.
2. **Dasbor Khusus Buku Tamu (Gatekeeper View):** Menyediakan halaman steril dari menu edit undangan yang khusus digunakan oleh panitia penjaga meja registrasi untuk melakukan *scanning*.
3. **Idempotensi Scan (Anti-Double Scan):** Tamu yang sudah berhasil dipindai dan berstatus `Hadir` tidak dapat dipindai ulang untuk mendapatkan tiket baru (mencegah penipuan penukaran souvenir ganda). Sistem harus memunculkan peringatan *"Tamu Sudah Hadir!"*.
4. **Cetak Tiket Standar:** Sistem mendukung perintah pencetakan (*print assignment*) langsung ke printer thermal lokal menggunakan pustaka *window.print()* dengan format CSS media print yang disesuaikan (lebar struk 58mm atau 80mm).

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION)

Perbarui tabel `guests` untuk menyimpan kode unik, status kehadiran, waktu check-in, dan informasi pendukung:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Kode unik untuk di-generate menjadi QR Code
            $table->string('qr_code_token')->unique()->after('id');
            
            // Status kehadiran tamu
            $table->enum('attendance_status', ['pending', 'hadir', 'absen'])->default('pending')->after('qr_code_token');
            $table->timestamp('checked_in_at')->nullable()->after('attendance_status');
            
            // Indeks untuk mempercepat pencarian saat pemindaian QR Code
            $table->index(['qr_code_token', 'attendance_status'], 'idx_guest_checkin');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropIndex('idx_guest_checkin');
            $table->dropColumn(['qr_code_token', 'attendance_status', 'checked_in_at']);
        });
    }
};