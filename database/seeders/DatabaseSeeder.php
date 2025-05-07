<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user only if it doesn't exist
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Seed other models
        Student::factory(20)->create();
        Course::factory(10)->create();
        Staff::factory(15)->create();
    }
}