<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;

class Student extends Component
{
    public $courses;

    public $numberOfCoures;

    public $finishedCourses;

    public $hoursThisMonth;

    public $numberOfClasses;

    public $totalHours;

    public $todayClasses;

    public $calendarClasses;

    public $pendingClasses;

    public $student;
    public function mount()
    {
        $currentMonth = Carbon::now()->month;
        $user = auth()->user();
        $this->student = $user;
        $this->courses = $user->coursesAsStudent;
        $this->numberOfCoures = $this->courses->count();

        $this->totalHours = $user->coursesAsStudent->flatMap(function ($course) {
            return $course->classes->where('status', '=', '2')->pluck('hours');
        })->sum();


        $this->hoursThisMonth = $user->coursesAsStudent->flatMap(function ($course) use ($currentMonth) {
            return $course->classes->filter(function ($class) use ($currentMonth) {
                // Filter classes with status 2 and date in the current month
                return $class->status === 2 && Carbon::parse($class->date)->month === $currentMonth;
            })->pluck('hours');
        })->sum();

        $this->numberOfClasses = $user->coursesAsStudent->flatMap->classes->unique()->count();

        $currentDateTime = now();

        $this->todayClasses = $user->coursesAsStudent()
            ->whereHas('classes', function ($query) use ($currentDateTime) {
                $query->whereDate('date', $currentDateTime->toDateString())
                ;
            })
            ->with([
                'classes' => function ($query) use ($currentDateTime) {
                    $query->whereDate('date', $currentDateTime->toDateString())

                        ->orderBy('start_time', 'asc'); // Order by start_time in ascending order
                }
            ])
            ->get()
            ->flatMap->classes; // Flatten the classes collection


        $pastThirtyDaysDateTime = now()->subDays(30);

        $this->calendarClasses = $user->coursesAsStudent()
            ->whereHas('classes', function ($query) use ($pastThirtyDaysDateTime) {
                $query->whereDate('date', '>', $pastThirtyDaysDateTime->toDateString())
                ;
            })
            ->with([
                'classes' => function ($query) use ($pastThirtyDaysDateTime) {
                    $query->whereDate('date', '>', $pastThirtyDaysDateTime->toDateString())

                        ->orderBy('start_time', 'asc'); // Order by start_time in ascending order
                }
            ])
            ->get()
            ->flatMap->classes; // Flatten the classes collection

        $this->finishedCourses = $user->coursesAsStudent()
            ->where('status_id', 3)
            ->count();




        $this->pendingClasses = $user->coursesAsStudent()
            ->with([
                'classes' => function ($query) {
                    $query->where('status', 1) // Filter classes by status 1
                        ->orderBy('start_time', 'asc'); // Order by start_time in ascending order
                }
            ])
            ->get()
            ->flatMap->classes; // Flatten the classes collection



    }
    public function render()
    {
        return view('livewire.student');
    }
}
