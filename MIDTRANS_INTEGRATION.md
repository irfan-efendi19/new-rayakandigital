# Midtrans Payment Integration Documentation

## Overview

Proyek ini menggunakan **Midtrans Snap** sebagai payment gateway otomatis (QRIS/VA/E-Wallet), dengan opsi fallback ke **Transfer Bank Manual** (verifikasi via WhatsApp). Sistem routing payment method dapat dikonfigurasi secara dinamis melalui Filament Admin Panel.

---

## Architecture

```
User -> Checkout Page -> PaymentRoutingService
                           |
            +--------------+--------------+
            |                             |
      isMidtrans()                 isManualBank()
            |                             |
   MidtransService               Manual Bank Flow
   (Snap popup)                  (Invoice + WA Verify)
            |                             |
   Webhook /payments/notification   Admin approve via Filament
            |                             |
      Subscription + Order          Subscription + Order
      (auto activate)               (manual activate)
```

---

## Configuration

### `.env` Variables

```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

### `config/midtrans.php`

| Key | Description |
|-----|-------------|
| `server_key` | Midtrans server key (from `.env`) |
| `client_key` | Midtrans client key (from `.env`) |
| `is_production` | Toggle sandbox/production |
| `is_sanitized` | Sanitize transaction params (default: `true`) |
| `is_3ds` | Enable 3DS authentication (default: `true`) |
| `snap_url` | Snap.js CDN URL (auto-switches based on environment) |
| `pricing` | Default prices per tier (fallback if no `Package` record) |
| `duration_days` | Default subscription durations per tier |

### Payment Method Routing (Admin Panel)

**Menu:** Payments > Payment Routing

Admin dapat memilih metode aktif:
- **Midtrans Gateway** — pembayaran otomatis via Snap popup
- **Manual Bank Transfer** — transfer manual + verifikasi WhatsApp

Setelan tambahan untuk Midtrans:
- `Client Key`
- `Server Key`
- `Environment` (sandbox / production)

> **Note:** Keys yang diisi di Admin Panel akan **override** nilai dari `config/midtrans.php` saat runtime.

---

## Database Structure

### Orders Table (`orders`)

| Column | Type | Description |
|--------|------|-------------|
| `order_id` | `string(100) UNIQUE` | Format: `RD-{TIER}-{userId}-{random8}` |
| `user_id` | `FK -> users` | Pembeli |
| `invitation_id` | `FK -> invitations (nullable)` | Undangan terkait |
| `package_type` | `enum(silver,gold,platinum,addon)` | Paket yang dibeli |
| `payment_method_used` | `enum(manual_bank,midtrans)` | Metode pembayaran |
| `payment_gateway_used` | `string(50) nullable` | `midtrans`, `manual_whatsapp`, dll |
| `gross_amount` | `decimal(10,2)` | Total harga |
| `payment_status` | `enum(pending,verifying,success,failed,expired)` | Status pembayaran |
| `snap_token` | `text nullable` | Midtrans Snap token |
| `is_manual_whatsapp` | `boolean` | Flag manual bank |
| `unique_code` | `integer nullable` | Kode unik untuk manual bank |
| `verified_by` | `FK -> users nullable` | Admin yang verifikasi |

### Subscriptions Table (`subscriptions`)

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | `FK -> users` | Pemilik subscription |
| `tier` | `enum(free,silver,gold,platinum)` | Tier subscription |
| `midtrans_order_id` | `string nullable UNIQUE` | Order ID dari Midtrans |
| `midtrans_transaction_id` | `string nullable` | Transaction ID dari Midtrans |
| `payment_status` | `enum(pending,settlement,expire,cancel,deny)` | Status dari Midtrans |
| `amount` | `decimal(12,2)` | Jumlah pembayaran |
| `starts_at` | `timestamp nullable` | Mulai aktif (saat settlement) |
| `expires_at` | `timestamp nullable` | Berakhir (berdasarkan durasi paket) |

### Payment Method Configs (`payment_method_configs`)

Singleton table — hanya berisi 1 baris.

| Column | Type | Description |
|--------|------|-------------|
| `active_method` | `enum(manual_bank,midtrans)` | Metode aktif saat ini |
| `midtrans_client_key` | `text nullable` | Client key admin panel |
| `midtrans_server_key` | `text nullable` | Server key admin panel |
| `midtrans_environment` | `enum(sandbox,production)` | Environment |
| `manual_bank_name` | `string nullable` | Nama bank manual |
| `manual_account_number` | `string nullable` | No rekening manual |
| `manual_account_name` | `string nullable` | Nama pemilik rekening |
| `admin_whatsapp_number` | `string nullable` | No WA admin |

---

## Key Classes

### `App\Services\MidtransService`

Core service untuk interaksi dengan Midtrans API.

**Methods:**

| Method | Parameters | Returns | Description |
|--------|-----------|---------|-------------|
| `getPrice(tier)` | `string $tier` | `int` | Harga paket |
| `getDurationDays(tier)` | `string $tier` | `int|null` | Durasi subscription |
| `createSnapToken(user, tier)` | `User $user, string $tier` | `array` | Buat Snap token + Subscription |
| `handleNotification(payload)` | `array $payload` | `void` | Handle webhook notifikasi |
| `simulatePayment(orderId)` | `string $orderId` | `void` | Simulasi pembayaran (dev mode) |

**Simulation Mode:**

Jika `serverKey` kosong, service berjalan di **simulation mode**:
- `createSnapToken()` mengembalikan token palsu `SIMULATION_TOKEN_{orderId}`
- Langsung memanggil `simulatePayment()` yang auto-set status ke `settlement`
- Berguna untuk development tanpa kredensial Midtrans

### `App\Services\PaymentRoutingService`

Menentukan metode pembayaran aktif berdasarkan `payment_method_configs`.

| Method | Returns | Description |
|--------|---------|-------------|
| `isMidtrans()` | `bool` | Apakah Midtrans aktif |
| `isManualBank()` | `bool` | Apakah manual bank aktif |
| `isMidtransConfigured()` | `bool` | Apakah key Midtrans sudah diisi |
| `isManualBankConfigured()` | `bool` | Apakah data bank manual sudah lengkap |

### `App\Http\Controllers\Dashboard\CheckoutController`

Menangani halaman checkout dan pemrosesan pembayaran.

- **`index()`** — Menampilkan halaman pricing dengan paket yang tersedia
- **`process()`** — Validasi tier, routing ke Midtrans atau manual bank
- **`processMidtrans()`** — Buat Snap token via MidtransService, simpan Order, kirim response JSON ke frontend
- **`processManualBank()`** — Buat Order manual, redirect ke halaman invoice

### `App\Http\Controllers\PaymentController`

Menangani callback dari Midtrans.

| Route | Method | Description |
|-------|--------|-------------|
| `POST /payments/notification` | `notification()` | Webhook dari Midtrans (notifikasi status pembayaran) |
| `GET /payments/finish` | `finish()` | Redirect setelah user selesai Snap popup |

---

## Payment Flow (Midtrans)

### Step-by-step:

```
1. User klik "Pilih Paket" di halaman checkout
       |
