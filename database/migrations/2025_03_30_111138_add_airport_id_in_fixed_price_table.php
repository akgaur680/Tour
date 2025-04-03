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
        Schema::table('fixed_tour_prices', function (Blueprint $table) {
            $table->foreignId('airport_id')
                ->after('car_id')
                ->nullable()
                ->constrained('airports')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixed_tour_prices', function (Blueprint $table) {
            //
        });
    }
};
