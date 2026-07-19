# Product Requirement Document (PRD)

## Enterprise Performance Architecture & Optimization (Laravel Core System Wide)

| Atribut               | Detail                                                                           |
| :-------------------- | :------------------------------------------------------------------------------- |
| **Status**            | Approved                                                                         |
| **Penulis**           | Mochammad Irfan Efendi                                                           |
| **Tanggal Pembuatan** | 20 Juli 2026                                                                     |
| **Cakupan Sistem**    | Seluruh Subsistem Laravel (Core Backend, Database, Filament Admin, & Guest View) |
| **Objektif Utama**    | Global RAM Efficiency, Zero Database Overhead, Maximum Request Per Second (RPS)  |

---

## 1. STRATEGI ALOKASI RAM & DATABASE (DATABASE LAYER)

Beban terbesar pada aplikasi berbasis Laravel adalah alokasi memori objek Eloquent dan I/O _database_. Seluruh komponen aplikasi wajib mematuhi standar kueri berikut.

### 1.1 Larangan Total Kueri N+1 & Lazy Loading

Sistem wajib menolak kueri yang dipanggil berulang di dalam sebuah perulangan data. Mekanisme pengujian otomatis (QA) harus memastikan hal ini bersih di semua modul (Undangan, Buku Tamu, Galeri, dan Pembayaran).

- **Aturan Dasar:** Selalu definisikan relasi di awal menggunakan metode `with()` (_Eager Loading_).
- **Keamanan Ekstrem:** Aktifkan proteksi _Lazy Loading_ pada _AppServiceProvider_ di lingkungan lokal/testing agar sistem langsung memicu _error_ jika ada _developer_ yang tidak sengaja menulis kueri tidak efisien.

```php
// app/Providers/AppServiceProvider.php
public function boot(): void
{
    // Memicu crash di lokal jika terjadi kueri N+1 secara tidak sengaja
    Model::preventLazyLoading(! app()->isProduction());
}
```
