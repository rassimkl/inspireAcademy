<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\Course;
use Livewire\Component;

class ClassSession extends Component
{


    public $course;
    public $hours = 0.25;
    public $date;
    public $start_time;
    public $end_time;
    public $room_id;
    public $total_hours;
    public $remainingHours;
    public $rooms;

    protected $rules = [
        'hours' => 'required|min:0.5',
        'date' => 'required|date|after_or_equal:today',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'room_id' => 'required|exists:rooms,id',

    ];

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->authorize('addClass', $course);
        $this->rooms = Room::all();
        $this->calculateRemainingHours();

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
        $this->reset(['end_time', 'start_time', 'date', 'hours', 'room_id']);
        $this->calculateRemainingHours();
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
