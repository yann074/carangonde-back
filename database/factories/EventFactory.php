<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'user_id'    => 1, // ou use um ID fixo, ex: 1
            'title'      => $this->faker->sentence(4),
            'description'=> $this->faker->paragraph(),
            'location'   => $this->faker->address(),
            'date'       => $this->faker->dateTimeBetween('+1 week', '+2 months')->format('Y-m-d'),
            'time'       => $this->faker->optional()->time('H:i'),
            'image'      => $this->faker->imageUrl(640, 480, 'event', true),
            'active'     => $this->faker->boolean(90),
        ];
    }
}
