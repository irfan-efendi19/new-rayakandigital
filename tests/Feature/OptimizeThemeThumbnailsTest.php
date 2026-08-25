<?php

use App\Models\Theme;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function storeLegacyThemeThumbnail(string $path, int $width = 1200, int $height = 2133): void
{
    $image = UploadedFile::fake()->image('legacy.jpg', $width, $height);

    Storage::disk('public')->put($path, file_get_contents($image->getRealPath()));
}

test('theme thumbnail optimization supports a dry run without changing files or database records', function () {
    Storage::fake('public');
    storeLegacyThemeThumbnail('themes/thumbnails/legacy.jpg');

    $theme = Theme::create([
        'name' => 'Tema Legacy',
        'view_path' => 'themes.legacy',
        'thumbnail_portrait' => 'themes/thumbnails/legacy.jpg',
        'is_active' => true,
    ]);

    $this->artisan('themes:optimize-thumbnails', ['--dry-run' => true])
        ->expectsOutputToContain('Akan dioptimalkan: Tema Legacy')
        ->assertSuccessful();

    expect($theme->refresh()->thumbnail_portrait)->toBe('themes/thumbnails/legacy.jpg');
    Storage::disk('public')->assertCount('themes/thumbnails', 1);
});

test('theme thumbnail optimization creates webp derivative and keeps original file', function () {
    Storage::fake('public');
    storeLegacyThemeThumbnail('themes/thumbnails/legacy.jpg');

    $theme = Theme::create([
        'name' => 'Tema Legacy',
        'view_path' => 'themes.legacy',
        'thumbnail_portrait' => 'themes/thumbnails/legacy.jpg',
        'is_active' => true,
    ]);

    $this->artisan('themes:optimize-thumbnails')
        ->expectsOutputToContain('Dioptimalkan: Tema Legacy')
        ->assertSuccessful();

    $optimizedPath = $theme->refresh()->thumbnail_portrait;

    expect($optimizedPath)
        ->toStartWith('themes/thumbnails/legacy-')
        ->toEndWith('.webp');

    Storage::disk('public')->assertExists('themes/thumbnails/legacy.jpg');
    Storage::disk('public')->assertExists($optimizedPath);

    [$width] = getimagesize(Storage::disk('public')->path($optimizedPath));

    expect($width)->toBeLessThanOrEqual(640)
        ->and(Storage::disk('public')->size($optimizedPath))->toBeLessThanOrEqual(262144);
});

test('theme pages use resolved thumbnail urls and defer image decoding', function () {
    $theme = Theme::create([
        'name' => 'Tema Statik',
        'view_path' => 'themes.static',
        'thumbnail_portrait' => '/images/themes/static-thumb.svg',
        'is_active' => true,
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('src="'.asset('images/themes/static-thumb.svg').'"', false)
        ->assertSee('loading="lazy" decoding="async"', false);

    $this->get(route('themes.index'))
        ->assertSuccessful()
        ->assertSee('src="'.asset('images/themes/static-thumb.svg').'"', false)
        ->assertSee('decoding="async"', false);
});
