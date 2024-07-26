<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Course;
use Livewire\Component;
use App\Mail\Reschedule;

use App\Mail\ClassCreated;
use Livewire\Attributes\On;
use App\Models\ClassSession;
use App\Rules\NoClassConflict;
use Livewire\Attributes\Title;
use App\Rules\ScheduleConflict;
use Illuminate\Support\Facades\Mail;

#[Title('Edit Class')]
class EditClassSession extends Component
{

    protected $listeners = [
        'deleteClass' => 'deleteClass',

    ];
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

    public $meeting_link;
    public $is_online = false;


    public $notifyUser = false;


    public $pendingHours;
    public $doneHours;
    public $events = [];


    public function rules()
    {
        $minDate = now()->subDays(31)->toDateString();


        return [
            'hours' => 'required|min:0.25',
            'date' => [
                'required',
                'date',

                'after_or_equal:' . $minDate,
            ],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_id' => 'required|exists:rooms,id',
            'meeting_link' => '',

        ];
    }




    public function crules()
    {
        return [
            'conflict' => [new NoClassConflict($this->classsession->id, $this->room_id, $this->date, $this->start_time, $this->end_time, $this->course->id)],


        ];
    }
    public function srules()
    {
        return [
            'conflict' => [new ScheduleConflict($this->course->teacher_id, $this->date, $this->start_time, $this->end_time, $this->classsession->id)],


        ];

    }

    public function mount(ClassSession $classsession)
    {

        if (auth()->user()->user_type_id == 1) {

        } elseif ($classsession->status == 2) {

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

        $this->doneHours = $this->course->classes->where('status', 2)->sum('hours');
        $this->pendingHours = $this->course->classes->where('status', 1)->sum('hours');

        $this->authorize('addClass', $this->course);


        $this->rooms = Room::all();
        $this->calculateRemainingHours();

        $this->hours = $classsession->hours;
        $this->date = Carbon::parse($classsession->date)->format('d-m-Y');

        $this->start_time = Carbon::parse($classsession->start_time)->format('H:i');
        $this->end_time = Carbon::parse($classsession->end_time)->format('H:i');
        $this->meeting_link = $classsession->meeting_link;
        $this->room_id = $classsession->room_id;

        if ($this->room_id == 102) {
            $this->is_online = true;


        }


        $this->loadClasses($classsession->room_id);



    }

    #[On('datechange')]
    public function changedate()
    {
        $this->dispatch('dateChanged', $this->date);
    }

    public function loadClasses($roomId)
    {
        $today = now()->subDays(31)->toDateString();

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
        $this->is_online = ($value == 102);
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
        $this->validate($this->srules());




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


    public function cdeleteClass()
    {

        $this->dispatch('cancelClass', 'Are you sure you want to Cancel this Class', 'deleteClass');

    }

    public function deleteClass()
    {

        $this->authorize('addClass', $this->course);
        if ($this->classsession->status == 2) {
            return;
        }
        $this->classsession->delete();


        $this->dispatch('showAlert', [
            'title' => "Class Canceled Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);


        $this->redirect(ClassList::class);

    }


    public function calculateRemainingHours()
    {
        $this->totalHours = $this->course->classes->sum('hours');
        $this->remainingHours = $this->course->total_hours - $this->totalHours;

        $this->remainingHours += $this->classsession->hours;
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