2. POST /dashboard/checkout {tier, invitation_id}
       |
3. CheckoutController@process()
       |  PaymentRoutingService::isMidtrans() = true
       v
4. processMidtrans()
       |  MidtransService::createSnapToken($user, $tier)
       |    - Generate order_id: RD-{TIER}-{userId}-{random8}
       |    - Create Subscription (payment_status: pending)
       |    - Call Midtrans Snap API -> get snap_token
       |  Create Order (payment_status: pending, snap_token: ...)
       v
5. Return JSON {snap_token, order_id} ke frontend
       |
6. Frontend buka Midtrans Snap popup
       |  window.snap.pay(snap_token, ...)
       |
7. User bayar via QRIS / VA / E-Wallet
       |
       +------> [SUCCESS] -----------------------+
       |                                         |
8. Midtrans kirim POST ke /payments/notification |
       |                                         |
       v                                         |
  PaymentController@notification()               |
       |  MidtransService::handleNotification()   |
       |    - Update Subscription status          |
       |    - Set starts_at/expires_at            |
       |    - Sync Order status                   |
       v                                         |
  Response 200 OK                                |
       |                                         |
9. User redirect ke /payments/finish?order_id=.. |
       |                                         |
       v                                         |
  PaymentController@finish()                     |
       |  Cek status subscription                 |
       |  Redirect ke dashboard                   |
       +-----------------------------------------+
