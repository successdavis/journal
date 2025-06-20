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
        Schema::create('manuscript_reviewers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manuscript_id')->references('id')->on('publications')->onDelete('cascade');
            $table->foreignId('reviewer_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('request_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('complete_reviewed_on')->nullable();
            $table->enum('status', ['pending_acceptance', 'in_progress', 'completed', 'declined'])->default('pending_acceptance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manuscript_reviewers');
    }
};
