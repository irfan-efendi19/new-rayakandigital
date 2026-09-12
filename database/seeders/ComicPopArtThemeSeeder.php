<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class ComicPopArtThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.comic_pop_art'],
            [
                'name' => 'Komik & Pop Art (Comic Strip Vintage)',
                'thumbnail_portrait' => '/images/themes/comic-pop-art-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'Special Issue #01: Andi & Sari — The Wedding Chronicles',
                'groom_full_name' => 'Andi Wijaya Pratama, S.Kom.',
                'groom_short_name' => 'Andi',
                'groom_father_name' => 'Bapak Hendra Wijaya',
                'groom_mother_name' => 'Ibu Ratna Dewi',
                'bride_full_name' => 'Sari Indah Maharani, S.Ds.',
                'bride_short_name' => 'Sari',
                'bride_father_name' => 'Bapak Suryono Baskoro',
                'bride_mother_name' => 'Ibu Maya Anggraini',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 30,
                'event_time' => '08:00',
                'event_time_end' => '11:00',
                'venue_name' => 'The Grand Ballroom Comic Hall',
                'venue_address' => 'Jl. Gatot Subroto No. 88, Senayan, Jakarta Selatan',
                'venue_maps_url' => 'https://maps.google.com/?q=Jakarta',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Sebuah petualangan cinta dua insan berjiwa muda yang dipertemukan oleh semesta dalam babak penuh tawa, komitmen, dan kebahagiaan.',
                'stories' => [
                    [
                        'story_title' => 'PANEL 1: THE FIRST ENCOUNTER ☕',
                        'story_description' => 'Di sebuah sudut kedai kopi yang tenang, takdir mempertemukan kami lewat cangkir kopi yang tak sengaja tertukar. Tatapan mata pertama itu mengunci awal dari segalanya.',
                    ],
                    [
                        'story_title' => 'PANEL 2: SPARKS & LAUGHTER ⚡',
                        'story_description' => 'Dari obrolan singkat tentang komik dan musik indie, tawa lepas mengalir begitu natural. Kami menyadari memiliki frekuensi hati yang sama persis.',
                    ],
                    [
                        'story_title' => 'PANEL 3: WEATHERING THE STORMS 🛡️',
                        'story_description' => 'Tak selalu pelangi, badai dan jarak sempat menguji. Namun komitmen untuk saling memegang tangan membuat perahu cinta kami semakin kokoh mengarungi ombak.',
                    ],
                    [
                        'story_title' => 'PANEL 4: THE BIG PROPOSAL 💍',
                        'story_description' => 'Di bawah temaram lampu kota dan langit malam yang syahdu, satu pertanyaan paling berharga terucap tulus. Dan jawaban terindah mengalir: "I do!"',
                    ],
                    [
                        'story_title' => 'PANEL 5: TO BE CONTINUED AT THE ALTAR! 💒',
                        'story_description' => 'Kini babak baru segera dibuka di pelaminan! Saksikan babak suci pernikahan kami dan jadilah saksi awal petualangan seumur hidup ini.',
                    ],
                ],
                'events' => [
                    [
                        'event_title' => 'Akad Nikah Suci',
                        'event_date_offset_days' => 30,
                        'start_time' => '08:00',
                        'end_time' => '10:00',
                        'place_name' => 'The Grand Ballroom Comic Hall',
                        'place_address' => 'Jl. Gatot Subroto No. 88, Senayan, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                    [
                        'event_title' => 'Resepsi & Pesta Perayaan',
                        'event_date_offset_days' => 30,
                        'start_time' => '11:00',
                        'end_time' => '14:00',
                        'place_name' => 'The Grand Ballroom Comic Hall',
                        'place_address' => 'Jl. Gatot Subroto No. 88, Senayan, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                ],
                'gift_banks' => [
                    [
                        'bank_name' => 'BCA',
                        'account_number' => '8820193844',
                        'account_holder' => 'Andi Wijaya Pratama',
                    ],
                    [
                        'bank_name' => 'Mandiri',
                        'account_number' => '1370019283741',
                        'account_holder' => 'Sari Indah Maharani',
                    ],
                ],
            ]
        );
    }
}
