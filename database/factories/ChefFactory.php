<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChefFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'speciality' => $this->faker->name,
            'image' => $this->faker->imageUrl($width = 140, $height=300),
        ];
    }
}
