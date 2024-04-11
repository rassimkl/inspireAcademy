<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Course;
use Livewire\Component;
use App\Rules\NoClassConflict;

class ClassSession extends Component
{


    public $course;
    public $hours = 1;
    public $date;
    public $start_time;
    public $end_time;
    public $room_id;
    public $total_hours;
    public $remainingHours;
    public $rooms;
    public $conflict;


    public $events = [];

    public function rules()
    {

        return [
            'hours' => 'required|min:0.5',
            'date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_id' => 'required|exists:rooms,id',



        ];
    }

    public function crules()
    {
        return [
            'conflict' => [new NoClassConflict(null, $this->room_id, $this->date, $this->start_time, $this->end_time)],


        ];
    }


    public function mount(Course $course)
    {
        $this->date = Carbon::today()->format('d-m-Y');
        $this->start_time = Carbon::now()->format('H:i');
        $this->calculateEndTime();
        $this->room_id = 1;
        $this->course = $course;
        $this->authorize('addClass', $course);
        $this->rooms = Room::all();
        $this->calculateRemainingHours();
        $this->loadClasses(1);




    }

    public function updatedRoomId($value)
    {
        $this->loadClasses($value);
    }
    public function loadClasses($roomId)
    {
        $today = now()->toDateString();

        $classes = \App\Models\ClassSession::where('date', '>=', $today)
            ->where('room_id', $roomId)
            ->get();

        $this->events = [];

        foreach ($classes as $class) {
            $this->events[] = [
                'title' => $class->course->name . ' In ' . $class->room->name,
                'start' => $class->date . 'T' . $class->start_time,
                'end' => $class->date . 'T' . $class->end_time,
                // Add other necessary properties
            ];
        }
        $this->dispatch('roomChanged', $this->events);
    }

    public function updatedDate($value)
    {
        $this->dispatch('dateChanged', $value);
        $this->loadClasses($this->room_id); // Pass the current room_id

    }

    public function updatedHours($value)
    {
        $this->hours = max(0.25, $value); // Ensure hours is at least 0.5
        $this->calculateEndTime();
    }
    public function updatedStartTime($value)
    {
        $this->calculateEndTime();
    }
    protected function calculateEndTime()
    {
        if (!empty($this->hours) && !empty($this->start_time)) {
            // Convert the hours to minutes
            $minutes = $this->hours * 60;

            // Calculate the end time by adding the minutes to the start time
            $start = \DateTime::createFromFormat('H:i', $this->start_time);
            $end = clone $start;
            $end->modify('+' . $minutes . ' minutes');

            // Set the end time property
            $this->end_time = $end->format('H:i');

            // Dispatch a Livewire event to update the end time
            $this->dispatch('updateEndtime', $this->end_time);
        } else {
            $this->end_time = null;
        }
    }




    public function createClass()
    {
        $validatedData = $this->validate();

        $this->validate($this->crules());


        $validatedData['date'] = Carbon::parse($this->date)->format('Y-m-d');

        if ($this->hours > $this->remainingHours) {
            $this->addError('hours', 'The total hours of this classe cannot exceed the remaining  ' . $this->remainingHours . ' hours for this course.');
            return;
        }


        Course::find($this->course->id)->classes()->create($validatedData);

        $this->dispatch('showAlert', [
            'title' => "Class Created Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);
        //$this->reset(['end_time', 'start_time', 'date', 'hours', 'room_id']);
        $this->calculateRemainingHours();
        $this->loadClasses($this->room_id);
    }

    public function calculateRemainingHours()
    {
        $this->totalHours = $this->course->classes->sum('hours');
        $this->remainingHours = $this->course->total_hours - $this->totalHours;
    }
    public function render()
    {
        return view('livewire.class-session');
    }
}
