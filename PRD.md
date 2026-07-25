# Product Requirement Document (PRD)

## Standarisasi Unopinionated Standalone Template Engine (Layar Sapa)

| Atribut               | Detail                                                       |
| :-------------------- | :----------------------------------------------------------- |
| **Status**            | Approved                                                     |
| **Penulis**           | Mochammad Irfan Efendi                                       |
| **Tanggal Pembuatan** | 26 Juli 2026                                                 |
| **Target Komponen**   | Modul Layar Sapa & Filament Admin Upload Engine              |
| **Filosofi Utama**    | **Zero Design System Enforcement (100% Free UI/UX Freedom)** |

---

## 1. FILOSOFI KEBEBASAN DESAIN (UNOPINIONATED DESIGN)

Sistem **TIDAK MENENTUKAN** aturan tampilan sama sekali:

- **Bebas Kelas CSS:** Developer bebas membuat nama kelas CSS sendiri (`.kartu-ucapan`, `.box-pesan`, `.card-item`, dll) tanpa terikat aturan konvensi Laravel.
- **Bebas Pustaka Frontend:** Bebas memakai CSS murni, Tailwind via CDN, Bootstrap, GSAP Animation, Three.js, Canvas, atau pustaka JavaScript apa pun di dalam paket ZIP.
- **Bebas Layouting:** Tata letak grid, flexbox, posisi melayang (_absolute/fixed_), atau tampilan proyektor ultrawide sepenuhnya ditentukan oleh developer di komputer lokal.

---

## 2. ATURAN INTEGRASI MINIMAL (THE ONLY CONTRACT)

Agar data dari server Laravel dapat masuk ke dalam desain bebas milik developer, sistem hanya membutuhkan **2 aturan sederhana**:

### 2.1 Struktur Berkas ZIP Lokal

Developer membuat folder kerja secara bebas di VS Code, lalu membungkusnya menjadi file `.zip` dengan struktur berkas dasar berikut:

```text
nama-bebas-template.zip/
├── index.html          <-- File utama HTML (bebas desain)
├── css/                <-- Folder CSS (nama file bebas)
│   └── style.css
├── js/                 <-- Folder JS (nama file bebas)
│   └── script.js
└── assets/             <-- Folder aset media (gambar, font, video, sound)
    └── background.mp4
```
