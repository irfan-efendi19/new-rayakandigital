<?php

namespace Database\Seeders;

use App\Models\ScreenPreset;
use Illuminate\Database\Seeder;

class ScreenPresetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $presets = [
            [
                'name' => 'Minimalist Typography',
                'slug' => 'minimal-clean',
                'description' => 'Desain bersih dan elegan dengan latar pastel terang dan aksen emas. Cocok untuk undangan berkelas.',
                'thumbnail_image' => null,
                'html_content' => <<<'HTML'
<style>
    :root {
        --font-heading: 'Cormorant Garamond', serif;
        --font-body: 'Inter', sans-serif;
        --bg-gradient: linear-gradient(135deg, #fbfbf9 0%, #f4f3ee 100%);
        --accent-color: #c5a880;
        --accent-gradient: linear-gradient(135deg, #c5a880 0%, #b3956d 50%, #c5a880 100%);
        --text-primary: #1a1a1a;
        --text-secondary: rgba(26, 26, 26, 0.6);
        --border-color: rgba(197, 168, 128, 0.4);
        --card-bg: rgba(255, 255, 255, 0.8);
        --card-text: #1a1a1a;
    }
</style>
HTML,
                'is_active' => true,
            ],
            [
                'name' => 'Rustic Floral',
                'slug' => 'rustic-floral',
                'description' => 'Nuansa alam dedaunan dengan animasi kelopak bunga berguguran yang manis dan romantis.',
                'thumbnail_image' => null,
                'html_content' => <<<'HTML'
<style>
    :root {
        --font-heading: 'Cormorant Garamond', serif;
        --font-body: 'Inter', sans-serif;
        --bg-gradient: linear-gradient(135deg, #f4f6f0 0%, #e2e8da 100%);
        --accent-color: #8fa882;
        --accent-gradient: linear-gradient(135deg, #8fa882 0%, #768d6a 50%, #8fa882 100%);
        --text-primary: #2d3829;
        --text-secondary: rgba(45, 56, 41, 0.6);
        --border-color: rgba(143, 168, 130, 0.4);
        --card-bg: rgba(255, 255, 255, 0.85);
        --card-text: #2d3829;
    }
</style>
HTML,
                'is_active' => true,
            ],
            [
                'name' => 'Modern Dark',
                'slug' => 'modern-dark',
                'description' => 'Nuansa gelap kontras tinggi dengan efek bersinar yang premium untuk proyektor.',
                'thumbnail_image' => null,
                'html_content' => <<<'HTML'
<style>
    :root {
        --font-heading: 'Playfair Display', serif;
        --font-body: 'Inter', sans-serif;
        --bg-gradient: linear-gradient(135deg, #09090d 0%, #12121e 50%, #0d0d16 100%);
        --accent-color: #fda085;
        --accent-gradient: linear-gradient(135deg, #f6d365 0%, #fda085 50%, #f6d365 100%);
        --text-primary: #ffffff;
        --text-secondary: rgba(255, 255, 255, 0.5);
        --border-color: rgba(254, 160, 133, 0.3);
        --card-bg: rgba(255, 255, 255, 0.07);
        --card-text: #ffffff;
    }
</style>
HTML,
                'is_active' => true,
            ],
        ];

        foreach ($presets as $preset) {
            ScreenPreset::updateOrCreate(
                ['slug' => $preset['slug']],
                $preset
            );
        }
    }
}
