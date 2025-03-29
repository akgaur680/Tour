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
            $table->foreignId('trip_type_id')
                ->after('car_id')
                ->nullable()
                ->constrained('trip_types')
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
