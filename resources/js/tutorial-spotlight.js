import { driver } from "driver.js";
import "driver.js/dist/driver.css";

/**
 * Helper: switch the Alpine multi-step form to a specific section ID.
 * We dispatch a custom window event that the root x-data listens to.
 * Returns a Promise that resolves after the section has been rendered
 * (we wait one animation frame so Alpine/x-show has time to show the element).
 */
function switchToSection(sectionId) {
    return new Promise((resolve) => {
        window.dispatchEvent(
            new CustomEvent("set-active-section", { detail: sectionId })
        );
        // Wait for the next frame so Alpine finishes showing the section
        requestAnimationFrame(() => requestAnimationFrame(resolve));
    });
}

/**
 * Map each data-tour attribute to the section it lives in.
 * Used by the tour driver to auto-switch before highlighting.
 */
const tourSectionMap = {
    "mempelai-info":    "sec-1",
    "invitation-link": "sec-1",
    "event-schedule":  "sec-2",
    "layar-sapa-config": "sec-3",
    "cover-photo":     "sec-3",
    "youtube-video":   "sec-3",
    "gallery-photos":  "sec-3",
    "music-background":"sec-3",
    "select-theme":    "sec-3",
    "love-story":      "sec-4",
    "gift-digital":    "sec-5",
    "guest-management":"sec-7",
    "publish-btn":     null, // always visible (fixed bottom bar)
};

document.addEventListener("DOMContentLoaded", () => {
    const isEditMode = document.querySelector('#slug-input[data-original]');

    const createSteps = [
        {
            element: '[data-tour="invitation-link"]',
            popover: {
                title: "🔗 Tautan Undangan",
                description:
                    "Buat alamat web unik agar tamu dapat membuka undangan Anda secara online.",
                side: "bottom",
                align: "start",
            },
        },
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
            element: '[data-tour="publish-btn"]',
            popover: {
                title: "🚀 Publikasikan Undangan",
                description:
                    "Klik tombol ini jika semua data sudah siap untuk mengaktifkan dan membagikan tautan undangan.",
                side: "left",
                align: "center",
            },
        },
    ];

    const editSteps = [
        {
            element: '[data-tour="mempelai-info"]',
            popover: {
                title: "💍 Langkah 1 — Informasi Pasangan",
                description:
                    "Perbarui nama lengkap, nama panggilan, urutan pasangan, serta foto mempelai pria dan wanita.",
                side: "bottom",
                align: "start",
            },
        },
        {
            element: '[data-tour="invitation-link"]',
            popover: {
                title: "🔗 Langkah 2 — Tautan Undangan Kustom",
                description:
                    "Sesuaikan tautan undangan unik yang akan dibagikan kepada tamu. Pastikan belum digunakan orang lain.",
                side: "bottom",
                align: "start",
            },
        },
        {
            element: '[data-tour="event-schedule"]',
            popover: {
                title: "📅 Langkah 3 — Jadwal & Lokasi Acara",
                description:
                    "Sesuaikan sesi acara, waktu, lokasi, dan tautan Google Maps agar tamu bisa navigasi dengan mudah.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="cover-photo"]',
            popover: {
                title: "📸 Langkah 4 — Foto Sampul",
                description:
                    "Unggah foto sampul yang akan menjadi kesan pertama tamu saat membuka undangan.",
                side: "bottom",
                align: "start",
            },
        },
        {
            element: '[data-tour="youtube-video"]',
            popover: {
                title: "▶️ Langkah 5 — Video YouTube",
                description:
                    "Sematkan video YouTube atau siaran langsung ke dalam undangan untuk pengalaman lebih berkesan.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="gallery-photos"]',
            popover: {
                title: "🖼️ Langkah 6 — Galeri Foto",
                description:
                    "Unggah koleksi foto kenangan untuk mempercantik tampilan undangan Anda.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="music-background"]',
            popover: {
                title: "🎵 Langkah 7 — Musik Latar",
                description:
                    "Tambahkan musik latar favorit agar undangan terasa lebih hidup saat dibuka.",
                side: "top",
                align: "center",
            },
        },
        {
            element: '[data-tour="select-theme"]',
            popover: {
                title: "🎨 Langkah 8 — Ganti Tema Undangan",
                description:
                    "Ganti preset tema visual undangan kapan saja sesuai konsep acara Anda.",
                side: "bottom",
                align: "start",
            },
        },
        {
            element: '[data-tour="love-story"]',
            popover: {
                title: "💕 Langkah 9 — Cerita Cinta & Kutipan",
                description:
                    "Bagikan perjalanan cinta Anda dan tambahkan kutipan inspiratif sebagai pembuka undangan.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="gift-digital"]',
            popover: {
                title: "🎁 Langkah 10 — Kado Digital",
                description:
                    "Atur rekening bank, e-wallet, atau QRIS agar tamu dapat mengirim kado secara digital.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="guest-management"]',
            popover: {
                title: "👥 Langkah 11 — Kategori Tamu",
                description:
                    "Buat kategori tamu (VIP, Keluarga, Rekan Kerja, dll.) untuk mengatur undangan dengan lebih rapi.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="publish-btn"]',
            popover: {
                title: "💾 Simpan Semua Perubahan",
                description:
                    "Klik tombol ini kapan saja untuk menyimpan semua perubahan yang telah Anda buat. Tombol ini selalu tersedia di setiap langkah.",
                side: "top",
                align: "center",
            },
        },
    ];

    const tourDriver = driver({
        showProgress: true,
        animate: true,
        allowClose: true,
        doneBtnText: "Selesai 🙌",
        nextBtnText: "Lanjut →",
        prevBtnText: "← Kembali",
        progressText: "Langkah {{current}} dari {{total}}",
        popoverClass: "rayakan-spotlight-popover",

        /**
         * Before each step is highlighted, switch to the section that
         * contains the target element so it is visible (not hidden by x-show).
         */
        onHighlightStarted: async (element, step) => {
            const tourAttr = step?.element?.replace('[data-tour="', '').replace('"]', '');
            const sectionId = tourAttr ? tourSectionMap[tourAttr] : null;
            if (sectionId) {
                await switchToSection(sectionId);
            }
        },

        onDestroyed: () => {
            localStorage.setItem("editor_tour_completed", "true");

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

        steps: isEditMode ? editSteps : createSteps,
    });

    if (!localStorage.getItem("editor_tour_completed")) {
        if (document.querySelector('[data-tour="select-theme"]') || document.querySelector('[data-tour="mempelai-info"]')) {
            tourDriver.drive();
        }
    }

    const startHelpBtn = document.getElementById("btn-start-tour");
    if (startHelpBtn) {
        startHelpBtn.addEventListener("click", (e) => {
            e.preventDefault();
            tourDriver.drive();
        });
    }
});