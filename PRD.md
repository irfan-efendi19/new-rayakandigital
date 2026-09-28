## 1. Ringkasan & Tujuan Produk

Sistem Layar Sapa (*Welcome Screen Display*) adalah aplikasi berbasis *web display* interaktif yang ditampilkan pada layar besar/TV/Projector di lokasi acara pernikahan. Aplikasi ini dibuat menggunakan teknologi murni **HTML, CSS, dan JavaScript saja** tanpa membutuhkan *framework* berat atau proses *compile*.

Sistem ini bersifat dinamis dengan memanggil variabel data/fitur secara *client-side* untuk menampilkan informasi sambutan, galeri foto, serta ucapan *real-time* dan notifikasi selamat datang saat tamu melakukan *check-in*.

---

## 2. Fitur Utama (Core Features Breakdown)

Aplikasi dipisah menjadi 5 modul modul panggilan data utama:

| No | Nama Fitur / Komponen | Deskripsi & Spesifikasi Tampilan |
| :--- | :--- | :--- |
| **1** | **Judul Sambutan & Nama Pengantin** | Menampilkan teks sambutan kustom (misal: *"Selamat Datang di Pernikahan"*) serta Nama Pasangan Pengantin dengan tipografi elegan/estetis. |
| **2** | **Kustomisasi Background Latar** | Dukungan latar belakang visual berupa **Gambar Statis** atau **Video Loops** (animasi halus/estetik) yang memenuhi layar (*fullscreen cover*). |
| **3** | **Galeri Layar (Photo Slideshow)** | *Slider/Carousel* foto galeri pernikahan yang berganti secara otomatis dengan efek transisi *fade-in/fade-out* atau *smooth slide*. |
| **4** | **Dinding Ucapan (Wish Wall / Guestbook Board)** | Menampilkan daftar ucapan, doa, dan nama tamu yang mengalir (*scrolling animation*) atau tampil secara bergantian di bagian layar. |
| **5** | **Popup Selamat Datang Check-in** | Notifikasi *overlay/popup* dinamis yang muncul otomatis saat ada tamu yang berhasil *check-in* di penerima tamu (menampilkan Nama Tamu & Ucapan Selamat Datang). |

---

## 3. Arsitektur Teknis & Struktur File

Sistem dibangun secara modular menggunakan file web standar agar mudah diakses langsung lewat browser: