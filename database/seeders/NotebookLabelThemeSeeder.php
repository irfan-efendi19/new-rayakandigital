<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class NotebookLabelThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.notebook_label'],
            [
                'name' => 'Stiker Label Buku Catatan Sekolah (Vintage Notebook Label)',
                'thumbnail_portrait' => '/images/themes/notebook-label-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'Buku Catatan Pernikahan: Rangga & Cinta (Vintage Notebook Label)',
                'groom_full_name' => 'Rangga Wardhana',
                'groom_short_name' => 'Rangga',
                'groom_father_name' => 'Wardhana',
                'groom_mother_name' => 'Ratna',
                'bride_full_name' => 'Cinta Permatasari',
                'bride_short_name' => 'Cinta',
                'bride_father_name' => 'Permatasari',
                'bride_mother_name' => 'Sulastri',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 30,
                'event_time' => '08:30',
                'event_time_end' => '14:00',
                'venue_name' => 'Gedung Graha Pelaminan Bahagia',
                'venue_address' => 'Jl. Nostalgia Putih Abu-Abu No. 88, Menteng, Jakarta Pusat',
                'venue_maps_url' => 'https://maps.google.com/?q=-6.1950,106.8330',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'Materi Budi Pekerti // QS. Ar-Rum: 21',
                'love_story' => 'Bermula dari buku catatan dan tugas kelompok yang saling tertukar di bangku sekolah masa lalu. Siapa sangka, coretan pena di lembar kertas bergaris itu berlanjut menjadi tulisan takdir sehidup semati.',
                'stories' => [
                    [
                        'story_date' => 'Semester 1 - 2018',
                        'story_title' => 'Buku Catatan yang Tertukar 📚',
                        'story_description' => 'Pertemuan pertama saat pembagian tugas kelompok di kelas. Dari meminjam buku catatan bergaris dan belajar bersama, benih-benih perhatian mulai tumbuh.',
                    ],
                    [
                        'story_date' => 'Semester 4 - 2021',
                        'story_title' => 'Janji Pulpen Biru 🖋️',
                        'story_description' => 'Menyelesaikan ujian demi ujian dan resmi berkomitmen untuk saling mendukung cita-cita. Menemani setiap langkah wisuda dan awal karier.',
                    ],
                    [
                        'story_date' => 'Semester Akhir - 2026',
                        'story_title' => 'Lulus Menuju Pelaminan 💍',
                        'story_description' => 'Hari bahagia saat kedua keluarga saling bersilaturahmi dan melingkarkan cincin lamaran. Bersiap membuka lembaran baru kehidupan bersama.',
                    ],
                ],
                'gallery_photos' => [
                    'https://picsum.photos/seed/notebook1/800/800',
                    'https://picsum.photos/seed/notebook2/800/800',
                    'https://picsum.photos/seed/notebook3/800/800',
                    'https://picsum.photos/seed/notebook4/800/800',
                ],
                'gift_banks' => [
                    [
                        'bank_name' => 'Bank BCA (SPP / Tabungan Kas)',
                        'account_number' => '8899112233',
                        'account_holder' => 'Cinta Permatasari',
                    ],
                    [
                        'bank_name' => 'Bank Mandiri (Komite Kas Asmara)',
                        'account_number' => '1370008899221',
                        'account_holder' => 'Rangga Wardhana',
                    ],
                ],
                'gift_ewallets' => [
                    [
                        'wallet_name' => 'GoPay',
                        'wallet_number' => '081234567890',
                    ],
                    [
                        'wallet_name' => 'OVO',
                        'wallet_number' => '081298765432',
                    ],
                ],
                'events' => [
                    [
                        'event_title' => 'Sesi 1: Ujian Ijab Qabul / Akad Nikah',
                        'date_offset_days' => 0,
                        'start_time' => '08:30',
                        'end_time' => '10:30',
                        'is_until_finished' => false,
                        'place_name' => 'Masjid Nurul Pelaminan',
                        'place_address' => 'Jl. Nostalgia Putih Abu-Abu No. 88, Menteng, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.1950,106.8330',
                    ],
                    [
                        'event_title' => 'Sesi 2: Perayaan Kelulusan Cinta / Resepsi',
                        'date_offset_days' => 0,
                        'start_time' => '11:00',
                        'end_time' => '14:00',
                        'is_until_finished' => false,
                        'place_name' => 'Grand Ballroom Graha Pelaminan Bahagia',
                        'place_address' => 'Jl. Nostalgia Putih Abu-Abu No. 88, Menteng, Jakarta Pusat',
                        'google_maps_url' => 'https://maps.google.com/?q=-6.1950,106.8330',
                    ],
                ],
            ]
        );
    }
}
