<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\PublicationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manuscript>
 */
class ManuscriptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'publication_type_id' => PublicationType::inRandomOrder()->first()->id ?? PublicationType::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'title' => $this->faker->sentence,
            'abstract' => $this->faker->paragraph(5),
            'keywords' => implode(',', $this->faker->words(5)),
            'affiliation' => $this->faker->company,
            'journal' => $this->faker->word . ' Journal',
            'main_document' => 'documents/sample.pdf',
            'figures' => json_encode(['fig1.png', 'fig2.png']),
            'supplementary' => json_encode(['sup1.docx', 'sup2.xlsx']),
            'cover_letter' => 'documents/cover_letter.pdf',
            'ethical_approval' => $this->faker->optional()->paragraph,
            'conflict_of_interest' => $this->faker->optional()->paragraph,
            'funding_statement' => $this->faker->optional()->paragraph,
            'excerpt' => $this->faker->paragraph,
            'consent' => $this->faker->boolean,
            'originality' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['under_review', 'accepted', 'rejected', 'published']),
        ];
    }
}
