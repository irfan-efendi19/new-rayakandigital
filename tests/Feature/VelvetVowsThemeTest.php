<?php

use App\Models\Invitation;
use App\Models\Theme;

function createVelvetVowsTheme(): Theme
{
    return Theme::firstOrCreate(
        ['view_path' => 'themes.velvet_vows'],
        [
            'name' => 'Velvet Vows — Burgundy & Gold',
            'thumbnail_portrait' => '/images/themes/velvet-vows-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ],
    );
}

test('velvet vows can be previewed with its complete burgundy wedding layout', function () {
    createVelvetVowsTheme();

    $response = $this->get(route('theme.preview', ['themeSlug' => 'velvet-vows']));

    $response->assertSuccessful();
    $response->assertSee('vv-cover', false);
    $response->assertSee('vv-cover-date', false);
    $response->assertSee('vv-seal', false);
    $response->assertSee('vv-nav', false);
    $response->assertSee('Buka Undangan', false);
    $response->assertSee('id="vvMain" tabindex="-1" inert aria-hidden="true"', false);
    $response->assertSee('id="vvShare"', false);
    $response->assertSee('Bagikan Undangan', false);
    $response->assertSee('data-vv-gift-label', false);
    $response->assertSee('role="dialog" aria-modal="true"', false);
    $response->assertSee('Kedua Mempelai', false);
    $response->assertSee('Waktu &amp; Tempat', false);
    $response->assertSee('Perjalanan Kami', false);
    $response->assertSee('<ol class="vv-timeline" aria-label="Linimasa perjalanan pasangan">', false);
    $response->assertSee('vv-story-date', false);
    $response->assertSee('vv-story-copy', false);
    $response->assertSee('Tanda Kasih', false);
    $response->assertSee('Konfirmasi Kehadiran', false);
    $response->assertSee('Kirimkan Doa Terbaik', false);
    $response->assertSee('themes/velvet_vows/assets/css/style.css', false);
    $response->assertSee('themes/velvet_vows/assets/js/script.js', false);

    expect(file_get_contents(public_path('themes/velvet_vows/assets/css/style.css')))
        ->toContain('--vv-wine: #641d2c')
        ->toContain('min-height: 100dvh')
        ->toContain('.vv-cover-photo')
        ->toContain('.vv-cover-date')
        ->toContain('@media (min-width: 761px)')
        ->toContain('.vv-countdown')
        ->toContain('.vv-event-actions')
        ->toContain('grid-template-columns: 120px minmax(0, 1fr)')
        ->toContain('--vv-story-line: 7px')
        ->toContain('white-space: pre-line')
        ->toContain(':focus-visible')
        ->toContain('@media (max-width: 760px)')
        ->toContain('prefers-reduced-motion');

    expect(file_get_contents(public_path('themes/velvet_vows/assets/js/script.js')))
        ->toContain('function revealInvitation()')
        ->toContain('navigator.share')
        ->toContain("link.setAttribute('aria-current', 'page')")
        ->toContain("body.classList.add('vv-modal-open')");
});

test('velvet vows preview supports a personalized guest name', function () {
    createVelvetVowsTheme();

    $this->get(route('theme.preview', [
        'themeSlug' => 'velvet-vows',
        'to' => 'Keluarga Pratama',
    ]))
        ->assertSuccessful()
        ->assertSee('Keluarga Pratama', false);
});

test('an active invitation can render velvet vows independently', function () {
    $invitation = Invitation::factory()->create([
        'theme' => 'velvet_vows',
        'is_active' => true,
    ]);

    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertSee('vv-cover', false)
        ->assertSee('themes/velvet_vows/assets/css/style.css', false)
        ->assertDontSee('themes/deluxe_05/assets/css/style.css', false);
});

test('velvet vows navigation omits links for disabled invitation sections', function () {
    $invitation = Invitation::factory()->create([
        'theme' => 'velvet_vows',
        'is_active' => true,
        'show_event_detail' => false,
        'show_gift' => false,
        'show_comments' => false,
    ]);

    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertSee('href="#vvCouple"', false)
        ->assertDontSee('href="#vvEvents"', false)
        ->assertDontSee('href="#vvGift"', false)
        ->assertDontSee('href="#vvWishes"', false);
});

test('velvet vows navigation does not link to an empty gift section', function () {
    $invitation = Invitation::factory()->create([
        'theme' => 'velvet_vows',
        'is_active' => true,
        'show_gift' => true,
        'gift_banks' => [],
        'gift_ewallets' => [],
        'gift_bank_name' => null,
        'gift_bank_account' => null,
        'gift_ewallet_name' => null,
        'gift_ewallet_number' => null,
        'gift_qris_image' => null,
    ]);

    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertDontSee('id="vvGift"', false)
        ->assertDontSee('href="#vvGift"', false);
});
