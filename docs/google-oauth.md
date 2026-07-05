# Google OAuth Setup

Dokumentasi ini menjelaskan implementasi **Login dengan Google** menggunakan Laravel Socialite pada aplikasi ini.

---

## Daftar Isi

- [Arsitektur](#arsitektur)
- [Alur Autentikasi](#alur-autentikasi)
- [Konfigurasi](#konfigurasi)
- [Google Cloud Console](#google-cloud-console)
- [File yang Terlibat](#file-yang-terlibat)
- [Troubleshooting](#troubleshooting)

---

## Arsitektur

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 11 |
| Package | `laravel/socialite ^5.27` |
| Provider | Google OAuth 2.0 |
| Driver | `google` (built-in Socialite) |

---

## Alur Autentikasi

```
User klik "Google" → /auth/google → redirect ke Google Consent Screen
                                            ↓
User setujui → Google callback ke /auth/google/callback
                                            ↓
                        SocialiteController@handleGoogleCallback
                                            ↓
              Cari user by email — apakah sudah terdaftar?
                   /                          \
                 ADA                         TIDAK ADA
                  |                              |
          Update google_id,              Buat user baru
          token, avatar                  dengan data Google
                  |                              |
                   \                            /
                    └────── Login & redirect ke dashboard
```

### Detail Controller

**`SocialiteController::redirectToGoogle()`** — mengarahkan user ke halaman consent Google.

**`SocialiteController::handleGoogleCallback()`** — memproses callback:
1. Mengambil data user dari Google (`Socialite::driver('google')->user()`)
2. Jika gagal (user menolak), redirect ke login dengan pesan error
3. Mencari user berdasarkan email di database
4. Jika user sudah ada tetapi belum punya `google_id`, update data Google-nya
5. Jika user belum ada, buat user baru dengan data dari Google
6. Login dan redirect ke dashboard

---

## Konfigurasi

### 1. Environment Variables (`.env`)

```ini
APP_URL=http://rayakandigital.id

GOOGLE_CLIENT_ID=xxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxx
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback
```

> **Penting:** `GOOGLE_REDIRECT_URI` menggunakan `${APP_URL}` — pastikan `APP_URL` sudah benar sesuai domain yang digunakan.

### 2. Config (`config/services.php`)

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

### 3. Routes (`routes/web.php`)

```php
Route::prefix('auth/google')->name('google.')->group(function () {
    Route::get('/', [SocialiteController::class, 'redirectToGoogle'])->name('redirect');
    Route::get('/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('callback');
});
```

### 4. Blade View

Tombol Google ada di:
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`

```blade
<a href="{{ route('google.redirect') }}" class="...">
    Google
</a>
```

### 5. Database Migration

Migration `2026_06_03_000001_add_socialite_fields_to_users_table.php` menambahkan kolom:

| Kolom | Tipe | Keterangan |
|---|---|---|
| `google_id` | string, nullable, unique | ID user dari Google |
| `google_token` | string, nullable | Access token |
| `google_refresh_token` | string, nullable | Refresh token |
| `avatar` | string, nullable | URL foto profil Google |

---

## Google Cloud Console

### Langkah-langkah

1. Buka [Google Cloud Console](https://console.cloud.google.com)
2. Pilih project yang sesuai
3. Navigasi ke **APIs & Services** → **Credentials**
4. Buat atau pilih **OAuth 2.0 Client ID** (tipe **Web application**)
5. Tambahkan **Authorized redirect URIs**:

```
http://rayakandigital.id/auth/google/callback
```

> Untuk lingkungan lokal, tambahkan juga:
> ```
> http://localhost/auth/google/callback
> ```

6. Catat **Client ID** dan **Client Secret**, isi ke `.env`

---

## File yang Terlibat

| File | Peran |
|---|---|
| `app/Http/Controllers/Auth/SocialiteController.php` | Controller redirect & callback |
| `routes/web.php` | Definisi route `/auth/google` |
| `config/services.php` | Konfigurasi driver Google |
| `.env` | Client ID, Secret, Redirect URI |
| `resources/views/auth/login.blade.php` | Tombol Google di halaman login |
| `resources/views/auth/register.blade.php` | Tombol Google di halaman daftar |
| `app/Models/User.php` | Model dengan atribut Google |
| `database/migrations/2026_06_03_000001_add_socialite_fields_to_users_table.php` | Migration kolom Google |
| `database/factories/UserFactory.php` | Factory default untuk kolom Google |

---

## Troubleshooting

### Error 400: `invalid_request` — redirect_uri mismatch

**Penyebab:** URL redirect yang dikirim ke Google tidak cocok dengan yang terdaftar di Google Cloud Console.

**Solusi:**
1. Cek nilai `GOOGLE_REDIRECT_URI` dan `APP_URL` di `.env`
2. Pastikan URL tersebut terdaftar di **Google Cloud Console** → **Credentials** → **Authorized redirect URIs**
3. URL harus **sama persis** (termasuk `http`/`https` dan trailing slash)

### Error `InvalidStateException`

**Penyebab:** State mismatch — biasanya terjadi saat menggunakan SPA/API tanpa session.

**Solusi:** Gunakan `stateless()`:
```php
return Socialite::driver('google')->stateless()->user();
```

### Error 401: `invalid_client`

**Penyebab:** Client ID atau Client Secret salah.

**Solusi:** Periksa `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` di `.env`.

---

## Referensi

- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
- [Google OAuth 2.0 Documentation](https://developers.google.com/identity/protocols/oauth2/web-server)
- [Google Cloud Console](https://console.cloud.google.com)
