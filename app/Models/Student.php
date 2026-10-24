<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        'library_id',
        'student_code',
        'name',
        'mobile',
        'email',
        'guardian_name',
        'guardian_mobile',
        'address',
        'admission_date',
        'status',
        'seat_id',
        'total_fee',
        'discount',
        'payable_fee',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'total_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'payable_fee' => 'decimal:2',
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class);
    }
}
