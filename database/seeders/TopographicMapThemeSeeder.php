<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class TopographicMapThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.topographic_map'],
            [
                'name' => 'Peta Topografi Pendakian Gunung (Topographic Map)',
                'thumbnail_portrait' => '/images/themes/topographic-map-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'Ekspedisi Mahligai Puncak: Arya & Dania — Topographic Wedding Map',
                'groom_full_name' => 'Arya Danuarta, S.Hut.',
                'groom_short_name' => 'Arya',
                'groom_father_name' => 'Bapak Ir. Bambang Danuarta',
                'groom_mother_name' => 'Ibu Dra. Ratna Danuarta',
                'bride_full_name' => 'Dania Larasati, M.Sc.',
                'bride_short_name' => 'Dania',
                'bride_father_name' => 'Bapak H. Hendra Daniswara, S.Si.',
                'bride_mother_name' => 'Ibu Hj. Siti Nurhasanah',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 50,
                'event_time' => '08:30',
                'event_time_end' => '14:30',
                'venue_name' => 'The Summit Peak Glasshouse & Pine Sanctuary',
                'venue_address' => 'Jl. Puncak Asmara No. 77, Kawasan Perbukitan Pinus, Bandung Barat',
                'venue_maps_url' => 'https://maps.google.com/?q=Bandung',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'PANDUAN NAVIGASI KEHIDUPAN // QS. AR-RUM: 21',
                'love_story' => 'Sebuah peta topografi perjalanan cinta yang merekam setiap garis kontur elevasi kehidupan: dari pos perbekalan pertama, terjalnya medan komitmen bersama, hingga akhirnya menancapkan bendera suci sehidup semati di puncak mahligai tertinggi.',
                'stories' => [
                    [
                        'story_date' => 'BASECAMP 2021 — 850 MDPL',
                        'story_title' => 'Titik Awal Ekspedisi (Pertemuan di Pos Mandalawangi)',
                        'story_description' => 'Dalam sebuah pendakian di lereng pinus, langkah kami pertama kali beriringan. Berawal dari berbagi kompas dan air perbekalan, obrolan hangat pun mengalir menembus dinginnya kabut senja.',
                    ],
                    [
                        'story_date' => 'SHELTER 01 — 1.600 MDPL',
                        'story_title' => 'Menyelaraskan Ritme Langkah & Menjaga Komitmen',
                        'story_description' => 'Mendaki bukan tentang siapa yang tercepat, melainkan tentang siapa yang sanggup melangkah bersama. Melalui berbagai dinamika dan tantangan, kami belajar saling menopang dan menjaga asa.',
                    ],
                    [
                        'story_date' => 'SHELTER 02 — 2.200 MDPL',
                        'story_title' => 'Restu Dua Markas Besar (Pertemuan Dua Keluarga)',
                        'story_description' => 'Di hadapan kedua orang tua dan keluarga besar, sebuah cincin komitmen disematkan. Lampu hijau dari dua markas besar menandai dimulainya persiapan pendakian menuju puncak tertinggi.',
                    ],
                    [
                        'story_date' => 'PUNCAK MAHLIGAI — 2.840 MDPL',
                        'story_title' => 'Penancapan Bendera Janji Suci Seumur Hidup',
                        'story_description' => 'Kini garis kontur tertinggi telah kami capai. Di titik puncak mahligai ini, kami mengundang para saksi pendaki terhormat untuk menjadi saksi pengucapan janji suci di hadapan Sang Maha Kuasa.',
                    ],
                ],
                'events' => [
                    [
                        'event_title' => 'Tahap I: Akad Nikah & Penancapan Bendera Janji Suci',
                        'event_date_offset_days' => 50,
                        'start_time' => '08:30',
                        'end_time' => '10:30',
                        'place_name' => 'The Summit Peak Glasshouse — Bukit Pinus',
                        'place_address' => 'Jl. Puncak Asmara No. 77, Kawasan Perbukitan Pinus, Bandung Barat',
                        'google_maps_url' => 'https://maps.google.com/?q=Bandung',
                    ],
                    [
                        'event_title' => 'Tahap II: Resepsi Ekspedisi Puncak & Jamuan Rekan Pendaki',
                        'event_date_offset_days' => 50,
                        'start_time' => '11:30',
                        'end_time' => '14:30',
                        'place_name' => 'The Grand Alpine Conservatory Ballroom',
                        'place_address' => 'Jl. Puncak Asmara No. 77, Kawasan Perbukitan Pinus, Bandung Barat',
                        'google_maps_url' => 'https://maps.google.com/?q=Bandung',
                    ],
                ],
                'gift_banks' => [
                    [
                        'bank_name' => 'Bank BCA (Rekening Logistik Arya)',
                        'account_number' => '8291048591',
                        'account_holder' => 'Arya Danuarta',
                    ],
                    [
                        'bank_name' => 'Bank Mandiri (Rekening Perbekalan Dania)',
                        'account_number' => '1370019284721',
                        'account_holder' => 'Dania Larasati',
                    ],
                ],
                'gift_ewallets' => [
                    [
                        'wallet_name' => 'GoPay',
                        'wallet_number' => '081299887711',
                    ],
                    [
                        'wallet_name' => 'OVO',
                        'wallet_number' => '081299887711',
                    ],
                ],
                'gallery_photos' => [
                    'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1520854221256-17451cc331bf?q=80&w=800&auto=format&fit=crop',
                ],
            ]
        );
    }
}
