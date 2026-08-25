<?php

use App\Models\Theme;
use Database\Seeders\ThemeSeeder;
use Illuminate\Support\Facades\File;

test('attendance clock theme renders the complete fingerprint terminal invitation', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.attendance_clock'],
        [
            'name' => 'Attendance Time Clock',
            'thumbnail_portrait' => '/images/themes/attendance-clock-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'attendance-clock']));

    $response->assertSuccessful();
    $response->assertSee('themes/attendance_clock/assets/css/style.css', false);
    $response->assertSee('themes/attendance_clock/assets/js/script.js', false);
    $response->assertSee('Verified:', false);
    $response->assertSee('Welcome Onboard', false);
    $response->assertSee('Hadir Tepat Waktu Menuju Pelaminan', false);
    $response->assertSee('Jam Masuk Kerja', false);
    $response->assertSee('Wajib melakukan scan kehadiran membawa doa restu.', false);
    $response->assertSee('[ Punch In &amp; Konfirmasi Hadir ]', false);
});

test('attendance clock preview aliases resolve to the canonical theme', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.attendance_clock'],
        ['name' => 'Attendance Time Clock', 'is_premium' => true, 'is_active' => true]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('Welcome Onboard', false);
})->with(['attendance-clock', 'fingerprint-attendance', 'kartu-absensi', 'mesin-absensi', 'time-clock']);

test('theme seeder registers attendance clock with preview schedule and thumbnail', function () {
    $this->seed(ThemeSeeder::class);

    $theme = Theme::query()->where('view_path', 'themes.attendance_clock')->firstOrFail();

    expect($theme->thumbnail_portrait)->toBe('/images/themes/attendance-clock-thumb.svg')
        ->and($theme->previewData)->not->toBeNull()
        ->and($theme->previewData->groom_full_name)->toBe('Dimas Pradana')
        ->and($theme->previewData->events)->toHaveCount(2);
});

test('attendance clock public assets exist', function () {
    expect(File::exists(public_path('themes/attendance_clock/assets/css/style.css')))->toBeTrue()
        ->and(File::exists(public_path('themes/attendance_clock/assets/js/script.js')))->toBeTrue()
        ->and(File::exists(public_path('themes/attendance_clock/assets/images/fingerprint.svg')))->toBeTrue()
        ->and(File::exists(public_path('images/themes/attendance-clock-thumb.svg')))->toBeTrue();
});
