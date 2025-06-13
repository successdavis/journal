<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submitted_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('review_manuscript_id')
                ->references('id')
                ->on('manuscript_reviewers')
                ->constrained()->onDelete('cascade');

            $table->unsignedTinyInteger('round')
                ->default(1);
            $table->string('review_title');
            $table->string('opinion');
            $table->text('general_comment');
            $table->text('specific_comment');
            $table->text('comment_to_editor');

            $table->tinyInteger('originality');
            $table->tinyInteger('clarity_of_writing');
            $table->tinyInteger('methodology_soundness');
            $table->tinyInteger('relevance_of_manuscript');
            $table->tinyInteger('quality_of_data');

            $table->string('annotated_manuscript');
            $table->string('supplementary_feedback')->nullable();

            $table->string('conflict_of_interest');
            $table->boolean('review_is_honest');
            $table->boolean('agreed_review_policy');
            $table->enum('submit_option', ['draft', 'submitted']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitted_reviews');
    }
};
