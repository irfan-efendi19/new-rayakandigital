# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: INTEGRASI GERBANG PEMBAYARAN ADD-ON (AUTOMATED PAYMENT GATEWAY FLOW)
**Versi:** 16.0 (Spesifikasi Snap Token, Webhook Handling & Auto-Fulfillment - Laravel 13)  
**Tanggal:** 1 Juli 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Untuk mengotomatisasi proses bisnis, sistem tidak lagi menggunakan konfirmasi transfer manual. Modul ini mengintegrasikan *Payment Gateway API* (seperti Midtrans/Xendit) ke dalam alur pembelian *add-on* di `/dashboard/invitations/`. Ketika pengguna memilih sebuah fitur ekstra, sistem akan memicu pembuatan token pembayaran (*invoice/snap token*), menampilkan *pop-up* opsi metode pembayaran (QRIS, E-Wallet, Virtual Account), dan mengaktifkan fitur tersebut secara instan setelah status berubah menjadi `settlement`/lunas.

### 1.2 Aturan Bisnis (Payment & Activation Rules)
1. **Penerbitan Invoice Tunggal:** Satu transaksi pembelian *add-on* menghasilkan satu record *invoice* unik di tabel `transactions` dengan status awal `pending`.
2. **Masa Kedaluwarsa (*Token Timeout*):** Sesi pembayaran dibatasi maksimal **24 jam** (atau sesuai kebijakan Midtrans/Xendit). Jika kedaluwarsa, status transaksi berubah menjadi `expired` dan *add-on* dapat diajukan kembali oleh pengguna.
3. **Fulfillment Otomatis Tanpa Campur Tangan Admin:** Sistem wajib memanfaatkan *Webhook / Callback handler* dari pihak *payment gateway* untuk mengubah status kolom `status_active` pada tabel pivot `addon_invitation` menjadi `true` (`1`) secara *real-time* tepat saat dana berhasil diverifikasi oleh sistem hulu.

---

## 2. BLUEPRINT ARSITEKTUR DATABASE (TRANSACTION PATTERNS)

Buat tabel baru `addon_transactions` untuk merekam rekam jejak pembayaran sebelum memanipulasi status di tabel pivot `addon_invitation`:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addon_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_order_id')->unique(); // ID Transaksi unik sistem (misal: INV-ADDON-20260701-XXXX)
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->foreignId('addon_id')->constrained('addons')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('payment_status')->default('pending'); // pending, settlement, expire, cancel
            $table->string('snap_token_url')->nullable(); // URL halaman pembayaran midtrans/xendit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addon_transactions');
    }
};