<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'mc' => fake()->numberBetween(10000, 999999),
            'dot' => fake()->numberBetween(100000, 9999999),
            'about' => fake()->paragraph(),
            'street_address' => fake()->buildingNumber() . fake()->streetAddress,
            'city'=> fake()->city(),
            'state' => fake('en_US')->state(),
            'zip_code' => fake()->postcode(),
            'country' => fake()->country(),
            'phone' => fake()->phoneNumber()
        ];
    }
}
