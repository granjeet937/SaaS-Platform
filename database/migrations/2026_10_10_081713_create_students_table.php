<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('library_id')
                ->constrained('libraries')
                ->cascadeOnDelete();

            $table->foreignId('seat_id')
                ->nullable()
                ->constrained('seats')
                ->nullOnDelete();

            $table->foreignId('shift_id')
                ->nullable()
                ->constrained('library_shifts')
                ->nullOnDelete();

            $table->string('student_code', 50)->unique();
            $table->string('name', 100);
            $table->string('mobile', 20);
            $table->string('email', 100)->nullable();

            $table->string('guardian_name', 100)->nullable();
            $table->string('guardian_mobile', 20)->nullable();

            $table->text('address')->nullable();
            $table->string('photo', 255)->nullable();

            $table->date('admission_date');
            $table->decimal('total_fee', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('payable_fee', 10, 2)->default(0);
            $table->string('status', 20)->default('active');

            $table->timestamps();

            $table->index(['library_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
