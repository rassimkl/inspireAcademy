<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;


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
    public function mount()
    {

        $currentMonth = Carbon::now()->month;


        $this->teacher = User::with(['coursesAsTeacher.students', 'coursesAsTeacher.classes'])->find(auth()->id());
        $this->calendarClasses = $this->teacher->classes;
        $this->unfinishedClasses = $this->teacher->classes->where('status', 1);
        $this->totalStudents = $this->teacher->coursesAsTeacher->flatMap->students->unique()->count();
        $this->totalClasses = $this->teacher->coursesAsTeacher->flatMap->classes->unique()->count();

        $this->totalHours = $this->teacher->coursesAsTeacher->flatMap(function ($course) {
            return $course->classes->where('status', '=', '2')->pluck('hours');
        })->sum();

        $this->totalHoursThisMonth = $this->teacher->coursesAsTeacher->flatMap(function ($course) use ($currentMonth) {
            return $course->classes->filter(function ($class) use ($currentMonth) {
                // Filter classes with status 2 and date in the current month
                return $class->status === 2 && Carbon::parse($class->date)->month === $currentMonth;
            })->pluck('hours');
        })->sum();

        // Get the current date and time
        $currentDateTime = Carbon::now();

        // Retrieve the teacher's upcoming classes
        $this->upcomingClasses = $this->teacher->coursesAsTeacher()
            ->with([
                'classes' => function ($query) use ($currentDateTime) {
                    $query->where('date', '>=', $currentDateTime->toDateString()) // Classes after or on the current date
                        ->orWhere(function ($query) use ($currentDateTime) {
                            $query->where('date', $currentDateTime->toDateString()) // Classes on the current date
                                ->where('start_time', '>=', $currentDateTime->toTimeString()); // Classes with start time after or equal to current time
                        })
                        ->orderBy('date', 'asc') // Order by date in ascending order
                        ->orderBy('start_time', 'asc') // Then by start_time in ascending order
                        ->limit(2); // Limit the results to 2
                }
            ])
            ->get()
            ->flatMap->classes; // Flatten the classes collection


        $this->courses = $this->teacher->coursesAsTeacher()
            ->whereIn('status_id', [1, 2])
            ->withSum('classes', 'hours')
            ->get();

    }
    public function render()
    {
        return view('livewire.teacher-home');
    }
}
