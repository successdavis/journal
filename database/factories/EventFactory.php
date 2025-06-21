<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(5);
        return [
            'title' => $title,
            'description' => $this->faker->paragraphs(3, true),
            'location' => $this->faker->randomElement([
                $this->faker->address,
                'Online - Zoom',
                'Online - Google Meet',
                'Auditorium, Main Campus'
            ]),
            'start_date' => $this->faker->dateTimeBetween('+1 days', '+2 months'),
            'end_date' => $this->faker->optional()->dateTimeBetween('+2 days', '+3 months'),
            'organizer' => $this->faker->company,
            'banner_image' => 'https://via.placeholder.com/800x400.png?text=Event+Banner',
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'is_published' => $this->faker->boolean(85),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
