<?php

namespace App\Models;

use App\Models\CourseFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'course_type',
        'name',
        'info',
        'total_hours',
        'charge_per_hour',
        'status',
    ];
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassSession::class);
    }

    public function updateStatus()
    {
        // Check if the course status is not already "in progress" (status 2)
        if ($this->status_id != 2) {
            // Check if any class with status 2 exists
            $hasInProgressClass = $this->classes()->where('status', 2)->exists();

            // If at least one class is in progress, update course status to "in progress"
            if ($hasInProgressClass) {
                $this->status_id = 2; // Update status to "in progress"
                $this->save();
                return;
            }
        }

        // Check if all classes have status 2 and their total hours match total_hours of the course
        $classesWithStatus2 = $this->classes()->where('status', 2)->get();
        $totalHours = $classesWithStatus2->sum('hours');

        // If the course status is not already "completed" (status 3) and all conditions are met, update to "completed"
        if ($this->status_id != 3 && $classesWithStatus2->count() > 0 && $totalHours == $this->total_hours) {
            $this->status_id = 3; // Update status to "completed"
            $this->save();
        }
    }


    public function files()
    {
        return $this->hasMany(CourseFile::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }


    public function latestClassDate()
    {
        return $this->hasOne(ClassSession::class)
            ->latest('date');
    }
}
