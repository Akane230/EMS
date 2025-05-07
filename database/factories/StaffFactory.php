<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    public function definition()
    {
        return [
            'staff_id' => $this->faker->unique()->numberBetween(100, 999),
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
            'contact_number' => $this->faker->phoneNumber,
        ];
    }
}