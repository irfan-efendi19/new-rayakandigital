<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\InvitationScreen;
use App\Models\ScreenPreset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvitationScreen>
 */
class InvitationScreenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invitation_id' => Invitation::factory(),
            'selected_theme' => ScreenPreset::factory()->create()->slug,
            'custom_title' => null,
            'show_wishes_wall' => true,
        ];
    }
}
