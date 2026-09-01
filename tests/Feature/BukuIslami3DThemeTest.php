<?php

use Database\Seeders\ThemeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('buku islami 3d theme preview renders successfully with all 8 pages content', function () {
    $this->seed(ThemeSeeder::class);

    $response = $this->get(route('theme.preview', 'buku_islami_3d').'?to=Bapak+Ahmad+Dahlan');

    $response->assertSuccessful();

    // Page 1: Cover & Dynamic Guest
    $response->assertSee('Walimatul', false);
    $response->assertSee('Bapak Ahmad Dahlan');
    $response->assertSee('Buka Lembaran Undangan');
    $response->assertSee('بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', false);

    // Page 2: Mukaddimah & QS. Ar-Rum 21
    $response->assertSee('Mukaddimah');
    $response->assertSee('QS. Ar-Rum : 21');
    $response->assertSee('وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا', false);

    // Page 3: Detail Mempelai Syar'i (Tanpa Foto)
    $response->assertSee('Muhammad Rayhan');
    $response->assertSee('Siti Aisyah');
    $response->assertSee('Menikah adalah sunnahku');

    // Page 4: Jadwal Acara & Google Maps
    $response->assertSee('Rangkaian Acara');
    $response->assertSee('Akad');
    $response->assertSee('Masjid Agung Al-Mubarak');
    $response->assertSee('Buka di Google Maps');

    // Page 5: Hitung Mundur
    $response->assertSee('Hitung Mundur');
    $response->assertSee('SAVE THE DATE');

    // Page 6: RSVP & Buku Tamu
    $response->assertSee('RSVP &amp; Buku Tamu', false);
    $response->assertSee('Kirim Doa Restu');

    // Page 7: Amplop Digital
    $response->assertSee('Tanda Kasih');
    $response->assertSee('BANK SYARIAH INDONESIA', false);
    $response->assertSee('7182930488');
    $response->assertSee('Salin No. Rekening');

    // Page 8: Penutup & Doa Pengantin
    $response->assertSee('Doa &amp; Penutup', false);
    $response->assertSee('QS. Al-Furqan : 74');
    $response->assertSee('Bagikan ke WhatsApp');
});
