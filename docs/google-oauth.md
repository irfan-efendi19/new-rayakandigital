# Google OAuth Setup

Dokumentasi ini menjelaskan implementasi **Login dengan Google** menggunakan Laravel Socialite pada aplikasi ini.

---

## Daftar Isi

- [Arsitektur](#arsitektur)
- [Alur Autentikasi](#alur-autentikasi)
- [Persistensi Pilihan Tema](#persistensi-pilihan-tema)
- [Konfigurasi](#konfigurasi)
- [Google Cloud Console](#google-cloud-console)
- [File yang Terlibat](#file-yang-terlibat)
- [Troubleshooting](#troubleshooting)

---

## Arsitektur

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 13 |
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

**`SocialiteController::redirectToGoogle()`** — memvalidasi pilihan tema dan mengarahkan user ke halaman consent Google.

**`SocialiteController::handleGoogleCallback()`** — memproses callback:
1. Memvalidasi `state` terhadap sesi dan mengambil data user dari Google (`Socialite::driver('google')->user()`)
2. Jika gagal (user menolak), redirect ke login dengan pesan error
3. Mencari user berdasarkan email di database
4. Jika user sudah ada tetapi belum punya `google_id`, update data Google-nya
5. Membaca `theme_id` dari payload `state` terenkripsi, lalu memeriksa apakah tema masih aktif
6. Jika user belum ada, buat user baru dengan data Google dan simpan tema pilihan atau tema bawaan pada `users.theme_id`
7. Jika user sudah ada dan belum memiliki undangan, simpan pilihan tema baru; undangan yang sudah dibuat tetap dipertahankan
8. Login, regenerasi sesi, dan redirect ke halaman tujuan atau dashboard

## Persistensi Pilihan Tema

Kartu tema pada landing page dan katalog mengirim slug melalui `/register?theme=modern`. Tautan Google serta tautan berpindah antara halaman daftar dan login mempertahankan `theme` atau `theme_id`. Endpoint `/auth/google` mendukung ID tema maupun slug yang sudah digunakan aplikasi.

`App\Auth\GoogleProvider` menambahkan `theme_id` dan nonce acak ke payload `state` terenkripsi. Socialite menyimpan keseluruhan nilai tersebut dalam sesi dan membandingkannya saat callback, kemudian mengonsumsinya satu kali. Payload hanya dibaca setelah validasi Socialite berhasil. Jangan menggunakan `with(['state' => ...])` atau `stateless()` untuk alur ini. [Dokumentasi Socialite](https://laravel.com/docs/13.x/socialite#optional-parameters)

Pilihan disimpan sebagai foreign key nullable `users.theme_id`. Penanda `users.has_selected_theme` bernilai true hanya jika pilihan tema aktif dari pengguna disimpan; pemberian tema bawaan tidak mengaktifkan penanda ini. Formulir pembuatan undangan menyembunyikan pemilih hanya untuk pilihan aktif dari URL atau pilihan aktif tersimpan dengan penanda tersebut. Slug tetap dikirim melalui input tersembunyi. Jika pengguna belum memilih, tema bawaan boleh terpilih otomatis tetapi pemilih tema tetap ditampilkan. Tema yang hilang atau tidak aktif juga menampilkan pemilih kembali. Ketika formulir disimpan, slug tetap masuk ke `invitations.theme`.

Akun lama yang belum memiliki penanda pilihan tetap menampilkan pemilih. Migration mempertahankan `theme_id` mereka dan tidak mengasumsikan bahwa tema tersebut dipilih sendiri oleh pengguna.

Urutan tema bawaan untuk pengguna Google baru:

1. Tema aktif pada `config('themes.default_theme_id')`, dikonfigurasi melalui `DEFAULT_THEME_ID`.
2. Tema aktif `themes.elegant` (Elegant Rose).
3. Tema aktif pertama berdasarkan ID.
4. Jika katalog kosong, preferensi bernilai null dan formulir menampilkan pemilih tema.

ID atau slug yang tidak tersedia menggunakan fallback tersebut. Bentuk parameter yang tidak valid ditolak sebelum redirect. Tema diperiksa kembali pada callback; tema yang dinonaktifkan atau dihapus selama proses login juga menggunakan fallback. Penghapusan tema mengosongkan foreign key pengguna tanpa menghapus pengguna.

Login Google yang dibatalkan, gagal, memakai `state` berubah, kehilangan sesi, atau mengulang callback akan kembali ke login dengan pesan kesalahan dan menghapus state. Login biasa tanpa pilihan baru mempertahankan preferensi pengguna lama. Tema undangan yang sudah ada tidak ditimpa.

### Migrasi dan pengujian

Jalankan `php artisan migrate` saat menerapkan perubahan untuk menambahkan `users.theme_id` dan `users.has_selected_theme`. Opsional, isi `DEFAULT_THEME_ID` dengan ID tema aktif lalu perbarui cache konfigurasi sesuai prosedur deployment.

Pengujian regresi: `php artisan test --compact tests/Feature/Auth/GoogleThemePersistenceTest.php`. Tes menggunakan provider aplikasi dengan validasi state asli, respons HTTP Google tiruan, dan database SQLite di memori.

Callback aplikasi tetap `/auth/google/callback` sesuai route dan konfigurasi Google yang ada. Contoh `/api/v1/auth/google/callback` pada PRD bukan endpoint aplikasi ini.

---

## Konfigurasi

### 1. Environment Variables (`.env`)

```ini
APP_URL=http://rayakandigital.id

GOOGLE_CLIENT_ID=xxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxx
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback
DEFAULT_THEME_ID=
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
<a href="{{ route('google.redirect', request()->only(['theme', 'theme_id'])) }}" class="...">
    Google
</a>
```

### 5. Database Migration

Migration `2026_06_03_000001_add_socialite_fields_to_users_table.php` menambahkan kolom Google. Migration `2026_09_19_232314_widen_google_tokens_on_users_table.php` memperluas kedua kolom token menjadi `TEXT` karena token dapat melebihi 255 karakter. Struktur akhirnya:

| Kolom | Tipe | Keterangan |
|---|---|---|
| `google_id` | string, nullable, unique | ID user dari Google |
| `google_token` | text, nullable | Access token tanpa pemotongan |
| `google_refresh_token` | text, nullable | Refresh token tanpa pemotongan |
| `avatar` | string, nullable | URL foto profil Google |

Jalankan `php artisan migrate` setelah deploy, kemudian mulai ulang login Google. Migration mempertahankan token yang sudah tersimpan. Rollback ke `VARCHAR(255)` ditolak jika ada token yang lebih panjang agar kredensial tidak terpotong.

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
| `app/Auth/GoogleProvider.php` | Payload state terenkripsi dengan nonce dan ID tema |
| `app/Http/Requests/Auth/GoogleRedirectRequest.php` | Validasi dan resolusi tema aktif |
| `app/Providers/AppServiceProvider.php` | Registrasi provider Google aplikasi |
| `config/themes.php` | Konfigurasi tema bawaan |
| `database/migrations/2026_09_19_225653_add_theme_id_to_users_table.php` | Foreign key preferensi tema pengguna |
| `tests/Feature/Auth/GoogleThemePersistenceTest.php` | Pengujian alur tema dan keamanan state |
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

**Penyebab:** Callback tidak memiliki sesi yang memulai login, state berubah, login baru menggantikan state sebelumnya, atau callback sudah dipakai.

**Solusi:** Mulai ulang login dari aplikasi. Periksa domain, HTTPS, cookie sesi, serta `SESSION_DRIVER` dan `SESSION_DOMAIN` agar sesi bertahan saat kembali dari Google. Jangan menonaktifkan validasi dengan `stateless()`; alur web ini memerlukan sesi untuk perlindungan CSRF.

### Error 401: `invalid_client`

**Penyebab:** Client ID atau Client Secret salah.

**Solusi:** Periksa `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` di `.env`.

---

## Referensi

- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
- [Google OAuth 2.0 Documentation](https://developers.google.com/identity/protocols/oauth2/web-server)
- [Google Cloud Console](https://console.cloud.google.com)
