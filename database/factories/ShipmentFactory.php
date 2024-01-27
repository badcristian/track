<?php

namespace Database\Factories;

use App\Enums\ShipmentEquipmentTypesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'weight' => fake()->numberBetween(1, 60000),
            'temperature' => fake()->numberBetween(-30, 150),
            'equipment_type' => ShipmentEquipmentTypesEnum::reefer->value,
            'notes' => fake()->text(200),
            'order_id' => Str::random(3) . Str::random(fake()->numberBetween(5,8))
        ];
    }
}
