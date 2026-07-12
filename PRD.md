# Product Requirement Document (PRD) Addendum

## Modul: Automated Email Notification Engine (Laravel Mailables & Queue)

| Atribut               | Detail                                         |
| :-------------------- | :--------------------------------------------- |
| **Status**            | Approved                                       |
| **Penulis**           | Irfan                                          |
| **Tanggal Pembuatan** | 12 Juli 2026                                   |
| **Target Rilis**      | Sprint 4 - Q3 2026                             |
| **Dependencies**      | Laravel Mail / AWS SES / Mailgun & Redis Queue |

---

## 1. Deskripsi Fitur & Aturan Bisnis

### 1.1 Skenario A: Email Aktivasi / Selamat Datang (Order Paket Gratis)

Ketika pengguna memilih paket dasar berbiaya Rp 0 (Gratis/Trial), sistem tidak memicu gateway pembayaran, melainkan langsung mengaktifkan undangan. Sistem wajib mengirimkan email sambutan (_Welcome & Onboarding Email_) yang berisi tautan akses instan ke dasbor kontrol mereka dan petunjuk langkah pertama pengelolaan undangan.

### 1.2 Skenario B: Email Pengingat Pembayaran (Order Paket Komersial / Add-on)

Untuk transaksi berbayar yang masih berstatus `pending` (menunggu pembayaran via QRIS/Transfer Bank), sistem memerlukan pengingat otomatis berjadwal (_scheduled cron cron-job reminder_) untuk mendorong penyelesaian transaksi sebelum masa berlaku tautan pembayaran kedaluwarsa.

### 1.3 Aturan Bisnis (Email Automation Rules)

1.  **Asynchronous Queue Processing:** Seluruh pengiriman email wajib dilemparkan ke dalam sistem antrean (_Redis/Database Queue Worker_) menggunakan job `ShouldQueue` agar tidak menghambat waktu muat (_render time_) request pengguna di peramban.
2.  **Saringan Kedaluwarsa Transaksi:** Email pengingat pembayaran hanya dikirimkan jika status transaksi di database _masih_ `pending` dan sisa waktu kedaluwarsa pembayaran (Midtrans/Xendit token expiration) masih berdurasi lebih dari 15 menit.
3.  **Batas Frekuensi Pengiriman:** Pengingat pembayaran otomatis hanya dikirimkan maksimal **1 kali** dalam kurun waktu 2 jam setelah _checkout_ dilakukan, guna menghindari klasifikasi email sebagai spam oleh penyedia layanan (Gmail/Yahoo).

---

## 2. Arsitektur Kode Backend (Laravel 13 Style)

### A. Mailable Kelas untuk Paket Gratis (`FreeOrderWelcomeMail.php`)

```php
namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FreeOrderWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invitation;
    public $user;

    public function __construct(Invitation $invitation)
    {
        $this->invitation =$invitation;
        $this->user =$invitation->user;
    }

    public function build()
    {
        return $this->subject('✦ Undangan Digital Anda Siap Dibuat! - PLATFORM.ID')
                    ->view('emails.orders.free_welcome')
                    ->with([
                        'dashboardUrl' => url('/dashboard/invitations/' . $this->invitation->id . '/edit')
                    ]);
    }
}
```
