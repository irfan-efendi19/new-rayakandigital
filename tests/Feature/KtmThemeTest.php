<?php

use App\Models\Theme;

test('ktm theme can be previewed with authentic Indonesian student ID card and academic portal parody', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.ktm'],
        [
            'name' => 'Kartu Tanda Mahasiswa (KTM)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'ktm']));

    $response->assertOk();
    $response->assertSee('themes/ktm/assets/css/style.css', false);
    $response->assertSee('themes/ktm/assets/js/script.js', false);

    // Card & Portal Header
    $response->assertSee('UNIVERSITAS ASMARA INDONESIA', false);
    $response->assertSee('KTM DIGITAL', false);
    $response->assertSee('SIAKAD', false);

    // Status & Akademik
    $response->assertSee('Mahasiswa Abadi di Hati Satu Sama Lain', false);
    $response->assertSee('Lulus Menuju Pelaminan', false);
    $response->assertSee('IPK: 4.00 (SUMMA CUM LAUDE)', false);
    $response->assertSee('NIM.', false);

    // KRS & Jadwal Kuliah Umum
    $response->assertSee('KARTU RENCANA STUDI (KRS)', false);
    $response->assertSee('100 SKS', false);
    $response->assertSee('Petunjuk Arah Menuju Lokasi (Google Maps)', false);

    // RSVP & Presensi BAAK
    $response->assertSee('PRESENSI KULIAH UMUM', false);
    $response->assertSee('Scan KTM &amp; Konfirmasi Hadir', false);
    $response->assertSee('TERVALIDASI BAAK KAMPUS', false);
});

test('ktm aliases resolve correctly to the theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.ktm'],
        [
            'name' => 'Kartu Tanda Mahasiswa (KTM)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => $slug]));

    $response->assertOk();
    $response->assertSee('UNIVERSITAS ASMARA INDONESIA', false);
    $response->assertSee('KTM DIGITAL', false);
})->with([
    'ktm',
    'kartu-tanda-mahasiswa',
    'kartu_tanda_mahasiswa',
    'student-id',
    'student_id',
    'kampus',
    'kartu-mahasiswa',
    'mahasiswa',
]);
