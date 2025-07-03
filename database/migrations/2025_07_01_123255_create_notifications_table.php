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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('set null');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');

            $table->string('message');

            $table->string('notifiable_type'); // e.g. App\Models\Article or App\Models\RoleRequest
            $table->unsignedBigInteger('notifiable_id'); // ID of the related item

            $table->boolean('status')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
