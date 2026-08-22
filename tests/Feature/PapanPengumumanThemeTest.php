<?php

use App\Models\Theme;

test('papan pengumuman theme can be previewed with vintage school notice board elements', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.papan_pengumuman'],
        [
            'name' => 'Papan Pengumuman Sekolah Jadul (Surat Edaran Resmi)',
            'thumbnail_portrait' => '/images/themes/papan-pengumuman-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'papan-pengumuman']));

    $response->assertOk();
    $response->assertSee('themes/papan_pengumuman/assets/css/style.css', false);
    $response->assertSee('themes/papan_pengumuman/assets/js/papan-pengumuman.js', false);
    $response->assertSee('nbCoverGate', false);
    $response->assertSee('SEKOLAH TINGGI CINTA SEHIDUP SEMATI', false);
    $response->assertSee('SURAT EDARAN RESMI', false);
    $response->assertSee('Libur Permanen dari Masa Lajang', false);
    $response->assertSee('BUKA PAPAN PENGUMUMAN', false);
    $response->assertSee('LULUS &amp; SAH', false);
    $response->assertSee('KARTU IDENTITAS SISWA &amp; SISWI', false);
    $response->assertSee('LIHAT PETA MENUJU AULA (GOOGLE MAPS)', false);
    $response->assertSee('HITUNG MUNDUR BEL PULANG MASA LAJANG TERAKHIR', false);
    $response->assertSee('BUKU PIKET ABSENSI KEHADIRAN (RSVP)', false);
    $response->assertSee('BUKU KENANGAN ANGKATAN (YEARBOOK)', false);
    $response->assertSee('KOTAK SUMBANGAN KAS KELAS (KADO DIGITAL)', false);
});

test('papan pengumuman theme works via notice-board alias', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.papan_pengumuman'],
        [
            'name' => 'Papan Pengumuman Sekolah Jadul (Surat Edaran Resmi)',
            'thumbnail_portrait' => '/images/themes/papan-pengumuman-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'notice-board']));

    $response->assertOk();
    $response->assertSee('SEKOLAH TINGGI CINTA SEHIDUP SEMATI', false);
    $response->assertSee('SURAT EDARAN RESMI', false);
});
