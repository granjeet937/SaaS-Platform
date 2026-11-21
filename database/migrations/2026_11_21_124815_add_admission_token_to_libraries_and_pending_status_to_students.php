<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('libraries', function (Blueprint $table) {
            if (!Schema::hasColumn('libraries', 'admission_token')) {
                $table->string('admission_token', 40)->nullable()->unique()->after('library_code');
            }
        });

        // Existing libraries ko automatic unique token assign karein
        DB::table('libraries')->whereNull('admission_token')->get()->each(function ($lib) {
            DB::table('libraries')
                ->where('id', $lib->id)
                ->update(['admission_token' => strtoupper(Str::random(16))]);
        });

        // Students table mein status column ko string/enum ensure karein taaki 'pending' support kare
        Schema::table('students', function (Blueprint $table) {
            $table->string('status', 20)->default('active')->change();
        });
    }

    public function down(): void
    {
        Schema::table('libraries', function (Blueprint $table) {
            if (Schema::hasColumn('libraries', 'admission_token')) {
                $table->dropColumn('admission_token');
            }
        });
    }
};
