<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookSlot>
 */
class BookSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mobile' => fake()->randomElement([7,8,9]).fake()->numerify('#########'),
            'name' => fake()->name,
            'age' => fake()->numberBetween(18, 100),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'sport' => fake()->randomElement(['Swimming', 'Gym', 'Cricket', 'Badminton', 'Tennis']),
            'slot_type' => fake()->randomElement(['One-time', 'Subscription']),
            'slot_name' => fake()->name(),
            'no_of_times_allowed' => fake()->numberBetween(1, 10),
            'starts_at_unix' => fake()->unixTime,
            'ends_at_unix' => fake()->unixTime,
            'starts_at_hours' => fake()->numberBetween(5, 21),
            'starts_at_minutes' => fake()->numberBetween(0, 59),
            'ends_at_hours' => fake()->numberBetween(5, 21),
            'ends_at_minutes' => fake()->numberBetween(0, 59),
            'amount' => fake()->randomFloat(2, 0, 99999.99),
        ];
    }
}
