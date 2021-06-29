<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the student that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    /**
     * Get the counselor that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id', 'id');
    }
}
