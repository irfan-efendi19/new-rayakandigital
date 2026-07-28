# Product Requirement Document (PRD)

## MODUL: LAYAR SAPA - INDEPENDENT FULL-CUSTOM ENGINE

| Atribut               | Detail                                                                                |
| :-------------------- | :------------------------------------------------------------------------------------ |
| **Status**            | Approved                                                                              |
| **Penulis**           | Mochammad Irfan Efendi                                                                |
| **Tanggal Pembuatan** | 28 Juli 2026                                                                          |
| **Target Komponen**   | Modul Layar Sapa & Filament Admin Upload Engine                                       |
| **Filosofi Utama**    | **Unopinionated Standalone Template & Native ZIP Pipeline (100% Free UI/UX Freedom)** |

---

## 1. KONSEP & ARSITEKTUR INDEPENDEN (DECOUPLED DESIGN)

Sistem Layar Sapa tidak lagi memaksakan struktur CSS/JS atau komponen template tertentu. **Setiap tema adalah berkas web murni yang bisa dibuka dan diuji secara independen di komputer lokal (VS Code)** tanpa memerlukan Laravel, database, atau koneksi internet.

### 1.1 Struktur Berkas Wajib di Lingkungan Lokal (VS Code)

Pengembang lokal bebas menentukan desain, tetapi berkas ZIP yang diunggah harus memiliki struktur hirarki berikut:

```text
nama-tema-bebas.zip/
├── index.html          <-- Pure HTML (Struktur visual & penempatan bracket placeholder)
├── css/
│   └── style.css       <-- Pure CSS (Aturan styling, layout, grid/flex, keyframe animasi)
├── js/
│   └── app.js          <-- Pure JS (Logika manipulasi DOM, marquee scroll, atau WebSockets)
└── assets/
    ├── bg-video.mp4     <-- Aset media lokal (opsional: video, gambar, audio)
    └── custom-font.ttf <-- Font kustom
```

### 1.2 Aturan Penulisan Kode Lokal (Local Rules)

1. **Path Relatif Murni:** Pemanggilan berkas pendukung pada `index.html` **wajib** menggunakan path relatif standar agar dapat berjalan langsung saat _double-click_ file `index.html` di laptop lokal:
    ```html
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/app.js" defer></script>
    <img src="assets/bg.jpg" alt="Background" />
    ```
2. **Kebebasan Total Frontend:** Pengembang bebas menggunakan Pure CSS, Tailwind via CDN, GSAP Animation, Three.js, Canvas, atau pustaka JavaScript apa pun di dalam berkas murni tersebut.
3. **Penyisipan Variable Placeholder (Contract Layer):** Laravel hanya bertugas mengganti tag bracket `{...}` yang diletakkan secara bebas oleh pengembang pada `index.html`:
    - `{judul_kustom}` : Judul ucapan/layar (misal: "Selamat Datang").
    - `{nama_pengantin}` : Nama pasangan/mempelai.
    - `{wish_list_items}` : Penampung elemen daftar ucapan tamu.

---

## 2. ENGINE REFAKTORISASI PARSER (`ScreenDisplayController.php`)

Controller bekerja secara pasif tanpa mengubah atau memotong logika JS/CSS kustom buatan pengembang. Mesin parser memindai pemanggilan berkas relatif (`href="..."`, `src="..."`, `url(...)`) lalu mengubahnya secara otomatis menjadi **URL Publik Storage Server Laravel**.

```php
<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationScreen;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ScreenDisplayController extends Controller
{
    public function showLiveScreen($slug)
    {
        // 1. Eksekusi dari Cache Redis untuk memastikan TTFB cepat (< 80ms)
        $cacheKey = "live_screen_output_{$slug}";

        $htmlOutput = Cache::remember($cacheKey, now()->addHours(2), function () use ($slug) {
            $invitation = Invitation::where('slug', $slug)->firstOrFail();
            $settings = InvitationScreen::with('screenPreset')
                ->where('invitation_id', $invitation->id)
                ->firstOrFail();

            $preset = $settings->screenPreset;

            // Validasi keberadaan file index.html di storage hasil ekstrak ZIP admin Filament
            if (!$preset || !$preset->is_active || !Storage::disk('public')->exists($preset->storage_path . '/index.html')) {
                return response("Template Layar Sapa tidak ditemukan atau berkas ZIP belum diekstrak.", 404);
            }

            $folderPath = $preset->storage_path;
            $baseUrl = asset('storage/' . $folderPath) . '/';

            // 2. Baca isi Pure HTML mentah buatan pengembang lokal
            $rawHtml = Storage::disk('public')->get($folderPath . '/index.html');

            // 3. AUTOMATION PARSER: Mengubah SELURUH path relatif lokal (css/, js/, assets/) ke Absolute URL Storage
            // Regex ini mendeteksi atribut href="...", src="...", dan action="..." yang berupa path relatif
            $parsedHtml = preg_replace_callback(
                '/(href|src)=["']((?!http|https|\/\/|data:)[^"']+)["']/',
                function ($matches) use ($baseUrl) {
                    $attribute = $matches[1];
                    $relativePath = ltrim($matches[2], '/');
                    return $attribute . '="' . $baseUrl . $relativePath . '"';
                },
                $rawHtml
            );

            // 4. GENERATE UCAPAN TAMU (Renders Standard HTML Items)
            $wishes = $invitation->comments()->latest()->take(12)->get();
            $wishesHtml = '';
            foreach ($wishes as $wish) {
                $wishesHtml .= "
                    <div class='wish-card'>
                        <h4 class='wish-sender'>" . e($wish->name) . "</h4>
                        <p class='wish-message'>"" . e($wish->content) . ""</p>
                    </div>
                ";
            }

            // 5. INJEKSI VARIABEL: Substitusi data ke tag bracket placeholder HTML murni
            return str_replace([
                '{judul_kustom}',
                '{nama_pengantin}',
                '{wish_list_items}'
            ], [
                e($settings->custom_title ?? 'Selamat Datang'),
                e($invitation->title ?? 'Pasangan Mempelai'),
                $wishesHtml
            ], $parsedHtml);
        });

        // 6. Kembalikan respons sebagai Pure HTML
        return response($htmlOutput, 200)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }
}
```

