# PRODUCT REQUIREMENT DOCUMENT (PRD) - REVISI PERBAIKAN UTAMA
## Modul: Multi-Invitation Support & Webhook Handler (1 Undangan, 1 Invoice Aktif)
**Versi:** 3.3 (Edisi Akun Multi-Undangan - Laravel 13 & PHP 8.4 Optimized)  
**Tanggal:** 1 Juni 2026  
**Status:** Approved  
**Target Komponen:** Route Bypass, Webhook Controller, Checkout Logic, & Database Layer  

---

## 1. DESKRIPSI MASALAH & ATURAN BISNIS BARU (BUSINESS RULES)

### 1.1 Kondisi Baru Sistem
Platform SaaS sekarang mendukung fitur di mana **1 Akun Pengguna (User/Tenant) dapat membuat dan mengelola lebih dari satu undangan** (misal: satu akun membuat Undangan Pernikahan Budi, sekaligus Undangan Khitanan Adiknya).

### 1.2 Aturan Pembayaran Terikat (Strict Payment Binding)
Meskipun 1 user memiliki banyak undangan, aturan *override* pembayaran diisolasi pada tingkat **Undangan (`invitation_id`)**, bukan tingkat User:
1. **1 Undangan, 1 Invoice Aktif:** Setiap entitas undangan hanya diperbolehkan memiliki maksimal **1 data transaksi** dengan status belum dibayar (`pending` atau `verifying`).
2. **Mekanisme Replaced/Override:** Jika user memicu pembayaran baru untuk *Undangan A*, maka invoice pending lama khusus untuk *Undangan A* akan diubah menjadi `expired` (dan di-cancel ke Midtrans).
3. **Isolasi Transaksi:** Proses pembatalan/override ini **tidak boleh mengganggu** jalannya transaksi atau status aktif pada *Undangan B* milik user yang sama.
4. **Anti-Menggantung:** Sinyal sukses (`settlement`) dari Midtrans harus mengeksekusi aktivasi secara tepat sasaran pada `invitation_id` yang tertera di dalam data invoice.

---

## 2. BLUEPRINT STRUKTUR DATABASE (MIGRATION UPDATE)

Untuk mendukung relasi ini, struktur tabel `orders` wajib menyimpan kunci tamu `invitation_id` sebagai acuan utama sistem (bukan hanya `user_id`).

```sql
-- Memastikan tabel orders memiliki relasi ke user dan ke undangan spesifik
ALTER TABLE orders ADD COLUMN user_id BIGINT NOT NULL AFTER id;
ALTER TABLE orders ADD COLUMN invitation_id BIGINT NOT NULL AFTER user_id;

-- Menambahkan Foreign Key Constraints
ALTER TABLE orders ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE orders ADD FOREIGN KEY (invitation_id) REFERENCES invitations(id) ON DELETE CASCADE;

-- Indeks komposit untuk mempercepat pengecekan invoice aktif per undangan
ALTER TABLE orders ADD INDEX idx_invitation_invoice_status (invitation_id, payment_status);