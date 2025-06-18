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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title');
            $table->text('abstract');
            $table->string('keywords');
            $table->string('article_type');
            $table->string('affiliation');
            $table->string('journal');
            $table->string('subject_area');
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
                ->default('under_review');

            $table->unsignedBigInteger('views')
                ->default(0);

            $table->unsignedBigInteger('downloads')
                ->default(0);

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
