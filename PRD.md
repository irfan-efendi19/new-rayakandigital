# Product Requirement Document (PRD)

## FEATURE SPECIFICATION: INTERACTIVE WEDDING CHECKLIST PLANNER

| Atribut               | Detail                                                                                            |
| :-------------------- | :------------------------------------------------------------------------------------------------ |
| **Status**            | Approved / Living Document                                                                        |
| **Penulis**           | Mochammad Irfan Efendi                                                                            |
| **Tanggal Pembuatan** | 10 Agustus 2026                                                                                   |
| **Target Komponen**   | Checklist Dashboard, Dynamic Progress Engine, Category Grouping UI, Checklist Management          |
| **Fokus Utama**       | **40 Preset Checklist Items, 9 Categories, Live Progress Tracking, Dynamic Checklist Management** |
| **Parent System**     | Wedding Planner & Organizer                                                                       |
| **Ownership Policy**  | **1 User = 1 Invitation**                                                                         |

---

# 1. DESKRIPSI & OBJECTIVE FITUR

**Interactive Wedding Checklist Planner** merupakan fitur yang digunakan untuk membantu pengguna mengelola dan memantau seluruh tugas persiapan pernikahan melalui checklist yang terstruktur berdasarkan kategori.

Fitur dirancang agar pengguna dapat:

- Melihat seluruh checklist persiapan pernikahan.
- Mengelola checklist berdasarkan kategori.
- Menandai tugas sebagai selesai atau belum selesai.
- Melihat progress persiapan secara langsung.
- Menambahkan checklist custom.
- Menghapus atau mengubah checklist custom.
- Memantau jumlah tugas selesai dan total tugas.
- Mengakses checklist hanya dari invitation miliknya.

Fitur ini menggunakan konsep:

```text
1 User
   ↓
1 Invitation
   ↓
40 Preset Checklist Items
   ↓
9 Categories
   ↓
Dynamic Checklist Management
   ↓
Live Progress Tracking
```

---

# 2. OBJECTIVE

## 2.1 Primary Objective

Menyediakan sistem checklist persiapan pernikahan yang sederhana, interaktif, dan mudah dipantau oleh calon pengantin.

## 2.2 Secondary Objectives

1. Mengurangi kebutuhan pengguna untuk membuat checklist dari nol.
2. Memberikan struktur persiapan berdasarkan kategori.
3. Memberikan gambaran kesiapan pernikahan melalui persentase progress.
4. Memungkinkan pengguna menyesuaikan checklist dengan kebutuhan pribadi.
5. Memastikan seluruh data checklist terisolasi berdasarkan invitation.

---

# 3. CORE FEATURES

| No  | Fitur                    | Deskripsi                                                   |
| :-: | :----------------------- | :---------------------------------------------------------- |
|  1  | **Preset Checklist**     | Sistem menyediakan 40 item checklist bawaan.                |
|  2  | **9 Categories**         | Checklist dikelompokkan ke dalam 9 kategori.                |
|  3  | **Checkbox Toggle**      | User dapat menandai item sebagai selesai/belum selesai.     |
|  4  | **Live Progress**        | Persentase progress dihitung berdasarkan item yang selesai. |
|  5  | **Category Grouping**    | Item ditampilkan berdasarkan kategori.                      |
|  6  | **Custom Item**          | User dapat menambahkan item sendiri.                        |
|  7  | **Edit Item**            | User dapat mengubah checklist custom.                       |
|  8  | **Delete Item**          | User dapat menghapus checklist custom.                      |
|  9  | **Ownership Validation** | User hanya dapat mengakses checklist invitation miliknya.   |
| 10  | **Responsive UI**        | Checklist dapat digunakan pada desktop maupun mobile.       |

---

# 4. PRESET CHECKLIST

Sistem menyediakan **40 preset checklist items** yang terbagi ke dalam **9 kategori**.

## 4.1 Administrasi & Legal

**Total: 2 item**

