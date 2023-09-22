<?php

namespace Database\Factories;

use App\Models\Board;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->regexify('Room [A-Z][0-9]'),
            'uuid' => fake()->regexify('[A-Z0-9]{12}'),
            'ip' => fake()->ipv4(),
            'last_seen' => fake()->dateTimeBetween(startDate: '-30 days'),
        ];
    }
}
