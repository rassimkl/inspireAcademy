<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Room;
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
    public $coursesCountdstart;

    public function mount()
    {

    }
    public function render()
    {

        $this->studentCount = UserType::where('name', 'Student')->firstOrFail()->users()->count();
        $this->coursesCountdstart = Course::whereIn('status_id', [1])
            ->count();
        ;

        $this->coursesCount = Course::whereIn('status_id', [2])
            ->count();
        ;
        $classesToPayThisMonth = ClassSession::whereYear('date', '=', date('Y'))

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

        $this->classesForToday = ClassSession::whereDate('date', '=', now()->format('Y-m-d'))
            ->with('course')
            ->get()
            ->sortBy('start_time');




        $classesForCalendar = ClassSession::whereDate('date', '>=', now()->subMonth()->startOfMonth()->format('Y-m-d'))
            ->get();


        $colors = [
            1 => '#FF5733',   // Specific color for room with ID 1
            2 => '#00468B',
            3 => '#8B0000',   // Specific color for room with ID 2
            // Add more specific colors for other rooms as needed
        ];

        $defaultColor = '#006400'; // Dark green as default color for other rooms

        $formattedEvents = [];

        foreach ($classesForCalendar as $classC) {
            $title = $classC->course->name . ' - ' . $classC->room->name . ' - ' . $classC->course->teacher->first_name . ' ' . $classC->course->teacher->last_name;

            // Determine color based on room_id
            $color = isset($colors[$classC->room_id]) ? $colors[$classC->room_id] : $defaultColor;

            $formattedEvents[] = [
                'title' => $title,
                'start' => Carbon::parse($classC->date)->format('Y-m-d') . ' ' . $classC->start_time,
                'end' => Carbon::parse($classC->date)->format('Y-m-d') . ' ' . $classC->end_time,
                'color' => $color,
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
