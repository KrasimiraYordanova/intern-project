<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->name(),
            'address' => fake()->name('New York'),
            'price' => fake()->numberBetween(25000, 80000),
            'manufacturing' => fake()->numberBetween(2000, 2022),
        ];
    }
}
