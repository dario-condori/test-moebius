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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable()->default(null);
            $table->string('first_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('phone_2')->nullable()->default(null);
            $table->string('postal_code')->nullable()->default(null);
            $table->string('birth_date')->nullable()->default(null);
            $table->string('gender',1)->nullable()->default(null);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
