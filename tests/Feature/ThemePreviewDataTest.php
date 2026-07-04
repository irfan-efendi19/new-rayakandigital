<?php

use App\Models\PreviewData;
use App\Models\Theme;
use App\Models\ThemePreviewData;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('theme preview uses global fallback when no theme-specific data exists', function () {
    PreviewData::getPreview();

    Theme::create([
        'name' => 'Garden Green',
        'view_path' => 'themes.garden',
        'is_premium' => false,
        'is_active' => true,
    ]);

    $this->get(route('theme.preview', 'garden'))
        ->assertSuccessful()
        ->assertSee('Ani Suryani');
});

test('theme preview uses theme-specific data when configured', function () {
    PreviewData::getPreview();

    $theme = Theme::create([
        'name' => 'Garden Green',
        'view_path' => 'themes.garden',
        'is_premium' => false,
        'is_active' => true,
    ]);

    ThemePreviewData::create([
        'theme_id' => $theme->id,
        'groom_full_name' => 'Rizky Pratama',
        'groom_short_name' => 'Rizky',
        'bride_full_name' => 'Dewi Lestari',
        'bride_short_name' => 'Dewi',
    ]);

    $this->get(route('theme.preview', 'garden'))
        ->assertSuccessful()
        ->assertSee('Dewi Lestari')
        ->assertSee('Rizky Pratama')
        ->assertDontSee('Ani Suryani');
});

test('theme preview merges partial theme data with global fallback', function () {
    $fallback = PreviewData::getPreview();

    $theme = Theme::create([
        'name' => 'Garden Green',
        'view_path' => 'themes.garden',
        'is_premium' => false,
        'is_active' => true,
    ]);

    $themePreview = new ThemePreviewData([
        'theme_id' => $theme->id,
        'bride_full_name' => 'Putri Adinda',
        'bride_short_name' => 'Putri',
        'groom_full_name' => null,
        'groom_short_name' => null,
    ]);

    $resolved = $themePreview->mergeWithFallback($fallback);

    expect($resolved->bride_name)->toBe('Putri Adinda')
        ->and($resolved->groom_name)->toBe('Budi Santoso');
});

test('legacy preview url redirects to new theme preview url', function () {
    PreviewData::getPreview();

    Theme::create([
        'name' => 'Garden Green',
        'view_path' => 'themes.garden',
        'is_premium' => false,
        'is_active' => true,
    ]);

    $this->get('/preview/garden')
        ->assertRedirect(route('theme.preview', 'garden'));
});

test('resolved preview data merges parents from theme-specific data', function () {
    PreviewData::getPreview();

    $theme = Theme::create([
        'name' => 'Garden Green',
        'view_path' => 'themes.garden',
        'is_premium' => false,
        'is_active' => true,
    ]);

    ThemePreviewData::create([
        'theme_id' => $theme->id,
        'groom_father_name' => 'Ahmad',
        'groom_mother_name' => 'Siti',
        'bride_father_name' => 'Bambang',
        'bride_mother_name' => 'Rina',
    ]);

    $resolved = $theme->fresh()->resolvedPreviewData();

    expect($resolved->groom_parents)->toBe('Putra dari Bapak Ahmad & Ibu Siti')
        ->and($resolved->bride_parents)->toBe('Putri dari Bapak Bambang & Ibu Rina');
});
