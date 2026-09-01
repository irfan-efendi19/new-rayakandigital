<?php

use App\Models\Theme;
use Database\Seeders\ThemeSeeder;

test('photobox strip theme renders classic 4-cut film strip and retro photobox elements', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.photobox_strip'],
        [
            'name' => 'Photobox Strip Klasik (Retro & Gen Z Vibe)',
            'thumbnail_portrait' => '/images/themes/photobox-strip-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'photobox-strip']));

    $response->assertSuccessful();
    $response->assertSee('themes/photobox_strip/assets/css/style.css', false);
    $response->assertSee('themes/photobox_strip/assets/js/script.js', false);
    $response->assertSee('PHOTOBOX STUDIO', false);
    $response->assertSee('Filter Photobox:', false);
    $response->assertSee('PHOTOBOX LIVE CUTS', false);
    $response->assertSee('PHOTOBOX SESSION RUNDOWN', false);
    $response->assertSee('PHOTOBOX STRIP JOURNEY', false);
    $response->assertSee('CAMERA ROLL &amp; PRINTS', false);
    $response->assertSee('SESSION PRINT TICKET / RSVP', false);
    $response->assertSee('PHOTOBOX CASH BOX / GIFT', false);
});

test('photobox strip preview aliases resolve to the canonical theme', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.photobox_strip'],
        ['name' => 'Photobox Strip Klasik', 'is_premium' => true, 'is_active' => true]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('PHOTOBOX STUDIO', false);
})->with(['photobox-strip', 'retro-photobox', 'photobox', 'photo-strip', 'photobox-klasik', 'gen-z-photobox']);

test('theme seeder registers photobox strip with retro studio preview data', function () {
    $this->seed(ThemeSeeder::class);

    $theme = Theme::query()->where('view_path', 'themes.photobox_strip')->firstOrFail();

    expect($theme->thumbnail_portrait)->toBe('/images/themes/photobox-strip-thumb.svg')
        ->and($theme->previewData)->not->toBeNull()
        ->and($theme->previewData->groom_full_name)->toBe('Dimas Aditya Pratama, S.T.')
        ->and($theme->previewData->bride_full_name)->toBe('Nadia Putri Maharani, S.I.Kom.')
        ->and($theme->previewData->events)->toHaveCount(2);
});
