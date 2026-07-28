<?php

namespace Database\Factories;

use App\Models\ScreenPreset;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ScreenPreset>
 */
class ScreenPresetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'thumbnail_image' => null,
            'html_content' => null,
            'zip_path' => null,
            'storage_path' => null,
            'is_active' => true,
        ];
    }
}
