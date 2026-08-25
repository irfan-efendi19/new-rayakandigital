<?php

use App\Filament\Forms\Components\CompressedImageUpload;
use App\Filament\Resources\PreviewData\Pages\EditPreviewData;
use App\Filament\Resources\ScreenPresets\Pages\EditScreenPreset;
use App\Filament\Resources\Themes\Pages\EditTheme;
use App\Models\PreviewData;
use App\Models\ScreenPreset;
use App\Models\Theme;
use App\Models\User;
use Filament\Forms\Components\Field;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('filament admin image fields use automatic compression', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $previewData = PreviewData::create(PreviewData::defaultData());
    $theme = Theme::create([
        'name' => 'Tema Tes',
        'view_path' => 'themes.test',
        'is_active' => true,
    ]);
    $screenPreset = ScreenPreset::create([
        'name' => 'Preset Tes',
        'slug' => 'preset-tes',
        'is_active' => true,
    ]);

    $usesCompression = fn (Field $field): bool => $field instanceof CompressedImageUpload;

    $previewForm = Livewire::actingAs($admin)
        ->test(EditPreviewData::class, ['record' => $previewData->getRouteKey()]);

    foreach (['cover_photo', 'bride_photo', 'groom_photo', 'gallery_photos'] as $field) {
        $previewForm->assertFormFieldExists($field, $usesCompression);
    }

    $themeForm = Livewire::actingAs($admin)
        ->test(EditTheme::class, ['record' => $theme->getRouteKey()]);

    foreach ([
        'thumbnail_portrait',
        'preview_hero_image_path',
        'preview_bride_photo_path',
        'preview_groom_photo_path',
        'preview_gallery_photos',
    ] as $field) {
        $themeForm->assertFormFieldExists($field, $usesCompression);
    }

    Livewire::actingAs($admin)
        ->test(EditScreenPreset::class, ['record' => $screenPreset->getRouteKey()])
        ->assertFormFieldExists('thumbnail_image', $usesCompression);
});

test('filament admin stores uploaded images as compressed webp files', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['role' => 'admin']);
    $previewData = PreviewData::create(PreviewData::defaultData());

    Livewire::actingAs($admin)
        ->test(EditPreviewData::class, ['record' => $previewData->getRouteKey()])
        ->fillForm([
            'cover_photo' => UploadedFile::fake()->image('cover.png', 1800, 1400),
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $storedPath = $previewData->refresh()->cover_photo;

    expect($storedPath)
        ->toStartWith('preview/photos/')
        ->and(pathinfo($storedPath, PATHINFO_EXTENSION))->toBe('webp');

    Storage::disk('public')->assertExists($storedPath);

    $absolutePath = Storage::disk('public')->path($storedPath);
    [$width] = getimagesize($absolutePath);

    expect($width)->toBeLessThanOrEqual(1200)
        ->and(filesize($absolutePath))->toBeLessThanOrEqual(1048576);
});
