<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    // All subscriptions of this library
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    // Current active subscription
    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->latestOfMany();
    }
}
