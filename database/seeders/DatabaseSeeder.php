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
            ['feature_key' => 'addon_digital_gift'],
            [
                'feature_name' => 'Amplop Digital',
                'price' => 15000.00,
                'is_active' => true,
            ]
        );

        \App\Models\Addon::firstOrCreate(
            ['feature_key' => 'addon_custom_music'],
            [
                'feature_name' => 'Musik Kustom',
                'price' => 15000.00,
                'is_active' => true,
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

        $this->call(ThemeSeeder::class);

        $this->call(PackageSeeder::class);
    }
}