1. Daftar pernikahan ke KUA
2. Izin cuti menikah

---

## 4.2 Attire & Rias Pengantin

**Total: 8 item**

1. Rias pengantin
2. Nail art
3. Henna wedding
4. Rias orang tua dan besan
5. Baju pengantin akad
6. Baju pengantin resepsi
7. Baju orang tua dan besan
8. Baju pendamping (pagar ayu)

---

## 4.3 Mahar & Seserahan

**Total: 5 item**

1. Mahar
2. Cincin nikah
3. Kotak cincin
4. Seserahan
5. Kotak seserahan

---

## 4.4 Venue & Dekorasi

**Total: 2 item**

1. Dekorasi
2. Tenda

---

## 4.5 Dokumentasi & Media

**Total: 5 item**

1. Prewedding
2. Fotografer
3. Videografer
4. Wedding Content Creator
5. Photobooth

---

## 4.6 Pengisi Acara & Entertainment

**Total: 4 item**

1. MC
2. Tilawah
3. Sambutan
4. Hiburan

---

## 4.7 Konsumsi & Catering

**Total: 2 item**

1. Catering
2. Snack

---

## 4.8 Undangan & Logistik Tamu

**Total: 5 item**

1. Daftar tamu undangan
2. Undangan digital
3. Undangan cetak
4. Buku tamu
5. Souvenir

---

## 4.9 Koordinasi Tim & Operasional

**Total: 7 item**

1. WO
2. Rundown acara
3. Susunan panitia
4. Briefing vendor
5. Briefing keluarga
6. Bridesmaid
7. Transport

---

# 5. VALIDASI TOTAL PRESET ITEM

```text
Administrasi & Legal                  2
Attire & Rias Pengantin               8
Mahar & Seserahan                     5
Venue & Dekorasi                      2
Dokumentasi & Media                   5
Pengisi Acara & Entertainment         4
Konsumsi & Catering                   2
Undangan & Logistik Tamu              5
Koordinasi Tim & Operasional          7
                                      ──
TOTAL                                 40
```

Requirement:

> Sistem **WAJIB** menghasilkan tepat **40 preset checklist items** ketika invitation baru dibuat.

---

# 6. CHECKLIST STATUS

Setiap checklist menggunakan status berikut:

| Status      | Label         | Deskripsi                |
| :---------- | :------------ | :----------------------- |
| `PENDING`   | Belum Selesai | Item belum dikerjakan.   |
| `COMPLETED` | Selesai       | Item telah diselesaikan. |

Untuk fitur checklist sederhana, sistem cukup menggunakan dua status utama.

```text
PENDING
   ↕
COMPLETED
```

Ketika user melakukan toggle:

```text
☐ PENDING
     ↓
☑ COMPLETED
```

dan sebaliknya:

```text
☑ COMPLETED
     ↓
☐ PENDING
```

---

# 7. LIVE PROGRESS TRACKING

## 7.1 Formula

Progress dihitung berdasarkan:

```text
Progress Percentage =
(COMPLETED ITEMS / TOTAL ACTIVE ITEMS) × 100
```

Contoh awal:

```text
Completed : 0
Total     : 40
Progress  : 0%
```

Setelah 10 item selesai:

```text
Completed : 10
Total     : 40
Progress  : 25%
```

Setelah seluruh item selesai:

```text
Completed : 40
Total     : 40
Progress  : 100%
```

---

# 8. PROGRESS UI

Dashboard menampilkan informasi:

```text
┌──────────────────────────────────────────┐
│ CHECKLIST WEDDING PLAN                   │
│                                          │
│ Yuk mulai ceklis!                       │
│ 20/40 selesai · 9 kategori               │
│                                          │
│ ███████████████░░░░░░░░░░░  50%         │
└──────────────────────────────────────────┘
```

Jika seluruh checklist selesai:

```text
┌──────────────────────────────────────────┐
│ 🎉 Semua Ceklis Selesai!                │
│                                          │
│ 40/40 selesai · 9 kategori               │
│                                          │
│ ███████████████████████████  100%        │
└──────────────────────────────────────────┘
```

