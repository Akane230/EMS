<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition()
    {
        return [
            'course_code' => strtoupper($this->faker->bothify('??###')),
            'course_name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'credits' => $this->faker->numberBetween(1, 5),
        ];
    }
}
