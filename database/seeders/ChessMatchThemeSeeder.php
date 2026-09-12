<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class ChessMatchThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.chess_match'],
            [
                'name' => 'Papan Catur (Chess Match / Tactical Vows)',
                'thumbnail_portrait' => '/images/themes/chess-match-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'The Grand Chess Match of Arya & Kirana — Langkah Menuju Kemenangan',
                'groom_full_name' => 'Arya Danendra, S.T.',
                'groom_short_name' => 'Arya',
                'groom_father_name' => 'Bapak Ir. Bambang Danendra',
                'groom_mother_name' => 'Ibu Dra. Retno Sulistyo',
                'bride_full_name' => 'Kirana Larasati, S.Ds.',
                'bride_short_name' => 'Kirana',
                'bride_father_name' => 'Bapak Hendra Larasati, M.M.',
                'bride_mother_name' => 'Ibu Maharani Indah, S.Pd.',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 45,
                'event_time' => '08:00',
                'event_time_end' => '14:00',
                'venue_name' => 'The Grand Monarch Pavilion',
                'venue_address' => 'Jl. Senopati Asmara No. 88, Kebayoran Baru, Jakarta Selatan',
                'venue_maps_url' => 'https://maps.google.com/?q=Jakarta',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'QS. Ar-Rum: 21',
                'love_story' => 'Pernikahan bukan tentang mengalahkan satu sama lain, melainkan dua kekuatan yang berdiri berdampingan di atas satu papan kehidupan, menyusun setiap langkah taktis menuju kemenangan abadi.',
                'stories' => [
                    [
                        'story_date' => 'Langkah 1',
                        'story_title' => 'The Opening Move (Pertemuan Pertama)',
                        'story_description' => 'Di sebuah sudut kedai buku yang hening, takdir mempertemukan kami lewat papan catur kayu klasik. Sebuah langkah pembuka yang tak sengaja mengubah seluruh perjalanan hidup.',
                    ],
                    [
                        'story_date' => 'Langkah 2',
                        'story_title' => 'Developing Harmony (Penyelarasan Visi)',
                        'story_description' => 'Dari diskusi strategi karier hingga impian masa depan, kami menyadari setiap perbedaan karakter justru saling melengkapi bagai Raja dan Ratu yang saling menjaga.',
                    ],
                    [
                        'story_date' => 'Langkah 3',
                        'story_title' => 'Weathering Challenges (Ketenangan di Tengah Ujian)',
                        'story_description' => 'Jarak dan dinamika kehidupan sempat menguji komitmen kami. Namun dengan ketenangan, komunikasi terbuka, dan strategi bersama, badai berhasil kami lalui.',
                    ],
                    [
                        'story_date' => 'Langkah 4',
                        'story_title' => 'Castling in Sacred Vow (Pinangan Sang Raja)',
                        'story_description' => 'Di bawah langit senja yang damai, Sang Raja mengajukan langkah terpenting dalam hidupnya: meminang Sang Ratu untuk menyatukan dua hati selamanya.',
                    ],
                    [
                        'story_date' => 'Final Move',
                        'story_title' => 'Checkmate in Love (Langkah Menuju Pelaminan)',
                        'story_description' => 'Kini saatnya merayakan kemenangan cinta abadi di atas pelaminan suci bersama para saksi dan orang-orang tercinta.',
                    ],
                ],
                'events' => [
                    [
                        'event_title' => 'Langkah Pertama: Akad Nikah Suci',
                        'event_date_offset_days' => 45,
                        'start_time' => '08:00',
                        'end_time' => '10:00',
                        'place_name' => 'The Grand Monarch Pavilion',
                        'place_address' => 'Jl. Senopati Asmara No. 88, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                    [
                        'event_title' => 'Langkah Menuju Kemenangan (Checkmate / Pelaminan & Resepsi)',
                        'event_date_offset_days' => 45,
                        'start_time' => '11:00',
                        'end_time' => '14:00',
                        'place_name' => 'The Grand Monarch Pavilion',
                        'place_address' => 'Jl. Senopati Asmara No. 88, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                ],
                'gift_banks' => [
                    [
                        'bank_name' => 'BCA',
                        'account_number' => '8291048572',
                        'account_holder' => 'Arya Danendra',
                    ],
                    [
                        'bank_name' => 'Bank Mandiri',
                        'account_number' => '1370098472819',
                        'account_holder' => 'Kirana Larasati',
                    ],
                ],
                'gallery_photos' => [
                    'https://images.unsplash.com/photo-1583939003579-730e3918a45a?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1520854221256-17451cc331bf?q=80&w=800&auto=format&fit=crop',
                ],
            ]
        );
    }
}
