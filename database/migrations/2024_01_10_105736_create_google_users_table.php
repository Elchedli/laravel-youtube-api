<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('google_users', function (Blueprint $table) {
            $table->string('google_id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('thumbnailURL');
            $table->string('refreshToken')->unique(); // this refresh token is using the google API to generate an access_token (security)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('google_users');
    }
}
