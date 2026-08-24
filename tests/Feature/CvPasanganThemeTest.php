<?php

use App\Models\Theme;
use Database\Seeders\ThemeSeeder;

test('cv pasangan theme can be previewed as a complete couple resume', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.cv_pasangan'],
        [
            'name' => 'CV Pasangan',
            'thumbnail_portrait' => '/images/themes/cv-pasangan-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'cv-pasangan']));

    $response->assertSuccessful();
    $response->assertSee('themes/cv_pasangan/assets/css/style.css', false);
    $response->assertSee('themes/cv_pasangan/assets/js/script.js', false);
    $response->assertSee('CURRICULUM VITAE PASANGAN', false);
    $response->assertSee('Kepala Keluarga &amp; Menteri Rumah Tangga', false);
    $response->assertSee('PENDIDIKAN HATI', false);
    $response->assertSee('JADWAL WAWANCARA TERBUKA', false);
    $response->assertSee('[ Hire &amp; Konfirmasi Hadir ]', false);
});

test('cv pasangan preview aliases resolve to the canonical theme', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.cv_pasangan'],
        ['name' => 'CV Pasangan', 'is_premium' => true, 'is_active' => true]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('CURRICULUM VITAE PASANGAN', false);
})->with(['cv-pasangan', 'curriculum-vitae', 'daftar-riwayat-hidup', 'resume-pasangan']);

test('theme seeder registers cv pasangan with its preview data and thumbnail', function () {
    $this->seed(ThemeSeeder::class);

    $theme = Theme::query()->where('view_path', 'themes.cv_pasangan')->firstOrFail();

    expect($theme->thumbnail_portrait)->toBe('/images/themes/cv-pasangan-thumb.svg')
        ->and($theme->previewData)->not->toBeNull()
        ->and($theme->previewData->groom_full_name)->toBe('Raka Pratama')
        ->and($theme->previewData->events)->toHaveCount(2);
});