---

# 9. CATEGORY GROUPING

Checklist harus dikelompokkan berdasarkan kategori.

Contoh:

```text
ATTIRE & RIAS PENGANTIN

6 / 8 selesai

☑ Rias pengantin
☑ Nail art
☑ Henna wedding
☑ Rias orang tua dan besan
☑ Baju pengantin akad
☑ Baju pengantin resepsi
☐ Baju orang tua dan besan
☐ Baju pendamping (pagar ayu)
```

Setiap kategori minimal menampilkan:

- Nama kategori.
- Jumlah item.
- Jumlah item selesai.
- Daftar checklist.
- Status checklist.
- Action untuk item custom.

---

# 10. DYNAMIC CHECKLIST MANAGEMENT

User dapat menambahkan checklist tambahan selain 40 preset item.

Contoh:

```text
Preset:
- Catering
- Dekorasi
- Fotografer

Custom:
- Sewa mobil pengantin
- Pesan kamar hotel keluarga
- Cetak label souvenir
```

## 10.1 Custom Item

Custom item memiliki:

```text
is_preset = false
```

Sedangkan item bawaan sistem:

```text
is_preset = true
```

---

# 11. CUSTOM ITEM REQUIREMENTS

Ketika user menambahkan checklist custom, form minimal harus memiliki:

| Field         | Required | Keterangan          |
| :------------ | :------: | :------------------ |
| `category`    |   Yes    | Kategori checklist. |
| `title`       |   Yes    | Nama tugas.         |
| `description` |    No    | Detail tambahan.    |
| `status`      |    No    | Default `PENDING`.  |

Contoh:

```text
Kategori:
Koordinasi Tim & Operasional

Nama:
Sewa mobil pengantin

Status:
PENDING
```

---

# 12. DATABASE SCHEMA

Karena sistem menggunakan kebijakan:

> **1 User = 1 Invitation**

Checklist sebaiknya **tidak langsung menggunakan `user_id`**.

Ownership chain:

```text
users
  ↓
invitations
  ↓
wedding_checklists
```

## 12.1 Invitations

```sql
CREATE TABLE invitations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT UNSIGNED NOT NULL UNIQUE,

    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    wedding_date DATE NOT NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_invitations_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
```

Constraint:

```sql
UNIQUE (user_id)
```

memastikan:

```text
1 User = maksimal 1 Invitation
```

---

# 13. WEDDING CHECKLIST TABLE

```sql
CREATE TABLE wedding_checklists (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    invitation_id BIGINT UNSIGNED NOT NULL,

    category_code VARCHAR(50) NOT NULL,
    category_name VARCHAR(100) NOT NULL,

    title VARCHAR(255) NOT NULL,
    description TEXT NULL,

    is_completed BOOLEAN NOT NULL DEFAULT FALSE,
    is_preset BOOLEAN NOT NULL DEFAULT TRUE,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_wedding_checklists_invitation
        FOREIGN KEY (invitation_id)
        REFERENCES invitations(id)
        ON DELETE CASCADE,

    INDEX idx_checklists_invitation (
        invitation_id
    ),

    INDEX idx_checklists_category (
        invitation_id,
        category_code
    )
);
```

---

# 14. CATEGORY CODE

Untuk menjaga konsistensi data, sistem menggunakan `category_code`.

| Code              | Category                      |
| :---------------- | :---------------------------- |
| `ADMINISTRATION`  | Administrasi & Legal          |
| `ATTIRE_BEAUTY`   | Attire & Rias Pengantin       |
| `MAHAR_SESERAHAN` | Mahar & Seserahan             |
| `VENUE_DECOR`     | Venue & Dekorasi              |
| `DOCUMENTATION`   | Dokumentasi & Media           |
| `ENTERTAINMENT`   | Pengisi Acara & Entertainment |
| `CATERING`        | Konsumsi & Catering           |
| `GUEST_LOGISTICS` | Undangan & Logistik Tamu      |
| `OPERATIONS`      | Koordinasi Tim & Operasional  |

