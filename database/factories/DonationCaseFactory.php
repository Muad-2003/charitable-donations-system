<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationCase>
 */
class DonationCaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // /* 'beneficiary_id' => Beneficiary::factory(), */
            // 'title' => $this->faker->sentence(),
            // 'description' => $this->faker->paragraph(),
            // 'target_amount' => $this->faker->randomFloat(2, 100, 10000),
            // 'current_amount' => $this->faker->numberBetween(0, 'target_amount'),
            // 'status' => $this->faker->randomElement(['active', 'pending']),
            // 'type' => $this->faker->randomElement(['زكاة', 'صدقة', 'علاج', 'وقف']),
        ];
    }
}
