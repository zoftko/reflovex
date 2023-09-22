<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'board_id' => Board::factory(),
            'ramp_up_gradient' => fake()->numberBetween(1, 3),
            'soak_time' => fake()->numberBetween(60, 120),
            'soak_temperature' => fake()->randomElement([90, 100, 110, 115]),
            'reflow_gradient' => fake()->numberBetween(1, 3),
            'reflow_peak_temp' => fake()->randomElement([145, 150, 160, 170]),
            'reflow_max_time' => fake()->numberBetween(30, 80),
            'cooldown_gradient' => fake()->numberBetween(1, 5),
        ];
    }
}
