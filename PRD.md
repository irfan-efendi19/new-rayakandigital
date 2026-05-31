# PRODUCT REQUIREMENT DOCUMENT (PRD) - HOTFIX RESIZE FOTO
## Modul: Perbaikan Aspek Rasio Image Cropper (Foto Pasangan)
**Versi:** 1.0 (Spesifikasi Khusus Hotfix - Frontend & File Upload Layer)  
**Tanggal:** 1 Juni 2026  
**Status:** Approved  
**Target Komponen:** Canvas Cropper/Croppie Initialization, Form Upload Pengantin, & Image Processing Backend  

---

## 1. DESKRIPSI MASALAH & TARGET PERBAIKAN

### 1.1 Kendala Aktual (Bug Description)
Saat pengguna mengunggah foto pasangan (Foto Pengantin Pria/Wanita) yang memiliki rasio asal bukan persegi (misalnya foto potret `3:4` atau lanskap `16:9`), pustaka *cropper* secara paksa mendistorsi/menarik (*stretch/squeeze*) gambar mentah menjadi rasio `1:1` sejak awal pemuatan. Hal ini mengakibatkan wajah pasangan terlihat lonjong, gepeng, dan tidak natural sebelum sempat dipotong.

### 1.2 Perilaku yang Diharapkan (Expected Behavior)
1. **Pertahankan Rasio Asli:** Saat gambar dipilih dari perangkat, pustaka pemotong wajib merender gambar dengan mempertahankan aspek rasio aslinya (*original aspect ratio*) tanpa distorsi visual.
2. **Fleksibilitas Bingkai Potong:** Pustaka menyediakan bingkai pemotong berbentuk lingkaran/persegi (sesuai kebutuhan desain tema). Pengguna dapat menggeser, memperbesar (*zoom*), atau memposisikan area gambar asli mana yang ingin diambil untuk dijadikan hasil akhir.

---

## 2. SPESIFIKASI KEBUTUHAN FUNGSIONAL (FUNCTIONAL REQUIREMENTS)

* **FR-CROP-01 (Aspect Ratio Preservation):** Sistem wajib membaca metadata dimensi gambar asli dan memuatnya ke dalam viewport *Croppie* dengan opsi `enforceBoundary` tetap aktif, namun tanpa memodifikasi properti skala dasar gambar mentah.
* **FR-CROP-02 (Dynamic Viewport Bounding):** Menentukan ukuran batas bingkai potret hasil akhir (misal: lingkaran diameter 300px) sementara gambar latar belakang bebas bergerak sesuai rasio aslinya.

---

## 3. IMPLEMENTASI PERBAIKAN FRONTEND (JAVASCRIPT / CROPPIE.JS)

Berikut adalah perbaikan konfigurasi inisialisasi *Croppie* pada halaman Edit Undangan untuk memastikan gambar tidak dipaksa ringsek/distorsi saat dimuat:

### Kode Perbaikan Inisialisasi JavaScript

```javascript
// Memastikan element penampung cropper tersedia
const el = document.getElementById('cropper-pasangan-pria');

// HOTFIX: Inisialisasi Croppie dengan mempertahankan rasio asli gambar
const uploadCropper = new Croppie(el, {
    viewport: {
        width: 250,
        height: 250,
        type: 'square' // atau 'circle' tergantung kebutuhan UI tema pernikahan
    },
    boundary: {
        width: 350,
        height: 350
    },
    showZoomer: true,
    enableOrientation: true,
    enforceBoundary: true // Mengunci agar hasil crop tidak keluar dari batas gambar asli
});

// Handler saat file input berubah (User memilih foto baru)
document.getElementById('input-foto-pria').addEventListener('change', function () {
    const reader = new FileReader();
    
    reader.onload = function (e) {
        // Memuat gambar ke dalam objek Croppie
        uploadCropper.bind({
            url: e.target.result
        }).then(() => {
            console.log('Gambar berhasil dimuat dengan mempertahankan aspek rasio asli.');
        });
    };
    
    if (this.files && this.files[0]) {
        reader.readAsDataURL(this.files[0]);
    }
});

// Handler saat form disubmit (Mengambil hasil potongan gambar)
document.getElementById('btn-simpan-foto').addEventListener('click', function() {
    uploadCropper.result({
        type: 'blob',       // Menggunakan blob untuk performa upload aman via FormData
        size: 'viewport',   // Output disesuaikan dengan ukuran viewport pemotong
        format: 'jpeg',     // Standardisasi format output gambar
        quality: 0.9        // Menjaga kualitas kompresi foto tetap tajam
    }).then(function (blob) {
        // Kirim blob gambar ini ke backend Laravel menggunakan FormData/Axios/Inertia
        let formData = new FormData();
        formData.append('foto_pasangan', blob, 'foto-pengantin-pria.jpg');
        
        // Contoh eksekusi upload via fetch/axios
        // axios.post('/invitations/upload-foto', formData)...
    });
});