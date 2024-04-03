<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'email',
        'password',
        'phone_number',
        'user_type',
        'blood_group',
        'address',
        'city',
        'zip_code',
        'country',
        'profile_picture',
        'languages',
        'info',
        'user_type_id' // Add profile picture to fillable
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }



    public function coursesAsTeacher()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function coursesAsStudent()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }

    public function classes()
    {
        return $this->hasManyThrough(ClassSession::class, Course::class);
    }
}