`category_name` digunakan sebagai label yang ditampilkan kepada user.

`category_code` digunakan sebagai identifier internal.

---

# 15. INITIALIZATION FLOW

Ketika user berhasil membuat invitation:

```text
CREATE INVITATION
       │
       ▼
VALIDATE USER OWNERSHIP
       │
       ▼
CREATE 40 PRESET ITEMS
       │
       ▼
SET is_preset = TRUE
       │
       ▼
SET is_completed = FALSE
       │
       ▼
CHECKLIST READY
```

Semua proses harus menggunakan database transaction.

---

# 16. BACKEND CONTROLLER

## 16.1 Checklist Index

**`app/Http/Controllers/ChecklistController.php`**

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $invitation = $user->invitation;

        if (!$invitation) {
            return redirect()
                ->route('invitation.create');
        }

        $checklists = $invitation
            ->checklists()
            ->orderBy('category_code')
            ->orderBy('id')
            ->get();

        $totalItems = $checklists->count();

        $completedItems = $checklists
            ->where('is_completed', true)
            ->count();

        $progressPercent = $totalItems > 0
            ? round(
                ($completedItems / $totalItems) * 100
            )
            : 0;

        $groupedChecklists = $checklists
            ->groupBy('category_code');

        return view(
            'dashboard.checklist.index',
            compact(
                'invitation',
                'groupedChecklists',
                'totalItems',
                'completedItems',
                'progressPercent'
            )
        );
    }
}
```

---

# 17. TOGGLE CHECKLIST

Toggle harus memvalidasi bahwa item memang milik invitation user yang sedang login.

```php
public function toggle($id)
{
    $invitation = Auth::user()->invitation;

    if (!$invitation) {
        abort(403);
    }

    $item = $invitation
        ->checklists()
        ->findOrFail($id);

    $item->is_completed = !$item->is_completed;

    $item->save();

    $totalItems = $invitation
        ->checklists()
        ->count();

    $completedItems = $invitation
        ->checklists()
        ->where('is_completed', true)
        ->count();

    $progressPercent = $totalItems > 0
        ? round(
            ($completedItems / $totalItems) * 100
        )
        : 0;

    return response()->json([
        'success' => true,
        'is_completed' => $item->is_completed,
        'total_items' => $totalItems,
        'completed_items' => $completedItems,
        'progress_percent' => $progressPercent,
    ]);
}
```

---

# 18. LIVE UPDATE REQUIREMENT

Toggle checklist harus menggunakan AJAX/fetch sehingga:

> **Tidak diperlukan full page reload.**

Flow:

```text
USER CLICK CHECKBOX
        │
        ▼
JAVASCRIPT FETCH
        │
        ▼
PATCH / TOGGLE
        │
        ▼
SERVER VALIDATION
        │
        ▼
UPDATE DATABASE
        │
        ▼
RETURN JSON
        │
        ▼
UPDATE UI
        │
        ├── Checkbox
        ├── Text Style
        ├── Completed Count
        └── Progress Bar
```

Response minimal:

```json
{
    "success": true,
    "is_completed": true,
    "total_items": 40,
    "completed_items": 15,
    "progress_percent": 38
}
```

---

# 19. FRONTEND REQUIREMENTS

## 19.1 Header

```text
Checklist Wedding Plan
Item persiapan per kategori.

[ + Tambah Data ]
```

## 19.2 Progress Card

Menampilkan:

- Headline status.
- Completed item.
- Total item.
- Total kategori.
- Progress percentage.
- Progress indicator.

Contoh:

```text
Yuk mulai ceklis!

15/40 selesai · 9 kategori

