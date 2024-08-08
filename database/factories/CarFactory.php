<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => fake()->name(),
            'model' => fake()->name(),
            'year' => fake()->numberBetween(2015, 2024),
            'price' => fake()->numberBetween(25000, 80000),
            'manufacturing' => fake()->numberBetween(2000, 2022),
        ];
    }
}
