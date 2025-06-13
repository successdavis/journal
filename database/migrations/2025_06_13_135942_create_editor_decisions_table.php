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
        Schema::create('editor_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreign('manuscript_id')->references('id')->on('manuscripts')->onDelete('cascade');
            $table->foreign('submitted_review_id')->references('id')->on('submitted_reviews')->onDelete('cascade');
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('round');
            $table->string('decision'); // Accept, Reject, Minor Revisions, etc.
            $table->text('comments_to_author')->nullable();
            $table->text('comments_to_reviewer')->nullable();

            $table->unsignedBigInteger('decided_by_editor_id');
            $table->timestamps();

            // Foreign keys
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editor_decisions');
    }
};
