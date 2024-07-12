<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Home')]

class TeacherHome extends Component
{
    public $teacher;
    public $totalStudents;
    public $totalClasses;
    public $courses;
    public $upcomingClasses;

    public $totalHours;
    public $totalHoursThisMonth;
    public $calendarClasses;
    public $unfinishedClasses;

    public $latestSubmitted;
    public function mount()
    {
       
        $currentMonth = Carbon::now()->month;


        $this->teacher = User::with(['coursesAsTeacher.students', 'coursesAsTeacher.classes'])->find(auth()->id());
        $this->calendarClasses = $this->teacher->classes;

        $this->unfinishedClasses = $this->teacher->classes
            ->where('status', 1)
            ->sortBy(function ($class) {
                return $class->date . ' ' . $class->start_time; // Combine date and start_time for sorting
            });
        $this->totalStudents = $this->teacher->coursesAsTeacher->flatMap->students->unique()->count();
        $this->totalClasses = $this->teacher->coursesAsTeacher->flatMap->classes->unique()->count();

        $this->totalHours = $this->teacher->coursesAsTeacher->flatMap(function ($course) {
            return $course->classes->where('status', '=', '2')->where('status', '=', '2')->pluck('hours');
        })->sum();

        $this->totalHoursThisMonth = $this->teacher->coursesAsTeacher->flatMap(function ($course) use ($currentMonth) {
            return $course->classes->filter(function ($class) use ($currentMonth) {
                // Filter classes with status 2 and date in the current month
                return $class->status === 2 && Carbon::parse($class->date)->month === $currentMonth;
            })->pluck('hours');
        })->sum();

        // Get the current date and time
        $currentDateTime = Carbon::now();

        // Get the current date and time
        $currentDateTime = now();

        // Retrieve the teacher's upcoming classes for today
        $this->upcomingClasses = $this->teacher->coursesAsTeacher()
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



        $this->courses = $this->teacher->coursesAsTeacher()
            ->whereIn('status_id', [1, 2])
            ->with([
                'classes' => function ($query) {
                    $query->where('status', 2);
                }
            ])
            ->withSum([
                'classes' => function ($query) {
                    $query->where('status', 2);
                }
            ], 'hours')
            ->get();



    }


    public function render()
    {

        return view('livewire.teacher-home');
    }
}
