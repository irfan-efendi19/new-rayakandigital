# PRODUCT REQUIREMENT DOCUMENT (PRD) ADDENDUM

## MODUL: LAYAR SAPA - DYNAMIC ZIP TEMPLATE UPLOADER ENGINE

**Versi:** 6.0 (Sistem Unggah Berkas ZIP dari Admin Filament & Rendering Dinamis)  
**Tanggal:** 19 Juli 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi

---

## 1. STRATEGIC OVERVIEW

### 1.1 Perubahan Mekanisme Distribusi Tema

- **Lama (Fase 5.0):** Admin harus menyalin dan menempelkan ribuan baris kode HTML murni ke dalam kotak teks Filament. Rentan terjadi kesalahan format tanda kutip atau karakter rusak (_code escape error_).
- **Baru (Fase 6.0):** Developer/Desainer menyusun struktur tema di komputer lokal mereka (`index.html`, `style.css`, `app.js`, dan folder gambar pendukung). Struktur ini dibungkus menjadi file **`.zip`** dan diunggah langsung melalui komponen File Upload di Filament. Sistem backend Laravel akan mengekstrak berkas tersebut secara otomatis ke dalam ruang penyimpanan publik (_Storage Disk_).

### 1.2 Manfaat Utama

- **Kerapian Struktur Kode:** Proses _coding_ tetap dilakukan di kode editor lokal (VS Code, dll) dengan fitur _auto-complete_ dan struktur direktori yang rapi.
- **Dukungan Aset Lokal:** Tema dapat membawa aset bawaan mereka sendiri (seperti font khusus, gambar dekorasi floral, atau ikon svg) di dalam satu paket zip tanpa bergantung pada tautan luar (_external CDN dependency_).

---

## 2. STRUKTUR BERKAS TEMPLATE LOKAL (STANDARISASI)

Setiap paket template `.zip` yang dibuat oleh pengembang wajib mematuhi arsitektur folder berikut sebelum diunggah ke admin Filament:

```text
nama-tema.zip/
├── index.html          <-- File utama (wajib menggunakan placeholder tags)
├── css/
│   └── style.css       <-- File styling khusus tema
├── js/
│   └── main.js         <-- Script animasi/interaksi live-refresh
└── assets/
    └── bg-pattern.png  <-- Ornamen grafis / background pendukung
```
