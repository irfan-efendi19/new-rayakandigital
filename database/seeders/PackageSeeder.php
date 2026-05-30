<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PlatformFeature;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['feature_key' => 'basic_theme', 'feature_name' => '2 Pilihan Tema Dasar', 'description' => 'Akses ke tema dasar platform'],
            ['feature_key' => 'all_themes', 'feature_name' => 'Semua Pilihan Tema', 'description' => 'Akses ke semua tema termasuk premium'],
            ['feature_key' => 'gallery_photos', 'feature_name' => 'Foto Galeri', 'description' => 'Unggah foto ke galeri undangan'],
            ['feature_key' => 'custom_music', 'feature_name' => 'Upload Musik Custom', 'description' => 'Unggah lagu favorit sebagai latar undangan'],
            ['feature_key' => 'digital_gift', 'feature_name' => 'Digital Gift / Angpao', 'description' => 'Fitur amplop digital dan QRIS'],
            ['feature_key' => 'multi_gift', 'feature_name' => 'Multi-Akun Gift & QRIS', 'description' => 'Banyak akun transfer dan QRIS'],
            ['feature_key' => 'unlimited_gift', 'feature_name' => 'Gift & QRIS Unlimited', 'description' => 'Akun gift dan QRIS tanpa batas'],
            ['feature_key' => 'guest_import', 'feature_name' => 'Import Tamu (Excel)', 'description' => 'Import daftar tamu dari file Excel'],
            ['feature_key' => 'unlimited_guests', 'feature_name' => 'Import Tamu Unlimited', 'description' => 'Import tamu tanpa batas dari Excel'],
            ['feature_key' => 'rsvp', 'feature_name' => 'Manajemen RSVP', 'description' => 'Konfirmasi kehadiran tamu otomatis'],
            ['feature_key' => 'personal_link', 'feature_name' => 'Link Personal per Tamu', 'description' => 'Link undangan personal untuk setiap tamu'],
            ['feature_key' => 'wa_template', 'feature_name' => 'Template Pesan WhatsApp', 'description' => 'Template pesan otomatis untuk undangan'],
            ['feature_key' => 'no_watermark', 'feature_name' => 'Tanpa Watermark', 'description' => 'Hilangkan watermark dari halaman undangan'],
            ['feature_key' => 'custom_css', 'feature_name' => 'Custom CSS / Tema Custom', 'description' => 'Kustomisasi CSS dan tema sesuai keinginan'],
            ['feature_key' => 'eo_branding', 'feature_name' => 'Custom Branding EO', 'description' => 'Branding khusus untuk Event Organizer'],
            ['feature_key' => 'multi_quota', 'feature_name' => 'Multi-Quota Undangan', 'description' => 'Buat banyak undangan dalam satu paket'],
            ['feature_key' => 'real_time_guestbook', 'feature_name' => 'Buku Tamu Real-time', 'description' => 'Buku tamu interaktif real-time'],
            ['feature_key' => 'qr_checkin', 'feature_name' => 'QR Code Check-In', 'description' => 'Scan QR code untuk check-in tamu'],
        ];

        foreach ($features as $f) {
            PlatformFeature::firstOrCreate(
                ['feature_key' => $f['feature_key']],
                $f
            );
        }

        $freeFeatureKeys = ['basic_theme', 'gallery_photos', 'rsvp', 'personal_link', 'wa_template', 'real_time_guestbook'];
        $silverFeatureKeys = array_merge($freeFeatureKeys, ['digital_gift', 'guest_import']);
        $goldFeatureKeys = array_merge($silverFeatureKeys, ['all_themes', 'multi_gift', 'custom_music', 'unlimited_guests', 'no_watermark']);
        $platinumFeatureKeys = array_merge($goldFeatureKeys, ['unlimited_gift', 'custom_css', 'eo_branding', 'multi_quota', 'qr_checkin']);

        $packages = [
            [
                'package_code' => 'free',
                'package_name' => 'Free',
                'price' => 0,
                'slashed_price' => null,
                'active_period_days' => 3,
                'description' => 'Cocok untuk mencoba sistem undangan digital. Nikmati fitur dasar gratis selama 3 hari.',
                'is_visible' => true,
                'is_popular' => false,
                'sort_order' => 0,
                'features' => $freeFeatureKeys,
            ],
            [
                'package_code' => 'silver',
                'package_name' => 'Silver',
                'price' => 49000,
                'slashed_price' => 99000,
                'active_period_days' => 90,
                'description' => 'Untuk acara minimalis dan sederhana. Dapatkan lebih banyak fitur dan masa aktif 3 bulan.',
                'is_visible' => true,
                'is_popular' => false,
                'sort_order' => 1,
                'features' => $silverFeatureKeys,
            ],
            [
                'package_code' => 'gold',
                'package_name' => 'Gold',
                'price' => 99000,
                'slashed_price' => 199000,
                'active_period_days' => 365,
                'description' => 'Paling diminati calon pengantin. Semua fitur lengkap dengan masa aktif 1 tahun penuh.',
                'is_visible' => true,
                'is_popular' => true,
                'sort_order' => 2,
                'features' => $goldFeatureKeys,
            ],
            [
                'package_code' => 'platinum',
                'package_name' => 'Platinum',
                'price' => 299000,
                'slashed_price' => 499000,
                'active_period_days' => 0,
                'description' => 'Untuk Event Organizer profesional. Fitur lengkap tanpa batas dengan akses seumur hidup.',
                'is_visible' => true,
                'is_popular' => false,
                'sort_order' => 3,
                'features' => $platinumFeatureKeys,
            ],
        ];

        foreach ($packages as $pkg) {
            $features = $pkg['features'];
            unset($pkg['features']);

            $package = Package::firstOrCreate(
                ['package_code' => $pkg['package_code']],
                $pkg
            );

            $featureIds = PlatformFeature::whereIn('feature_key', $features)->pluck('id');
            $package->features()->sync($featureIds);
        }
    }
}
