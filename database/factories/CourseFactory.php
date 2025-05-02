<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'user_id'     => 1, // cria um user automaticamente ou usa um existente
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'instructor'  => $this->faker->name(),
            'start_date'  => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'end_date'    => $this->faker->dateTimeBetween('+3 weeks', '+5 weeks'),
            'location'    => $this->faker->randomElement(['Online', 'Community Center', 'Library']),
            'image'       => $this->faker->imageUrl(640, 480, 'education', true),
            'slots'       => $this->faker->numberBetween(10, 50),
            'active'      => $this->faker->boolean(90), // 90% chance de ser true
        ];
    }
}
