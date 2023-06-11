<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slot>
 */
class SlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'no_of_slots' => fake()->randomNumber(2),
            'starts_at_hours' => fake()->numberBetween(5, 21),
            'starts_at_minutes' => fake()->numberBetween(1, 60),
            'ends_at_hours' => fake()->numberBetween(5, 21),
            'ends_at_minutes' => fake()->numberBetween(1, 60),
        ];
    }
}
