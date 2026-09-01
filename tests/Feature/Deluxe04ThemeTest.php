<?php

use App\Models\Invitation;
use App\Models\Theme;

function createDeluxe04Theme(): Theme
{
    return Theme::firstOrCreate(
        ['view_path' => 'themes.deluxe_04'],
        [
            'name' => 'Deluxe 04 — Gallery House Editorial',
            'thumbnail_portrait' => '/images/themes/deluxe-04-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ],
    );
}

test('deluxe 04 can be previewed with its gallery house layout', function () {
    createDeluxe04Theme();

    $response = $this->get(route('theme.preview', ['themeSlug' => 'deluxe-04']));

    $response->assertSuccessful();
    $response->assertSee('d04v-layout', false);
    $response->assertSee('d04v-cover-rule', false);
    $response->assertSee('d04v-hero-rail', false);
    $response->assertSee('d04v-stage-caption', false);
    $response->assertSee('GALLERY HOUSE', false);
    $response->assertSee('DELUXE / 04', false);
    $response->assertSee('NO. 04 · GALLERY HOUSE COLLECTION', false);
    $response->assertSee('themes/deluxe_04/assets/css/style.css', false);
    $response->assertSee('themes/deluxe_04/assets/js/script.js', false);
    $response->assertDontSee('d04-nav', false);
    $response->assertSee('Kedua Mempelai', false);
    $response->assertSee('Acara Pernikahan', false);
    $response->assertSee('Kisah Cinta', false);
    $response->assertSee('Galeri Kenangan', false);
    $response->assertSee('Konfirmasi Kehadiran', false);
    $response->assertSee('Ucapan &amp; Doa', false);

    $css = file_get_contents(public_path('themes/deluxe_04/assets/css/style.css'));

    expect($css)
        ->toContain('Deluxe 04 — Gallery House layout')
        ->toContain('grid-template-columns: minmax(520px, 58vw) minmax(360px, 42vw)')
        ->toContain('grid-column: 2')
        ->toContain('height: 100dvh')
        ->toContain('@media (max-width: 820px)')
        ->toContain('.d04v-layout .d04-couple');
});

test('deluxe 04 aliases resolve to the same preview', function (string $slug) {
    createDeluxe04Theme();

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('d04v-layout', false)
        ->assertSee('DELUXE / 04', false);
})->with([
    'deluxe-04',
    'deluxe_04',
    'deluxe04',
]);

test('deluxe 04 supports a custom guest name', function () {
    createDeluxe04Theme();

    $this->get(route('theme.preview', [
        'themeSlug' => 'deluxe-04',
        'to' => 'Keluarga Mahendra',
    ]))
        ->assertSuccessful()
        ->assertSee('Keluarga Mahendra', false);
});

test('active invitations can render deluxe 04 independently', function () {
    $invitation = Invitation::factory()->create([
        'theme' => 'deluxe_04',
        'is_active' => true,
    ]);

    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertSee('d04v-layout', false)
        ->assertSee('themes/deluxe_04/assets/css/style.css', false)
        ->assertSee('DELUXE / 04', false)
        ->assertDontSee('themes/deluxe_01/assets/css/style.css', false)
        ->assertDontSee('themes/deluxe_02/assets/css/style.css', false)
        ->assertDontSee('themes/deluxe_03/assets/css/style.css', false);
});
