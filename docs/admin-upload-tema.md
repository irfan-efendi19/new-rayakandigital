# Upload Tema Undangan (Admin)

Dokumentasi ini menjelaskan fitur **upload tema undangan** oleh admin melalui panel Filament, mulai dari persiapan file ZIP tema, proses deploy, hingga konfigurasi data pratinjau.

---

## Daftar Isi

- [Akses Halaman Admin](#akses-halaman-admin)
- [Arsitektur](#arsitektur)
- [Alur Upload Tema](#alur-upload-tema)
- [Persyaratan File ZIP](#persyaratan-file-zip)
- [Keamanan (Security Scan)](#keamanan-security-scan)
- [Detail Proses Deploy](#detail-proses-deploy)
- [Form Upload Tema](#form-upload-tema)
- [Data Pratinjau Tema](#data-pratinjau-tema)
- [Preview di Front-End](#preview-di-front-end)
- [Mengedit & Menghapus Tema](#mengedit--menghapus-tema)
- [File yang Terlibat](#file-yang-terlibat)
- [Troubleshooting](#troubleshooting)

---

## Akses Halaman Admin

| Item | Nilai |
|---|---|
| URL Panel Admin | `{APP_URL}/admin` |
| Group Navigasi | **Manajemen Tema** |
| Menu | **Tema** |
| Resource | `App\Filament\Resources\Themes\ThemeResource` |

Dari halaman **Tema**, admin dapat:
- Melihat daftar semua tema (nama, kategori, `view_path`, status premium/aktif).
- Mencari & menyaring tema (filter Premium/Reguler dan Aktif/Nonaktif).
- Membuat tema baru (upload ZIP).
- Mengedit / menghapus tema yang sudah ada.

---

## Arsitektur

| Komponen | Teknologi / File |
|---|---|
| Panel Admin | Laravel Filament |
| Resource | `app/Filament/Resources/Themes/ThemeResource.php` |
| Form | `app/Filament/Resources/Themes/Schemas/ThemeForm.php` |
| Tabel | `app/Filament/Resources/Themes/Tables/ThemesTable.php` |
| Halaman | `app/Filament/Resources/Themes/Pages/{ListThemes,CreateTheme,EditTheme}.php` |
| Service Deploy | `app/Services/ThemeUploaderService.php` |
| Model | `app/Models/Theme.php`, `app/Models/ThemePreviewData.php` |
| View Tema | `resources/views/themes/` (+ folder `custom/`) |
| Aset Publik | `public/themes/custom/{slug}/` |

Tema yang di-upload akan disimpan sebagai **view Blade** baru (`themes.custom.<slug>`) beserta aset statisnya (CSS, JS, gambar) di folder `public/themes/custom/<slug>/`.

---

## Alur Upload Tema

```
Admin buka /admin → Manajemen Tema → Tema → Create
                                    ↓
              Upload ZIP (berisi index.html + aset)
                                    ↓
            ThemeUploaderService::deploy($zip, $name)
                    ↓
          1. Security Scan (ekstensi berbahaya ditolak)
                    ↓
          2. Cek index.html — wajib ada (error jika tidak)
                    ↓
          3. Ekstrak ke folder temp
                    ↓
          4. Cari folder root yang berisi index.html
                    ↓
          5. Rewrite path aset → asset('themes/custom/<slug>/...')
                    ↓
          6. Simpan index.html → views/themes/custom/<slug>.blade.php
                    ↓
          7. Salin aset lain → public/themes/custom/<slug>/
                    ↓
          8. Hapus folder temp & file ZIP
                    ↓
          Simpan record tema (view_path = themes.custom.<slug>) → success
```

---

## Persyaratan File ZIP

ZIP tema harus memenuhi kriteria berikut:

1. **Ekstensi file**: `.zip` (MIME `application/zip` atau `application/x-zip-compressed`).
2. **Wajib mengandung `index.html`** di folder root atau di dalam satu folder pembungkus (wrapper). Contoh struktur yang diterima:

```
theme.zip
├── index.html          ← valid (index.html di root)
├── css/style.css
├── js/app.js
└── images/bg.jpg
```

```
theme.zip
└── my-theme/           ← valid (index.html di dalam 1 folder pembungkus)
    ├── index.html
    ├── css/style.css
    └── images/bg.jpg
```

3. **Ukuran upload** mengikuti limit upload PHP/server.

---

## Keamanan (Security Scan)

Sebelum file diekstrak, semua nama file di dalam ZIP di-scan. Upload **ditolak** jika ditemukan ekstensi berikut:

```
php, phtml, php3, php4, php5, phps, exe, sh, bat
```

Jika terdeteksi, proses berhenti dan menampilkan pesan:

> **Security Error: Blocked file extension detected -> {nama file}**

Selain itu, URL aset yang ditulis di `index.html` hanya mengizinkan path relatif. Path yang mencurigakan (absolut URL `http/https//`, `data:`, `mailto:`, `tel:`, anchor `#`) dibiarkan apa adanya dan tidak di-rewrite.

---

## Detail Proses Deploy

Lokasi: `app/Services/ThemeUploaderService.php` → `deploy()`

1. **Slug tema** dibuat dari nama via `Str::slug()` — contoh `"My Theme"` → `my-theme`.
2. **Ekstraksi** dilakukan ke folder temp `storage/app/temp_theme_extract_<uniqid>`.
3. **Folder root** ditemukan otomatis (folder yang berisi `index.html`), baik di root ZIP maupun di dalam folder pembungkus.
4. **Rewrite path aset** di `index.html`:
   - `href="css/style.css"` → `href="{{ asset('themes/custom/my-theme/css/style.css') }}"`
   - `src="images/bg.jpg"` → `src="{{ asset('themes/custom/my-theme/images/bg.jpg') }}"`
   - Skrip Blade yang sudah ditulis user (`{{ ... }}` atau versi URL-encoded `%7B%7B`) tidak ikut diubah.
5. **Hasil render** disimpan sebagai `resources/views/themes/custom/<slug>.blade.php`.
6. **Aset statis** (semua file selain `index.html`) disalin ke `public/themes/custom/<slug>/`.
7. **Bersih-bersih**: folder temp dan file ZIP dihapus.
8. Mengembalikan `view_path` berupa `themes.custom.<slug>`.

> `index.html` pada tema biasa diberi nama `index.blade.php`? Tidak — khusus tema custom, file disimpan sebagai `<slug>.blade.php` dan dipanggil lewat `view_path` `themes.custom.<slug>`.

---

## Form Upload Tema

Form diatur di `app/Filament/Resources/Themes/Schemas/ThemeForm.php`.

### Field pada saat **Create** (tema baru)

| Field | Keterangan |
|---|---|
| `theme_category_id` | Kategori tema (dropdown, opsional). |
| `name` | Nama tema (wajib, maks 255 karakter). Menjadi basis slug & folder. |
| `zip_file` | Upload ZIP tema (wajib, hanya saat create). |
| `thumbnail_portrait` | Gambar thumbnail portrait (rasio 9:16, dengan editor gambar). |
| `is_premium` | Toggle tema premium. |
| `is_active` | Toggle tema aktif (default: aktif). |

### Field tambahan saat **Edit**

| Field | Keterangan |
|---|---|
| `view_path` | Auto-generated (read-only, tidak bisa diubah manual). |
| `Data Pratinjau Tema` | Section berisi data demo untuk preview (lihat di bawah). |

> ZIP hanya bisa di-upload saat **create**. Saat edit, `view_path` tidak dapat diubah. Untuk mengganti paket ZIP, hapus tema lalu buat ulang.

---

## Data Pratinjau Tema

Section **Data Pratinjau Tema** (hanya muncul saat edit) mengatur data demo yang tampil di halaman preview tema. Field yang kosong akan otomatis memakai data default platform (`PreviewData::getPreview()`).

Kelompok field:

| Grup | Field |
|---|---|
| Cover & Judul | `preview_hero_image_path`, `preview_title` |
| Mempelai Wanita | `preview_bride_photo_path`, `preview_bride_full_name`, `preview_bride_short_name`, `preview_bride_father_name`, `preview_bride_mother_name` |
| Mempelai Pria | `preview_groom_photo_path`, `preview_groom_full_name`, `preview_groom_short_name`, `preview_groom_father_name`, `preview_groom_mother_name` |
| Musik & Video | `preview_bg_music_path`, `preview_show_video`, `preview_youtube_url`, `preview_youtube_video_id` |
| Waktu & Tempat | `preview_event_date_offset_days`, `preview_event_time`, `preview_event_time_end`, `preview_timezone`, `preview_venue_name`, `preview_venue_address`, `preview_venue_maps_url` |
| Kutipan | `preview_quote_content`, `preview_quote_source` |
| Cerita Cinta | `preview_stories` (repeater: `story_date`, `story_title`, `story_description`) |
| Galeri Foto | `preview_gallery_photos` (multi upload, maks 20) |
| Kado Digital | `preview_gift_banks` (repeater), `preview_gift_ewallets` (repeater) |
| Daftar Acara | `preview_events` (repeater: `event_title`, `date_offset_days`, `start_time`, `end_time`, `is_until_finished`, `place_name`, `place_address`, `google_maps_url`) |

Data ini disimpan di tabel `theme_preview_data` (relasi `hasOne` pada `Theme`). Saat save, `EditTheme` mengambil field `preview_*` lalu disimpan/di-update via `ThemePreviewData::updateOrCreate`.

---

## Preview di Front-End

Setelah tema tersimpan & aktif, tema bisa di-preview publik lewat:

```
{APP_URL}/themes/{slug}/preview
```

Contoh: tema dengan `view_path` `themes.custom.my-theme` bisa diakses di `/themes/my-theme/preview`.

`ThemePreviewController@show`:
1. Mencari tema aktif berdasarkan `view_path`.
2. Mengambil data pratinjau (`resolvedPreviewData()`) — menggabungkan data tema dengan fallback global.
3. Membangun objek `Invitation` dummy dengan data preview.
4. Merender view tema (`themes.custom.<slug>`).

> Jika `view_path` yang tersimpan tidak ditemukan di folder view, controller otomatis memakai `themes.jawa` sebagai fallback.

---

## Mengedit & Menghapus Tema

- **Edit**: klik ikon edit pada baris tema. Hanya thumbnail, kategori, toggle, dan data pratinjau yang bisa diubah.
- **Hapus**: tombol delete pada halaman edit atau bulk delete. Saat tema dihapus, event `deleting` di `Theme::booted()` menjalankan `cleanupFiles()`:
  - Menghapus `resources/views/themes/custom/<slug>.blade.php`.
  - Menghapus folder `public/themes/custom/<slug>/`.
  - Menghapus file `thumbnail_portrait` dari storage public.

---

## File yang Terlibat

| File | Peran |
|---|---|
| `app/Filament/Resources/Themes/ThemeResource.php` | Resource utama tema. |
| `app/Filament/Resources/Themes/Pages/CreateTheme.php` | Memanggil `ThemeUploaderService::deploy()` saat create. |
| `app/Filament/Resources/Themes/Pages/EditTheme.php` | Menangani data pratinjau saat edit. |
| `app/Filament/Resources/Themes/Schemas/ThemeForm.php` | Definisi form upload & toggle tema. |
| `app/Filament/Resources/Themes/Schemas/ThemePreviewDataForm.php` | Form data pratinjau (preview). |
| `app/Filament/Resources/Themes/Tables/ThemesTable.php` | Kolom, filter, dan aksi tabel. |
| `app/Services/ThemeUploaderService.php` | Security scan, ekstraksi, rewrite path, deploy. |
| `app/Models/Theme.php` | Model + `cleanupFiles()` saat hapus. |
| `app/Models/ThemePreviewData.php` | Data pratinjau & merge dengan fallback. |
| `app/Http/Controllers/ThemePreviewController.php` | Preview publik `/themes/{slug}/preview`. |
| `database/migrations/*_create_themes_table.php` | Migration tabel `themes`. |
| `database/migrations/*_add_thumbnail_*_to_themes_table.php` | Migration kolom thumbnail. |
| `database/migrations/*_create_theme_categories_table.php` | Migration tabel kategori. |
| `database/seeders/ThemeSeeder.php` | Seeder tema bawaan platform. |

---

## Troubleshooting

### Error "Invalid Theme: Missing index.html in the root folder."

**Penyebab:** ZIP tidak mengandung `index.html` di root atau di dalam folder pembungkus.

**Solusi:** Pastikan ZIP berisi `index.html` (bukan `.html` lain, bukan di dalam subfolder lebih dari satu level).

### Error "Could not locate index.html inside the extracted folder structure."

**Penyebab:** `index.html` berada di dalam struktur folder yang terlalu dalam, misalnya `theme/dist/index.html`.

**Solusi:** Re-package ZIP sehingga `index.html` berada di root atau tepat 1 level di dalam folder pembungkus.

### Error "Security Error: Blocked file extension detected"

**Penyebab:** ZIP mengandung file berekstensi berbahaya (`php`, `exe`, `sh`, `bat`, dll).

**Solusi:** Hapus file tersebut dari ZIP sebelum upload.

### Error "Could not open ZIP file."

**Penyebab:** File tidak valid / korup, atau MIME tidak dikenali sebagai ZIP.

**Solusi:** Periksa format file; pastikan benar-benar `.zip`.

### Tema tampil blank / aset tidak muncul

**Penyebab:** Path aset tidak di-rewrite karena ditulis sebagai URL absolut atau sudah berbentuk Blade.

**Solusi:** Tulis referensi aset dengan path relatif (`css/style.css`, `js/app.js`). Setelah deploy, cek folder `public/themes/custom/<slug>/` untuk memastikan aset tersalin.

---

## Referensi

- [Laravel Filament Resources](https://filamentphp.com/docs/3.x/panels/resources)
- [Laravel Blade & asset() helper](https://laravel.com/docs/blade)
- [ZipArchive (PHP)](https://www.php.net/manual/en/class.ziparchive.php)
