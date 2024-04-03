<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'hours',
        'date',
        'start_time',
        'end_time',
    ];

    /**
     * Get the course that owns the class session.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
