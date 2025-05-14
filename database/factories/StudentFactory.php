<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'date_of_birth' => $this->faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
            'country' => $this->faker->country,
            'province' => $this->faker->state,
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'zipcode' => $this->faker->postcode,
            'status' => fake()->randomElement(['Regular', 'Irregular', 'Active', 'Inactive',]),
            'contact_number' => $this->faker->phoneNumber,
        ];
    }
}
