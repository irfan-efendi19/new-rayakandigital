<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class ScratchCardThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.scratch_card'],
            [
                'name' => 'Scratch Card (Karcis Gosok)',
                'thumbnail_portrait' => '/images/themes/scratch-card-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'Golden Ticket Wedding of Dimas & Citra',
                'groom_full_name' => 'Dimas Adiputra, S.T.',
                'groom_short_name' => 'Dimas',
                'groom_father_name' => 'Ir. H. Hendro Adiputra',
                'groom_mother_name' => 'Hj. Endang Suryani',
                'bride_full_name' => 'Citra Kirana Paramita, S.Ds.',
                'bride_short_name' => 'Citra',
                'bride_father_name' => 'Drs. H. Bambang Subagyo',
                'bride_mother_name' => 'Hj. Rina Mardiana',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 45,
                'event_time' => '09:00',
                'event_time_end' => '14:00',
                'venue_name' => 'The Hermitage Grand Pavilion',
                'venue_address' => 'Jl. Cikini Raya No. 45, Menteng, Jakarta Pusat',
                'venue_maps_url' => 'https://maps.google.com/?q=Jakarta',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Dari miliaran kemungkinan di dunia, semesta mempertemukan dua hati yang siap melangkah bersama dalam perjalanan cinta abadi.',
                'stories' => [
                    [
                        'story_date' => '2021',
                        'story_title' => 'Tiket Takdir Pertama',
                        'story_description' => 'Pertemuan tak terduga dalam sebuah pameran seni di mana satu obrolan sederhana menjadi awal dari ribuan senyuman.',
                    ],
                    [
                        'story_date' => '2023',
                        'story_title' => 'Komitmen & Janji Hati',
                        'story_description' => 'Di bawah temaram lampu kota, kami sepakat menyatukan visi hidup dan melangkah menuju jenjang yang lebih bermakna.',
                    ],
                    [
                        'story_date' => '2026',
                        'story_title' => 'The Golden Wedding Day',
                        'story_description' => 'Hari penuh berkah di mana kami mengikrarkan janji suci di hadapan Allah SWT dan seluruh orang-orang terkasih.',
                    ],
                ],
                'gallery_photos' => [],
                'show_video' => false,
                'gift_banks' => [
                    [
                        'bank_name' => 'Bank Central Asia (BCA)',
                        'account_number' => '8410293847',
                        'account_holder' => 'Dimas Adiputra',
                    ],
                    [
                        'bank_name' => 'Bank Mandiri',
                        'account_number' => '1270009847123',
                        'account_holder' => 'Citra Kirana',
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
                        'place_name' => 'Masjid Cut Meutia',
                        'place_address' => 'Jl. Taman Cut Mutiah No. 1, Menteng, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                    [
                        'event_title' => 'Resepsi Karcis Emas',
                        'date_offset_days' => 0,
                        'start_time' => '11:00',
                        'end_time' => '14:00',
                        'is_until_finished' => false,
                        'place_name' => 'The Hermitage Grand Pavilion',
                        'place_address' => 'Jl. Cikini Raya No. 45, Menteng, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                ],
            ]
        );
    }
}
