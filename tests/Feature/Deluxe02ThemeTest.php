<?php

use App\Models\Invitation;
use App\Models\Theme;

function createDeluxe02Theme(): Theme
{
    return Theme::firstOrCreate(
        ['view_path' => 'themes.deluxe_02'],
        [
            'name' => 'Deluxe 02 — Wide Editorial',
            'thumbnail_portrait' => '/images/themes/deluxe-02-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ],
    );
}

test('deluxe 02 can be previewed with its wide editorial layout', function () {
    createDeluxe02Theme();

    $response = $this->get(route('theme.preview', ['themeSlug' => 'deluxe-02']));

    $response->assertSuccessful();
    $response->assertSee('d02-layout', false);
    $response->assertSee('themes/deluxe_02/assets/css/style.css', false);
    $response->assertSee('themes/deluxe_02/assets/js/script.js', false);
    $response->assertSee('DELUXE / 02', false);
    $response->assertSee('NO. 02 · EDITORIAL COLLECTION', false);
    $response->assertDontSee('d04-nav', false);
    $response->assertSee('Kedua Mempelai', false);
    $response->assertSee('Acara Pernikahan', false);
    $response->assertSee('Galeri Kenangan', false);
    $response->assertSee('Konfirmasi Kehadiran', false);
    $response->assertSee('Ucapan &amp; Doa', false);

    expect(file_get_contents(public_path('themes/deluxe_02/assets/css/style.css')))
        ->toContain('.d02-layout .d04-panel-hero')
        ->toContain('height: 100dvh');
});

test('deluxe 02 aliases resolve to the same preview', function (string $slug) {
    createDeluxe02Theme();

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('d02-layout', false)
        ->assertSee('DELUXE / 02', false);
})->with([
    'deluxe-02',
    'deluxe_02',
    'deluxe02',
]);

test('deluxe 02 supports a custom guest name', function () {
    createDeluxe02Theme();

    $this->get(route('theme.preview', [
        'themeSlug' => 'deluxe-02',
        'to' => 'Keluarga Wijaya',
    ]))
        ->assertSuccessful()
        ->assertSee('Keluarga Wijaya', false);
});

test('active invitations can render deluxe 02 without affecting deluxe 01', function () {
    $invitation = Invitation::factory()->create([
        'theme' => 'deluxe_02',
        'is_active' => true,
    ]);

    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertSee('d02-layout', false)
        ->assertSee('themes/deluxe_02/assets/css/style.css', false)
        ->assertSee('DELUXE / 02', false)
        ->assertDontSee('themes/deluxe_01/assets/css/style.css', false);
});
