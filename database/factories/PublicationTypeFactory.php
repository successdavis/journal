<?php

namespace Database\Factories;

use App\Models\PublicationType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PublicationTypeFactory extends Factory
{
    protected $model = PublicationType::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->randomElement([
            'Thesis','Book','Research Article', 'Review Paper', 'Case Study', 'Short Communication'
        ]);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
        ];
    }
}

