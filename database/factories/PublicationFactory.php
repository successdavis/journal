<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Manuscript;
use App\Models\Publication;
use App\Models\PublicationType;
use App\Models\SubmittedReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    protected $model = Publication::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6, true);

        return [
            'manuscript_id' => Manuscript::factory(),
            'review_id' => SubmittedReview::factory(),
            'author_id' => User::factory(),

            'title' => $title,
            'abstract' => $this->faker->paragraph(4),
            'keywords' => implode(', ', $this->faker->words(5)),
            'journal' => $this->faker->randomElement(['SciencePlus', 'OpenAccess Med', 'Journal of AI', 'NatureTech']),
            'affiliation' => $this->faker->company . ', ' . $this->faker->country,

            'final_document' => 'documents/' . \Str::random(10) . '.pdf',
            'supplementary_feedback' => $this->faker->sentence(),

            'figures' => json_encode([
                'figure1.png',
                'figure2.png',
            ]),
            'supplementary_files' => json_encode([
                'appendix_a.docx',
                'dataset.xlsx',
            ]),

            'views' => $this->faker->numberBetween(0, 500),
            'downloads' => $this->faker->numberBetween(0, 200),

            'doi' => '10.1234/' . \Str::slug($title) . '-' . rand(1000, 9999),
            'slug' => \Str::slug($title),

            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

}
