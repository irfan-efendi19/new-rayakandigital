import { driver } from "driver.js";
import "driver.js/dist/driver.css";

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
                title: "💍 Informasi Pasangan",
                description:
                    "Perbarui nama lengkap, nama panggilan, serta foto calon mempelai pria dan wanita jika diperlukan.",
                side: "right",
                align: "center",
            },
        },
        {
            element: '[data-tour="event-schedule"]',
            popover: {
                title: "📅 Tanggal & Waktu Acara",
                description:
                    "Sesuaikan sesi acara, waktu pelaksanaan, serta tautan Google Maps untuk navigasi tamu.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="invitation-link"]',
            popover: {
                title: "🔗 Tautan Undangan",
                description:
                    "Sesuaikan tautan undangan unik yang akan dibagikan kepada tamu.",
                side: "bottom",
                align: "start",
            },
        },
        {
            element: '[data-tour="youtube-video"]',
            popover: {
                title: "▶️ Video YouTube & Live",
                description:
                    "Sematkan video YouTube atau siaran langsung ke dalam undangan.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="gallery-photos"]',
            popover: {
                title: "🖼️ Galeri Foto",
                description:
                    "Unggah koleksi foto untuk mempercantik tampilan undangan.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="music-background"]',
            popover: {
                title: "🎵 Musik Latar",
                description:
                    "Tambahkan musik latar favorit agar undangan lebih hidup.",
                side: "top",
                align: "center",
            },
        },
        {
            element: '[data-tour="select-theme"]',
            popover: {
                title: "🎨 Ganti Tema Undangan",
                description:
                    "Ganti preset tema visual undangan kapan saja sesuai konsep acara Anda.",
                side: "bottom",
                align: "start",
            },
        },
        {
            element: '[data-tour="cover-photo"]',
            popover: {
                title: "📸 Foto Sampul Undangan",
                description:
                    "Unggah foto sampul untuk mempercantik tampilan undangan Anda.",
                side: "bottom",
                align: "start",
            },
        },
        {
            element: '[data-tour="love-story"]',
            popover: {
                title: "💕 Cerita Cinta",
                description:
                    "Bagikan momen-momen spesial perjalanan cinta Anda kepada para tamu.",
                side: "bottom",
                align: "center",
            },
        },
        {
            element: '[data-tour="gift-digital"]',
            popover: {
                title: "🎁 Kado Digital",
                description:
                    "Atur rekening bank atau e-wallet untuk tamu yang ingin mengirim kado secara digital.",
                side: "bottom",
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
                title: "💾 Simpan Perubahan",
                description:
                    "Simpan semua perubahan yang telah Anda buat pada undangan.",
                side: "left",
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