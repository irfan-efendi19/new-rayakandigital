<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class TopSecretDossierThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.top_secret_dossier'],
            [
                'name' => 'Segel Arsip Rahasia Negara (Top Secret Dossier)',
                'thumbnail_portrait' => '/images/themes/top-secret-dossier-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'Berkas Perkara Rahasia Asmara: Farhan & Anindya — Top Secret Dossier',
                'groom_full_name' => 'Mayor Farhan Danuarta, M.Sc.',
                'groom_short_name' => 'Farhan',
                'groom_father_name' => 'Bapak Kolonel (Purn.) Hendra Danuarta',
                'groom_mother_name' => 'Ibu Dra. Ratna Danuarta',
                'bride_full_name' => 'Kapten Anindya Putri Rahayu, S.I.P.',
                'bride_short_name' => 'Anindya',
                'bride_father_name' => 'Bapak Ir. Bambang Rahayu',
                'bride_mother_name' => 'Ibu Siti Nurhaliza, M.Pd.',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 35,
                'event_time' => '08:30',
                'event_time_end' => '14:00',
                'venue_name' => 'The State Intelligence Conservatory Ballroom',
                'venue_address' => 'Jl. Senopati Asmara No. 77, Kebayoran Baru, Jakarta Selatan',
                'venue_maps_url' => 'https://maps.google.com/?q=Jakarta',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'DEKRIT KENEGARAAN & KONSIDERANS ASMARA // QS. AR-RUM: 21',
                'love_story' => 'Sebuah dokumen penyelidikan rahasia yang mencatat kronologi dua agen hati dari misi penugasan tak terduga hingga penetapan sumpah setia sehidup semati di hadapan negara dan Yang Maha Kuasa.',
                'stories' => [
                    [
                        'story_date' => 'FASE 01 - 2021',
                        'story_title' => 'Inisiasi Kontak Perdana (Pertemuan Tak Terduga)',
                        'story_description' => 'Dalam sebuah pertemuan tugas kenegaraan, pandangan kami pertama kali bertemu. Sinyal keterikatan batin terdeteksi melampaui seluruh protokol kerahasiaan dinas.',
                    ],
                    [
                        'story_date' => 'FASE 02 - 2023',
                        'story_title' => 'Operasi Bersama & Pengujian Komitmen',
                        'story_description' => 'Melalui berbagai dinamika tugas, jarak, dan pengorbanan waktu, komitmen kami diuji. Keduanya terbukti saling melindungi, menjaga kepercayaan, dan saling melengkapi.',
                    ],
                    [
                        'story_date' => 'FASE 03 - 2025',
                        'story_title' => 'Konsolidasi & Verifikasi Dua Keluarga Besar',
                        'story_description' => 'Dua markas keluarga besar bertemu dalam kehangatan diplomatik. Restu penuh dari orang tua menandai lampu hijau bagi eksekusi misi seumur hidup.',
                    ],
                    [
                        'story_date' => 'FASE 04 - 2026',
                        'story_title' => 'Deklasifikasi & Maklumat Janji Suci',
                        'story_description' => 'Kini seluruh kerahasiaan resmi dideklasifikasi. Saatnya mengikrarkan janji suci di pelaminan bersama para saksi kunci terhormat.',
                    ],
                ],
                'events' => [
                    [
                        'event_title' => 'Operasi I: Ijab Kabul & Pengikraran Sumpah Setia (Akad Nikah)',
                        'event_date_offset_days' => 35,
                        'start_time' => '08:30',
                        'end_time' => '10:30',
                        'place_name' => 'The State Intelligence Conservatory Ballroom',
                        'place_address' => 'Jl. Senopati Asmara No. 77, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                    [
                        'event_title' => 'Operasi II: Resepsi Diplomatik & Jamuan Kenegaraan Asmara (Resepsi)',
                        'event_date_offset_days' => 35,
                        'start_time' => '11:30',
                        'end_time' => '14:00',
                        'place_name' => 'The State Intelligence Conservatory Ballroom',
                        'place_address' => 'Jl. Senopati Asmara No. 77, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=Jakarta',
                    ],
                ],
                'gift_banks' => [
                    [
                        'bank_name' => 'Bank Mandiri (Rekening Operasi Farhan)',
                        'account_number' => '1370019284729',
                        'account_holder' => 'Farhan Danuarta',
                    ],
                    [
                        'bank_name' => 'Bank BCA (Rekening Taktis Anindya)',
                        'account_number' => '8291048592',
                        'account_holder' => 'Anindya Putri Rahayu',
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
