<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'mc' => fake()->numberBetween(10000, 999999),
            'dot' => fake()->numberBetween(100000, 9999999),
            'about' => fake()->paragraph(),
            'street_address' => fake()->buildingNumber() . fake()->streetAddress,
            'city' => fake()->city(),
            'state' => fake('en_US')->state(),
            'zip_code' => fake()->postcode(),
            'country' => fake()->country(),
            'phone' => fake()->phoneNumber(),
            'email' => Str::random(3) . fake()->unique()->safeEmail(),
        ];
    }
}
