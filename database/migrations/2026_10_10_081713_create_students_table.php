
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

            $table->unsignedBigInteger('library_id');

            // Unique student code with shorter index length
            $table->string('student_code', 50)->unique();

            $table->string('name', 100);
            $table->string('mobile', 20);
            $table->string('email', 100)->nullable();

            $table->string('guardian_name', 100)->nullable();
            $table->string('guardian_mobile', 20)->nullable();

            $table->text('address')->nullable();
            $table->date('admission_date');
            $table->string('status', 20)->default('active');

            $table->timestamps();

            $table->foreign('library_id')
                ->references('id')
                ->on('libraries')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
