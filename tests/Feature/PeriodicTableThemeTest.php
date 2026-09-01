<?php

use App\Models\Theme;
use Database\Seeders\ThemeSeeder;

test('periodic table theme renders chemical love formula and periodic elements', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.periodic_table'],
        [
            'name' => 'Tabel Periodik Kimia (Periodic Love Table)',
            'thumbnail_portrait' => '/images/themes/periodic-table-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'periodic-table']));

    $response->assertSuccessful();
    $response->assertSee('themes/periodic_table/assets/css/style.css', false);
    $response->assertSee('themes/periodic_table/assets/js/script.js', false);
    $response->assertSee('THE PERIODIC LOVE TABLE', false);
    $response->assertSee('IDENTIFIKASI UNSUR REAKTIF', false);
    $response->assertSee('PERSAMAAN REAKSI SINTESIS CINTA', false);
    $response->assertSee('SIMULATOR REAKTOR SINTESIS CINTA', false);
    $response->assertSee('TABEL PERIODIK CINTA &amp; UNSUR KEBAHAGIAAN', false);
    $response->assertSee('PROTOKOL &amp; JADWAL REAKSI SINTESIS', false);
    $response->assertSee('KINETIKA &amp; KRONOLOGI REAKSI CINTA', false);
    $response->assertSee('SPEKTROMETRI &amp; DOKUMENTASI MOLEKULER', false);
    $response->assertSee('VALIDASI SAMPEL &amp; PRESENSI PENELITI', false);
    $response->assertSee('DONASI REAGEN &amp; TRANSFER ENERGI', false);
});

test('periodic table preview aliases resolve to the canonical theme', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.periodic_table'],
        ['name' => 'Tabel Periodik Kimia', 'is_premium' => true, 'is_active' => true]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('THE PERIODIC LOVE TABLE', false);
})->with(['periodic-table', 'tabel-periodik', 'kimia', 'chemistry', 'unsur-kimia']);

test('theme seeder registers periodic table with scientific preview data', function () {
    $this->seed(ThemeSeeder::class);

    $theme = Theme::query()->where('view_path', 'themes.periodic_table')->firstOrFail();

    expect($theme->thumbnail_portrait)->toBe('/images/themes/periodic-table-thumb.svg')
        ->and($theme->previewData)->not->toBeNull()
        ->and($theme->previewData->groom_full_name)->toBe('Dimas Aditya Pratama, S.Si.')
        ->and($theme->previewData->bride_full_name)->toBe('Nadia Putri Maharani, M.Sc.')
        ->and($theme->previewData->events)->toHaveCount(2);
});
