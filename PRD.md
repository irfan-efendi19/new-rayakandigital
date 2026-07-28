prd_spotlight_md = """# Product Requirement Document (PRD)

## MODUL: INTERACTIVE SPOTLIGHT TUTORIAL (DRIVER.JS ENGINE)

| Atribut               | Detail                                                                                          |
| :-------------------- | :---------------------------------------------------------------------------------------------- |
| **Status**            | Approved                                                                                        |
| **Penulis**           | Mochammad Irfan Efendi                                                                          |
| **Tanggal Pembuatan** | 29 Juli 2026                                                                                    |
| **Target Komponent**  | Dashboard Editor Undangan & Form Input Data                                                     |
| **Library Utama**     | **Driver.js v1.3+** (Zero Dependency, Lightweight < 5KB)                                        |
| **Filosofi Utama**    | **Non-Intrusive Onboarding, Highly Scalable HTML Data-Attributes, & Seamless State Management** |

---

## 1. DESKRIPSI & OBJECTIVE

Fitur Interactive Spotlight Tutorial dirancang untuk memberikan panduan langkah demi langkah (_onboarding tour_) kepada pengguna baru saat pertama kali mengakses editor undangan digital. Menggunakan **Driver.js**, sistem akan menyorot elemen-elemen kunci dalam pembuatan undangan (seperti pemilihan tema, pengisian data mempelai, pengaturan Layar Sapa, hingga publikasi) tanpa mengganggu fungsionalitas utama aplikasi.

---

## 2. SPESIFIKASI ALUR PENGGUNA (USER JOURNEY)

1. **Auto-Trigger First Visit:** Saat pengguna baru membuka halaman editor undangan untuk pertama kalinya, overlay _spotlight_ akan otomatis aktif.
2. **Interactive Stepper:** Pengguna dipandu melalui urutan elemen visual dengan _popover card_ yang menjelaskan fungsi elemen terkait.
3. **Flexible Controls:** Pengguna dapat berpindah ke langkah selanjutnya, kembali ke langkah sebelumnya, atau menutup panduan kapan saja (`Esc` / tombol tutup).
4. **Manual Re-trigger:** Menyediakan tombol "Panduan / Bantuan" di navigasi editor untuk memicu ulang tutorial secara manual tanpa menghapus riwayat penggunaan.

---

## 3. INTEGRASI & ATRIBUT ELEMEN (`data-tour`)

Pengembang hanya perlu menambahkan atribut `data-tour="..."` pada komponen HTML/Blade target:

| Step  | Target Selector (`data-tour`)     | Title Popover                | Deskripsi Popover                                                                             |    Position    |
| :---: | :-------------------------------- | :--------------------------- | :-------------------------------------------------------------------------------------------- | :------------: |
| **1** | `[data-tour="select-theme"]`      | 🎨 Pilih Desain Undangan     | Pilih preset tema visual undangan yang sesuai dengan konsep acara Anda.                       | `bottom-start` |
| **2** | `[data-tour="mempelai-info"]`     | 💍 Isikan Informasi Pasangan | Lengkapi nama lengkap, nama panggilan, serta foto calon mempelai pria dan wanita.             |    `right`     |
| **3** | `[data-tour="event-schedule"]`    | 📅 Tanggal & Waktu Acara     | Tentukan sesi acara, waktu pelaksanaan, serta tautan Google Maps untuk navigasi tamu.         |    `bottom`    |
| **4** | `[data-tour="layar-sapa-config"]` | 📺 Konfigurasi Layar Sapa    | Atur tampilan ucapan live untuk proyektor lokasi acara dan pilih preset tema Layar Sapa Anda. |     `top`      |
| **5** | `[data-tour="guest-management"]`  | 👥 Manajemen Tamu & RSVP     | Kelola daftar tamu, buat tautan kustom per tamu, dan pantau konfirmasi kehadiran.             |    `right`     |
| **6** | `[data-tour="publish-btn"]`       | 🚀 Publikasikan Undangan     | Klik tombol ini jika semua data sudah siap untuk mengaktifkan dan membagikan tautan undangan. |     `left`     |

---

## 4. SKRIP IMPLEMENTASI ENGINE (`tutorial-spotlight.js`)

```javascript
document.addEventListener("DOMContentLoaded", () => {
    // Inisialisasi Driver.js
    const driver = window.driver.js.driver;

    const tourDriver = driver({
        showProgress: true,
        animate: true,
        allowClose: true,
        doneBtnText: "Selesai 🙌",
        nextBtnText: "Lanjut →",
        prevBtnText: "← Kembali",
        progressText: "Langkah {{current}} dari {{total}}",

        // Callback saat tour ditutup atau selesai
        onDestroyed: () => {
            // 1. Simpan di LocalStorage
            localStorage.setItem("editor_tour_completed", "true");

            // 2. Simpan State ke Server Laravel via API (Optional)
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");
            if (csrfToken) {
                fetch("/api/v1/user/complete-onboarding", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({ tour_key: "editor_tour" }),
                }).catch((err) =>
                    console.error("Failed to sync tour state:", err),
                );
            }
        },

        // Definisikan langkah-langkah spotlight
        steps: [
            {
                element: '[data-tour="select-theme"]',
                popover: {
                    title: "🎨 Pilih Desain Undangan",
                    description:
                        "Pilih preset tema visual undangan yang sesuai dengan konsep acara Anda.",
                    side: "bottom",
                    align: "start",
                },
            },
            {
                element: '[data-tour="mempelai-info"]',
                popover: {
                    title: "💍 Isikan Informasi Pasangan",
                    description:
                        "Lengkapi nama lengkap, nama panggilan, serta foto calon mempelai pria dan wanita.",
                    side: "right",
                    align: "center",
                },
            },
            {
                element: '[data-tour="event-schedule"]',
                popover: {
                    title: "📅 Tanggal & Waktu Acara",
                    description:
                        "Tentukan sesi acara, waktu pelaksanaan, serta tautan Google Maps untuk navigasi tamu.",
                    side: "bottom",
                    align: "center",
                },
            },
            {
                element: '[data-tour="layar-sapa-config"]',
                popover: {
                    title: "📺 Konfigurasi Layar Sapa",
                    description:
                        "Atur tampilan ucapan live untuk proyektor lokasi acara dan pilih preset tema Layar Sapa Anda.",
                    side: "top",
                    align: "center",
                },
            },
            {
                element: '[data-tour="guest-management"]',
                popover: {
                    title: "👥 Manajemen Tamu & RSVP",
                    description:
                        "Kelola daftar tamu, buat tautan kustom per tamu, dan pantau konfirmasi kehadiran.",
                    side: "right",
                    align: "center",
                },
            },
            {
                element: '[data-tour="publish-btn"]',
                popover: {
                    title: "🚀 Publikasikan Undangan",
                    description:
                        "Klik tombol ini jika semua data sudah siap untuk mengaktifkan dan membagikan tautan undangan.",
                    side: "left",
                    align: "center",
                },
            },
        ],
    });

    // 1. AUTO-TRIGGER: Jalankan otomatis jika pengguna belum pernah melihat tutorial
    if (!localStorage.getItem("editor_tour_completed")) {
        tourDriver.drive();
    }

    // 2. MANUAL RE-TRIGGER: Buka kembali saat pengguna mengklik tombol "Panduan / Bantuan"
    const startHelpBtn = document.getElementById("btn-start-tour");
    if (startHelpBtn) {
        startHelpBtn.addEventListener("click", (e) => {
            e.preventDefault();
            tourDriver.drive();
        });
    }
});
```
