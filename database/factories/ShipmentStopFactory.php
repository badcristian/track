<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShipmentStop>
 */
class ShipmentStopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pickup_time' => fake()->dateTime(),
            'delivery_time' => fake()->dateTime(),
            'reference_numbers' => fake()->numberBetween(1,100) . fake()->word,
            'status' => 'some status'
        ];
    }
}
