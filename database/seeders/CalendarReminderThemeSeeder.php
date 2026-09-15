<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Database\Seeder;

class CalendarReminderThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = Theme::updateOrCreate(
            ['view_path' => 'themes.calendar_reminder'],
            [
                'name' => 'Stiker Label Pengingat Tanggal (Calendar Reminder Sticker)',
                'thumbnail_portrait' => '/images/themes/calendar-reminder-thumb.svg',
                'is_premium' => true,
                'is_active' => true,
            ]
        );

        ThemePreviewData::updateOrCreate(
            ['theme_id' => $theme->id],
            [
                'title' => 'Save The Date: Rangga & Clarissa — Kalender Pengingat Hari Bahagia',
                'groom_full_name' => 'Rangga Pradana, S.Kom.',
                'groom_short_name' => 'Rangga',
                'groom_father_name' => 'Bapak Ir. Bambang Pradana',
                'groom_mother_name' => 'Ibu Dra. Ratna Kusuma Dewi',
                'bride_full_name' => 'Clarissa Amanda, B.Des.',
                'bride_short_name' => 'Clarissa',
                'bride_father_name' => 'Bapak H. Hendra Daniswara, S.E.',
                'bride_mother_name' => 'Ibu Hj. Siti Nurhasanah',
                'timezone' => 'Asia/Jakarta',
                'event_date_offset_days' => 45,
                'event_time' => '08:00',
                'event_time_end' => '14:00',
                'venue_name' => 'The Botanical Conservatory & Grand Pavilion',
                'venue_address' => 'Jl. Taman Asmara No. 88, Kebayoran Baru, Jakarta Selatan',
                'venue_maps_url' => 'https://maps.google.com/?q=The+Botanical+Conservatory+Jakarta',
                'quote_content' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
                'quote_source' => 'PENGINGAT SUCI PERNIKAHAN // QS. AR-RUM: 21',
                'love_story' => 'Sebuah lembaran kalender kehidupan yang merekam setiap tanggal berharga, dari coretan pertemuan pertama hingga lingkaran spidol merah tebal yang menandai awal janji suci kami seumur hidup.',
                'stories' => [
                    [
                        'story_date' => '14 JANUARI 2022',
                        'story_title' => 'Coretan Tanggal Pertama (Pertemuan Tak Sengaja)',
                        'story_description' => 'Sebuah pertemuan di sebuah kafe perpustakaan kecil di sudut kota. Berawal dari catatan buku agenda yang tertukar, obrolan hangat pun mengalir tanpa henti hingga sore menjelang.',
                    ],
                    [
                        'story_date' => '28 AGUSTUS 2023',
                        'story_title' => 'Stiker Hati: Komitmen & Saling Menjaga',
                        'story_description' => 'Setelah melewati berbagai obrolan mendalam dan perjalanan bersama, kami sepakat memberi tanda stiker merah muda di kalender kami untuk berjalan beriringan saling mendukung impian.',
                    ],
                    [
                        'story_date' => '18 MEI 2025',
                        'story_title' => 'Pin Kalender: Lamaran & Penyatuan Dua Keluarga',
                        'story_description' => 'Di hadapan kedua orang tua dan keluarga besar, sebuah pin emas ditancapkan di kalender. Cincin pertunangan melingkar indah sebagai tanda kesungguhan melangkah ke mahligai pernikahan.',
                    ],
                    [
                        'story_date' => 'HARI H PERNIKAHAN',
                        'story_title' => 'Lingkaran Spidol Merah & Stiker Bintang: Hari Bahagia',
                        'story_description' => 'Tanggal sakral yang paling kami nanti. Lingkaran spidol merah tebal dan bintang emas kini resmi tersemat, mengundang Anda untuk menjadi saksi pengikatan janji suci seumur hidup kami.',
                    ],
                ],
                'events' => [
                    [
                        'event_title' => 'Agenda I: Akad Nikah & Pengucapan Ijab Kabul',
                        'event_date_offset_days' => 45,
                        'start_time' => '08:00',
                        'end_time' => '10:00',
                        'place_name' => 'The Botanical Conservatory — Glasshouse Sanctuary',
                        'place_address' => 'Jl. Taman Asmara No. 88, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=The+Botanical+Conservatory+Jakarta',
                    ],
                    [
                        'event_title' => 'Agenda II: Resepsi Pernikahan & Jamuan Syukuran',
                        'event_date_offset_days' => 45,
                        'start_time' => '11:00',
                        'end_time' => '14:00',
                        'place_name' => 'The Botanical Conservatory — Grand Lawn Pavilion',
                        'place_address' => 'Jl. Taman Asmara No. 88, Kebayoran Baru, Jakarta Selatan',
                        'google_maps_url' => 'https://maps.google.com/?q=The+Botanical+Conservatory+Jakarta',
                    ],
                ],
                'gift_banks' => [
                    [
                        'bank_name' => 'Bank BCA (Rekening Rangga)',
                        'account_number' => '8420194821',
                        'account_holder' => 'Rangga Pradana',
                    ],
                    [
                        'bank_name' => 'Bank Mandiri (Rekening Clarissa)',
                        'account_number' => '1370018492019',
                        'account_holder' => 'Clarissa Amanda',
                    ],
                ],
                'gift_ewallets' => [
                    [
                        'wallet_name' => 'GoPay',
                        'wallet_number' => '081294820192',
                    ],
                    [
                        'wallet_name' => 'OVO',
                        'wallet_number' => '081294820192',
                    ],
                ],
                'gallery_photos' => [
                    'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1583939003579-730e3918a45a?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1520854221256-17451cc331bf?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1537633552985-df8429e8048b?q=80&w=800&auto=format&fit=crop',
                ],
            ]
        );
    }
}
