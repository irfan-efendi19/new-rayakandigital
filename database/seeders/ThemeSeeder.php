<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Theme::updateOrCreate(
            ['view_path' => 'themes.elegant'],
            ['name' => 'Elegant Rose', 'thumbnail' => '/images/themes/elegant-thumb.jpg', 'is_premium' => false, 'is_active' => true]
        );
        Theme::updateOrCreate(
            ['view_path' => 'themes.modern'],
            ['name' => 'Modern Dark', 'thumbnail' => '/images/themes/modern-thumb.jpg', 'is_premium' => false, 'is_active' => true]
        );
        Theme::updateOrCreate(
            ['view_path' => 'themes.garden'],
            ['name' => 'Garden Green', 'thumbnail' => '/images/themes/garden-thumb.jpg', 'is_premium' => true, 'is_active' => true]
        );
    }
}

