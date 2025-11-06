<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Electronics', 'Clothing', 'Books', 'Home & Garden', 'Sports', 'Toys', 'Food', 'Health'];

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 10, 1000),
            'category' => fake()->randomElement($categories),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}
