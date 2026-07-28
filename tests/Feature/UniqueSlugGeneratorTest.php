<?php

use App\Models\Addon;
use App\Models\Package;
use App\Models\PlatformFeature;
use App\Models\ScreenPreset;
use App\Support\UniqueSlugGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('generates a base slug when no duplicate exists', function () {
    $slug = UniqueSlugGenerator::generate(Addon::class, 'My Addon');

    expect($slug)->toBe('my-addon');
});

it('appends random suffix when slug already exists', function () {
    Addon::create(['name' => 'My Addon', 'slug' => 'my-addon', 'price' => 10000]);

    $slug = UniqueSlugGenerator::generate(Addon::class, 'My Addon');

    expect($slug)
        ->toStartWith('my-addon-')
        ->not->toBe('my-addon')
        ->toMatch('/^my-addon-[a-z0-9]{5}$/');
});

it('ignores the current record id on update', function () {
    $addon = Addon::create(['name' => 'My Addon', 'slug' => 'my-addon', 'price' => 10000]);

    $slug = UniqueSlugGenerator::generate(Addon::class, 'My Addon', 'slug', $addon->id);

    expect($slug)->toBe('my-addon');
});

it('works with custom column for Package model', function () {
    Package::create(['package_name' => 'Basic', 'package_code' => 'basic', 'price' => 50000, 'active_period_days' => 30]);

    $slug = UniqueSlugGenerator::generate(Package::class, 'Basic', 'package_code');

    expect($slug)
        ->toStartWith('basic-')
        ->not->toBe('basic');
});

it('works with custom column for PlatformFeature model', function () {
    PlatformFeature::create(['feature_name' => 'Gallery', 'feature_key' => 'gallery']);

    $slug = UniqueSlugGenerator::generate(PlatformFeature::class, 'Gallery', 'feature_key');

    expect($slug)
        ->toStartWith('gallery-')
        ->not->toBe('gallery');
});

it('auto-generates unique slug via model creating hook', function () {
    Addon::create(['name' => 'Music Player', 'slug' => 'music-player', 'price' => 10000]);
    $second = Addon::create(['name' => 'Music Player', 'price' => 10000]);

    expect($second->slug)
        ->toStartWith('music-player-')
        ->not->toBe('music-player');
});

it('auto-generates unique slug for ScreenPreset model', function () {
    ScreenPreset::create(['name' => 'Elegant', 'slug' => 'elegant']);
    $second = ScreenPreset::create(['name' => 'Elegant']);

    expect($second->slug)
        ->toStartWith('elegant-')
        ->not->toBe('elegant');
});
