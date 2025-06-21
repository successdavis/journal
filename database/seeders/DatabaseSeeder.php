<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);
        User::factory(10)->create();
        \App\Models\PublicationType::factory()->count(4)->create();
        $this->call(CategorySeeder::class);
        \App\Models\Publication::factory(30)->create();
        $this->call(EventSeeder::class);
    }
}
