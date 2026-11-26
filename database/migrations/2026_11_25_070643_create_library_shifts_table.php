<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_id')
                ->constrained('libraries')
                ->cascadeOnDelete();
            $table->string('shift_code', 30)->unique();
            $table->string('shift_name', 100);
            $table->unsignedTinyInteger('duration_hours');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('monthly_fee', 10, 2)->default(0.00);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['library_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_shifts');
    }
};
