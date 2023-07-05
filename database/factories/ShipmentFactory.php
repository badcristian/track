<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'weight' => fake()->numberBetween(1, 60000),
            'temperature' => fake()->numberBetween(-30, 150),
            'equipment_type' => 'some type',
            'notes' => fake()->text(20)
        ];
    }
}
