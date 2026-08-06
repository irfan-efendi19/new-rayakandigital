# Product Requirement Document (PRD)

## MODUL: INTEGRASI QR CODE INTERAKTIF (UCAPAN PERNIKAHAN, UNDANGAN, & KADO DIGITAL)

| Atribut               | Detail                                                                                  |
| :-------------------- | :-------------------------------------------------------------------------------------- |
| **Status**            | Approved                                                                                |
| **Penulis**           | Mochammad Irfan Efendi                                                                  |
| **Tanggal Pembuatan** | 7 Agustus 2026                                                                          |
| **Target Komponen**   | Frontend Hub Page, Dashboard User (Config Kado), Admin Panel, & Payment Handler         |
| **Arsitektur**        | **Dynamic Dashboard-Driven Gift Accounts, Dynamic QR Routing, Cashless Angpao Handler** |

---

## 1. DESKRIPSI & OBJECTIVE

Fitur **QR Code Interaktif** bertindak sebagai gerbang tunggal (_hub page_) bagi tamu undangan untuk mengakses 3 fungsi utama sekaligus, di mana seluruh data rekening/pembayaran dikelola penuh melalui Dashboard User:

1. **Konfigurasi Kado Mandiri dari Dashboard:** Penyelenggara dapat menginput daftar rekening bank, e-wallet, dan mengunggah QRIS dari Dashboard Pengguna.
2. **Akses Cepat Undangan:** Membuka landing page undangan digital secara instan saat QR di-scan.
3. **Kado Digital & Angpao (Dynamic Display):** Menampilkan opsi pembayaran sesuai data aktif yang telah diatur oleh penyelenggara di dashboard.
4. **Buku Tamu & Ucapan Digital:** Memfasilitasi tamu untuk mengirimkan ucapan, doa, serta upload media secara _real-time_.

---

## 2. USER JOURNEY & ALUR SISTEM

```text
[User Input Data Kado di Dashboard]
                 │
                 ▼
      [Simpan ke `gift_settings`]
                 │
                 ▼
        [Tamu Scan QR Code] ──► [Akses QR Action Hub]
                                       │
                                       ▼
                             [Klik "Kirim Kado"]
                                       │
                                       ▼
                     [Fetch Data Kado Aktif dari DB]
                                       │
                                       ▼
                       Tampilkan Rekening/E-Wallet/QRIS
```
