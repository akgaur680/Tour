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
        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->char('client_id', 36)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->change();
        });
    }
};
