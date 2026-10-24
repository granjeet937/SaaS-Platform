<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('library_id')
                ->constrained('libraries')
                ->cascadeOnDelete();

            $table->string('seat_number', 30);
            $table->string('section')->nullable();

            $table->enum('status', [
                'available',
                'occupied',
                'maintenance'
            ])->default('available');

            $table->timestamps();

            $table->unique(['library_id', 'seat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
