<?php

namespace Database\Seeders;

use App\Models\Manuscript;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManuscriptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manuscript::factory()->count(50)->create(); // Creates 50 publications with dummy authors
    }
}
