<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->name,
            'lastname' => $this->faker->name,
            'gender' => $this->faker->randomElement(['male', 'female', 'others']),
            'occupation' => $this->faker->randomElement(['student', 'trader', 'software developer']),
            'phone1' => $this->faker->numberBetween('1000000', 2000000),
            'phone2' => $this->faker->numberBetween('1000000', 2000000),
            'address1' => $this->faker->sentence(),
            'address2' => $this->faker->sentence(),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'active' => $this->faker->boolean(),
        ];
    }
}
