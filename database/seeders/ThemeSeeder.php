<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        Theme::updateOrCreate(
            ['view_path' => 'themes.elegant'],
            ['name' => 'Elegant Rose', 'thumbnail_portrait' => '/images/themes/elegant-thumb.jpg', 'is_premium' => false, 'is_active' => true]
        );
        Theme::updateOrCreate(
            ['view_path' => 'themes.modern'],
            ['name' => 'Modern Dark', 'thumbnail_portrait' => '/images/themes/modern-thumb.jpg', 'is_premium' => false, 'is_active' => true]
        );
        Theme::updateOrCreate(
            ['view_path' => 'themes.garden'],
            ['name' => 'Garden Green', 'thumbnail_portrait' => '/images/themes/garden-thumb.jpg', 'is_premium' => true, 'is_active' => true]
        );
    }
}
