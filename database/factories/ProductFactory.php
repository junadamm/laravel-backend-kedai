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
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(100, 1000),
            'stok' => $this->faker->numberBetween(1, 100),
            'category' => $this->faker->randomElement(['food', 'drinks', 'snacks']),
            'image' => $this->faker->imageUrl(640, 400),
  ];
}
}
