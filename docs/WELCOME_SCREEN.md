# Layar Sapa

Layar Sapa mengikuti lima modul pada PRD.md: judul/nama pengantin, latar gambar atau video, slideshow, dinding ucapan, dan popup check-in.

## Menjalankan

- Terapkan migration baru dengan `php artisan migrate`.
- Buka **Buku tamu → Pengaturan layar sapa**. Pilih tema, isi sambutan, unggah latar dan foto, lalu simpan.
- Pilih **Buka layar sapa**, lalu **Layar penuh**. Layar dibuka oleh pemilik undangan atau administrator dengan fitur `qr_checkin`.
- Latar mendukung JPG/PNG/WebP hingga 10 MB atau MP4/WebM hingga 50 MB. Video diputar muted, autoplay, loop, dan playsinline. Unggahan latar baru mengganti latar lama. Sesuaikan `upload_max_filesize`, `post_max_size`, dan batas unggahan web server jika diperlukan.

## File standar tanpa build

`public/welcome-screen/` berisi `index.html`, `style.css`, `modules.js`, dan `app.js`. Buka `index.html` langsung di browser untuk pratinjau mandiri. Seluruh asetnya lokal; tidak membutuhkan Alpine, Vite, CDN, atau instalasi npm. Pengaturan dashboard tetap mengikuti frontend aplikasi yang sudah ada.

Ubah JSON pada elemen `#welcome-screen-data` untuk menggunakan data sendiri:

```json
{
  "title": "Selamat Datang di Pernikahan",
  "names": "Alya & Raka",
  "background": { "type": "video", "url": "assets/background.mp4" },
  "galleries": [{ "id": 1, "url": "assets/photo.jpg" }],
  "show_wishes_wall": true,
  "wishes": [{ "id": 1, "name": "Sahabat", "message": "Bahagia selalu!" }]
}
```

Untuk data live, sajikan halaman melalui HTTP(S) pada origin aplikasi dan tambahkan `data_url`, `checkins_url`, serta `checkin_since` (ISO 8601). Halaman Laravel mengisinya otomatis dengan endpoint dashboard yang terautentikasi. Endpoint publik kompatibilitas tersedia di `/api/v1/screen-data/{slug}`, `/api/v1/screen-wishes/{slug}`, `/api/v1/screen-galleries/{slug}`, dan `/api/v1/screen-checkins/{slug}`; hanya undangan aktif, belum kedaluwarsa, dan memiliki fitur QR check-in yang dilayani.

## Perilaku live

- Sambutan, latar, galeri, dan ucapan diperbarui setiap 5 detik. Ucapan tersembunyi/dihapus dan sakelar dinding ucapan diterapkan pada pembaruan berikutnya.
- Foto berganti setiap 6 detik dengan fade. Galeri kosong disembunyikan; satu foto tetap tampil tanpa rotasi. Foto gagal dimuat dilewati.
- Ucapan berganti setiap 8 detik. Isi teks dirender menggunakan `textContent`.
- Check-in diperiksa setiap 3 detik, kemudian ditampilkan satu per satu selama 7 detik. Layar mulai dari waktu dibuka agar tamu lama tidak diputar ulang.
- Feed mengembalikan maksimal 100 tamu per halaman dalam urutan waktu dan ID, dengan `has_more` dan `next_cursor`. Saat `has_more` aktif, gunakan cursor persis untuk mengambil halaman berikutnya. Setelah halaman terakhir, gunakan timestamp terakhir dengan `after_id=0` dan deduplikasi pasangan `(id, checked_in_at)` agar check-in dalam detik yang sama tetap tertangkap.
- Polling tidak tumpang tindih, memiliki timeout 10 detik, dan mencoba kembali saat koneksi pulih. Foto/sambutan terakhir tetap tampil ketika koneksi terputus.

## Preset ZIP

Placeholder lama tetap tersedia. Placeholder tambahan: `{bg_video_url}`, `{background_type}`, `{screen_data_url}`, dan `{screen_checkins_url}`. URL relatif aset diubah terhadap direktori preset; URL root, absolut, dan placeholder media tetap dipertahankan.

Untuk memakai lima modul JavaScript bersama pada preset, tambahkan `data-welcome-screen` pada body dan gunakan struktur/hook yang sama dengan `public/welcome-screen/index.html`. Controller menyisipkan JSON konfigurasi serta dua script runtime secara otomatis. CSS preset dapat mengatur tampilannya sendiri; script runtime hanya aktif jika root `data-welcome-screen` tersedia. Jangan menjalankan polling preset lama dan runtime bersama pada komponen yang sama.

Hook utama: `data-screen-title`, `data-screen-names`, `data-screen-background`, `data-screen-gallery`, `data-screen-wishes` (dengan `data-wish-message` dan `data-wish-name`), serta `data-screen-checkin` (dengan `data-guest-name`, `data-guest-order`, dan `data-checkin-progress`). Modul yang tidak mempunyai hook dilewati.

## Verifikasi

```sh
php artisan test --compact tests/Feature/WelcomeScreenPrdTest.php tests/Feature/WelcomeScreenTest.php tests/Feature/GuestbookTest.php
node --check public/welcome-screen/modules.js
node --check public/welcome-screen/app.js
node --test tests/JavaScript/welcome-screen.test.cjs
npm run build
```
