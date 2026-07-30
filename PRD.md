# Product Requirement Document (PRD)

## MODUL: PENGATURAN MUSIK BACKGROUND UNDANGAN (DEFAULT TEMA VS UPLOAD MP3 LOKAL)

| Atribut               | Detail                                                                                     |
| :-------------------- | :----------------------------------------------------------------------------------------- |
| **Status**            | Approved                                                                                   |
| **Penulis**           | Mochammad Irfan Efendi                                                                     |
| **Tanggal Pembuatan** | 31 Juli 2026                                                                               |
| **Target Komponen**   | Dashboard Pengaturan Undangan (User), Backend Service, & Frontend Player Undangan          |
| **Arsitektur**        | **Per-Invitation Music Management, Dynamic Audio Source Selection, Local Storage Handler** |

---

## 1. DESKRIPSI & OBJECTIVE

Fitur ini bertujuan untuk memberikan fleksibilitas penuh kepada pengguna dalam menentukan musik latar (_background music_) pada undangan digital mereka:

1. **Default State (_Zero Setup_):** Secara otomatis, undangan baru akan memutar file musik bawaan dari **Tema** yang dipilih.
2. **Custom Audio Upload:** Jika pengguna ingin memakai lagu kenangan sendiri, pengguna **cukup mengunggah (_upload_) file MP3/audio dari perangkat lokal mereka** tanpa perlu memilih dari daftar dropdown.
3. **Switch Back Option:** Pengguna dapat kembali menggunakan lagu bawaan tema kapan saja hanya dengan memilih tombol pilihan (radio button).

---

## 2. ALUR KERJA & LOGIKA PENGGUNAAN (USER JOURNEY)

```text
[Undangan Baru Dibuat]
       │
       ├──► (Default) use_custom_music = false ──► Player memutar lagu bawaan TEMA
       │
       └──► User memilih "Gunakan Lagu Sendiri" & Upload MP3
                  │
                  ▼
            Simpan File ke Storage (`/storage/invitation-musics/`)
            Update `custom_music` & Set `use_custom_music = true`
                  │
                  ▼
            Player memutar lagu CUSTOM LOKAL milik user
```
