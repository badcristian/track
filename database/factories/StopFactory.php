<?php

namespace Database\Factories;

use App\Enums\StopStatusesEnum;
use App\Enums\StopTypesEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class StopFactory extends Factory
{

    public function definition(): array
    {
        $shippingHoursStart = fake()->dateTime;
        $shippingHoursEnd = Carbon::parse($shippingHoursStart)->addHours(8);

        return [
            'type' => StopTypesEnum::pickup->value, // default
            'name' => fake()->company, // default
            'status' => StopStatusesEnum::ready->value, // default
            'eta' => fake()->date,
            'datetime' => fake()->dateTime,
            'arrival_datetime' => fake()->dateTime,
            'departure_datetime' => fake()->dateTime,
            'fcfs' => (bool)fake()->numberBetween(0, 1),
            'working_hours_start' => $shippingHoursStart,
            'working_hours_end' => $shippingHoursEnd,
            'ref_numbers' => fake()->numberBetween(1, 100) . fake()->word,
            'street_address' => fake()->numberBetween(1,9999) . fake()->streetAddress,
            'city' => fake()->city(),
            'state' => $this->faker->countryCode(),
            'zip_code' => fake()->postcode(),
            'country' => fake()->country(),
            'lat' => fake()->longitude(24.7433195, 49.3457868),
            'lng' => fake()->longitude(-124.7844079, -66.9513812),
        ];
    }

    public function type(StopTypesEnum $type): static
    {
        return $this->state(function (array $attributes) use ($type) {
            return [
                'type' => $type->value
            ];
        });
    }

    public function withCoordinates(array $coordinates): static
    {
        return $this->state(function () use ($coordinates) {
            return [
                'lat' => data_get($coordinates, 'lat'),
                'lng' => data_get($coordinates, 'lng'),
            ];
        });
    }
}
