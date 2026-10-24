<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seat extends Model
{
    protected $fillable = [
        'library_id',
        'seat_number',
        'section',
        'status',
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'seat_id');
    }
}