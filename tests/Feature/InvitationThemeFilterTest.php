<?php

use App\Models\Invitation;
use App\Models\Theme;
use App\Models\ThemeCategory;
use App\Models\User;

beforeEach(function () {
    $this->themeCategory = ThemeCategory::create([
        'name' => 'Romantis Khusus',
        'slug' => 'romantis-khusus',
    ]);

    Theme::create([
        'theme_category_id' => $this->themeCategory->id,
        'name' => 'Tema Romantis',
        'view_path' => 'themes.romantis_khusus',
        'thumbnail_portrait' => 'images/themes/romantis.svg',
        'is_active' => true,
    ]);

    Theme::create([
        'name' => 'WhatsApp Chat',
        'view_path' => 'themes.whatsapp',
        'thumbnail_portrait' => 'images/themes/whatsapp.svg',
        'is_active' => true,
    ]);
});

test('invitation create uses admin theme categories and lazy loads previews', function () {

    $response = $this->actingAs(User::factory()->create())
        ->get(route('invitation.create'));

    $response->assertSuccessful()
        ->assertSee('aria-label="Filter kategori tema"', false)
        ->assertSee('data-category="romantis-khusus"', false)
        ->assertSee('data-category="__uncategorized__"', false)
        ->assertSee('data-initial-category="romantis-khusus"', false)
        ->assertSee('loading="lazy"', false)
        ->assertSee('decoding="async"', false)
        ->assertSee('/images/themes/whatsapp.svg', false)
        ->assertDontSee('/storage//images/themes/whatsapp.svg', false)
        ->assertSeeText('Romantis Khusus')
        ->assertSeeText('Tanpa Kategori')
        ->assertDontSeeText('Sosial & Digital');
});

test('invitation edit uses admin theme categories and opens the selected theme category', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->for($user)->create([
        'theme' => 'romantis_khusus',
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.invitations.edit', $invitation));

    $response->assertSuccessful()
        ->assertSee('aria-label="Filter kategori tema"', false)
        ->assertSee('data-category="romantis-khusus"', false)
        ->assertSee('data-category="__uncategorized__"', false)
        ->assertSee('data-selected-theme="romantis_khusus"', false)
        ->assertSee('data-initial-category="romantis-khusus"', false)
        ->assertSee('loading="lazy"', false)
        ->assertSee('decoding="async"', false)
        ->assertSee('/images/themes/whatsapp.svg', false)
        ->assertDontSee('/storage//images/themes/whatsapp.svg', false)
        ->assertSeeText('Romantis Khusus')
        ->assertSeeText('Tanpa Kategori');
});
