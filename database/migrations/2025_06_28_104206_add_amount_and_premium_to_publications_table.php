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
            Schema::table('publications', function (Blueprint $table) {
                $table->decimal('amount', 10, 2)
                    ->nullable()
                    ->after('excerpt');
                $table->boolean('premium')
                    ->default(0)
                    ->after('amount');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn(['amount', 'premium']);
        });
    }
};
