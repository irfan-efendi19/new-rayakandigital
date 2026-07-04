<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $elegant = Theme::updateOrCreate(
            ['view_path' => 'themes.elegant'],
            ['name' => 'Elegant Rose', 'thumbnail_portrait' => '/images/themes/elegant-thumb.svg', 'is_premium' => false, 'is_active' => true]
        );

        $modern = Theme::updateOrCreate(
            ['view_path' => 'themes.modern'],
            ['name' => 'Modern Dark', 'thumbnail_portrait' => '/images/themes/modern-thumb.svg', 'is_premium' => false, 'is_active' => true]
        );

        $garden = Theme::updateOrCreate(
            ['view_path' => 'themes.garden'],
            ['name' => 'Garden Green', 'thumbnail_portrait' => '/images/themes/garden-thumb.svg', 'is_premium' => true, 'is_active' => true]
        );

        $themes = [
            $elegant->id => [
                'title' => 'Pernikahan Raisa & Hamish',
                'groom_full_name' => 'Hamish Daud',
                'groom_short_name' => 'Hamish',
                'groom_father_name' => 'Daud',
                'groom_mother_name' => 'Rini',
                'bride_full_name' => 'Raisa Andriana',
                'bride_short_name' => 'Raisa',
                'bride_father_name' => 'Andriana',
                'bride_mother_name' => 'Sari',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 60,
                'event_time' => '09:00',
                'event_time_end' => '15:00',
                'venue_name' => 'Hotel Indonesia Kempinski',
                'venue_address' => 'Jl. M.H. Thamrin No.1, Menteng, Jakarta Pusat 10310',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.1958,106.8225',
                'quote_content' => 'Aku telah mencari cinta sejati sepanjang hidupku, dan akhirnya aku menemukannya di dalam dirimu. Engkau adalah belahan jiwa yang selama ini aku nantikan.',
                'quote_source' => 'Inspirasi Cinta',
                'love_story' => 'Kisah cinta kami dimulai dari sebuah perkenalan singkat di acara musik yang akhirnya bersemi menjadi ikatan suci.',
                'stories' => [
                    ['story_date' => 'Juni 2018', 'story_title' => 'Pertemuan di Festival Musik', 'story_description' => 'Pertama kali bertemu di sebuah festival musik. Sebuah perkenalan yang tidak terduga namun terasa begitu akrab.'],
                    ['story_date' => 'Februari 2020', 'story_title' => 'Menjalin Hubungan', 'story_description' => 'Hubungan kami semakin serius. Saling mendukung dan melengkapi dalam suka maupun duka.'],
                    ['story_date' => 'Oktober 2025', 'story_title' => 'Momen Lamaran', 'story_description' => 'Lamaran yang penuh kejutan dan haru, menjadi awal dari perjalanan baru menuju pernikahan.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/elegant1/800/1200',
                    'https://picsum.photos/seed/elegant2/1200/800',
                    'https://picsum.photos/seed/elegant3/800/1200',
                    'https://picsum.photos/seed/elegant4/1200/800',
                    'https://picsum.photos/seed/elegant5/800/800',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank Mandiri', 'account_number' => '1230004567890', 'account_holder' => 'Raisa Andriana'],
                    ['bank_name' => 'BCA', 'account_number' => '9876543210', 'account_holder' => 'Hamish Daud'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081234567891'],
                    ['wallet_name' => 'OVO', 'wallet_number' => '081234567892'],
                ],
                'events' => [
                    [
                        'event_title' => 'Akad Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '09:00',
                        'end_time' => '11:00',
                        'is_until_finished' => false,
                        'place_name' => 'Hotel Indonesia Kempinski',
                        'place_address' => 'Jl. M.H. Thamrin No.1, Menteng, Jakarta Pusat 10310',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.1958,106.8225',
                    ],
                    [
                        'event_title' => 'Resepsi',
                        'date_offset_days' => 0,
                        'start_time' => '12:00',
                        'end_time' => '15:00',
                        'is_until_finished' => false,
                        'place_name' => 'Hotel Indonesia Kempinski',
                        'place_address' => 'Jl. M.H. Thamrin No.1, Menteng, Jakarta Pusat 10310',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.1958,106.8225',
                    ],
                ],
            ],
            $modern->id => [
                'title' => 'Wedding of Alex & Maya',
                'groom_full_name' => 'Alexander Sebastian',
                'groom_short_name' => 'Alex',
                'groom_father_name' => 'Sebastian',
                'groom_mother_name' => 'Linda',
                'bride_full_name' => 'Maya Indah',
                'bride_short_name' => 'Maya',
                'bride_father_name' => 'Indra',
                'bride_mother_name' => 'Dewi',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 45,
                'event_time' => '18:00',
                'event_time_end' => '22:00',
                'venue_name' => 'The Ritz-Carlton Ballroom',
                'venue_address' => 'Jl. DR. Ide Anak Agung Gde Agung Kav. 1, Jakarta Selatan 12950',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.2303,106.8277',
                'quote_content' => 'Love is not about how many days, months, or years you have been together. Love is about how much you love each other every single day.',
                'quote_source' => 'Anonymous',
                'love_story' => 'Perjalanan cinta kami dimulai dari dunia digital, sebuah pesan singkat yang berubah menjadi percakapan panjang hingga akhirnya bersatu.',
                'stories' => [
                    ['story_date' => 'Maret 2019', 'story_title' => 'Pesan Pertama di Instagram', 'story_description' => 'Sebuah like dan komentar sederhana menjadi awal dari segalanya. Kami mulai berkenalan dan berbincang setiap hari.'],
                    ['story_date' => 'Agustus 2021', 'story_title' => 'Pertemuan Pertama', 'story_description' => 'Setelah dua tahun LDR, akhirnya kami bertemu langsung. Perasaan yang sudah terjalin semakin kuat.'],
                    ['story_date' => 'Januari 2026', 'story_title' => 'Bertunangan', 'story_description' => 'Momen bahagia ketika Alexander melamar di restoran favorit kami dengan pemandangan kota yang indah.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/modern1/800/1200',
                    'https://picsum.photos/seed/modern2/1200/800',
                    'https://picsum.photos/seed/modern3/800/1200',
                    'https://picsum.photos/seed/modern4/1200/800',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank BNI', 'account_number' => '0123456789', 'account_holder' => 'Maya Indah'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'Dana', 'wallet_number' => '081234567893'],
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081234567894'],
                    ['wallet_name' => 'ShopeePay', 'wallet_number' => '081234567895'],
                ],
                'events' => [
                    [
                        'event_title' => 'Pemberkatan Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '16:00',
                        'end_time' => '17:30',
                        'is_until_finished' => false,
                        'place_name' => 'Gereja Katedral Jakarta',
                        'place_address' => 'Jl. Katedral No.7B, Pasar Baru, Jakarta Pusat 10710',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.1674,106.8331',
                    ],
                    [
                        'event_title' => 'Resepsi Malam',
                        'date_offset_days' => 0,
                        'start_time' => '18:00',
                        'end_time' => '22:00',
                        'is_until_finished' => false,
                        'place_name' => 'The Ritz-Carlton Ballroom',
                        'place_address' => 'Jl. DR. Ide Anak Agung Gde Agung Kav. 1, Jakarta Selatan 12950',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2303,106.8277',
                    ],
                ],
            ],
            $garden->id => [
                'title' => 'Pernikahan Sinta & Yoga',
                'groom_full_name' => 'Yoga Pratama',
                'groom_short_name' => 'Yoga',
                'groom_father_name' => 'Pratama',
                'groom_mother_name' => 'Widya',
                'bride_full_name' => 'Sinta Aulia',
                'bride_short_name' => 'Sinta',
                'bride_father_name' => 'Aulia',
                'bride_mother_name' => 'Fitri',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 30,
                'event_time' => '08:00',
                'event_time_end' => '13:00',
                'venue_name' => 'Taman Bunga Nusantara',
                'venue_address' => 'Jl. Raya Puncak No. 1, Cipanas, Cianjur 43253',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.7333,107.0386',
                'quote_content' => 'Dan kami jadikan kamu berpasang-pasangan supaya kamu saling mengenal, saling menyayangi, dan saling melengkapi.',
                'quote_source' => 'QS. Al-Hujurat: 13',
                'love_story' => 'Kisah kami dimulai dari kecintaan yang sama terhadap alam dan bunga. Setiap pertemuan adalah petualangan baru yang penuh warna.',
                'stories' => [
                    ['story_date' => 'Januari 2021', 'story_title' => 'Bertemu di Kebun Raya', 'story_description' => 'Seperti takdir, kami bertemu saat berkunjung ke Kebun Raya Bogor. Berawal dari foto bunga yang sama, kami memulai percakapan.'],
                    ['story_date' => 'Juli 2023', 'story_title' => 'Mendaki Gunung Bersama', 'story_description' => 'Pendakian pertama kami ke Gunung Papandayan memperkuat ikatan. Di puncak, kami berjanji untuk saling setia.'],
                    ['story_date' => 'Februari 2026', 'story_title' => 'Lamaran di Taman Anggrek', 'story_description' => 'Yoga melamar di Taman Anggrek Indonesia Indah dengan latar bunga-bunga yang bermekaran, persis seperti mimpi Sinta.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/garden1/800/1200',
                    'https://picsum.photos/seed/garden2/1200/800',
                    'https://picsum.photos/seed/garden3/800/1200',
                    'https://picsum.photos/seed/garden4/1200/800',
                    'https://picsum.photos/seed/garden5/800/1200',
                    'https://picsum.photos/seed/garden6/800/800',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank Syariah Indonesia', 'account_number' => '7112345678', 'account_holder' => 'Sinta Aulia'],
                    ['bank_name' => 'Bank BRI', 'account_number' => '123401234567', 'account_holder' => 'Yoga Pratama'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081234567896'],
                    ['wallet_name' => 'OVO', 'wallet_number' => '081234567897'],
                ],
                'events' => [
                    [
                        'event_title' => 'Akad Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '08:00',
                        'end_time' => '10:00',
                        'is_until_finished' => false,
                        'place_name' => 'Taman Bunga Nusantara',
                        'place_address' => 'Jl. Raya Puncak No. 1, Cipanas, Cianjur 43253',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.7333,107.0386',
                    ],
                    [
                        'event_title' => 'Resepsi & Taman',
                        'date_offset_days' => 0,
                        'start_time' => '10:30',
                        'end_time' => '13:00',
                        'is_until_finished' => false,
                        'place_name' => 'Taman Bunga Nusantara',
                        'place_address' => 'Jl. Raya Puncak No. 1, Cipanas, Cianjur 43253',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.7333,107.0386',
                    ],
                ],
            ],
        ];

        foreach ($themes as $themeId => $previewData) {
            ThemePreviewData::updateOrCreate(
                ['theme_id' => $themeId],
                $previewData,
            );
        }
    }
}
