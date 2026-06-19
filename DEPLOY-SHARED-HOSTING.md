# Panduan Deploy Rayakan Digital di Shared Hosting

## Persyaratan Server

### PHP
- **PHP ^8.3** (8.3 atau 8.4)
- Ekstensi wajib:
  - `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `gd`, `gmp`
  - `iconv`, `intl`, `json`, `mbstring`, `mysqli`, `openssl`
  - `pdo`, `pdo_mysql`, `session`, `simplexml`, `sodium`
  - `tokenizer`, `xml`, `zip`, `zlib`

### Database
- MySQL 5.7+ atau MariaDB 10.3+

---

## Struktur Folder di Shared Hosting

Letakkan **seluruh project** satu level di atas `public_html`:

```
/home/user/
  ├── rayakandigital/          # Seluruh project Laravel
  │   ├── app/
  │   ├── bootstrap/
  │   ├── config/
  │   ├── database/
  │   ├── public/
  │   ├── resources/
  │   ├── routes/
  │   ├── storage/
  │   ├── vendor/
  │   ├── .env
  │   └── artisan
  └── public_html/              -> symlink ke rayakandigital/public
```

Buat symlink agar `public_html` mengarah ke folder `public`:

```bash
cd /home/user
mv public_html public_html_backup   # backup dulu
ln -s /home/user/rayakandigital/public public_html
```

> Jika penyedia hosting tidak mendukung symlink, lihat **Alternatif tanpa symlink** di bawah.

---

## Langkah Deploy

### 1. Upload File

Upload seluruh folder project (kecuali `node_modules`, `.env`, `storage`) ke `/home/user/rayakandigital/`.

### 2. Konfigurasi .env

Copy `.env.example` menjadi `.env` dan sesuaikan:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...                         # generate dengan langkah #3
APP_URL=https://domainanda.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=mail.domainanda.com
MAIL_PORT=587
MAIL_USERNAME=noreply@domainanda.com
MAIL_PASSWORD=password_email
MAIL_FROM_ADDRESS=noreply@domainanda.com
MAIL_FROM_NAME="Rayakan Digital"

GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...

MIDTRANS_SERVER_KEY=...
MIDTRANS_CLIENT_KEY=...
MIDTRANS_IS_PRODUCTION=true

WHATSAPP_API_URL=...
WHATSAPP_API_KEY=...
```

### 3. Generate APP_KEY

```bash
cd /home/user/rayakandigital
php artisan key:generate
```

### 4. Install Composer (Production)

```bash
composer install --optimize-autoloader --no-dev
```

### 5. Build Assets (Lokal)

Jalankan di komputer lokal/dev, lalu upload folder `public/build/` ke server:

```bash
npm install
npm run build
```

### 6. Storage Link

```bash
php artisan storage:link
```

Jika `storage:link` gagal karena tidak ada akses shell, buat symlink manual via cPanel File Manager atau SSH:

```bash
ln -s /home/user/rayakandigital/storage/app/public /home/user/rayakandigital/public/storage
```

### 7. Migrasi Database

```bash
php artisan migrate
```

### 8. Cache Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan filament:upgrade
```

### 9. Permission

```bash
chmod -R 775 storage bootstrap/cache
chmod -R 775 public/build
```

---

## Cron Job

Tambahkan cron job via cPanel atau crontab:

```cron
* * * * * /usr/bin/php /home/user/rayakandigital/artisan schedule:run >> /dev/null 2>&1
* * * * * /usr/bin/php /home/user/rayakandigital/artisan queue:work --stop-when-empty --tries=3 --max-time=30 >> /dev/null 2>&1
```

---

## Alternatif Tanpa Symlink

Jika hosting tidak mendukung symlink:

1. Upload seluruh project ke `/home/user/rayakandigital/`
2. Kosongkan folder `public_html/`
3. Pindahkan isi `public/` ke `public_html/`:
   - `.htaccess`
   - `index.php`
   - `build/`
   - `storage/` (symlink, lihat langkah 6)
   - File/folder lain di `public/`
4. Edit `public_html/index.php`:

```php
<?php
require __DIR__.'/../rayakandigital/vendor/autoload.php';
$app = require_once __DIR__.'/../rayakandigital/bootstrap/app.php';
```

---

## Troubleshooting

### 500 Server Error
- Cek `storage/logs/laravel.log`
- Pastikan permission `storage/` dan `bootstrap/cache/` sudah 775
- Pastikan PHP ekstensi terinstall semua

### Storage Link Tidak Bisa Diakses
- Upload manual isi `storage/app/public/` ke folder yang bisa diakses web
- Sesuaikan `config/filesystems.php` untuk menggunakan path absolut

### White Screen / Tidak Ada Output
- Set `APP_DEBUG=true` sementara untuk melihat error
- Cek versi PHP (minimal 8.3)
- Cek file `public/index.php` path-nya benar

### Queue Tidak Berjalan
- Pastikan cron job sudah ditambahkan
- Cek tabel `jobs` di database
- Jalankan manual: `php artisan queue:work --stop-when-empty`

---

## Checklist

- [ ] PHP 8.3+ dan semua ekstensi terinstall
- [ ] Database MySQL sudah dibuat
- [ ] `.env` sudah diisi lengkap
- [ ] `APP_KEY` sudah digenerate
- [ ] `composer install --optimize-autoloader --no-dev` sudah jalan
- [ ] `npm run build` sudah jalan dan `public/build/` terupload
- [ ] Storage symlink sudah dibuat
- [ ] Migrasi sudah jalan
- [ ] Config/route/view cache sudah dijalankan
- [ ] Permission sudah benar (775 storage, bootstrap/cache)
- [ ] Cron job sudah ditambahkan
- [ ] `APP_DEBUG=false` dan `APP_ENV=production`
