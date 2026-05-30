<?php

namespace Database\Factories;

use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'slug' => $this->faker->unique()->slug(),
            'title' => $this->faker->sentence(3),
            'bride_name' => $this->faker->name('female'),
            'groom_name' => $this->faker->name('male'),
            'bride_nickname' => $this->faker->firstName('female'),
            'groom_nickname' => $this->faker->firstName('male'),
            'theme' => 'elegant',
            'tier' => 'free',
            'is_active' => true,
        ];
    }
}
