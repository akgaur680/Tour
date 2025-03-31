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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('pickup_location');
            $table->string('drop_location')->nullable();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->boolean('is_chauffeur_needed')->default(false);
            $table->string('preffered_chauffeur_language')->nullable();
            $table->boolean('is_new_car_promised')->default(false);
            $table->boolean('is_cab_luggage_needed')->default(false);
            $table->boolean('is_diesel_car_needed')->default(false);
            $table->decimal('received_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('total_distance', 10, 2)->nullable();
            $table->integer('total_hours')->nullable();
            $table->enum('payment_type', ['Half Payment', 'Partial Payment', 'Full Payment', 'Pay on Delivery']);
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->enum('order_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->enum('booking_status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
