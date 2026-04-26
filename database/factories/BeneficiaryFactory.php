<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'fullName' => $this->faker->name(),
            // 'surname' => $this->faker->lastName(),
            // 'ssn' => $this->faker->unique()->numerify('#########'),
            // 'date_of_birth' => $this->faker->date(),
            // 'place_of_birth' => $this->faker->city(),
            // 'address' => $this->faker->address(),
            // 'phone_number' => $this->faker->phoneNumber(),
            // 'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