██████████░░░░░░░░░░░░░░░░░░ 38%
```

---

# 20. CHECKLIST ITEM UI

Setiap item minimal terdiri dari:

```text
☐ Nama Checklist
```

Ketika selesai:

```text
☑ Nama Checklist
```

Text berubah menjadi:

```css
text-decoration: line-through;
```

dan menggunakan visual state yang membedakan item selesai dari item aktif.

---

# 21. CATEGORY PROGRESS

Selain progress global, setiap kategori sebaiknya memiliki progress sendiri.

Contoh:

```text
Administrasi & Legal

1 / 2 selesai

██████████████░░░░░░ 50%
```

Formula:

```text
Category Progress =
(Category Completed / Category Total) × 100
```

---

# 22. EMPTY STATE

Apabila checklist belum tersedia:

```text
Belum ada checklist.

Checklist persiapan pernikahan akan tersedia
setelah invitation dibuat.
```

Apabila seluruh item selesai:

```text
🎉 Semua checklist selesai!

Persiapan checklist pernikahanmu sudah mencapai 100%.
```

---

# 23. DELETE & EDIT REQUIREMENT

## 23.1 Preset Item

Preset item:

- Dapat diubah statusnya.
- Dapat memiliki perubahan data jika sistem mengizinkan.
- Tidak boleh dihapus secara permanen dari template global.

## 23.2 Custom Item

Custom item:

- Dapat diedit.
- Dapat dihapus.
- Memiliki `is_preset = false`.

---

# 24. SECURITY REQUIREMENTS

### SEC-01 — Authentication

Checklist hanya dapat diakses oleh authenticated user.

### SEC-02 — Invitation Ownership

Checklist harus diakses melalui invitation milik user.

### SEC-03 — IDOR Protection

User tidak boleh mengakses checklist user lain hanya dengan mengganti ID.

Tidak diperbolehkan:

```php
WeddingChecklist::findOrFail($id);
```

tanpa ownership validation.

Gunakan:

```php
$invitation
    ->checklists()
    ->findOrFail($id);
