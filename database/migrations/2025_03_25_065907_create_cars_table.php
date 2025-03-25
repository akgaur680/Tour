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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();  
            $table->string('car_number');
            $table->string('car_model');
            $table->string('car_type');
            $table->integer('seats');
            $table->boolean('ac');
            $table->integer('luggage_limit')->nullable();
            $table->integer('price_per_km');
            $table->text('car_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
