<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Ensure users exist first
        $users = User::all();
        if ($users->isEmpty()) {
            User::factory(5)->create();
            $users = User::all();
        }

        // Create 5 top-level categories
        Category::factory()->count(5)->create()->each(function ($category) use ($users) {
            // Attach 2 child categories to each parent
            Category::factory()->count(2)->create([
                'parent_id' => $category->id,
                'user_id' => $users->random()->id,
            ]);
        });
    }


}
