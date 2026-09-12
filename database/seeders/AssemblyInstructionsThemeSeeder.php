<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class AssemblyInstructionsThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.assembly_instructions'],
            [
                'name' => 'Kartu Instruksi Merakit Furnitur (Assembly Instructions)',
                'thumbnail_portrait' => '/images/themes/assembly-instructions-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'ÄKTENSKAP: Panduan Merakit Mahligai Pernikahan Dimas & Sarah',
                'groom_full_name' => 'Dimas Anggara, S.T.',
                'groom_short_name' => 'Dimas',
                'groom_father_name' => 'Bapak Bambang Anggara',
                'groom_mother_name' => 'Ibu Sri Wahyuni',
                'bride_full_name' => 'Sarah Daniswara, S.Ds.',
                'bride_short_name' => 'Sarah',
                'bride_father_name' => 'Bapak Hendra Daniswara',
                'bride_mother_name' => 'Ibu Retno Daniswara',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 40,
                'event_time' => '08:30',
                'event_time_end' => '14:00',
                'venue_name' => 'The Scandinavian Pavilion Ballroom',
                'venue_address' => 'Jl. Senopati Asmara No. 99, Kebayoran Baru, Jakarta Selatan',
                'venue_maps_url' => 'https://maps.google.com/?q=Jakarta',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'PETUNJUK KESELAMATAN & PANDUAN SEUMUR HIDUP // QS. AR-RUM: 21',
                'love_story' => 'Sebuah panduan perakitan cinta dua insan manusia yang diawali dari pertemuan tak sengaja berebut katalog furnitur hingga peresmian mahligai rumah tangga yang kokoh dan penuh tawa.',
                'stories' => [
                    [
                        'story_date' => 'LANGKAH 01',
                        'story_title' => 'Unboxing & Pertemuan Pertama di Lorong Perabot',
                        'story_description' => 'Mata kami bersitatap saat berebut katalog di lorong toko perabot rumah tangga. Pertemuan awal tak terduga yang membuka kardus takdir asmara.',
                    ],
                    [
                        'story_date' => 'LANGKAH 02',
                        'story_title' => 'Menyelaraskan Rangka & Pasak Kayu (Masa Penjajakan)',
                        'story_description' => 'Menjalin komunikasi intens dan belajar menyatukan dua perbedaan sudut pandang menjadi sebuah struktur hubungan yang kokoh, harmonis, dan seimbang.',
                    ],
                    [
                        'story_date' => 'LANGKAH 03',
                        'story_title' => 'Memasang Baut Komitmen & Obeng Restu Orang Tua',
                        'story_description' => 'Di hadapan kedua keluarga besar, baut komitmen dikencangkan dengan obeng restu orang tua. Tidak ada lagi keraguan dalam merakit masa depan bersama.',
                    ],
                    [
                        'story_date' => 'LANGKAH 04',
                        'story_title' => 'Peresmian Mahligai Rumah Tangga Selesai (Pelaminan)',
                        'story_description' => 'Kini seluruh bagian telah terpasang dengan sempurna. Saatnya merayakan selesainya rakitan suci di pelaminan bersama para saksi perakit terhormat.',
                    ],
                ],
                'events' => [
                    [
                        'event_title' => 'Tahap I: Ijab Kabul & Penyatuan Rangka Utama (Akad Nikah)',
                        'event_date_offset_days' => 40,
                        'start_time' => '08:30',
                        'end_time' => '10:30',
                        'place_name' => 'The Scandinavian Pavilion Ballroom',
                        'place_address' => 'Jl. Senopati Asmara No. 99, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                    [
                        'event_title' => 'Tahap II: Peresmian & Perayaan Mahligai Rumah Tangga (Resepsi)',
                        'event_date_offset_days' => 40,
                        'start_time' => '11:30',
                        'end_time' => '14:00',
                        'place_name' => 'The Scandinavian Pavilion Ballroom',
                        'place_address' => 'Jl. Senopati Asmara No. 99, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                ],
                'gift_banks' => [
                    [
                        'bank_name' => 'Bank Mandiri (Rekening Sparepart Dimas)',
                        'account_number' => '1370098472819',
                        'account_holder' => 'Dimas Anggara',
                    ],
                    [
                        'bank_name' => 'Bank BCA (Rekening Workshop Sarah)',
                        'account_number' => '8291048572',
                        'account_holder' => 'Sarah Daniswara',
                    ],
                ],
                'gift_ewallets' => [
                    [
                        'wallet_name' => 'GoPay',
                        'wallet_number' => '081299887766',
                    ],
                ],
                'gallery_photos' => [
                    'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1583939003579-730e3918a45a?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1520854221256-17451cc331bf?q=80&w=800&auto=format&fit=crop',
                ],
            ]
        );
    }
}
