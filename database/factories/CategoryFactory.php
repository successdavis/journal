<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\PublicationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->optional()->sentence,
            'status' => $this->faker->boolean(90),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'parent_id' => null, // We’ll override this in the seeder for nested categories
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            $publicationTypes = PublicationType::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $category->publicationTypes()->attach($publicationTypes);
        });
    }
}
