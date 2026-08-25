<?php

use App\Models\Theme;
use Database\Seeders\ThemeSeeder;
use Illuminate\Support\Facades\File;

test('orbit theme renders the complete celestial wedding journey', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.orbit'],
        [
            'name' => 'Orbit',
            'thumbnail_portrait' => '/images/themes/orbit-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'orbit']));

    $response->assertSuccessful();
    $response->assertSee('themes/orbit/assets/css/style.css', false);
    $response->assertSee('themes/orbit/assets/js/script.js', false);
    $response->assertSee('themes/orbit/assets/images/planet-atlas.svg', false);
    $response->assertSee('themes/orbit/assets/images/planet-lyra.svg', false);
    $response->assertSee('Dua dunia yang berbeda', false);
    $response->assertSee('Two different', false);
    $response->assertSee('One shared', false);
    $response->assertSee('The Celestial Pair', false);
    $response->assertSee('STELLAR ALIGNMENT IN', false);
    $response->assertSee('Coordinates of Celebration', false);
    $response->assertSee('JOIN THE GALAXY?', false);
    $response->assertSee('THE STAR LOG', false);
    $response->assertSee('[ Konfirmasi Orbit Kehadiran ]', false);
});

test('orbit preview aliases resolve to the canonical theme', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.orbit'],
        ['name' => 'Orbit', 'is_premium' => true, 'is_active' => true]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('One shared', false);
})->with(['orbit', 'orbit-wedding', 'orbit-cinta', 'cosmic-orbit']);

test('orbit preview includes backend-compatible rsvp and wish forms', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.orbit'],
        ['name' => 'Orbit', 'is_premium' => true, 'is_active' => true]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'orbit']));

    $response->assertSuccessful();
    $response->assertSee('name="attendance"', false);
    $response->assertSee('value="attending"', false);
    $response->assertSee('value="not_attending"', false);
    $response->assertSee('value="uncertain"', false);
    $response->assertSee('name="pax"', false);
    $response->assertSee('name="message"', false);
    $response->assertSee('maxlength="1000"', false);
});

test('theme seeder registers orbit with celestial preview data', function () {
    $this->seed(ThemeSeeder::class);

    $theme = Theme::query()->where('view_path', 'themes.orbit')->firstOrFail();

    expect($theme->thumbnail_portrait)->toBe('/images/themes/orbit-thumb.svg')
        ->and($theme->previewData)->not->toBeNull()
        ->and($theme->previewData->groom_full_name)->toBe('Arka Mahardika')
        ->and($theme->previewData->bride_full_name)->toBe('Lyra Amaranthe')
        ->and($theme->previewData->events)->toHaveCount(2);
});

test('orbit public assets exist', function () {
    expect(File::exists(resource_path('views/themes/orbit.blade.php')))->toBeTrue()
        ->and(File::exists(public_path('themes/orbit/assets/css/style.css')))->toBeTrue()
        ->and(File::exists(public_path('themes/orbit/assets/js/script.js')))->toBeTrue()
        ->and(File::exists(public_path('themes/orbit/assets/images/planet-atlas.svg')))->toBeTrue()
        ->and(File::exists(public_path('themes/orbit/assets/images/planet-lyra.svg')))->toBeTrue()
        ->and(File::exists(public_path('images/themes/orbit-thumb.svg')))->toBeTrue();
});
