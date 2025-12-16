<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table = 'course_student'; // ← important

    public $timestamps = false; // pivot table n'a pas de timestamps

    protected $fillable = [
        'course_id',
        'student_id',
        'followup_sent',
    ];

    // Relations facultatives (mais utiles)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
