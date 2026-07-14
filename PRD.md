# PRODUCT REQUIREMENT DOCUMENT (PRD)

## MODUL: HYBRID QRIS PAYMENT SYSTEM (DYNAMIC & STATIC COEXISTENCE)

**Versi:** 22.0 (Spesifikasi Integrasi QRIS Dinamis Verssache & Media Library Filament v3)  
**Tanggal:** 14 Juli 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi

---

## 1. STRATEGI ALUR KERJA (PAYMENT WORKFLOW ENGINE)

Sistem akan menentukan metode pembayaran QRIS yang disajikan kepada pengguna berdasarkan konfigurasi transaksi:

1. **Skenario QRIS Statis (Manual Transfer):** Pengguna melihat gambar QRIS milik platform yang diunggah Admin. Pengguna harus mengunggah bukti transfer manual setelah melakukan pembayaran.
2. **Skenario QRIS Dinamis (Auto-Generated):** Sistem menggunakan payload string QRIS statis milik Anda (biasanya didapatkan dari merchant acquirer) kemudian menyuntikkan nominal tagihan secara dinamis menggunakan algoritma CRC16 dari library `verssache/qris-dinamis`. Pengguna cukup memindai, dan nominal transfer akan terisi otomatis di aplikasi perbankan mereka.

---

## 2. BLUEPRINT DATABASES & CONFIGURATION

### 2.1 Migrasi Data Tabel Pengaturan (`payment_settings`)

Tabel ini digunakan untuk menyimpan payload QRIS Master (untuk di-generate dinamis) serta file gambar QRIS Statis.

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {$table->id();
            // Jalur Dinamis (Verssache Library)
            $table->string('qris_merchant_name')->default('PLATFORM ID');$table->text('qris_master_payload')->nullable(); // Isi teks/string dari QRIS statis Anda

            // Jalur Statis (Manual File Upload)
            $table->string('qris_static_image')->nullable(); // Path file gambar QRIS
            $table->boolean('is_dynamic_active')->default(true); // Toggle penentu metode utama$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
```
