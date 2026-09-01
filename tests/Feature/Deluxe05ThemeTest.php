<?php

use App\Models\Invitation;
use App\Models\Theme;

function createDeluxe05Theme(): Theme
{
    return Theme::firstOrCreate(
        ['view_path' => 'themes.deluxe_05'],
        [
            'name' => 'Deluxe 05 — Cinema Journal Editorial',
            'thumbnail_portrait' => '/images/themes/deluxe-05-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ],
    );
}

test('deluxe 05 can be previewed with its cinema journal layout', function () {
    createDeluxe05Theme();

    $response = $this->get(route('theme.preview', ['themeSlug' => 'deluxe-05']));

    $response->assertSuccessful();
    $response->assertSee('d05-layout', false);
    $response->assertSee('d05-cover-meta', false);
    $response->assertSee('d05-running-line', false);
    $response->assertSee('d05-hero-index', false);
    $response->assertSee('d05-hero-note', false);
    $response->assertSee('A CINEMA JOURNAL', false);
    $response->assertSee('DELUXE / 05', false);
    $response->assertSee('NO. 05 · CINEMA JOURNAL COLLECTION', false);
    $response->assertSee('themes/deluxe_05/assets/css/style.css', false);
    $response->assertSee('themes/deluxe_05/assets/js/script.js', false);
    $response->assertDontSee('d04-nav', false);
    $response->assertSee('Kedua Mempelai', false);
    $response->assertSee('Acara Pernikahan', false);
    $response->assertSee('Kisah Cinta', false);
    $response->assertSee('Galeri Kenangan', false);
    $response->assertSee('Konfirmasi Kehadiran', false);
    $response->assertSee('Ucapan &amp; Doa', false);

    $css = file_get_contents(public_path('themes/deluxe_05/assets/css/style.css'));

    expect($css)
        ->toContain('Deluxe 05 — Cinema Journal layout')
        ->toContain('grid-template-columns: 78px minmax(0, 1.55fr) minmax(300px, .62fr)')
        ->toContain('height: 100dvh')
        ->toContain('body.d05-layout .d04-events .d04-heading')
        ->toContain('@media (max-width: 820px)')
        ->toContain('body.d05-layout .d04-couple');
});

test('deluxe 05 aliases resolve to the same preview', function (string $slug) {
    createDeluxe05Theme();

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('d05-layout', false)
        ->assertSee('DELUXE / 05', false);
})->with([
    'deluxe-05',
    'deluxe_05',
    'deluxe05',
]);

test('deluxe 05 supports a custom guest name', function () {
    createDeluxe05Theme();

    $this->get(route('theme.preview', [
        'themeSlug' => 'deluxe-05',
        'to' => 'Keluarga Sinema',
    ]))
        ->assertSuccessful()
        ->assertSee('Keluarga Sinema', false);
});

test('active invitations can render deluxe 05 independently', function () {
    $invitation = Invitation::factory()->create([
        'theme' => 'deluxe_05',
        'is_active' => true,
    ]);

    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertSee('d05-layout', false)
        ->assertSee('themes/deluxe_05/assets/css/style.css', false)
        ->assertSee('DELUXE / 05', false)
        ->assertDontSee('themes/deluxe_01/assets/css/style.css', false)
        ->assertDontSee('themes/deluxe_02/assets/css/style.css', false)
        ->assertDontSee('themes/deluxe_03/assets/css/style.css', false)
        ->assertDontSee('themes/deluxe_04/assets/css/style.css', false);
});
