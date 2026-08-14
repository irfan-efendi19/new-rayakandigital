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
            ['view_path' => 'themes.jawa'],
            ['name' => 'Jawa', 'thumbnail_portrait' => '/images/themes/jawa-thumb.svg', 'is_premium' => true, 'is_active' => true]
        );

        $sakura = Theme::updateOrCreate(
            ['view_path' => 'themes.sakura'],
            ['name' => 'Sakura', 'thumbnail_portrait' => '/images/themes/sakura-thumb.svg', 'is_premium' => true, 'is_active' => true]
        );

        $whatsapp = Theme::updateOrCreate(
            ['view_path' => 'themes.whatsapp'],
            ['name' => 'WhatsApp Chat', 'thumbnail_portrait' => '/images/themes/whatsapp-thumb.svg', 'is_premium' => false, 'is_active' => true]
        );

        $tinder = Theme::updateOrCreate(
            ['view_path' => 'themes.tinder'],
            ['name' => 'Tinder Match', 'thumbnail_portrait' => '/images/themes/tinder-thumb.svg', 'is_premium' => true, 'is_active' => true]
        );

        $netflix = Theme::updateOrCreate(
            ['view_path' => 'themes.netflix'],
            ['name' => 'Netflix Movie', 'thumbnail_portrait' => '/images/themes/netflix-thumb.svg', 'is_premium' => true, 'is_active' => true]
        );

        $youtube = Theme::updateOrCreate(
            ['view_path' => 'themes.youtube'],
            ['name' => 'YouTube Vlog', 'thumbnail_portrait' => '/images/themes/youtube-thumb.svg', 'is_premium' => true, 'is_active' => true]
        );

        $spotify = Theme::updateOrCreate(
            ['view_path' => 'themes.spotify'],
            ['name' => 'Spotify Music', 'thumbnail_portrait' => '/images/themes/spotify-thumb.svg', 'is_premium' => true, 'is_active' => true]
        );

        $tiktok = Theme::updateOrCreate(
            ['view_path' => 'themes.tiktok'],
            ['name' => 'TikTok FYP', 'thumbnail_portrait' => '/images/themes/tiktok-thumb.svg', 'is_premium' => true, 'is_active' => true]
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
            $sakura->id => [
                'title' => 'Pernikahan Sakura & Kenji',
                'groom_full_name' => 'Kenji Pratama',
                'groom_short_name' => 'Kenji',
                'groom_father_name' => 'Pratama',
                'groom_mother_name' => 'Widya',
                'bride_full_name' => 'Sakura Hanako',
                'bride_short_name' => 'Sakura',
                'bride_father_name' => 'Hanako',
                'bride_mother_name' => 'Larasati',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 45,
                'event_time' => '09:00',
                'event_time_end' => '14:00',
                'venue_name' => 'Grand Sakura Ballroom',
                'venue_address' => 'Jl. Boulevard Utama No. 88, Jakarta',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.2000,106.8166',
                'quote_content' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Kisah manis kami bermula saat musim mekarnya bunga sakura. Sebuah momen indah yang membawa kami melangkah bersama menuju pernikahan.',
                'stories' => [
                    ['story_date' => 'Maret 2022', 'story_title' => 'Awal Mula Bertemu', 'story_description' => 'Pertemuan pertama kami di bawah rindangnya pepohonan saat musim semi.'],
                    ['story_date' => 'Desember 2024', 'story_title' => 'Momen Lamaran', 'story_description' => 'Kenji memberikan kejutan romantis dan meminta Sakura untuk menemani hidupnya selamanya.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/sakura1/800/1200',
                    'https://picsum.photos/seed/sakura2/1200/800',
                    'https://picsum.photos/seed/sakura3/800/1200',
                    'https://picsum.photos/seed/sakura4/1200/800',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank BCA', 'account_number' => '8830123456', 'account_holder' => 'Sakura Hanako'],
                    ['bank_name' => 'Bank Mandiri', 'account_number' => '1370009876543', 'account_holder' => 'Kenji Pratama'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081299887766'],
                ],
                'events' => [
                    [
                        'event_title' => 'Akad Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '09:00',
                        'end_time' => '11:00',
                        'is_until_finished' => false,
                        'place_name' => 'Grand Sakura Ballroom',
                        'place_address' => 'Jl. Boulevard Utama No. 88, Jakarta',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2000,106.8166',
                    ],
                    [
                        'event_title' => 'Resepsi Pernikahan',
                        'date_offset_days' => 0,
                        'start_time' => '11:30',
                        'end_time' => '14:00',
                        'is_until_finished' => false,
                        'place_name' => 'Grand Sakura Ballroom',
                        'place_address' => 'Jl. Boulevard Utama No. 88, Jakarta',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2000,106.8166',
                    ],
                ],
            ],
            $whatsapp->id => [
                'title' => 'Pernikahan Rina & Budi',
                'groom_full_name' => 'Budi Santoso',
                'groom_short_name' => 'Budi',
                'groom_father_name' => 'Santoso',
                'groom_mother_name' => 'Sari',
                'bride_full_name' => 'Rina Wati',
                'bride_short_name' => 'Rina',
                'bride_father_name' => 'Wibowo',
                'bride_mother_name' => 'Dewi',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 30,
                'event_time' => '08:00',
                'event_time_end' => '14:00',
                'venue_name' => 'Masjid Istiqlal Jakarta',
                'venue_address' => 'Jl. Taman Wijaya Kusuma, Ps. Baru, Jakarta Pusat',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.1700,106.8331',
                'quote_content' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Kisah cinta kami dimulai dari sebuah percakapan sederhana di WhatsApp yang akhirnya membawa kami ke pelaminan. Seperti chat yang tak pernah habis, cinta kami terus berlanjut.',
                'stories' => [
                    ['story_date' => 'Januari 2023', 'story_title' => 'Chat Pertama di WhatsApp', 'story_description' => 'Sebuah pesan singkat yang tidak terduga menjadi awal dari segalanya. Kami mulai berbalas pesan setiap hari.'],
                    ['story_date' => 'Juni 2024', 'story_title' => 'Pertemuan Langsung', 'story_description' => 'Setelah berbulan-bulan berkenalan lewat chat, akhirnya kami bertemu langsung. Perasaan yang sudah terjalin semakin kuat.'],
                    ['story_date' => 'Maret 2026', 'story_title' => 'Lamaran via Video Call', 'story_description' => 'Karena jarak, Budi melamar Rina melalui video call yang penuh haru. Rina mengangguk dengan air mata bahagia.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/whatsapp1/800/1200',
                    'https://picsum.photos/seed/whatsapp2/1200/800',
                    'https://picsum.photos/seed/whatsapp3/800/1200',
                    'https://picsum.photos/seed/whatsapp4/1200/800',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank BCA', 'account_number' => '1234567890', 'account_holder' => 'Rina Wati'],
                    ['bank_name' => 'Bank Mandiri', 'account_number' => '0987654321', 'account_holder' => 'Budi Santoso'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081234567890'],
                    ['wallet_name' => 'OVO', 'wallet_number' => '081234567891'],
                ],
                'events' => [
                    [
                        'event_title' => 'Akad Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '08:00',
                        'end_time' => '10:00',
                        'is_until_finished' => false,
                        'place_name' => 'Masjid Istiqlal Jakarta',
                        'place_address' => 'Jl. Taman Wijaya Kusuma, Ps. Baru, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.1700,106.8331',
                    ],
                    [
                        'event_title' => 'Resepsi',
                        'date_offset_days' => 0,
                        'start_time' => '11:00',
                        'end_time' => '14:00',
                        'is_until_finished' => false,
                        'place_name' => 'Hotel Borobudur Jakarta',
                        'place_address' => 'Jl. Lapangan Banteng Timur No. 1, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.1700,106.8331',
                    ],
                ],
            ],
            $tinder->id => [
                'title' => 'Pernikahan Kevin & Vania',
                'groom_full_name' => 'Kevin Pratama',
                'groom_short_name' => 'Kevin',
                'groom_father_name' => 'Pratama',
                'groom_mother_name' => 'Lestari',
                'bride_full_name' => 'Vania Aurelia',
                'bride_short_name' => 'Vania',
                'bride_father_name' => 'Aurelius',
                'bride_mother_name' => 'Megawati',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 40,
                'event_time' => '09:00',
                'event_time_end' => '15:00',
                'venue_name' => 'Glass House Senayan',
                'venue_address' => 'Jl. Asia Afrika No. 8, Gelora, Jakarta Pusat',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.2185,106.8018',
                'quote_content' => 'It was a match from the very first swipe, but a love that will last a lifetime.',
                'quote_source' => 'Kevin & Vania',
                'love_story' => 'Semua berawal dari swipe kanan di aplikasi kencan. Percakapan santai berubah menjadi cinta sejati yang bermuara di pelaminan.',
                'stories' => [
                    ['story_date' => 'Maret 2023', 'story_title' => 'It’s a Match! 🔥', 'story_description' => 'Swipe kanan yang mengubah takdir. Kami mulai mengobrol berjam-jam tentang musik dan kopi.'],
                    ['story_date' => 'Desember 2024', 'story_title' => 'Kencan Pertama', 'story_description' => 'Pertemuan langsung pertama di kafe favorit di Senopati.'],
                    ['story_date' => 'Januari 2026', 'story_title' => 'Lamaran Romantis', 'story_description' => 'Kevin melamar Vania saat liburan bersama di Bali.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/tinder1/800/1200',
                    'https://picsum.photos/seed/tinder2/1200/800',
                    'https://picsum.photos/seed/tinder3/800/1200',
                    'https://picsum.photos/seed/tinder4/1200/800',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank BCA', 'account_number' => '5432109876', 'account_holder' => 'Vania Aurelia'],
                    ['bank_name' => 'Bank Mandiri', 'account_number' => '1234567890123', 'account_holder' => 'Kevin Pratama'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081234567800'],
                    ['wallet_name' => 'OVO', 'wallet_number' => '081234567801'],
                ],
                'events' => [
                    [
                        'event_title' => 'Pemberkatan Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '09:00',
                        'end_time' => '11:00',
                        'is_until_finished' => false,
                        'place_name' => 'Glass House Senayan',
                        'place_address' => 'Jl. Asia Afrika No. 8, Gelora, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2185,106.8018',
                    ],
                    [
                        'event_title' => 'Resepsi Malam',
                        'date_offset_days' => 0,
                        'start_time' => '18:00',
                        'end_time' => '21:00',
                        'is_until_finished' => false,
                        'place_name' => 'Glass House Senayan',
                        'place_address' => 'Jl. Asia Afrika No. 8, Gelora, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2185,106.8018',
                    ],
                ],
            ],
            $netflix->id => [
                'title' => 'Pernikahan Nicholas & Dian (Netflix Wedding Special)',
                'groom_full_name' => 'Nicholas Saputra',
                'groom_short_name' => 'Nicholas',
                'groom_father_name' => 'Saputra',
                'groom_mother_name' => 'Helena',
                'bride_full_name' => 'Dian Sastrowardoyo',
                'bride_short_name' => 'Dian',
                'bride_father_name' => 'Sastrowardoyo',
                'bride_mother_name' => 'Dewi',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 35,
                'event_time' => '10:00',
                'event_time_end' => '16:00',
                'venue_name' => 'Plataran Dharmawangsa Jakarta',
                'venue_address' => 'Jl. Dharmawangsa Raya No. 6, Kebayoran Baru, Jakarta Selatan',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.2555,106.7972',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Sebuah kisah tentang dua hati yang dipertemukan oleh takdir, melewati berbagai episode kehidupan, hingga akhirnya memutuskan untuk menuliskan babak abadi bersama.',
                'stories' => [
                    ['story_date' => 'Season 1 - 2021', 'story_title' => 'Pertemuan Tak Terduga', 'story_description' => 'Pertemuan perdana di lokasi syuting dan proyek kreatif yang membuka lembaran cerita baru.'],
                    ['story_date' => 'Season 2 - 2023', 'story_title' => 'Menemukan Frekuensi Sama', 'story_description' => 'Menjalani hari-hari bersama, saling mendukung karya, mimpi, dan keluarga.'],
                    ['story_date' => 'Season 3 - 2026', 'story_title' => 'The Grand Proposal', 'story_description' => 'Sebuah komitmen suci di puncak bukit saat senja menyapa, melangkah menuju pelaminan.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/netflix1/1200/800',
                    'https://picsum.photos/seed/netflix2/800/1200',
                    'https://picsum.photos/seed/netflix3/1200/800',
                    'https://picsum.photos/seed/netflix4/800/1200',
                    'https://picsum.photos/seed/netflix5/1200/800',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank BCA', 'account_number' => '8899001122', 'account_holder' => 'Dian Sastrowardoyo'],
                    ['bank_name' => 'Bank Mandiri', 'account_number' => '1370009871234', 'account_holder' => 'Nicholas Saputra'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081299881122'],
                    ['wallet_name' => 'OVO', 'wallet_number' => '081299883344'],
                ],
                'events' => [
                    [
                        'event_title' => 'Episode 1: Akad Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '10:00',
                        'end_time' => '12:00',
                        'is_until_finished' => false,
                        'place_name' => 'Plataran Dharmawangsa Jakarta',
                        'place_address' => 'Jl. Dharmawangsa Raya No. 6, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2555,106.7972',
                    ],
                    [
                        'event_title' => 'Episode 2: Grand Reception',
                        'date_offset_days' => 0,
                        'start_time' => '13:00',
                        'end_time' => '16:00',
                        'is_until_finished' => false,
                        'place_name' => 'Plataran Dharmawangsa Jakarta',
                        'place_address' => 'Jl. Dharmawangsa Raya No. 6, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2555,106.7972',
                    ],
                ],
            ],
            $youtube->id => [
                'title' => 'The Wedding Vlog of Raffi & Nagita (RayaTube Special)',
                'groom_full_name' => 'Raffi Ahmad',
                'groom_short_name' => 'Raffi',
                'groom_father_name' => 'Munawar',
                'groom_mother_name' => 'Amy',
                'bride_full_name' => 'Nagita Slavina',
                'bride_short_name' => 'Gigi',
                'bride_father_name' => 'Gideon',
                'bride_mother_name' => 'Rieta',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 28,
                'event_time' => '09:00',
                'event_time_end' => '15:00',
                'venue_name' => 'The Westin Jakarta Grand Ballroom',
                'venue_address' => 'Jl. H.R. Rasuna Said Kav. C-22A, Karet Kuningan, Jakarta Selatan',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.2241,106.8315',
                'quote_content' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan-pasangan dari jenismu sendiri, supaya kamu merasa tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Dari sebuah kolaborasi konten vlog biasa yang tak disangka berlanjut hingga ke jenjang pelaminan. Inilah perjalanan cinta kami yang kini resmi menjadi satu channel seumur hidup.',
                'stories' => [
                    ['story_date' => 'Video #1 - 2022', 'story_title' => 'First Collab Vlog 📹', 'story_description' => 'Pertama kali membuat konten video bersama. Chemistry yang awalnya hanya di depan kamera ternyata berlanjut ke dunia nyata.'],
                    ['story_date' => 'Video #2 - 2024', 'story_title' => 'Official Going Out 💕', 'story_description' => 'Memutuskan untuk menjalin hubungan serius dan saling mendukung setiap langkah karir dan impian.'],
                    ['story_date' => 'Video #3 - 2026', 'story_title' => 'She Said YES! 💍', 'story_description' => 'Momen kejutan lamaran paling berkesan di tepi pantai saat matahari terbenam.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/yt1/800/1200',
                    'https://picsum.photos/seed/yt2/800/1200',
                    'https://picsum.photos/seed/yt3/800/1200',
                    'https://picsum.photos/seed/yt4/800/1200',
                    'https://picsum.photos/seed/yt5/800/1200',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank BCA', 'account_number' => '7788990011', 'account_holder' => 'Nagita Slavina'],
                    ['bank_name' => 'Bank Mandiri', 'account_number' => '1370001234567', 'account_holder' => 'Raffi Ahmad'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081277889900'],
                    ['wallet_name' => 'OVO', 'wallet_number' => '081277889911'],
                ],
                'events' => [
                    [
                        'event_title' => 'Chapter 1: Akad Nikah / Ijab Qabul',
                        'date_offset_days' => 0,
                        'start_time' => '09:00',
                        'end_time' => '11:30',
                        'is_until_finished' => false,
                        'place_name' => 'The Westin Jakarta Grand Ballroom',
                        'place_address' => 'Jl. H.R. Rasuna Said Kav. C-22A, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2241,106.8315',
                    ],
                    [
                        'event_title' => 'Chapter 2: Grand Wedding Reception',
                        'date_offset_days' => 0,
                        'start_time' => '12:30',
                        'end_time' => '15:30',
                        'is_until_finished' => false,
                        'place_name' => 'The Westin Jakarta Grand Ballroom',
                        'place_address' => 'Jl. H.R. Rasuna Said Kav. C-22A, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2241,106.8315',
                    ],
                ],
            ],
            $spotify->id => [
                'title' => 'The Wedding Album of Afgan & Isyana (Spotify Edition)',
                'groom_full_name' => 'Afgansyah Reza',
                'groom_short_name' => 'Afgan',
                'groom_father_name' => 'Reza',
                'groom_mother_name' => 'Lola',
                'bride_full_name' => 'Isyana Sarasvati',
                'bride_short_name' => 'Isyana',
                'bride_father_name' => 'Sarasvati',
                'bride_mother_name' => 'Luana',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 30,
                'event_time' => '10:00',
                'event_time_end' => '16:00',
                'venue_name' => 'Fairmont Jakarta Grand Ballroom',
                'venue_address' => 'Jl. Asia Afrika No. 8, Gelora, Tanah Abang, Jakarta Pusat',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.2215,106.7995',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Dua musisi yang disatukan oleh nada dan melodi cinta. Dari panggung musik dan studio rekaman, kini kami siap melantunkan simfoni terindah sepanjang masa.',
                'stories' => [
                    ['story_date' => 'Track 1 - 2021', 'story_title' => 'Harmony in the Studio 🎙️', 'story_description' => 'Pertemuan pertama saat kolaborasi rekaman lagu duet yang menggetarkan hati.'],
                    ['story_date' => 'Track 2 - 2023', 'story_title' => 'The Duet of a Lifetime 🎵', 'story_description' => 'Menyadari bahwa nada kehidupan kami berdua beresonansi pada frekuensi yang sama.'],
                    ['story_date' => 'Track 3 - 2026', 'story_title' => 'Encore & The Ring 💍', 'story_description' => 'Momen lamaran manis diiringi alunan piano lembut di bawah gemerlap bintang.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/sp1/800/1200',
                    'https://picsum.photos/seed/sp2/800/1200',
                    'https://picsum.photos/seed/sp3/800/1200',
                    'https://picsum.photos/seed/sp4/800/1200',
                    'https://picsum.photos/seed/sp5/800/1200',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank BCA', 'account_number' => '6677889900', 'account_holder' => 'Isyana Sarasvati'],
                    ['bank_name' => 'Bank Mandiri', 'account_number' => '1370005544332', 'account_holder' => 'Afgansyah Reza'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081266778899'],
                    ['wallet_name' => 'OVO', 'wallet_number' => '081266778800'],
                ],
                'events' => [
                    [
                        'event_title' => 'Track 1: Akad Nikah / Sacred Vows',
                        'date_offset_days' => 0,
                        'start_time' => '10:00',
                        'end_time' => '12:00',
                        'is_until_finished' => false,
                        'place_name' => 'Fairmont Jakarta Grand Ballroom',
                        'place_address' => 'Jl. Asia Afrika No. 8, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2215,106.7995',
                    ],
                    [
                        'event_title' => 'Track 2: Wedding Gala Concert & Reception',
                        'date_offset_days' => 0,
                        'start_time' => '13:00',
                        'end_time' => '16:00',
                        'is_until_finished' => false,
                        'place_name' => 'Fairmont Jakarta Grand Ballroom',
                        'place_address' => 'Jl. Asia Afrika No. 8, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2215,106.7995',
                    ],
                ],
            ],
            $tiktok->id => [
                'title' => 'TikTok Wedding: Thariq & Aaliyah #HalalGoals',
                'groom_full_name' => 'Thariq Halilintar',
                'groom_short_name' => 'Thariq',
                'groom_father_name' => 'Halilintar',
                'groom_mother_name' => 'Lenggogeni',
                'bride_full_name' => 'Aaliyah Massaid',
                'bride_short_name' => 'Aaliyah',
                'bride_father_name' => 'Adjie',
                'bride_mother_name' => 'Reza',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 20,
                'event_time' => '09:00',
                'event_time_end' => '16:00',
                'venue_name' => 'Hotel Raffles Jakarta Grand Ballroom',
                'venue_address' => 'Ciputra World 1, Jl. Prof. DR. Satrio No. 3-5, Karet Kuningan, Jakarta Selatan',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.2243,106.8229',
                'quote_content' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan-pasangan dari jenismu sendiri, supaya kamu merasa tenteram kepadanya.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Dari FYP TikTok dan trending topic, hingga janji suci di pelaminan yang viral di hati kita berdua selamanya.',
                'stories' => [
                    ['story_date' => 'TikTok Post #1', 'story_title' => 'First Stitch & Duet 📱', 'story_description' => 'Pertama kali berinteraksi lewat video viral dan saling follow akun media sosial.'],
                    ['story_date' => 'TikTok Post #2', 'story_title' => 'Official Dating Content 💕', 'story_description' => 'Memulai perjalanan romantis bersama dan saling mendukung impian masing-masing.'],
                    ['story_date' => 'TikTok Post #3', 'story_title' => 'She Said YES (Viral Proposal) 💍', 'story_description' => 'Momen lamaran paling manis di tengah hamparan bunga lavender yang abadi.'],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/tt1/800/1200',
                    'https://picsum.photos/seed/tt2/800/1200',
                    'https://picsum.photos/seed/tt3/800/1200',
                    'https://picsum.photos/seed/tt4/800/1200',
                    'https://picsum.photos/seed/tt5/800/1200',
                ],
                'gift_banks' => [
                    ['bank_name' => 'Bank BCA', 'account_number' => '5544332211', 'account_holder' => 'Aaliyah Massaid'],
                    ['bank_name' => 'Bank Mandiri', 'account_number' => '1370009988776', 'account_holder' => 'Thariq Halilintar'],
                ],
                'gift_ewallets' => [
                    ['wallet_name' => 'GoPay', 'wallet_number' => '081255443322'],
                    ['wallet_name' => 'OVO', 'wallet_number' => '081255443311'],
                ],
                'events' => [
                    [
                        'event_title' => 'Akad Nikah / Ijab Qabul',
                        'date_offset_days' => 0,
                        'start_time' => '09:00',
                        'end_time' => '11:00',
                        'is_until_finished' => false,
                        'place_name' => 'Hotel Raffles Jakarta Grand Ballroom',
                        'place_address' => 'Jl. Prof. DR. Satrio No. 3-5, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2243,106.8229',
                    ],
                    [
                        'event_title' => 'Grand Wedding Reception',
                        'date_offset_days' => 0,
                        'start_time' => '12:30',
                        'end_time' => '16:00',
                        'is_until_finished' => false,
                        'place_name' => 'Hotel Raffles Jakarta Grand Ballroom',
                        'place_address' => 'Jl. Prof. DR. Satrio No. 3-5, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.2243,106.8229',
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
