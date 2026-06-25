# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: IMPORT DATA TAMU VIA EXCEL (MASS GUEST IMPORTER ENGINE)
**Versi:** 7.0 (Spesifikasi Integrasi Maatwebsite/Excel - Laravel 13 & Tailwind CSS)  
**Tanggal:** 25 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Untuk mempercepat proses manajemen data, sistem menyediakan fitur **Import Tamu via Excel**. Fitur ini memungkinkan pengguna mengunduh berkas template spreadsheet standar yang sudah disediakan, mengisinya dengan ratusan nama tamu, nomor WhatsApp, serta kategori terkait, lalu mengunggahnya kembali ke halaman `/edit` dashboard user. Proses pemrosesan data dilakukan di latar belakang menggunakan library `maatwebsite/excel`.

### 1.2 Aturan Bisnis (Excel Import Business Rules)
1. **Validasi Struktur Kolom (Strict Header Matching):** Berkas Excel yang diunggah wajib mengikuti struktur kolom template resmi: `Nama Tamu`, `Nomor WhatsApp`, dan `Kategori`. Jika struktur kolom diubah atau tidak sesuai, sistem akan membatalkan proses import dan memunculkan pesan kesalahan (*error message*).
2. **Normalisasi Nomor WhatsApp:** Sistem wajib melakukan sanitasi otomatis terhadap nomor WhatsApp yang diimpor (misalnya mengubah awalan `08xxx` atau `+628xxx` secara otomatis menjadi format internasional murni `628xxx`).
3. **Penyelarasan Kategori Otomatis (Auto Category Mapping):** * Jika teks kategori pada baris Excel cocok dengan kategori yang sudah dibuat pengguna di database, tamu akan otomatis dikaitkan ke kategori tersebut.
   * Jika teks kategori belum ada, sistem akan membuatkan kategori baru tersebut secara otomatis (*on-the-fly creation*).
4. **Perlindungan Data Duplikat:** Jika ditemukan kombinasi nama tamu dan nomor WhatsApp yang sama persis dalam satu undangan, sistem akan melakukan *skip* (mengabaikan) atau melakukan *update* data terbaru (*Upsert mechanism*) guna mencegah penumpukan data ganda.

---

## 2. REKAYASA BACKEND: IMPLEMENTASI LARAVEL EXCEL (`maatwebsite/excel`)

### 2.1 Berkas Import Class (`App\Imports\GuestsImport.php`)
Buat berkas importer menggunakan fitur `ToModel`, `WithHeadingRow`, dan `WithValidation` bawaan Laravel Excel untuk memastikan validitas privasi dan keamanan data:

```php
namespace App\Imports;

use App\Models\Guest;
use App\Models\GuestCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class GuestsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $invitationId;

    public function __construct($invitationId)
    {
        $this->invitationId = $invitationId;
    }

    public function model(array $row)
    {
        // 1. Sanitasi & Normalisasi Nomor WhatsApp ke format 628xxx
        $whatsapp = $row['nomor_whatsapp'] ?? null;
        if ($whatsapp) {
            $whatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
            if (str_starts_with($whatsapp, '08')) {
                $whatsapp = '628' . substr($whatsapp, 2);
            } elseif (str_starts_with($whatsapp, '8')) {
                $whatsapp = '628' . substr($whatsapp, 1);
            }
        }

        // 2. Resolve Kategori Tamu secara dinamis
        $categoryId = null;
        $categoryName = trim($row['kategori'] ?? '');
        
        if (!empty($categoryName)) {
            $category = GuestCategory::firstOrCreate([
                'invitation_id' => $this->invitationId,
                'name' => $categoryName
            ]);
            $categoryId = $category->id;
        }

        // 3. Simpan data tamu ke database (Gunakan mekanisme Upsert berbasis slug/kombinasi)
        return new Guest([
            'invitation_id'     => $this->invitationId,
            'guest_category_id' => $categoryId,
            'name'              => trim($row['nama_tamu']),
            'whatsapp_number'   => $whatsapp,
            'slug'              => Str::slug(trim($row['nama_tamu'])) . '-' . Str::random(5),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_tamu' => 'required|string|max:255',
            'nomor_whatsapp' => 'nullable|string|max:20',
            'kategori' => 'nullable|string|max:50',
        ];
    }
}