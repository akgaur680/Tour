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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
           $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
           $table->foreignId('car_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
           $table->string('driving_license')->unique()->nullable();
           $table->string('license_expiry')->nullable();
           $table->string('license_image')->nullable();
           $table->string('adhaar_number')->unique()->nullable();
           $table->string('adhaar_image_front')->nullable();
           $table->string('adhaar_image_back')->nullable();
           $table->boolean('is_approved')->default(true);   
           $table->boolean('is_available')->default(true);   
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
