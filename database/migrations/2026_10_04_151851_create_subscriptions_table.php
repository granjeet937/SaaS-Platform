<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('library_id')
                ->constrained('libraries')
                ->cascadeOnDelete();

            $table->foreignId('plan_id')
                ->constrained('plans')
                ->restrictOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->enum('status', [
                'active',
                'expired',
                'cancelled',
                'pending'
            ])->default('active');

            $table->enum('payment_status', [
                'not_required',
                'pending',
                'paid',
                'failed'
            ])->default('not_required');

            $table->timestamps();

            $table->index(['library_id', 'status']);
            $table->index(['plan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
