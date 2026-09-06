<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('library_id')
                ->nullable()
                ->after('id')
                ->constrained('libraries')
                ->nullOnDelete();

            $table->string('phone', 10)->nullable();
            $table->string('role', 30)->default('library_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['library_id']);
            $table->dropColumn([
                'library_id',
                'phone',
                'role'
            ]);

        });
    }
};