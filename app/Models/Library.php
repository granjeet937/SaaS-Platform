<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Library extends Model
{
    protected $fillable = [
        'library_code',
        'library_type',
        'library_name',
        'address',
        'city',
        'state',
        'pincode',
        'total_seats',
        'facilities',
        'status',
    ];

    protected $casts = [
        'facilities' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}