<?php

namespace Database\Factories;

use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Guest>
 */
class GuestFactory extends Factory
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
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'whatsapp_number' => '628' . $this->faker->numerify('##########'),
            'address' => $this->faker->address(),
            'qr_code_token' => (string) Str::uuid(),
            'attendance_status' => 'pending',
            'checked_in_at' => null,
        ];
    }

    public function hadir(): static
    {
        return $this->state(fn (array $attributes) => [
            'attendance_status' => 'hadir',
            'checked_in_at' => now(),
        ]);
    }

    public function absen(): static
    {
        return $this->state(fn (array $attributes) => [
            'attendance_status' => 'absen',
            'checked_in_at' => null,
        ]);
    }
}
