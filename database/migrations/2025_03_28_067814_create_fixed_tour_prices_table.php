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
        Schema::create('fixed_tour_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->foreignId('origin_city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('origin_state_id')->constrained('states')->onDelete('cascade');
            $table->foreignId('destination_city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('destination_state_id')->constrained('states')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_tour_prices');
    }
};
