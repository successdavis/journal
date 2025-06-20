<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Publication;
use App\Models\PublicationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    protected $model = Publication::class;

    public function definition(): array
    {
         return [
            'author_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'publication_type_id' => PublicationType::inRandomOrder()->first()->id ?? PublicationType::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'title' => $this->faker->sentence,
            'abstract' => $this->faker->paragraph(5),
            'keywords' => implode(',', $this->faker->words(5)),
            'article_type' => $this->faker->randomElement(['Research', 'Review', 'Case Study']),
            'affiliation' => $this->faker->company,
            'journal' => $this->faker->word . ' Journal',
            'subject_area' => $this->faker->randomElement(['Science', 'Health', 'Technology']),
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
            'views' => $this->faker->numberBetween(0, 500),
            'downloads' => $this->faker->numberBetween(0, 300),
            'published_at' => $this->faker->optional()->dateTimeThisYear(),
        ];
    }
}
