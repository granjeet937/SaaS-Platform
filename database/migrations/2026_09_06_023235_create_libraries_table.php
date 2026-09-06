<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();

            $table->string('library_code', 20)->unique();

            $table->string('library_type', 100);
            $table->string('library_name', 150);

            $table->text('address');
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('pincode', 6);

            $table->unsignedInteger('total_seats');

            $table->json('facilities')->nullable();

            $table->string('status', 30)->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};