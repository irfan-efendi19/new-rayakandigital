# Flow Transaksi — Rayakan Digital

## Daftar Isi

- [Gambaran Umum](#gambaran-umum)
- [Arsitektur](#arsitektur)
- [Flow A: Midtrans Gateway (Otomatis)](#flow-a-midtrans-gateway-otomatis)
- [Flow B: Manual Bank Transfer (Verifikasi WhatsApp)](#flow-b-manual-bank-transfer-verifikasi-whatsapp)
- [Flow C: Pembelian Add-on](#flow-c-pembelian-add-on)
- [Status & Transisi Database](#status--transisi-database)
- [Mapping Status Midtrans](#mapping-status-midtrans)
- [Skenario Error & Edge Cases](#skenario-error--edge-cases)

---

## Gambaran Umum

Sistem mendukung **dua metode pembayaran** yang dapat dipilih oleh admin secara dinamis melalui **Filament Admin Panel** (`Payments > Payment Routing`):

| Metode | Tipe | Cara Kerja | Aktivasi |
|--------|------|------------|----------|
| **Midtrans Gateway** | Otomatis | Snap popup (QRIS/VA/E-Wallet) | Langsung via webhook |
| **Manual Bank Transfer** | Manual | Transfer + Kirim bukti via WhatsApp | Admin approve |

Penentuan metode aktif ditangani oleh `PaymentRoutingService` yang membaca record dari tabel `payment_method_configs` (singleton — hanya 1 baris).

---

## Arsitektur

```
User -> Halaman Checkout (/dashboard/checkout)
            |
            v
    PaymentRoutingService::activeMethod()
            |
    +-------+--------+
    |                |
isMidtrans()    isManualBank()
    |                |
    v                v
MidtransService   Manual Bank Flow
(Snap popup)      (Invoice + WA)
    |                |
    v                v
Webhook POST     Admin approve
/payments/        lewat Filament
notification      (OrderActions)
    |                |
    v                v
Subscription +    Subscription +
Order             Order
(auto activate)   (manual activate)
```

---

## Flow A: Midtrans Gateway (Otomatis)

### Tahap 1 — User Membuka Halaman Checkout

| Langkah | Detail | File |
|---------|--------|------|
| **1.1** | User membuka `/dashboard/checkout` | `CheckoutController@index()` |
| **1.2** | Sistem memuat semua paket (`Package::where('is_visible', true)`) kecuali `free` | `CheckoutController.php:23-27` |
| **1.3** | `PaymentRoutingService::activeMethod()` menentukan metode aktif | `PaymentRoutingService.php:36-39` |
| **1.4** | Jika Midtrans aktif, sistem mengirim `client_key` dan URL Snap.js CDN ke view | `CheckoutController.php:40-48` |
| **1.5** | View me-render daftar paket dengan tombol "Pilih" | `checkout/index.blade.php` |

### Tahap 2 — User Memilih Paket

| Langkah | Detail | File |
|---------|--------|------|
| **2.1** | User mengklik "Pilih" pada suatu paket | Form POST ke `/dashboard/checkout` |
| **2.2** | Jika metode aktif adalah `midtrans`, form di-intercept oleh JavaScript (Alpine.js `x-data="checkout"`) | `checkout/index.blade.php:156-157` |
| **2.3** | Request dikirim via `fetch()` sebagai AJAX (bukan submit biasa) | Frontend |

### Tahap 3 — CheckoutController Memproses Pesanan

| Langkah | Detail | File |
|---------|--------|------|
| **3.1** | `CheckoutController@process()` menerima request | `CheckoutController.php:53-95` |
| **3.2** | **Validasi input:** `tier` harus ada di tabel `packages`, `invitation_id` opsional | `CheckoutController.php:55-58` |
| **3.3** | **Cek kepemilikan undangan:** User harus memiliki invitation yang di-refer | `CheckoutController.php:68-73` |
| **3.4** | **Cek tier:** Paket yang dipilih harus lebih tinggi dari tier saat ini (tidak boleh upgrade ke tier sama atau lebih rendah) | `CheckoutController.php:81-86` |
| **3.5** | **Batalkan pesanan pending sebelumnya:** `cancelPendingOrders()` — semua order lama status `pending`/`verifying` untuk undangan yang sama di-set ke `expired`, dan di-cancel di Midtrans jika perlu | `CheckoutController.php:150-175` |
| **3.6** | Routing ke `processMidtrans()` karena `isMidtrans() = true` | `CheckoutController.php:90-91` |

### Tahap 4 — Pembuatan Snap Token Midtrans

| Langkah | Detail | File |
|---------|--------|------|
| **4.1** | `processMidtrans()` memanggil `MidtransService::createSnapToken($user, $tier)` | `CheckoutController.php:97-124` |
| **4.2** | Generate `order_id` format: `RD-YYYYMMDD-{userId}-{RAND4}` (contoh: `RD-20260713-42-A7K2`) | `MidtransService.php:73` |
| **4.3** | Cari harga paket dari database (tabel `packages`) atau fallback ke `config/midtrans.php` | `MidtransService.php:47-52` |
| **4.4** | Buat record **Subscription** dengan `payment_status = 'pending'` | `MidtransService.php:75-81` |
| **4.5** | Bangun parameter Snap API: `transaction_details`, `customer_details`, `item_details` | `MidtransService.php:85-101` |
| **4.6** | Panggil `Snap::getSnapToken($params)` — Midtrans mengembalikan `snap_token` | `MidtransService.php:114-115` |
| **4.7** | **Simulation Mode:** Jika `serverKey` kosong, return `SIMULATION_TOKEN_...` tanpa panggil API | `MidtransService.php:105-112` |
| **4.8** | Buat record **Order** dengan `payment_status = 'pending'`, `snap_token` disimpan | `CheckoutController.php:101-113` |
| **4.9** | Jika simulation mode, langsung panggil `simulatePayment()` → auto-settlement | `CheckoutController.php:115-118` |
| **4.10** | Return JSON `{ snap_token, order_id }` ke frontend | `CheckoutController.php:120-123` |

### Tahap 5 — User Membayar via Snap Popup

| Langkah | Detail | File |
|---------|--------|------|
| **5.1** | Frontend menerima JSON response | Frontend |
| **5.2** | Jika token diawali `SIMULATION_TOKEN_`, redirect langsung ke `/payments/finish?order_id=...` (tanpa popup) | Frontend |
| **5.3** | Jika token valid, panggil `window.snap.pay(snap_token, { callbacks })` | Frontend |
| **5.4** | Midtrans Snap popup terbuka — user memilih metode pembayaran (QRIS/VA/E-Wallet) | Midtrans |
| **5.5** | User menyelesaikan pembayaran di dalam Snap popup | Midtrans |

### Tahap 6 — Midtrans Mengirim Webhook Notifikasi

| Langkah | Detail | File |
|---------|--------|------|
| **6.1** | Midtrans mengirim POST ke `/payments/notification` (tanpa CSRF protection) | `routes/web.php:146` |
| **6.2** | `PaymentController@notification()` menerima payload | `PaymentController.php:11-22` |
| **6.3** | Meneruskan ke `MidtransService::handleNotification($payload)` | `PaymentController.php:15` |

### Tahap 7 — Handle Notification (Core Logic)

| Langkah | Detail | File |
|---------|--------|------|
| **7.1** | **Validasi signature key:** `SHA512(order_id + status_code + gross_amount + server_key)` | `MidtransService.php:152-164` |
| **7.2** | Jika signature tidak cocok → log warning, return `null` (ditolak) | `MidtransService.php:155-159` |
| **7.3** | Jika simulation mode, signature validation dilewati | `MidtransService.php:160-163` |
| **7.4** | **Cek apakah ini transaksi Add-on:** cari di `AddonTransaction` dulu | `MidtransService.php:169` |
| **7.5** | **Jika Add-on:** update status + aktivasi pivot (lihat Flow C) | `MidtransService.php:171-196` |
| **7.6** | **Jika Subscription:** cari `Subscription::where('midtrans_order_id', $orderId)` | `MidtransService.php:199` |
| **7.7** | **Jika settlement:** set `payment_status = 'settlement'`, `starts_at = now()`, `expires_at = now() + duration_days` | `MidtransService.php:207-211` |
| **7.8** | **Jika pending:** set `payment_status = 'pending'` | `MidtransService.php:212-213` |
| **7.9** | **Jika deny/expire/cancel:** set status sesuai mapping | `MidtransService.php:214-221` |
| **7.10** | **Sync Order:** update `payment_status` di tabel `orders` | `MidtransService.php:226-234` |
| **7.11** | **Sync Invitation:** update `tier`, `pricing_tier_id`, `expires_at`, `is_active = true` | `MidtransService.php:237-248` |
| **7.12** | Return `Subscription` model | `MidtransService.php:250` |

### Tahap 8 — User Redirect ke Halaman Finish

| Langkah | Detail | File |
|---------|--------|------|
| **8.1** | Setelah Snap popup sukses/tutup, user diarahkan ke `/payments/finish?order_id=...` | `PaymentController@finish()` |
| **8.2** | Cek status Subscription — jika `settlement`, redirect ke dashboard dengan pesan sukses | `PaymentController.php:31-33` |
| **8.3** | Jika masih `pending`, panggil `checkTransactionStatus()` untuk pull status terbaru dari Midtrans API | `PaymentController.php:37-42` |
| **8.4** | Jika gagal/unknown, redirect ke dashboard dengan pesan "sedang diproses" | `PaymentController.php:46-48` |

### Diagram Flow Midtrans

```
User                   Frontend              CheckoutController     MidtransService        Midtrans API
 |                        |                        |                     |                     |
 | 1. Buka /checkout      |                        |                     |                     |
 |----------------------->|                        |                     |                     |
 |                        | GET /dashboard/checkout|                     |                     |
 |                        |----------------------->|                     |                     |
 |                        | View + packages        |                     |                     |
 |                        |<-----------------------|                     |                     |
 |                        |                        |                     |                     |
 | 2. Pilih paket         |                        |                     |                     |
 |----------------------->|                        |                     |                     |
 |                        | POST /checkout (AJAX)  |                     |                     |
 |                        |----------------------->|                     |                     |
 |                        |                        | processMidtrans()   |                     |
 |                        |                        |-------------------->|                     |
 |                        |                        |                     | createSnapToken()   |
 |                        |                        |                     |-------------------->|
 |                        |                        |                     | Snap::getSnapToken  |
 |                        |                        |                     |<--------------------|
 |                        |                        |<--------------------|                     |
 |                        |{snap_token, order_id}  |                     |                     |
 |                        |<-----------------------|                     |                     |
 |                        |                        |                     |                     |
 | 3. Snap popup         |                        |                     |                     |
 |<-----------------------|                        |                     |                     |
 |                        |                        |                     |                     |
 | 4. Bayar               |                        |                     |                     |
 |--------------------------------------------------------------->     |                     |
 |                        |                        |                     |                     |
 |                        |                        |  5. POST /notification (webhook)           |
 |                        |                        |<------------------------------------------|
 |                        |                        |  handleNotification()|                    |
 |                        |                        |<--------------------|                     |
 |                        |                        |  6. Update DB       |                     |
 |                        |                        |                     |                     |
 | 7. Redirect /finish    |                        |                     |                     |
 |<-----------------------|                        |                     |                     |
 |                        | GET /finish?order_id=  |                     |                     |
 |                        |----------------------->|                     |                     |
 |                        | Redirect ke dashboard  |                     |                     |
 |                        |<-----------------------|                     |                     |
```

---

## Flow B: Manual Bank Transfer (Verifikasi WhatsApp)

### Tahap 1 — User Memilih Paket

| Langkah | Detail | File |
|---------|--------|------|
| **1.1** | Halaman checkout sama seperti Midtrans | `CheckoutController@index()` |
| **1.2** | User melihat instruksi transfer bank di halaman checkout atau di halaman invoice setelah submit | View |

### Tahap 2 — Proses Checkout Manual Bank

| Langkah | Detail | File |
|---------|--------|------|
| **2.1** | Form di-submit biasa (tidak di-intercept JavaScript) | Form submit normal |
| **2.2** | `process()` → routing ke `processManualBank()` karena `isManualBank() = true` | `CheckoutController.php:94` |
| **2.3** | Generate `order_id` dan `unique_code` (3 digit random, 100-999) | `CheckoutController.php:128-129` |
| **2.4** | Buat **Order** dengan: `payment_method_used = 'manual_bank'`, `payment_status = 'pending'`, `is_manual_whatsapp = true` | `CheckoutController.php:131-144` |
| **2.5** | Redirect ke halaman invoice `/dashboard/payment/{order}` | `CheckoutController.php:146` |

### Tahap 3 — User Melihat Invoice

| Langkah | Detail | File |
|---------|--------|------|
| **3.1** | `WhatsAppPaymentController@showInvoice()` menampilkan invoice | `WhatsAppPaymentController.php:12-19` |
| **3.2** | Total transfer = `gross_amount + unique_code` (contoh: Rp49.000 + Rp123 = Rp49.123) | `Order.php:59-62` |
| **3.3** | Kode unik digunakan admin untuk verifikasi bahwa user benar-benar transfer | — |

### Tahap 4 — User Transfer & Kirim Bukti

| Langkah | Detail | File |
|---------|--------|------|
| **4.1** | User transfer sejumlah total ke rekening bank admin | Eksternal |
| **4.2** | User mengklik "Kirim Bukti Transfer via WhatsApp" | Form POST ke `/dashboard/payment/{order}/send-whatsapp` |
| **4.3** | `WhatsAppPaymentController@sendWhatsApp()` | `WhatsAppPaymentController.php:21-52` |
| **4.4** | Update `payment_status` dari `pending` menjadi `verifying` | `WhatsAppPaymentController.php:35` |
| **4.5** | Generate pesan WhatsApp otomatis berisi detail invoice | `WhatsAppPaymentController.php:41-47` |
| **4.6** | Redirect user ke `https://api.whatsapp.com/send?phone={admin}&text={message}` | `WhatsAppPaymentController.php:49-51` |

### Tahap 5 — Admin Verifikasi via Filament

| Langkah | Detail | File |
|---------|--------|------|
| **5.1** | Admin membuka Filament → `Payments > Orders (WA Verification)` | `OrderResource` |
| **5.2** | Admin menemukan order dengan `payment_status = 'verifying'` | Filter |
| **5.3** | Admin mengklik tombol **"Setujui & Aktifkan"** | `OrderActions.php:13-91` |

### Tahap 6 — Aktivasi oleh Admin

| Langkah | Detail | File |
|---------|--------|------|
| **6.1** | `OrderActions::activate($order)` dijalankan | `OrderActions.php:13-91` |
| **6.2** | Update **Order:** `payment_status = 'success'`, `verified_by = auth()->id()` | `OrderActions.php:21-24` |
| **6.3** | Jika user punya subscription aktif, **perpanjang** durasinya (tambah hari) | `OrderActions.php:27-38` |
| **6.4** | Jika belum punya subscription, **buat baru** dengan `payment_status = 'settlement'` | `OrderActions.php:40-49` |
| **6.5** | Update **Invitation:** `tier`, `pricing_tier_id`, `expires_at`, `is_active = true` | `OrderActions.php:51-62` |
| **6.6** | Kirim notifikasi WhatsApp ke user bahwa akun sudah aktif | `OrderActions.php:80` |

### Diagram Flow Manual Bank

```
User                   Frontend              CheckoutController      Admin (Filament)
 |                        |                        |                     |
 | 1. Pilih paket         |                        |                     |
 |----------------------->|                        |                     |
 |                        | POST /checkout (form)  |                     |
 |                        |----------------------->|                     |
 |                        |                        | processManualBank() |
 |                        |                        | - generate unique_code|
 |                        |                        | - create Order      |
 |                        |<-- redirect invoice ---|                     |
 |                        |                        |                     |
 | 2. Lihat invoice       |                        |                     |
 |<-----------------------|                        |                     |
 |                        |                        |                     |
 | 3. Transfer ke bank    |                        |                     |
 |------------------------------------------------------> (eksternal)   |
 |                        |                        |                     |
 | 4. Klik "Kirim WA"     |                        |                     |
 |----------------------->|                        |                     |
 |                        | POST /send-whatsapp    |                     |
 |                        |----------------------->|                     |
 |                        |                        | status -> verifying |
 |                        |<-- redirect wa.me ----|                     |
 |                        |                        |                     |
 | 5. Kirim foto bukti    |                        |                     |
 |------------------------------------------------------> (WhatsApp)    |
 |                        |                        |                     |
 |                        |                        |  6. Admin approve   |
 |                        |                        |<--------------------|
 |                        |                        |  OrderActions::     |
 |                        |                        |  activate()         |
 |                        |                        |  - Order success    |
 |                        |                        |  - Subscription     |
 |                        |                        |  - Invitation update|
 |                        |                        |  - WA notif user    |
```

---

## Flow C: Pembelian Add-on

Add-on adalah fitur tambahan yang bisa dibeli untuk sebuah undangan (invitation) setelah memiliki paket berbayar.

### Alur Pembelian Add-on

| Langkah | Detail | File |
|---------|--------|------|
| **1** | User membuka halaman add-on undangan: `/dashboard/invitations/{invitation}/addons` | `AddonController@index()` |
| **2** | Sistem menampilkan add-on yang tersedia dan status pembelian sebelumnya | `AddonController.php:18-44` |
| **3** | User memilih add-on, mengklik "Beli" | POST ke `/dashboard/invitations/{invitation}/addons/{addon}/purchase` |
| **4** | `AddonController@process()` — cek apakah add-on sudah dimiliki | `AddonController.php:47-117` |
| **5** | Generate `reference_order_id`, buat `AddonTransaction` dengan `payment_status = 'pending'` | `AddonController.php:56-68` |

#### Jika metode aktif = Midtrans

| Langkah | Detail | File |
|---------|--------|------|
| **5a** | Bangun parameter Snap API (sama seperti subscription) | `AddonController.php:75-92` |
| **5a.1** | Panggil `Snap::getSnapToken()` → dapat `snap_token` | `AddonController.php:97` |
| **5a.2** | Simpan `snap_token` ke `AddonTransaction` | `AddonController.php:107` |
| **5a.3** | Return JSON `{ snap_token, reference_order_id }` → frontend buka Snap popup | `AddonController.php:109-112` |
| **5a.4** | Webhook Midtrans → `MidtransService::handleNotification()` deteksi `AddonTransaction` → update pivot `addon_invitation` dengan `status_active = true` | `MidtransService.php:171-182` |

#### Jika metode aktif = Manual Bank

| Langkah | Detail | File |
|---------|--------|------|
| **5b** | Redirect ke halaman invoice add-on | `AddonController.php:115-116` |
| **5b.1** | User transfer + kirim bukti via WhatsApp (sama seperti Flow B) | `AddonController@sendWhatsApp()` |
| **5b.2** | Admin approve via panel (aktivasi add-on bisa manual oleh admin atau user sendiri) | `AddonController@activate()` |

---

## Status & Transisi Database

### Tabel `orders`

```
                  +---------+
                  | pending |
                  +----+----+
                       |
          +------------+------------+
          |                         |
     (Midtrans)               (Manual Bank)
          |                         |
    settlement via             +-----+------+
    webhook                    |            |
          |              verifying    expired (cancel)
          |                    |           sebelumnya)
          v                    v
     +----------+        +---------+
     | success  |        | success |
     +----------+        +---------+
          |
     (jika gagal via webhook)
          |
          v
     +---------+
     | expired |
     +---------+
```

| Status | Arti | Selanjutnya |
|--------|------|-------------|
| `pending` | Menunggu pembayaran | `success` / `verifying` / `expired` |
| `verifying` | User sudah klaim bayar, menunggu verifikasi admin | `success` |
| `success` | Pembayaran berhasil | — (terminal) |
| `expired` | Pesanan kadaluarsa / dibatalkan | — (terminal) |

### Tabel `subscriptions`

| Status | Arti | Selanjutnya |
|--------|------|-------------|
| `pending` | Menunggu pembayaran | `settlement` / `expire` / `deny` / `cancel` |
| `settlement` | Pembayaran berhasil, subscription aktif | — (terminal) |
| `expire` | Subscription kadaluarsa | — (terminal) |
| `deny` | Pembayaran ditolak | — (terminal) |
| `cancel` | Pembayaran dibatalkan | — (terminal) |

### Transisi State untuk Manual Bank (Flow B)

```
Order: pending  -->  verifying  -->  success
                                     ^
                              Admin klik "Setujui & Aktifkan"
```

### Transisi State untuk Midtrans (Flow A)

```
Order:        pending  -->  success (via webhook settlement)
                            expired (via webhook deny/expire/cancel)

Subscription: pending  -->  settlement
                            expire
                            deny
                            cancel
```

---

## Mapping Status Midtrans

| Midtrans Status | Fraud Status | Subscription Status | Order Status |
|----------------|--------------|-------------------|--------------|
| `settlement` | — | `settlement` | `success` |
| `capture` | `accept` | `settlement` | `success` |
| `capture` | `deny` | `deny` | `expired` |
| `capture` | `challenge` | `pending` | `pending` |
| `pending` | — | `pending` | `pending` |
| `deny` | — | `deny` | `expired` |
| `expire` | — | `expire` | `expired` |
| `cancel` | — | `cancel` | `expired` |

---

## Skenario Error & Edge Cases

### 1. Signature Key Tidak Cocok (Webhook)

**Apa yang terjadi:** Webhook dari Midtrans memiliki `signature_key` yang tidak cocok dengan kalkulasi lokal.

**Dampak:** Notifikasi ditolak (`return null`), status subscription tidak berubah.

**Log:** `Midtrans webhook signature mismatch for order: {orderId}` — `MidtransService.php:156`

**Resolusi:** User datang ke halaman finish → `checkTransactionStatus()` akan pull status langsung dari Midtrans API.

### 2. Simulation Mode Aktif

**Penyebab:** `MIDTRANS_SERVER_KEY` kosong (tidak diisi di `.env` maupun di Admin Panel).

**Dampak:**
- `createSnapToken()` return `SIMULATION_TOKEN_{orderId}` tanpa panggil Midtrans API
- `processMidtrans()` langsung panggil `simulatePayment()` → auto-settlement
- Signature validation di `handleNotification()` dilewati
- `checkTransactionStatus()` return null (tidak panggil Midtrans API)

**Berguna untuk:** Development tanpa koneksi ke Midtrans.

### 3. User Membatalkan di Tengah Snap Popup

**Apa yang terjadi:** User menutup Snap popup sebelum menyelesaikan pembayaran.

**Dampak:**
- Callback `onClose()` di frontend dipanggil
- Order tetap `pending` di database
- Tidak ada webhook yang dikirim

**Resolusi:** User bisa kembali ke halaman checkout. Jika user klik "Pilih" lagi, `cancelPendingOrders()` akan expired order sebelumnya.

### 4. Webhook Gagal Sampai (Network Issue)

**Apa yang terjadi:** Server tidak menerima webhook dari Midtrans karena network issue.

**Dampak:** Subscription tetap `pending` meskipun user sudah bayar.

**Resolusi:** 
- Midtrans akan retry webhook beberapa kali
- User di redirect ke `/payments/finish` → `checkTransactionStatus()` pull status langsung dari Midtrans API

### 5. User Upgrade ke Tier yang Sama atau Lebih Rendah

**Apa yang terjadi:** User mencoba memilih paket yang setara atau lebih rendah dari tier saat ini.

**Dampak:** Ditolak di `CheckoutController@process()` — redirect back dengan flash message: *"Undangan ini sudah memiliki paket {tier} yang setara atau lebih tinggi."*

**Log:** `CheckoutController.php:84-86`

### 6. Order Pending Sebelumnya Tidak Dibayar

**Apa yang terjadi:** User memiliki order pending (`pending`/`verifying`) lalu membuat order baru.

**Dampak:** `cancelPendingOrders()` akan:
1. Cancel order lama di Midtrans (jika Midtrans)
2. Set `payment_status` order lama ke `expired`
3. Set `payment_status` subscription lama ke `expire`

**Log:** `CheckoutController.php:150-175`

### 7. Transaksi Add-on Ganda

**Apa yang terjadi:** User mencoba membeli add-on yang sudah dimiliki undangan.

**Dampak:** Ditolak — redirect back dengan flash message: *"Add-on sudah dimiliki undangan ini."*

**Log:** `AddonController.php:51-54`

### 8. Kode Unik Sama (Manual Bank)

**Apa yang terjadi:** Secara teoritis bisa ada 2 order dengan `unique_code` yang sama (karena random 100-999).

**Dampak:** Minimal — kode unik digunakan admin untuk verifikasi manual. Admin bisa membedakan berdasarkan kombinasi kode unik + nominal transfer + nama user.

**Catatan:** Tidak ada validasi unique di level database untuk kolom `unique_code`.
