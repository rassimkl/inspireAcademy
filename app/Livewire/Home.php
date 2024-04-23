<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\UserType;
use App\Models\ClassSession;
use Livewire\Attributes\Title;

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
    public function render()
    {
        $this->studentCount = UserType::where('name', 'Student')->firstOrFail()->users()->count();
        $this->teacherCount = UserType::where('name', 'Teacher')->firstOrFail()->users()->count();
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
            ->whereDate('created_at', '<=', Carbon::today()) // Classes submitted today or earlier
            ->orderByDesc('created_at') // Order by submission time in descending order
            ->limit(4) // Limit the results to the first 4 classes
            ->get();











        return view('livewire.dashboard.home');
    }
}
