<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    // Table
    protected $table = 'users';
    // Primary Key
    protected $primaryKey = 'id';
    // created_at and updated_at
    public $timestamps = true;


    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * $user = User::find(1);
     * $user->is_admin; // true or false
     * $user->is_counselor; // true or false
     * $user->is_student; // true or false
     */
    // UserTypes in user_type column: admin, counselor, student
    public function getIsAdminAttribute()
    {
        return auth()->user()->user_type == 'admin';
    }
    public function getIsCounselorAttribute()
    {
        return auth()->user()->user_type == 'counselor';
    }
    public function getIsStudentAttribute()
    {
        return auth()->user()->user_type == 'student';
    }

    public function sex_type_text($sex_type)
    {
        $result = '';
        if ($sex_type == 'M') {
            $result = 'Male';
        }
        if ($sex_type == 'F') {
            $result = 'Female';
        }

        return $result;
    }
    public function account_type_text($user_type)
    {
        $result = '';
        if ($user_type == 'admin') {
            $result = 'Adminstrator';
        }
        if ($user_type == 'counselor') {
            $result = 'Counselor';
        }
        if ($user_type == 'student') {
            $result = 'Student';
        }

        return $result;
    }


    // Relation
    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function specialty()
    {
        return $this->hasOne(Counselorspecialty::class);
        // return $this->hasOne(Counselorspecialty::class, 'foreign_key', 'local_key');
    }


    /**
     * Get all of the appointments for student User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function student_appointments()
    {
        return $this->hasMany(Appointment::class, 'student_id', 'id');
    }

    /**
     * Get all of the appointments for Counselor User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function counselor_appointments()
    {
        return $this->hasMany(Appointment::class, 'counselor_id', 'id');
    }
}
