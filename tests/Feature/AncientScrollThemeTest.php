<?php

use App\Models\Theme;
use Database\Seeders\ThemeSeeder;

test('ancient scroll theme renders every royal wedding chapter', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.ancient_scroll'],
        [
            'name' => 'Ancient Scroll',
            'thumbnail_portrait' => '/images/themes/ancient-scroll-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'ancient-scroll']));

    $response->assertSuccessful();
    $response->assertSee('themes/ancient_scroll/assets/css/style.css', false);
    $response->assertSee('themes/ancient_scroll/assets/js/script.js', false);
    $response->assertSee('THE ANCIENT SCROLL OF', false);
    $response->assertSee('The Sacred Chronology', false);
    $response->assertSee('Destination Coordinates', false);
    $response->assertSee('Tribute &amp; Blessings', false);
    $response->assertSee('Scroll Confirmation', false);
    $response->assertSee('The Chronicles of Wishes', false);
});

test('ancient scroll preview aliases resolve to the canonical theme', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.ancient_scroll'],
        ['name' => 'Ancient Scroll', 'is_premium' => true, 'is_active' => true]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('THE ANCIENT SCROLL OF', false);
})->with(['ancient-scroll', 'wedding-scroll', 'gulungan-kuno', 'prasasti-cinta']);

test('theme seeder registers ancient scroll with royal preview data', function () {
    $this->seed(ThemeSeeder::class);

    $theme = Theme::query()->where('view_path', 'themes.ancient_scroll')->firstOrFail();

    expect($theme->thumbnail_portrait)->toBe('/images/themes/ancient-scroll-thumb.svg')
        ->and($theme->previewData)->not->toBeNull()
        ->and($theme->previewData->groom_full_name)->toBe('Aditya Mahendra')
        ->and($theme->previewData->events)->toHaveCount(2);
});
