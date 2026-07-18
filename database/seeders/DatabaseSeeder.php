<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\PreviewData;
use App\Models\SystemConfig;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // System Config
        SystemConfig::firstOrCreate(
            ['id' => 1],
            [
                'demo_duration_days' => 3,
                'demo_grace_period_days' => 30,
            ]
        );

        // Addons
        Addon::firstOrCreate(
            ['slug' => 'addon-digital-gift'],
            [
                'name' => 'Amplop Digital',
                'description' => 'Fitur amplop digital untuk menerima hadiah secara online.',
                'price' => 15000.00,
                'icon_identifier' => 'heroicon-o-gift',
                'is_available' => true,
            ]
        );

        Addon::firstOrCreate(
            ['slug' => 'addon-custom-music'],
            [
                'name' => 'Musik Kustom',
                'description' => 'Unggah musik latar kustom untuk undangan Anda.',
                'price' => 15000.00,
                'icon_identifier' => 'heroicon-o-musical-note',
                'is_available' => true,
            ]
        );

        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@rayakandigital.test'],
            [
                'name' => 'Admin Rayakan Digital',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Regular User
        User::firstOrCreate(
            ['email' => 'user@rayakandigital.test'],
            [
                'name' => 'User Biasa',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        // Preview Data (default dummy for theme preview)
        PreviewData::firstOrCreate(
            ['id' => 1],
            PreviewData::defaultData()
        );

        $this->call(ThemeSeeder::class);

        $this->call(PackageSeeder::class);

        $this->call(QuoteTemplateSeeder::class);

        $this->call(ScreenPresetSeeder::class);
    }
}
