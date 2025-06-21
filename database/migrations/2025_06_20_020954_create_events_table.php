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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Event title
            $table->text('description')->nullable(); // Detailed info
            $table->string('location')->nullable(); // Venue or online link
            $table->dateTime('start_date'); // Start datetime
            $table->dateTime('end_date')->nullable(); // Optional end datetime
            $table->string('organizer')->nullable(); // Who is organizing
            $table->string('banner_image')->nullable(); // Event poster or image
            $table->string('slug')->unique(); // For SEO-friendly URLs
            $table->boolean('is_published')->default(false); // Visibility control
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Created by
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
