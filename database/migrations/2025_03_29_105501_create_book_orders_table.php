<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_address_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('from_address_state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('to_address_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('to_address_state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('trip_type_id')->constrained('trip_types')->onDelete('cascade');
            $table->date('return_date')->nullable();
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->foreignId('airport_id')->nullable()->constrained('airports')->onDelete('set null');
            $table->boolean(('from_airport'))->default(false);
            $table->boolean(('to_airport'))->default(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->string('pickup_location');
            $table->string('drop_location')->nullable();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->boolean('is_chauffeur_needed')->default(false);
            $table->decimal('chauffeur_price', 10, 2)->nullable();
            $table->string('preffered_chauffeur_language')->nullable();
            $table->boolean('is_new_car_promised')->default(false);
            $table->decimal('new_car_price', 10, 2)->nullable();
            $table->boolean('is_cab_luggage_needed')->default(false);
            $table->decimal('cab_luggage_price', 10, 2)->nullable();
            $table->boolean('is_diesel_car_needed')->default(false);
            $table->decimal('diesel_car_price', 10, 2)->nullable();
            $table->decimal('received_amount', 10, 2)->nullable();
            $table->decimal('original_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('total_distance', 10, 2)->nullable();
            $table->integer('total_hours')->nullable();
            $table->enum('payment_type', ['Half Payment', 'Partial Payment', 'Full Payment', 'Pay on Delivery']);
            $table->enum('payment_status', ['pending', 'partial', 'completed'])->default('pending');
            $table->enum('booking_status', ['upcoming', 'ongoing', 'completed', 'cancelled','failed'])->default('upcoming');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
