<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\ClassSession;
use Livewire\Component;

class SubmitClass extends Component
{
    public $course;
    public $report;
    public $classsession;
    public $hours;
    public $date;
    public $start_time;
    public $end_time;
    public $room_id;
    public $total_hours;
    public $remainingHours;
    public $rooms;

    protected $rules = [
        'report' => 'required|string',


    ];

    public function mount(ClassSession $classsession)
    {
        $this->classsession = $classsession;

        if ($classsession->status == 2) {

            $this->redirect(TeacherHome::class);
        }

        $this->course = $classsession->course;

        //$this->authorize('addClass', $course);
        $this->rooms = Room::all();
        $this->calculateRemainingHours();

        $this->hours = $classsession->hours;
        $this->date = Carbon::parse($classsession->date)->format('d-m-Y');
        $this->start_time = Carbon::parse($classsession->start_time)->format('H:i');
        $this->end_time = Carbon::parse($classsession->end_time)->format('H:i');

        $this->room_id = $classsession->room_id;



    }


    public function submitClass()
    {

        $validatedData = $this->validate();

        $endTime = Carbon::parse($this->date . ' ' . $this->end_time);


        if ($endTime->greaterThan(Carbon::now())) {
            $this->addError('report', 'You cant submit before end of the class');
            return;
        }

        $validatedData['status'] = 2;
        $this->classsession->update($validatedData);

        $this->dispatch('showAlert', [
            'title' => "Class Submited Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);

        $this->course->updateStatus();

        $this->redirect(TeacherHome::class);

    }







    public function calculateRemainingHours()
    {
        $this->totalHours = $this->course->classes->sum('hours');
        $this->remainingHours = $this->course->total_hours - $this->totalHours;
    }

    public function render()
    {
        return view('livewire.submit-class');
    }
}
