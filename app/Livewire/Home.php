<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Course;
use Livewire\Component;
use App\Models\UserType;
use App\Models\ClassSession;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Home')]
class Home extends Component
{
    public $studentCount;
    public $teacherCount;
    public $currentMonthClasses;
    public $totalPayment;
    public $classesForToday;

    public $formattedEvents;

    public $classSubmitted;

    public $coursesCount;

    public function mount()
    {

    }
    public function render()
    {
       
        $this->studentCount = UserType::where('name', 'Student')->firstOrFail()->users()->count();
        $this->coursesCount = Course::whereIn('status_id', [2])
            ->count();
        ;
        $classesToPayThisMonth = ClassSession::whereYear('date', '=', date('Y'))
            ->whereMonth('date', '=', date('m'))
            ->where('status', '=', 2)
            ->where('payment_status', '=', 1)
            ->with('course') // Preload the 'course' relationship
            ->get();

        $this->currentMonthClasses = $classesToPayThisMonth->count();

        $totalPayment = 0;

        foreach ($classesToPayThisMonth as $class) {
            // Calculate the total payment for each class
            $courseChargePerHour = $class->course->charge_per_hour;
            $classHours = $class->hours;
            $totalPayment += $courseChargePerHour * $classHours;
        }
        $this->totalPayment = $totalPayment;

        $this->classesForToday = ClassSession::whereDate('date', '=', now()->format('Y-m-d'))->with('course')
            ->get();



        $classesForCalendar = ClassSession::whereDate('date', '>=', now()->subMonth()->startOfMonth()->format('Y-m-d'))
            ->get();


        $formattedEvents = [];

        foreach ($classesForCalendar as $classC) {
            $title = $classC->course->name . '- ' . $classC->room->name . ' - ' . $classC->course->teacher->first_name . ' ' . $classC->course->teacher->last_name;
            $formattedEvents[] = [
                'title' => $title, // You can change this to any field you want to display
                'start' => Carbon::parse($classC->date)->format('Y-m-d') . ' ' . $classC->start_time,
                'end' => Carbon::parse($classC->date)->format('Y-m-d') . ' ' . $classC->end_time,
                // Add any other properties you want to pass to FullCalendar
            ];
        }

        $this->formattedEvents = $formattedEvents;









        $this->classSubmitted = ClassSession::where('status', 2)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();










        return view('livewire.dashboard.home');
    }
}
