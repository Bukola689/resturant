<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
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
            'email' => $this->faker->email,
            'phone' => '08105155989',
            'guest' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'message' => $this->faker->sentence(),
        ];
    }
}
