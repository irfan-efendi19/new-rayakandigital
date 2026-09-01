<?php

use App\Models\Theme;
use Database\Seeders\ThemeSeeder;

test('sticker and doodling theme renders scrapbook photobooth and cute elements', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.sticker_doodle'],
        [
            'name' => 'Sticker & Doodling Aesthetic (Photobooth Scrapbook)',
            'thumbnail_portrait' => '/images/themes/sticker-doodle-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'sticker-doodle']));

    $response->assertSuccessful();
    $response->assertSee('themes/sticker_doodle/assets/css/style.css', false);
    $response->assertSee('themes/sticker_doodle/assets/js/script.js', false);
    $response->assertSee('PHOTOBOOTH SCRAPBOOK', false);
    $response->assertSee('MEET THE BRIDE &amp; GROOM', false);
    $response->assertSee('OUR WEDDING SCHEDULE', false);
    $response->assertSee('OUR PHOTOBOOTH STORY', false);
    $response->assertSee('CAMERA ROLL &amp; MEMORIES', false);
    $response->assertSee('GUESTBOOK &amp; RSVP', false);
    $response->assertSee('WEDDING GIFT', false);
    $response->assertSee('Tempel Stiker:', false);
});

test('sticker doodle preview aliases resolve to the canonical theme', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.sticker_doodle'],
        ['name' => 'Sticker & Doodling Aesthetic', 'is_premium' => true, 'is_active' => true]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('PHOTOBOOTH SCRAPBOOK', false);
})->with(['sticker-doodle', 'sticker-doodling', 'photobooth-doodle', 'photobooth', 'scrapbook']);

test('theme seeder registers sticker doodle with cute scrapbook preview data', function () {
    $this->seed(ThemeSeeder::class);

    $theme = Theme::query()->where('view_path', 'themes.sticker_doodle')->firstOrFail();

    expect($theme->thumbnail_portrait)->toBe('/images/themes/sticker-doodle-thumb.svg')
        ->and($theme->previewData)->not->toBeNull()
        ->and($theme->previewData->groom_full_name)->toBe('Dimas Aditya Pratama, S.Kom.')
        ->and($theme->previewData->bride_full_name)->toBe('Nadia Putri Maharani, S.Ds.')
        ->and($theme->previewData->events)->toHaveCount(2);
});
