# Product Requirement Document (PRD)

## MODUL: PEMBATASAN KUOTA WA BLAST (FILAMENT ADMIN)

| Atribut               | Detail                                                                                          |
| :-------------------- | :---------------------------------------------------------------------------------------------- |
| **Status**            | Approved                                                                                        |
| **Penulis**           | Mochammad Irfan Efendi                                                                          |
| **Tanggal Pembuatan** | 31 Juli 2026                                                                                    |
| **Target Komponen**   | Filament Admin Panel, Backend Service, Queue Worker, & User Dashboard                           |
| **Arsitektur**        | **Per-Invitation Quota Rate-Limiting, Admin-Driven Capacity Control, Shared-Hosting Optimized** |

---

## 1. DESKRIPSI & OBJECTIVE

Fitur ini dirancang untuk memberikan kontrol penuh kepada Administrator dalam mengelola dan membatasi jumlah pesan WhatsApp blast yang dapat dikirim oleh setiap undangan:

1. **Aturan Kuota Berbasis Undangan (_Per-Invitation Limit_):** Setiap undangan (`invitation_id`) memiliki batas maksimum pengiriman pesan (`wa_quota_limit`) yang dikendalikan dari Filament Admin.
2. **Pencegahan Penyalahgunaan & Over-sending:** Memastikan pengguna tidak dapat melakukan blast melebihi kapasitas/paket yang dibeli.
3. **Pemberitahuan Transparan:** Memberikan feedback yang jelas pada antarmuka pengguna mengenai sisa kuota yang dimiliki sebelum atau sesudah mengeksekusi blast.

---

## 2. ALUR KERJA & LOGIKA PENGGUNAAN (USER JOURNEY)

```text
[User Klik "Kirim WA Blast"]
          │
          ▼
   Cek Kuota: (wa_sent_count < wa_quota_limit) ?
          │
          ├──► (TIDAK) ──► Hentikan Proses & Tampilkan Alert: "Kuota WA Blast Habis"
          │
          └──► (YA) ─────► Hitung Sisa Kuota (Remaining = Limit - Sent)
                                 │
                                 ▼
                     Ambil Daftar Tamu s.d. Sisa Kuota
                                 │
                                 ▼
                   Dispatch Queue Job & Increment `wa_sent_count`
```
