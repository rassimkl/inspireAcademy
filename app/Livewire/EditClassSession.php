<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Course;
use Livewire\Component;
use App\Mail\Reschedule;

use App\Mail\ClassCreated;
use App\Models\ClassSession;
use App\Rules\NoClassConflict;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Mail;

#[Title('Edit Class')]
class EditClassSession extends Component
{

    public $course;
    public $classsession;
    public $hours;
    public $date;
    public $start_time;
    public $end_time;
    public $room_id;
    public $total_hours;
    public $remainingHours;
    public $rooms;

    public $conflict;

    public $oldclassSession;
    public $notifyUser = true;

    public $events = [];


    protected $rules = [
        'hours' => 'required|min:0.25',
        'date' => 'required|date|after_or_equal:today',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'room_id' => 'required|exists:rooms,id',

    ];


    public function crules()
    {
        return [
            'conflict' => [new NoClassConflict($this->classsession->id, $this->room_id, $this->date, $this->start_time, $this->end_time)],


        ];
    }


    public function mount(ClassSession $classsession)
    {

        if ($classsession->status == 2) {

            $this->redirect(TeacherHome::class);
        }

        $this->classsession = $classsession;


        $this->oldclassSession = [
            'hours' => $classsession->hours,
            'date' => $classsession->date,
            'start_time' => $classsession->start_time,
            'end_time' => $classsession->end_time,
        ];


        $this->course = $classsession->course;
        $this->authorize('addClass', $this->course);

        //$this->authorize('addClass', $course);
        $this->rooms = Room::all();
        $this->calculateRemainingHours();

        $this->hours = $classsession->hours;
        $this->date = Carbon::parse($classsession->date)->format('d-m-Y');
        $this->start_time = Carbon::parse($classsession->start_time)->format('H:i');
        $this->end_time = Carbon::parse($classsession->end_time)->format('H:i');

        $this->room_id = $classsession->room_id;
        $this->loadClasses($classsession->room_id);



    }

    public function loadClasses($roomId)
    {
        $today = now()->toDateString();

        $classes = ClassSession::where('date', '>=', $today)
            ->where('room_id', $roomId)
            ->get();

        $this->events = [];

        foreach ($classes as $class) {
            $title = $class->course->name . ' In ' . $class->room->name;
            if ($class->id == $this->classsession->id) {
                $title .= ' - Current Session';
            }
            $this->events[] = [
                'title' => $title,
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

    public function updatedRoomId($value)
    {
        $this->loadClasses($value);
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




    public function updateClassSession()
    {

        $validatedData = $this->validate();
        $this->validate($this->crules());
        $validatedData['date'] = Carbon::parse($this->date)->format('Y-m-d');

        if ($this->hours > $this->remainingHours) {
            $this->addError('hours', 'The total hours of this classe cannot exceed the remaining  ' . $this->remainingHours . ' hours for this course.');
            return;
        }

        $this->classsession->update($validatedData);

        $this->dispatch('showAlert', [
            'title' => "Class Updated Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);

        foreach ($this->course->students as $student) {
            $this->sendEmail($this->classsession, $student->email, $this->oldclassSession);
        }

        $this->calculateRemainingHours();
        $this->loadClasses($validatedData['room_id']);
    }

    public function calculateRemainingHours()
    {
        $this->totalHours = $this->course->classes->sum('hours');
        $this->remainingHours = $this->course->total_hours - $this->totalHours;
    }

    public function sendEmail(\App\Models\ClassSession $classSession, $email, $oldclassSession)
    {

        //Mail::to('ali.gogo11ayad@gmail.com')->send(new ClassCreated($classSession));

        Mail::to($email)->queue(new Reschedule($classSession, $oldclassSession));

    }

    public function render()
    {
        return view('livewire.edit-class-session');
    }
}
