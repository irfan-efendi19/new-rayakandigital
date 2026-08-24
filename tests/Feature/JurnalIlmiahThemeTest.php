<?php

use App\Models\Theme;

test('jurnal ilmiah theme can be previewed with authentic Indonesian SINTA 1 academic journal indexing parody', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.jurnal_ilmiah'],
        [
            'name' => 'Situs Jurnal & E-Library (Journal Article Access)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'sinta']));

    $response->assertOk();
    $response->assertSee('themes/jurnal_ilmiah/assets/css/style.css', false);
    $response->assertSee('themes/jurnal_ilmiah/assets/js/script.js', false);

    // SINTA Branding & Judul Artikel
    $response->assertSee('Transformasi Status Hubungan dari Teman Kuliah Menjadi Pasangan Halal', false);
    $response->assertSee('SINTA — SCIENCE AND TECHNOLOGY INDEX', false);
    $response->assertSee('SINTA 1', false);
    $response->assertSee('SINTA Score', false);

    // Abstrak & Berita Acara
    $response->assertSee('ABSTRAK (ABSTRACT)', false);
    $response->assertSee('Kata Kunci (Keywords)', false);
    $response->assertSee('BAB III: JADWAL AKSES RUANG BACA', false);
    $response->assertSee('Petunjuk Arah Menuju Lokasi (Google Maps)', false);

    // Presensi & Download Button
    $response->assertSee('SINTA PEER-REVIEW FORM', false);
    $response->assertSee('Download Undangan &amp; Hadir', false);
    $response->assertSee('SINTA 1 ACCREDITED &amp; ACCEPTED', false);
});

test('jurnal ilmiah aliases resolve correctly to the theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.jurnal_ilmiah'],
        [
            'name' => 'Situs Jurnal & E-Library (Journal Article Access)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => $slug]));

    $response->assertOk();
    $response->assertSee('Transformasi Status Hubungan dari Teman Kuliah Menjadi Pasangan Halal', false);
})->with([
    'jurnal-ilmiah',
    'jurnal_ilmiah',
    'jurnal',
    'journal',
    'e-library',
    'sinta',
    'sinta-1',
    'skripsi',
]);
