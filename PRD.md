# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: GENERATOR QR CODE DENGAN LOGO TERPUSAT (QR CODE CENTER-LOGO OVERLAY ENGINE)
**Versi:** 10.0 (Spesifikasi GD Library Laravel 13, Enkapsulasi Lokasi Aset & Standar Ekspor Vektor - Laravel 13)  
**Tanggal:** 28 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Modul ini mengintegrasikan fungsi penggabungan gambar (*image blending*) untuk menyisipkan identitas visual logo platform kreatif tepat di tengah-tengah kotak QR Code RSVP Universal. Rekayasa visual ini mengadopsi mekanisme GD Library asli PHP ke dalam struktur Controller Laravel, menggunakan aset lokal yang tersimpan pada direktori `public/img/logo.png` sebagai sumber gambar logo statis bawaan.

### 1.2 Aturan Bisnis (Center-Logo QR Business Rules)
1. **Pemuatan Aset Lokal (On-Premise Local Asset Isolation):** Sistem dilarang memanggil API pihak ketiga (seperti Google Chart API) untuk alasan privasi data dan stabilitas performa. Seluruh proses pembuatan QR dan penempelan logo wajib diolah di dalam memori server backend memanfaatkan pustaka PHP GD.
2. **Skalasi Logo Presisi (Mathematical Scale Guard):** Ukuran logo di tengah kotak QR Code dibatasi secara ketat maksimal **1/3** atau **25%** dari total dimensi lebar QR Code utama. Pembatasan ini bertujuan agar pola kode matriks luar (*Data Matrix Patterns*) tidak tertutup terlalu banyak, sehingga QR Code tetap dapat dipindai dengan cepat oleh kamera ponsel (*Scannability Guarantee*).
3. **Mekanisme Error Correction Level Tinggi (High-Density ECC):** Rendering QR Code wajib dikonfigurasi dengan Error Correction Level **H (High)** atau **Q (Quartile)** untuk mengompensasi hilangnya area piksel di bagian tengah yang tertutup oleh logo.

---

## 2. ARSITEKTUR BACKEND: REKAYASA CONTROLLER GENERATOR (LARAVEL 13)

Perbarui fungsi manajemen QR Code pada `InvitationDashboardController.php` dengan mengimplementasikan teknik manipulasi gambar GD Library Laravel berbasis potongan kode native PHP Anda:

```php
namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvitationDashboardController extends Controller
{
    /**
     * Membuka halaman edit dan menghasilkan QR Code berlogo terintegrasi
     */
    public function getQrCodeWithLogo($id)
    {
        $invitation = Invitation::findOrFail($id);
        $rsvpUrl = url('/') . '/' . $invitation->slug . '?mode=scan_qr';

        // 1. Definisikan Path Lokasi File Logo Utama di folder Public
        $logoPath = public_path('img/logo.png');

        // 2. Generate Base QR Code dengan Level Error Correction "H" (High) 
        // Agar QR tetap terbaca dengan baik meskipun bagian tengah tertutup logo
        $qrBaseSvg = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->margin(1)
            ->generate($rsvpUrl);

        // 3. Konversi Data String QR Menjadi Resource GD Image
        $QR = imagecreatefromstring($qrBaseSvg);

        // 4. Periksa Jika File Logo Eksis di Folder public/img/
        if (file_exists($logoPath)) {
            $logoImage = imagecreatefrompng($logoPath);

            // Ambil dimensi asli QR dan Logo
            $QR_width    = imagesx($QR);
            $QR_height   = imagesy($QR);
            $logo_width  = imagesx($logoImage);
            $logo_height = imagesy($logoImage);

            // Hitung Rasio Skalasi (Logo diset 1/4 dari lebar QR untuk keamanan pemindaian)
            $logo_qr_width  = $QR_width / 4;
            $scale          = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;

            // Cari Koordinat Titik Tengah (Center Position)
            $center_x = ($QR_width - $logo_qr_width) / 2;
            $center_y = ($QR_height - $logo_qr_height) / 2;

            // Tempelkan Logo ke Tengah QR Code menggunakan teknik Resampled
            imagecopyresampled(
                $QR, $logoImage, 
                $center_x, $center_y, 
                0, 0, 
                $logo_qr_width, $logo_qr_height, 
                $logo_width, $logo_height
            );

            imagedestroy($logoImage);
        }

        // 5. Tangkap Output Buffer Gambar PNG untuk dikonversi ke Base64 (Untuk Rendering di Blade)
        ob_start();
        imagepng($QR);
        $imageData = ob_get_contents();
        ob_end_clean();
        imagedestroy($QR);

        $base64Image = 'data:image/png;base64,' . base64_encode($imageData);

        return view('dashboard.invitations.partials.qr_container', [
            'qrCodeImage' => $base64Image,
            'rsvpUrl'     => $rsvpUrl
        ]);
    }
}