<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(asText: true),
            'description' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-3 months'),
        ];
    }
}
