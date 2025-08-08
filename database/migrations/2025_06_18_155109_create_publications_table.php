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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manuscript_id')
                ->constrained('manuscripts')
                ->onDelete('cascade');
            $table->foreignId('review_id')
                ->constrained('manuscript_reviewers')
                ->onDelete('cascade');
            $table->foreignId('editor_id')
                ->constrained('manuscript_reviewers')
                ->onDelete('cascade');
            $table->foreignId('author_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('reviewer_id')
                ->nullable()->constrained('users')
                ->onDelete(null);
            $table->string('title');
            $table->string('affiliation');
            $table->text('abstract');
            $table->string('keywords');
            $table->string('journal');

            $table->string('final_document'); // The reviewed & approved file
            $table->string('supplementary_feedback')
                ->nullable();

            $table->json('figures');
            $table->json('supplementary_files');

            $table->unsignedBigInteger('views')
                ->default(0);
            $table->unsignedBigInteger('downloads')
                ->default(0);

            $table->string('doi')
                ->nullable();
            $table->string('slug')
                ->nullable();
            $table->string('citation_information')
                ->nullable();
            $table->string('co_writers')
                ->nullable();
            $table->timestamp('published_at')
                ->nullable();
            $table->Boolean('status')
                ->default(true);
            $table->decimal('amount', 10, 2)
                ->nullable();
            $table->boolean('premium')
                ->default(0);
            $table->foreignId('publication_type_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('thumbnail')
                ->nullable();
            $table->text('excerpt');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
