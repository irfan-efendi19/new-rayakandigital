<?php

use App\Models\Invitation;
use App\Models\Theme;

function createDeluxe03Theme(): Theme
{
    return Theme::firstOrCreate(
        ['view_path' => 'themes.deluxe_03'],
        [
            'name' => 'Deluxe 03 — Art Book Editorial',
            'thumbnail_portrait' => '/images/themes/deluxe-03-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ],
    );
}

test('deluxe 03 can be previewed with its creative art book layout', function () {
    createDeluxe03Theme();

    $response = $this->get(route('theme.preview', ['themeSlug' => 'deluxe-03']));

    $response->assertSuccessful();
    $response->assertSee('d03-layout', false);
    $response->assertSee('d03-hero-index', false);
    $response->assertSee('VOL. III', false);
    $response->assertSee('themes/deluxe_03/assets/css/style.css', false);
    $response->assertSee('themes/deluxe_03/assets/js/script.js', false);
    $response->assertSee('DELUXE / 03', false);
    $response->assertSee('NO. 03 · ART BOOK COLLECTION', false);
    $response->assertDontSee('d04-nav', false);
    $response->assertSee('Kedua Mempelai', false);
    $response->assertSee('Acara Pernikahan', false);
    $response->assertSee('Kisah Cinta', false);
    $response->assertSee('Galeri Kenangan', false);
    $response->assertSee('Konfirmasi Kehadiran', false);
    $response->assertSee('Ucapan &amp; Doa', false);

    $deluxe01Css = file_get_contents(public_path('themes/deluxe_01/assets/css/style.css'));
    $deluxe03Css = file_get_contents(public_path('themes/deluxe_03/assets/css/style.css'));

    expect(str_starts_with($deluxe03Css, $deluxe01Css))->toBeTrue()
        ->and($deluxe03Css)
        ->toContain('.d03-hero-index { display: none; }')
        ->toContain('.d03-layout .d04-panel-hero')
        ->toContain('height: 100dvh')
        ->toContain('@media (max-width: 820px)')
        ->toContain('.d03-layout .d04-couple');
});

test('deluxe 03 aliases resolve to the same preview', function (string $slug) {
    createDeluxe03Theme();

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('d03-layout', false)
        ->assertSee('DELUXE / 03', false);
})->with([
    'deluxe-03',
    'deluxe_03',
    'deluxe03',
]);

test('deluxe 03 supports a custom guest name', function () {
    createDeluxe03Theme();

    $this->get(route('theme.preview', [
        'themeSlug' => 'deluxe-03',
        'to' => 'Keluarga Pratama',
    ]))
        ->assertSuccessful()
        ->assertSee('Keluarga Pratama', false);
});

test('active invitations can render deluxe 03 independently', function () {
    $invitation = Invitation::factory()->create([
        'theme' => 'deluxe_03',
        'is_active' => true,
    ]);

    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertSee('d03-layout', false)
        ->assertSee('themes/deluxe_03/assets/css/style.css', false)
        ->assertSee('DELUXE / 03', false)
        ->assertDontSee('themes/deluxe_01/assets/css/style.css', false)
        ->assertDontSee('themes/deluxe_02/assets/css/style.css', false);
});
