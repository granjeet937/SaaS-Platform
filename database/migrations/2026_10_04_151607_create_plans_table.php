<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('slug', 100)->unique();

            $table->decimal('price', 10, 2)->default(0);

            $table->integer('duration_days');
            $table->string('duration_label', 50);

            // NULL = Unlimited
            $table->integer('student_limit')->nullable();

            // Plan features
            $table->json('features')->nullable();

            // Popular plan
            $table->boolean('is_popular')->default(false);

            // 1 = Active, 0 = Inactive
            $table->boolean('status')->default(true);

            $table->timestamps();
        });

        DB::table('plans')->insert([
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'price' => 0,
                'duration_days' => 30,
                'duration_label' => '30 Days',
                'student_limit' => 50,
                'features' => json_encode([
                    'Up to 50 students',
                    'Daily attendance',
                    'Seat assignments',
                ]),
                'is_popular' => false,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Starter',
                'slug' => 'starter',
                'price' => 999,
                'duration_days' => 90,
                'duration_label' => '3 Months',
                'student_limit' => 200,
                'features' => json_encode([
                    'Up to 200 students',
                    'All core modules',
                    'Expiry reminders',
                ]),
                'is_popular' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Pro',
                'slug' => 'pro',
                'price' => 1499,
                'duration_days' => 180,
                'duration_label' => '6 Months',
                'student_limit' => 500,
                'features' => json_encode([
                    'Up to 500 students',
                    'Reports & exports',
                    'Priority support',
                ]),
                'is_popular' => false,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Business',
                'slug' => 'business',
                'price' => 2499,
                'duration_days' => 365,
                'duration_label' => '1 Year',
                'student_limit' => null,
                'features' => json_encode([
                    'Unlimited students',
                    'Multi-branch feature',
                    'Dedicated manager',
                ]),
                'is_popular' => false,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