```

### SEC-04 — User ID Protection

`user_id` tidak boleh dikirim dari form.

User ID harus berasal dari authenticated session.

### SEC-05 — Database Constraint

`invitations.user_id` harus memiliki `UNIQUE`.

### SEC-06 — CSRF

Semua mutation request harus menggunakan CSRF protection.

---

# 25. PERFORMANCE REQUIREMENTS

Untuk checklist normal:

- Query checklist maksimal berdasarkan satu invitation.
- Gunakan eager loading jika relasi tambahan diperlukan.
- Progress dapat dihitung menggunakan database aggregate untuk dataset besar.
- Toggle hanya melakukan update terhadap satu item.
- Response AJAX harus mengembalikan data progress terbaru.

Untuk 40 item, query sederhana menggunakan Eloquent Collection masih diperbolehkan.

---

# 26. QA & TESTING MATRIX

| Test ID       | Skenario Testing              | Expected Result                                        | Status |
| :------------ | :---------------------------- | :----------------------------------------------------- | :----- |
| **QA-CHK-01** | User baru membuat invitation  | Invitation berhasil dibuat.                            | PASS   |
| **QA-CHK-02** | Inisialisasi checklist        | Tepat 40 preset item dibuat.                           | PASS   |
| **QA-CHK-03** | Validasi kategori             | 40 item terbagi dalam 9 kategori.                      | PASS   |
| **QA-CHK-04** | Initial state                 | Seluruh item memiliki `is_completed = false`.          | PASS   |
| **QA-CHK-05** | Toggle checkbox               | Status item berubah tanpa reload halaman.              | PASS   |
| **QA-CHK-06** | Progress update               | Progress berubah sesuai item yang selesai.             | PASS   |
| **QA-CHK-07** | Semua item selesai            | Progress mencapai 100%.                                | PASS   |
| **QA-CHK-08** | Tambah custom item            | Item baru berhasil dibuat dengan `is_preset = false`.  | PASS   |
| **QA-CHK-09** | Edit custom item              | Data custom item berhasil diperbarui.                  | PASS   |
| **QA-CHK-10** | Delete custom item            | Custom item berhasil dihapus.                          | PASS   |
| **QA-CHK-11** | Category grouping             | Item tampil pada kategori yang benar.                  | PASS   |
| **QA-CHK-12** | Category progress             | Progress masing-masing kategori dihitung dengan benar. | PASS   |
| **QA-SEC-01** | Akses checklist user lain     | Sistem menolak akses.                                  | PASS   |
| **QA-SEC-02** | Manipulasi ID checklist       | Sistem tetap memvalidasi ownership.                    | PASS   |
| **QA-LMT-01** | User membuat invitation kedua | Sistem menolak request.                                | PASS   |

---

# 27. ACCEPTANCE CRITERIA

Fitur dianggap selesai apabila:

- [x] Sistem menyediakan 40 preset checklist.
- [x] Checklist terbagi menjadi 9 kategori.
- [x] Semua preset memiliki `is_preset = true`.
- [x] Semua preset awal memiliki status belum selesai.
- [x] User dapat melakukan toggle checklist.
- [x] Toggle tidak membutuhkan full page reload.
- [x] Progress global diperbarui secara langsung.
- [x] Progress kategori dapat dihitung.
- [x] User dapat menambahkan custom checklist.
- [x] Custom checklist memiliki `is_preset = false`.
- [x] User dapat mengedit custom checklist.
- [x] User dapat menghapus custom checklist.
- [x] Checklist hanya dapat diakses oleh pemilik invitation.
- [x] User tidak dapat mengakses checklist invitation lain.
- [x] Sistem menggunakan relasi `User → Invitation → Checklist`.
- [x] Sistem tetap mengikuti kebijakan **1 User = 1 Invitation**.
- [x] Tidak terdapat penggunaan `user_id` langsung pada checklist untuk menentukan ownership.

---

# 28. FINAL FEATURE ARCHITECTURE

```text
                         USER
                           │
                           │ 1 : 1
                           ▼
                      INVITATION
                           │
                           │ 1 : N
                           ▼
                WEDDING CHECKLIST
                           │
          ┌────────────────┼────────────────┐
          │                │                │
          ▼                ▼                ▼
     40 PRESET        CUSTOM ITEMS      9 CATEGORIES
          │                │                │
          └────────────────┼────────────────┘
                           ▼
                  CHECKLIST STATUS
                           │
                           ▼
                 LIVE PROGRESS ENGINE
                           │
              ┌────────────┴────────────┐
              ▼                         ▼
       GLOBAL PROGRESS          CATEGORY PROGRESS
              │                         │
              └────────────┬────────────┘
                           ▼
                    INTERACTIVE UI
```

---

# 29. FINAL BUSINESS RULE

## **1 USER = 1 INVITATION**

Checklist bukan dimiliki langsung oleh user.

Struktur ownership yang digunakan:

```text
User
 │
 └── Invitation
       │
       └── Wedding Checklist
```

Dengan pendekatan ini:

1. Satu user hanya memiliki satu invitation.
2. Satu invitation memiliki banyak checklist.
3. Checklist tidak dapat dipindahkan ke user lain.
4. Data checklist otomatis terhapus ketika invitation dihapus.
5. Ownership dapat divalidasi melalui relasi invitation.
6. Sistem terlindungi dari akses checklist milik user lain.

---

# 30. SUMMARY

**Interactive Wedding Checklist Planner** menyediakan:

```text
40 PRESET ITEMS
       │
       ▼
9 CATEGORIES
       │
       ▼
CHECKLIST MANAGEMENT
       │
       ├── Toggle
       ├── Add
       ├── Edit
       └── Delete
       │
       ▼
LIVE PROGRESS TRACKING
       │
       ├── Global Progress
       └── Category Progress
       │
       ▼
OWNERSHIP PROTECTION
       │
       ▼
1 USER = 1 INVITATION
```

**Status:** Approved / Living Document

**Feature Scope:** Interactive Wedding Checklist Planner
