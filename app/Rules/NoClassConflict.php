<?php

// app/Rules/NoClassConflict.php

namespace App\Rules;

use Carbon\Carbon;
use App\Models\ClassSession;
use Illuminate\Contracts\Validation\Rule;


class NoClassConflict implements Rule
{
    protected $roomId;
    protected $date;
    protected $startTime;
    protected $endTime;
    protected $classId;

    public function __construct($classId, $roomId, $date, $startTime, $endTime)
    {
        $this->roomId = $roomId;
        $this->date = Carbon::parse($date)->format('Y-m-d');
        $this->classId = $classId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;

    }

    public function passes($attribute, $value)
    {
        if ($this->roomId == 102 || $this->roomId == 101) {
            return true;
        }
        $query = ClassSession::where('room_id', $this->roomId)
            ->where('date', $this->date)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('start_time', '<', $this->startTime)
                        ->where('end_time', '>', $this->startTime);
                })->orWhere(function ($q) {
                    $q->where('start_time', '>=', $this->startTime)
                        ->where('start_time', '<', $this->endTime);
                });
            });

        // If classId is provided, exclude the current class by ID
        if ($this->classId) {
            $query->where('id', '!=', $this->classId);
        }

        // Check for any existing classes that conflict with the provided room, date, start time, and end time
        $conflictingClasses = $query->exists();


        return !$conflictingClasses;
    }



    public function message()
    {
        return 'There is a class scheduled at the provided time and room.';
    }
}
