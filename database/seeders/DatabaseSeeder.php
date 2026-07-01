<?php

namespace Database\Seeders;

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
        \App\Models\SystemConfig::firstOrCreate(
            ['id' => 1],
            [
                'demo_duration_days' => 3,
                'demo_grace_period_days' => 30,
            ]
        );

        // Payment Gateway Settings
        \App\Models\PaymentGatewaySetting::firstOrCreate(
            ['provider_name' => 'midtrans'],
            [
                'client_key' => 'SB-Mid-client-SampleKey123',
                'server_key' => 'SB-Mid-server-SampleKey123',
                'webhook_secret' => 'webhook_secret_midtrans_sample',
                'environment' => 'sandbox',
                'is_active' => true,
            ]
        );

        \App\Models\PaymentGatewaySetting::firstOrCreate(
            ['provider_name' => 'xendit'],
            [
                'client_key' => 'xnd_public_key_sample',
                'server_key' => 'xnd_secret_key_sample',
                'webhook_secret' => 'xnd_webhook_secret_sample',
                'environment' => 'sandbox',
                'is_active' => false,
            ]
        );

        \App\Models\PaymentGatewaySetting::firstOrCreate(
            ['provider_name' => 'stripe'],
            [
                'client_key' => 'pk_test_sample',
                'server_key' => 'sk_test_sample',
                'webhook_secret' => 'whsec_sample',
                'environment' => 'sandbox',
                'is_active' => false,
            ]
        );

        // Addons
        \App\Models\Addon::firstOrCreate(
            ['slug' => 'addon-digital-gift'],
            [
                'name' => 'Amplop Digital',
                'description' => 'Fitur amplop digital untuk menerima hadiah secara online.',
                'price' => 15000.00,
                'icon_identifier' => 'heroicon-o-gift',
                'is_available' => true,
            ]
        );

        \App\Models\Addon::firstOrCreate(
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
        \App\Models\PreviewData::firstOrCreate(
            ['id' => 1],
            \App\Models\PreviewData::defaultData()
        );

        $this->call(ThemeSeeder::class);

        $this->call(PackageSeeder::class);

        $this->call(QuoteTemplateSeeder::class);
    }
}
