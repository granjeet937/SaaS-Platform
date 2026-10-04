<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'library_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function library()
    {
        return $this->belongsTo(Library::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today());
    }
}