---

## 3. DUKUNGAN RENDERING KHUSUS (DUA OPSI MANAJEMEN UCAPAN)

Agar pengembang tidak terikat pada komponen `div.wish-card` buatan Laravel, sistem mendukung dua skenario interaksi:

### Opsi A: Default CSS Injection (Sederhana)

Pengembang cukup menyisipkan `{wish_list_items}` di mana saja dalam file `index.html`. Pengembang kemudian bebas menentukan visual kartu ucapan tersebut melalui file `css/style.css` lokal:

```css
/* Bebas styling kelas .wish-card, .wish-sender, & .wish-message di style.css lokal */
.wish-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
}
.wish-sender {
    font-weight: bold;
    color: #ffd700;
}
.wish-message {
    font-size: 0.9rem;
    color: #ffffff;
}
```

### Opsi B: Pure JS Polling / REST API (100% Custom Motion / Canvas / 3D)

Jika pengembang ingin membuat efek visual animasi kompleks (seperti balon ucapan melayang, running text 3D, atau Canvas Particles), pengembang **tidak perlu memasang bracket `{wish_list_items}`**.

Pengembang cukup menulis skrip Pure JS di `js/app.js` untuk mengambil data JSON secara langsung melalui Endpoint API publik Laravel:

```javascript
// js/app.js - Dijalankan di dalam browser proyektor
document.addEventListener("DOMContentLoaded", () => {
    const invitationSlug = window.location.pathname.split("/").pop();

    // Fetch data ucapan secara berkala (Polling)
    setInterval(() => {
        fetch(`/api/v1/screen-wishes/${invitationSlug}`)
            .then((res) => res.json())
            .then((wishes) => {
                // Bebas me-render data ucapan ke elemen Canvas, Three.js, atau DOM kustom
                renderCustomAnimation(wishes);
            });
    }, 5000);
});
```

---

## 4. BYPASS ASET STATIS SERVER NGINX (LOW CPU USAGE)

Aplikasi Laravel **tidak boleh membuang daya komputasi CPU** untuk melayani berkas fisik `.css`, `.js`, gambar, atau video dari tema Layar Sapa. Pengiriman berkas ini diserahkan sepenuhnya ke web server **Nginx**.

```nginx
# Nginx Static Asset Direct Access
location ~* ^/storage/screen-templates/.*\.(js|css|png|jpg|jpeg|gif|ico|svg|webp|mp4|ttf|woff2)$ {
    expires 365d;
    add_header Cache-Control "public, no-transform, immutable";
    access_log off;
    log_not_found off;
    try_files $uri =404;
}
```

---

## 5. SKENARIO PENGUJIAN ALUR KERJA (QA MATRICES)

- **TC-CUSTOM-001 (Local Offline Preview):** Pengembang dapat membuka file `index.html` langsung dari file explorer laptop (tanpa local server/XAMPP). Seluruh visual, animasi CSS, dan skrip JS harus berjalan 100% normal.
- **TC-CUSTOM-002 (Zip Upload & Automatic Extraction):** Admin mengunggah berkas `.zip` tema baru via Filament Admin. Sistem mengestrak isi direktori ke folder `storage/app/public/screen-templates/{slug}` tanpa ada berkas yang hilang.
- **TC-CUSTOM-003 (Asset Path Resolution):** Buka halaman proyektor di browser (`/screen/{slug}`). Konsol pengembang (_F12 Developer Tools_) tidak boleh menampilkan pesan kesalahan `404 Not Found` pada pemanggilan berkas CSS, JS, maupun gambar/video di folder `assets/`.
