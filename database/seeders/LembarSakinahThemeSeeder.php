<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class LembarSakinahThemeSeeder extends Seeder
{
    public function run(): void
    {
        $theme = Theme::firstOrCreate(
            ['view_path' => 'themes.lembar_sakinah'],
            ['name' => 'Lembar Sakinah — Undangan Islami Swipe', 'thumbnail_portrait' => '/images/themes/lembar-sakinah-thumb.svg', 'is_premium' => true, 'is_active' => true],
        );

        ThemePreviewData::firstOrCreate(['theme_id' => $theme->id], [
            'title' => 'Walimatul ‘Ursy — Rayhan & Aisyah',
            'groom_full_name' => 'Muhammad Rayhan',
            'groom_short_name' => 'Rayhan',
            'groom_father_name' => 'H. Abdullah',
            'groom_mother_name' => 'Hj. Maryam',
            'bride_full_name' => 'Siti Aisyah',
            'bride_short_name' => 'Aisyah',
            'bride_father_name' => 'H. Ahmad',
            'bride_mother_name' => 'Hj. Khadijah',
            'timezone' => 'Asia/Jakarta',
            'event_date_offset_days' => 45,
            'event_time' => '08:00',
            'event_time_end' => '13:00',
            'venue_name' => 'Pendopo Sakinah',
            'venue_address' => 'Jakarta Selatan, DKI Jakarta',
            'venue_maps_url' => 'https://maps.google.com/?q=Jakarta+Selatan',
            'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
            'quote_source' => 'QS. Ar-Rum: 21',
            'love_story' => 'Dua perjalanan yang Allah pertemukan, untuk belajar saling menjaga dan bertumbuh dalam kebaikan.',
            'stories' => [
                ['story_date' => '2024', 'story_title' => 'Niat yang baik', 'story_description' => 'Melalui perantara keluarga, kami mulai mengenal dengan niat baik dan doa yang sama.'],
                ['story_date' => '2025', 'story_title' => 'Restu dua keluarga', 'story_description' => 'Percakapan menjadi keyakinan. Dengan restu orang tua, kami memantapkan langkah menuju pernikahan.'],
                ['story_date' => '2026', 'story_title' => 'Satu janji, insyaAllah', 'story_description' => 'Kami memilih berjalan bersama, saling menguatkan, dan menjadikan rumah sebagai tempat pulang yang menenteramkan.'],
            ],
            'gallery_photos' => [],
            'show_video' => false,
            'gift_banks' => [['bank_name' => 'BSI · Contoh', 'account_number' => '0000000000', 'account_holder' => 'Siti Aisyah']],
            'gift_ewallets' => [],
            'events' => [
                ['event_title' => 'Akad Nikah', 'date_offset_days' => 0, 'start_time' => '08:00', 'end_time' => '09:00', 'is_until_finished' => false, 'place_name' => 'Masjid Al-Hikmah', 'place_address' => 'Jakarta Selatan, DKI Jakarta', 'google_maps_url' => 'https://maps.google.com/?q=Masjid+Al+Hikmah+Jakarta+Selatan'],
                ['event_title' => 'Walimatul ‘Ursy', 'date_offset_days' => 0, 'start_time' => '11:00', 'end_time' => '13:00', 'is_until_finished' => false, 'place_name' => 'Pendopo Sakinah', 'place_address' => 'Jakarta Selatan, DKI Jakarta', 'google_maps_url' => 'https://maps.google.com/?q=Jakarta+Selatan'],
            ],
        ]);
    }
}
