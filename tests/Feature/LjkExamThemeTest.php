<?php

use App\Models\Theme;

test('ljk exam theme can be previewed with authentic school examination elements', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.ljk_exam'],
        [
            'name' => 'Ujian Sekolah / Lembar Jawaban Komputer (LJK)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'ljk-exam']));

    $response->assertOk();
    $response->assertSee('themes/ljk_exam/assets/css/style.css', false);
    $response->assertSee('themes/ljk_exam/assets/js/ljk-exam.js', false);
    $response->assertSee('ljkCoverGate', false);
    $response->assertSee('DOKUMEN RAHASIA NEGARA', false);
    $response->assertSee('BUKA LEMBAR SOAL &amp; MULAI UJIAN', false);
    $response->assertSee('LEMBAR JAWABAN KOMPUTER (LJK)', false);
    $response->assertSee('PETUNJUK PENGISIAN LEMBAR JAWABAN', false);
    $response->assertSee('KUMPUL LEMBAR JAWABAN (SUBMIT)', false);
    $response->assertSee('NILAI: 100', false);
});
