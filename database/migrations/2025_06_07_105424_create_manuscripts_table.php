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
        Schema::create('manuscripts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title');
            $table->text('abstract');
            $table->string('keywords')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('journal')->nullable();
            $table->string('main_document');
            $table->json('figures')->nullable();
            $table->json('supplementary')->nullable();
            $table->string('cover_letter')->nullable();
            $table->text('ethical_approval')->nullable();
            $table->text('conflict_of_interest')->nullable();
            $table->text('funding_statement')->nullable();
            $table->boolean('consent');
            $table->boolean('originality');

            $table->string('status')
                ->default('under_review')
                ->nullable();
            $table->decimal('amount', 10, 2)
                ->nullable();
            $table->boolean('premium')
                ->default(0);
            $table->string('citation_information')->nullable();
            $table->string('co_writers')->nullable();

            $table->foreignId('publication_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('thumbnail')->nullable();
            $table->text('excerpt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manuscripts');
    }
};
