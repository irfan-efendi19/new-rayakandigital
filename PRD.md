# Product Requirement Document (PRD)

## MODUL: INTEGRASI WHATSAPP GATEWAY PER-UNDANGAN (ADMIN-VERIFIED TOKEN)

| Atribut               | Detail                                                                                                    |
| :-------------------- | :-------------------------------------------------------------------------------------------------------- |
| **Status**            | Approved                                                                                                  |
| **Penulis**           | Mochammad Irfan Efendi                                                                                    |
| **Tanggal Pembuatan** | 31 Juli 2026                                                                                              |
| **Target Komponen**   | Dashboard Data Tamu (Per Undangan), Admin Panel (Filament/Laravel Admin), Backend Service, & Queue Worker |
| **Penyedia Service**  | **Fonnte API Engine (api.fonnte.com)**                                                                    |
| **Arsitektur**        | **Per-Invitation Scope, Admin Token Injection, Shared-Hosting Optimized**                                 |

---

## 1. DESKRIPSI & OBJECTIVE

Fitur WhatsApp Gateway ini ditempatkan secara terisolasi pada **Halaman Data Tamu (Scope Per-Undangan)**. Hal ini bertujuan untuk memberikan fleksibilitas tinggi bagi pengguna/mempelai yang memiliki beberapa proyek undangan, sehingga tiap undangan dapat menggunakan nomor WhatsApp pengirim yang berbeda-beda.

Untuk menjaga pengalaman pengguna tetap mudah (_zero-friction_), pengguna **hanya perlu memasukkan nomor WhatsApp pengirim** pada halaman Data Tamu dari undangan yang bersangkutan. Administrator kemudian akan memverifikasi dan memasukkan **API Token Fonnte** khusus untuk undangan tersebut melalui Admin Panel[cite: 3].

---

## 2. ALUR INTEGRASI & SPESIFIKASI PENGGUNA (USER JOURNEY)

```text
[Halaman Data Tamu Undangan]       [Admin Panel]               [Fonnte API Engine]
 Input No. HP Pengirim WA  -----> Daftar Pengajuan WA -----> Register Device / Token
       |                               |                              |
 Status: PENDING               Admin Input Token            Device Created/Paired
       |                               |                              |
 Tampil QR Code di Tamu   <----- Verifikasi Status   <----- Status: CONNECTED
  (Tinggal Scan)
```
