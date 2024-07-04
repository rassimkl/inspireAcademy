<?php
namespace App\Rules;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ScheduleConflict implements Rule
{
    protected $userId;
    protected $date;
    protected $startTime;
    protected $endTime;
    protected $classid;

    public function __construct($userId, $date, $startTime, $endTime, $classid)
    {
        $this->userId = $userId;
        $this->date = Carbon::parse($date)->format('Y-m-d');
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->classid = $classid;
    }

    public function passes($attribute, $value)
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // Check for conflicting classes
        if (!$this->classid) {
            $conflictingClasses = $user->classes()
                ->where('date', '=', $this->date)
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('start_time', '<', $this->startTime)
                            ->where('end_time', '>', $this->startTime);
                    })->orWhere(function ($q) {
                        $q->where('start_time', '>=', $this->startTime)
                            ->where('start_time', '<', $this->endTime);
                    });
                })->exists();


            return !$conflictingClasses;
        } else {
            $conflictingClasses = $user->classes()
                ->where('classes.id', '!=', $this->classid)
                ->where('date', '=', $this->date)
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('start_time', '<', $this->startTime)
                            ->where('end_time', '>', $this->startTime);
                    })->orWhere(function ($q) {
                        $q->where('start_time', '>=', $this->startTime)
                            ->where('start_time', '<', $this->endTime);
                    });
                })->exists();


            return !$conflictingClasses;

        }


    }

    public function message()
    {
        return 'You already set have a class at this time';
    }
}