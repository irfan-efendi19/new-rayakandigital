# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: GENERATOR CETAK PDF INVOICE & REKAPITULASI ADD-ON (BILLING ENGINE)
**Versi:** 17.0 (Spesifikasi Ekspor DomPDF, Kalkulasi Kombinasi Transaksi & Layout Komersial - Laravel 13)  
**Tanggal:** 2 Juli 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Sebagai transparansi transaksi dan kebutuhan pembukuan bagi pengguna, sistem memerlukan modul **Cetak PDF Invoice**. Fitur ini memungkinkan pengguna mengunduh berkas format `.pdf` resmi dari halaman `/dashboard/invitations/`. Dokumen ini akan merekap total biaya investasi pembuatan undangan digital, yang menggabungkan harga paket dasar undangan beserta rincian lembar baris (*line-items*) dari seluruh fitur premium (*add-on*) yang berhasil dibeli dan aktif.

### 1.2 Aturan Bisnis (Invoice PDF Business Rules)
1. **Penyaringan Saringan Validitas (Settlement Only Sieve):** Komponen *add-on* yang berhak masuk ke dalam struk cetak PDF *hanya* yang memiliki status pembayaran `settlement` (lunas) pada tabel log transaksi. Item yang masih berstatus `pending` atau `expired` wajib diabaikan dari kalkulasi.
2. **Kunci Nilai Sejarah (Historical Price Integrity):** Angka harga yang dicetak pada PDF wajib merujuk pada kolom `purchased_price` di tabel pivot saat transaksi sukses terjadi, bukan merujuk pada harga master produk yang ada saat ini di Admin Filament.
3. **Standar Penamaan Berkas (Naming Standardization):** Berkas PDF yang diunduh wajib memiliki format nama yang baku, yaitu: `Invoice-[Nomor_Invoice]-[Slug_Undangan].pdf` (Contoh: `Invoice-INV-20260702-0034-irfan-sasa.pdf`).

---

## 2. REKAYASA BACKEND: INVOICE CONTROLLER GENERATOR (LARAVEL 13)

Integrasikan pustaka `dompdf` ke dalam controller khusus untuk menyusun data finansial sebelum dikonversi menjadi berkas PDF:

```php
namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\AddonTransaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Memproses data billing dan mengunduh berkas PDF Invoice resmi
     */
    public function downloadPdf($id)
    {
        // 1. Ambil data undangan beserta relasi user dan addon yang berstatus lunas (settlement)
        $invitation = Invitation::with(['user', 'addons' => function ($query) {
            $query->wherePivot('status_active', true);
        }])->findOrFail($id);

        // 2. Ambil semua log transaksi sukses untuk mencantumkan Nomor Referensi Invoice Utama
        $latestTransaction = AddonTransaction::where('invitation_id', $invitation->id)
            ->where('payment_status', 'settlement')
            ->latest()
            ->first();

        $invoiceNumber = $latestTransaction 
            ? $latestTransaction->reference_order_id 
            : 'INV-BASIC-' . $invitation->id . '-' . date('Ymd');

        // 3. Kalkulasi Komponen Biaya Dasar & Add-on
        $packagePrice = $invitation->package_price ?? 0; // Misal harga paket dasar pembuatan awal
        $addonTotal = $invitation->addons->sum('pivot.purchased_price');
        $grandTotal = $packagePrice + $addonTotal;

        // 4. Siapkan Array Payload untuk dilemparkan ke dalam view Blade HTML khusus PDF
        $data = [
            'invoice_number' => $invoiceNumber,
            'issue_date'     => now()->translatedFormat('d F Y'),
            'invitation'     => $invitation,
            'user'           => $invitation->user,
            'package_price'  => $packagePrice,
            'addons'         => $invitation->addons,
            'grand_total'    => $grandTotal
        ];

        // 5. Generate DOMPDF menggunakan view template terisolasi dengan set ukuran kertas A4
        $pdf = Pdf::loadView('dashboard.billing.invoice_pdf', $data)
                  ->setPaper('a4', 'portrait')
                  ->setWarnings(false);

        // 6. Alirkan stream unduhan ke browser pengguna secara instan
        return $pdf->download('Invoice-' . $invoiceNumber . '-' . $invitation->slug . '.pdf');
    }
}