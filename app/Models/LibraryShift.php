<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryShift extends Model
{
    protected $fillable = [
        'library_id',
        'shift_code',
        'shift_name',
        'duration_hours',
        'start_time',
        'end_time',
        'monthly_fee',
        'status',
    ];

    protected $casts = [
        'duration_hours' => 'integer',
        'monthly_fee'    => 'decimal:2',
        'status'         => 'boolean',
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}