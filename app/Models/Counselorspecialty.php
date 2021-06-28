<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counselorspecialty extends Model
{
    use HasFactory;
    // Table
    protected $table = 'counselorspecialties';
    // Primary Key
    protected $primaryKey = 'id';
    // created_at and updated_at
    public $timestamps = true;

    protected $guarded = [];
    /**
     * Get the user that owns the Counselorspecialty
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
        // return $this->belongsTo(User::class, 'foreign_key', 'other_key');
    }
}
