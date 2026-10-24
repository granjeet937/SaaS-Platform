<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentPayment extends Model
{
    protected $fillable = [
        'library_id',
        'student_id',
        'amount',
        'payment_method',
        'payment_status',
        'payment_date',
        'reference_number',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}