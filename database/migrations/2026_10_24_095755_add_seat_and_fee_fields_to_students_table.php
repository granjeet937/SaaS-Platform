<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('seat_id')
                ->nullable()
                ->after('library_id')
                ->constrained('seats')
                ->nullOnDelete();

            $table->decimal('total_fee', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('payable_fee', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['seat_id']);
            $table->dropColumn([
                'seat_id',
                'total_fee',
                'discount',
                'payable_fee',
            ]);
        });
    }
};