```

### Midtrans Status Mapping

| Midtrans Status | Subscription Status | Order Status |
|----------------|-------------------|--------------|
| `capture` (credit card) | `settlement` | `success` |
| `settlement` (non-CC) | `settlement` | `success` |
| `pending` | `pending` | `pending` |
| `deny` | `deny` | `failed` |
| `expire` | `expire` | `expired` |
| `cancel` | `cancel` | `failed` |

---

## Manual Bank Flow (Alternatif)

Saat `isManualBank()` aktif:

```
1. User pilih paket
2. Sistem generate unique code (3 digit random)
3. Total = harga + unique_code (contoh: 49000 + 123 = 49123)
4. User transfer ke rekening bank yang ditentukan
5. User klik "Kirim Bukti Transfer via WhatsApp"
6. Admin verifikasi via Filament -> Approve
7. Subscription diaktifkan
```

---

## Filament Admin Panel

### Payment Routing

**Path:** Payments > Payment Routing

Toggle antara Midtrans dan Manual Bank. Input keys untuk Midtrans langsung disimpan ke database (override config).

### Orders

**Path:** Payments > Orders

- Melihat semua order
- Filter by `payment_method_used` (Bank Manual / Midtrans)
- Action "Setujui & Aktifkan" khusus untuk manual bank status `verifying`

### Verifikasi Manual Bank

**Action:** `activate(Order $order)` di `OrderActions.php`

1. Update Order: `payment_status = success`, `verified_by = admin_id`
2. Buat/update Subscription: `tier`, `midtrans_order_id = order.order_id`, `payment_status = settlement`, `starts_at = now()`, `expires_at` berdasarkan durasi paket

---

## Development & Testing

### Simulation Mode

Tanpa kredensial Midtrans, sistem otomatis masuk simulation mode:

```php
$midtransService->isSimulationMode(); // true jika serverKey kosong
```

Di mode ini:
- `createSnapToken()` return fake token `SIMULATION_TOKEN_...`
- Langsung auto-settlement via `simulatePayment()`
- Cocok untuk development tanpa koneksi ke Midtrans

### Sandbox vs Production

| Environment | Snap.js URL | Server Key Source |
|-------------|-------------|-------------------|
| Sandbox | `https://app.sandbox.midtrans.com/snap/snap.js` | `SB-Mid-server-...` |
| Production | `https://app.midtrans.com/snap/snap.js` | `Mid-server-...` |

### Testing Card Numbers (Sandbox)

| Brand | Number | CVV | 3DS |
|-------|--------|-----|-----|
| Visa | `4811 1111 1111 1114` | `123` | `112233` |
| Mastercard | `5211 1111 1111 1117` | `123` | `112233` |

---

## Frontend Integration (Snap Popup)

Saat ini form checkout menggunakan submit biasa (POST). Untuk integrasi Snap popup, frontend perlu:

```javascript
// Intercept form submission
document.querySelector('#checkout-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const response = await fetch('/dashboard/checkout', {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    
    const data = await response.json();
    
    if (data.snap_token.startsWith('SIMULATION_TOKEN_')) {
        // Simulation mode — redirect langsung
        window.location.href = '/payments/finish?order_id=' + data.order_id;
        return;
    }
    
    // Load Snap.js
    const snapUrl = data.is_production 
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
    
    // Open Snap popup
    window.snap.pay(data.snap_token, {
        onSuccess: function(result) {
            window.location.href = '/payments/finish?order_id=' + data.order_id;
        },
        onPending: function(result) {
            window.location.href = '/payments/finish?order_id=' + data.order_id;
        },
        onError: function(result) {
            alert('Pembayaran gagal, silakan coba lagi.');
        },
        onClose: function() {
            // User menutup popup tanpa menyelesaikan
        }
    });
});
```

---

## Environment Variables Reference

```env
# Required for Midtrans
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false

# App Configuration
APP_URL=http://localhost
APP_NAME=RayakanDigital
```

---

## Troubleshooting

| Problem | Cause | Solution |
|---------|-------|----------|
| Snap popup tidak muncul | Snap.js tidak di-load | Tambahkan `<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ $clientKey }}"></script>` di layout |
| "Transaction not found" | Order ID tidak cocok | Pastikan `order_id` di Midtrans Dashboard sama dengan `midtrans_order_id` di database |
| Webhook 404 | Route tidak terdaftar | Pastikan `POST /payments/notification` ada di `routes/web.php` dan CSRF exclusion |
| Simulation mode aktif | Server key kosong | Isi `MIDTRANS_SERVER_KEY` di `.env` atau via Admin Panel |
| Payment method config error | Belum ada record di `payment_method_configs` | Buka Admin Panel > Payment Routing, simpan form sekali |
