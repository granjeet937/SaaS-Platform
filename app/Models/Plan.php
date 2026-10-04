<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'duration_days',
        'duration_label',
        'student_limit',
        'features',
        'is_popular',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_popular' => 'boolean',
        'status' => 'boolean',
    ];
}