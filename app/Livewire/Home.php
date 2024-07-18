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

    public $events = [];
    public $rooms;

    public $selectedRoomId='null';

    public function mount()
    {
    
        $this->loadData($this->selectedRoomId);
        $this->rooms = Room::pluck('name', 'id');



    }

    public function updatedSelectedRoomId($value)
    {
        $this->loadData($value);

        $this->dispatch('reloadcaldenar', $this->formattedEvents);
    }
    public function loadData($room)
    {
        $query = ClassSession::query();

        if ($room !== 'null') {
            $query->where('room_id', $this->selectedRoomId);
        }



        $this->formattedEvents = $query->get()->map(function ($classC) {
            return [
                'id'=>$classC->id,
                'title' => $classC->course->name . ' - ' . $classC->room->name . ' - ' . $classC->course->teacher->first_name . ' ' . $classC->course->teacher->last_name,
                'start' => $classC->date . ' ' . $classC->start_time,
                'end' => $classC->date . ' ' . $classC->end_time,
                'color' => $this->getColorForRoom($classC->room_id),
                // Add any other properties you want to pass to FullCalendar
            ];
        });
    }

    private function getColorForRoom($roomId)
    {
        $colors = [
            1 => '#FF5733',
            2 => '#00468B',
            3 => '#8B0000',
            // Add more colors as needed
        ];

        return $colors[$roomId] ?? '#006400'; // Default color if room ID not found
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

       

// Get the classes for today
$this->classesForToday = ClassSession::whereDate('date', '=', now()->format('Y-m-d'))
    ->with('course')
    ->get()
    ->sortBy('start_time');

    $count = max($this->classesForToday->count(), 5);

// Get the latest submitted classes
$this->classSubmitted = ClassSession::where('status', 2)
    ->orderBy('updated_at', 'desc')
    ->take($count)
    ->get();



        return view('livewire.dashboard.home');
    }
}
