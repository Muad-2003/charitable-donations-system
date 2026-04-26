<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrepaidCard>
 */
class PrepaidCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected array $amounts = [10, 50, 100];

    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('########'),
            'amount' => $this->faker->randomElement($this->amounts),
        ];
    }
}
