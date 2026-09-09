<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class InstagramStoryThemeSeeder extends Seeder
{
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.instagram_story'],
            [
                'name' => 'Instagram Story (Vertikal 9:16)',
                'thumbnail_portrait' => '/images/themes/instagram-story-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'The Wedding Story of Kevin & Sarah',
                'groom_full_name' => 'Kevin Pratama, S.Kom.',
                'groom_short_name' => 'Kevin',
                'groom_father_name' => 'H. Hendra Pratama',
                'groom_mother_name' => 'Hj. Ratna Dewi',
                'bride_full_name' => 'Sarah Amanda, S.Ds.',
                'bride_short_name' => 'Sarah',
                'bride_father_name' => 'H. Bambang Wijaya',
                'bride_mother_name' => 'Hj. Sri Wahyuni',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 30,
                'event_time' => '08:00',
                'event_time_end' => '13:00',
                'venue_name' => 'Grand Ballroom Hotel Indonesia',
                'venue_address' => 'Jl. M.H. Thamrin No. 1, Jakarta Pusat',
                'venue_maps_url' => 'https://maps.google.com/?q=Jakarta',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Berawal dari balasan story yang berujung temu, kami belajar saling melengkapi hingga hari ini siap mengucap janji suci sehidup semati.',
                'stories' => [
                    [
                        'story_date' => '2022',
                        'story_title' => 'First DM & Coffee',
                        'story_description' => 'Percakapan singkat berawal dari reply story Instagram yang berlanjut ke perjumpaan hangat di kedai kopi.',
                    ],
                    [
                        'story_date' => '2024',
                        'story_title' => 'Two Families, One Heart',
                        'story_description' => 'Momen pertemuan dua keluarga besar dengan restu penuh untuk melangkah ke jenjang yang lebih serius.',
                    ],
                    [
                        'story_date' => '2026',
                        'story_title' => 'The Wedding Chapter',
                        'story_description' => 'Hari bahagia kami bersatu dalam ikatan suci pernikahan di hadapan Allah SWT dan seluruh sahabat terkasih.',
                    ],
                ],
                'gallery_photos' => [],
                'show_video' => false,
                'gift_banks' => [
                    [
                        'bank_name' => 'Bank Central Asia (BCA)',
                        'account_number' => '5410982341',
                        'account_holder' => 'Kevin Pratama',
                    ],
                    [
                        'bank_name' => 'Bank Mandiri',
                        'account_number' => '1370018923410',
                        'account_holder' => 'Sarah Amanda',
                    ],
                ],
                'gift_ewallets' => [],
                'events' => [
                    [
                        'event_title' => 'Akad Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '08:00',
                        'end_time' => '10:00',
                        'is_until_finished' => false,
                        'place_name' => 'Masjid Agung Al-Hikmah',
                        'place_address' => 'Jl. M.H. Thamrin No. 1, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                    [
                        'event_title' => 'Resepsi Pernikahan',
                        'date_offset_days' => 0,
                        'start_time' => '11:00',
                        'end_time' => '14:00',
                        'is_until_finished' => false,
                        'place_name' => 'Grand Ballroom Hotel Indonesia',
                        'place_address' => 'Jl. M.H. Thamrin No. 1, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                ],
            ]
        );
    }
}
