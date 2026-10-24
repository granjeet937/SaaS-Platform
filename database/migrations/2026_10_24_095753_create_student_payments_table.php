<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('library_id')
                ->constrained('libraries')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->string('payment_method')->default('cash');

            $table->enum('payment_status', [
                'paid',
                'pending',
                'failed'
            ])->default('paid');

            $table->date('payment_date')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['library_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_payments');
    }
};