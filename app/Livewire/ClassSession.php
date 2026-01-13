<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Course;
use Livewire\Component;
use App\Mail\ClassCreated;
use App\Rules\NoClassConflict;
use App\Rules\ScheduleConflict;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Mail;

#[Title('create class')]
class ClassSession extends Component
{
    public $course;
    public $hours = 1;
    public $date;
    public $start_time;
    public $end_time;
    public $room_id;
    public $remainingHours;
    public $rooms;
    public $conflict;

    public $pendingHours;
    public $doneHours;

    public $meeting_link;
    public $is_online = false;

    public $notifyUser = false;

    public $events = [];

    /* =========================
        VALIDATION
    ========================= */

    public function rules()
    {
        $minDate = now()->subMonths(6)->toDateString();

        return [
            'hours'      => 'required|min:0.5',
            'date'       => ['required', 'date', 'after_or_equal:' . $minDate],
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'room_id'    => 'required|exists:rooms,id',
            'meeting_link' => '',
        ];
    }

    public function crules()
    {
        return [
            'conflict' => [
                new NoClassConflict(
                    null,
                    $this->room_id,
                    $this->date,
                    $this->start_time,
                    $this->end_time,
                    $this->course->id
                )
            ],
        ];
    }

    public function srules()
    {
        return [
            'conflict' => [
                new ScheduleConflict(
                    $this->course->teacher_id,
                    $this->date,
                    $this->start_time,
                    $this->end_time,
                    null
                )
            ],
        ];
    }

    /* =========================
        MOUNT
    ========================= */

    public function mount(Course $course)
    {
        $this->course = $course;

        $this->authorize('addClass', $course);

        $this->date = Carbon::today()->format('d-m-Y');
        $this->start_time = Carbon::now()->format('H:i');
        $this->calculateEndTime();

        $this->rooms = Room::all();

        $this->doneHours    = $course->classes->where('status', 2)->sum('hours');
        $this->pendingHours = $course->classes->where('status', 1)->sum('hours');

        $this->calculateRemainingHours();

        // Valeur par défaut
        $this->room_id = 1;

        if ($course->course_type == 2) {
            // ONLINE
            $this->room_id = 102;
            $this->is_online = true;
            $this->clearCalendar();
        } else {
            $this->loadClasses($this->room_id);
        }
    }

    /* =========================
        ROOM CHANGE
    ========================= */

    public function updatedRoomId($value)
    {
        // Online ou Outside → pas de calendrier
        if (in_array($value, [102, 101])) {
            $this->is_online = ($value == 102);
            $this->clearCalendar();
            return;
        }

        $this->is_online = false;
        $this->loadClasses($value);
    }

    /* =========================
        CALENDAR LOGIC
    ========================= */

    protected function clearCalendar()
    {
        $this->events = [];
        $this->dispatch('roomChanged', []);
    }

    public function loadClasses($roomId)
    {
        $today = now()->subDays(31)->toDateString();

        $classes = \App\Models\ClassSession::where('date', '>=', $today)
            ->where('room_id', $roomId)
            ->get();

        $this->events = [];

        foreach ($classes as $class) {

            // Si c’est le prof connecté → vrai nom
            if ($class->course->teacher_id === auth()->id()) {
                $title = $class->course->name;
            } else {
                $title = 'Salle occupée';
            }

            $this->events[] = [
                'title' => $title,
                'start' => $class->date . 'T' . $class->start_time,
                'end'   => $class->date . 'T' . $class->end_time,
            ];
        }

        $this->dispatch('roomChanged', $this->events);
    }

    /* =========================
        TIME HANDLING
    ========================= */

    public function updatedDate()
    {
        $this->dispatch('dateChanged', $this->date);
        $this->loadClasses($this->room_id);
    }

    public function updatedHours($value)
    {
        $this->hours = max(0.25, $value);
        $this->calculateEndTime();
    }

    public function updatedStartTime()
    {
        $this->calculateEndTime();
    }

    protected function calculateEndTime()
    {
        if (!$this->hours || !$this->start_time) {
            $this->end_time = null;
            return;
        }

        $start = \DateTime::createFromFormat('H:i', $this->start_time);
        $minutes = $this->hours * 60;

        $end = clone $start;
        $end->modify("+{$minutes} minutes");

        $this->end_time = $end->format('H:i');
        $this->dispatch('updateEndtime', $this->end_time);
    }

    /* =========================
        CREATE CLASS
    ========================= */

    public function createClass()
    {
        $validatedData = $this->validate();

        $this->validate($this->crules());
        $this->validate($this->srules());

        if ($this->hours > $this->remainingHours) {
            $this->addError(
                'hours',
                "The total hours cannot exceed the remaining {$this->remainingHours} hours."
            );
            return;
        }

        $validatedData['date'] = Carbon::parse($this->date)->format('Y-m-d');
        $validatedData['course_id'] = $this->course->id;

        $classSession = \App\Models\ClassSession::create($validatedData);

        $this->dispatch('showAlert', [
            'title' => 'Class created successfully',
            'icon'  => 'success',
        ]);

        $this->calculateRemainingHours();
        $this->loadClasses($this->room_id);

        $this->doneHours    = $this->course->classes->where('status', 2)->sum('hours');
        $this->pendingHours = $this->course->classes->where('status', 1)->sum('hours');

        if ($this->notifyUser) {
            foreach ($this->course->students as $student) {
                Mail::to($student->email)->queue(new ClassCreated($classSession));
            }
        }
    }

    /* =========================
        HELPERS
    ========================= */

    protected function calculateRemainingHours()
    {
        $used = $this->course->classes->sum('hours');
        $this->remainingHours = $this->course->total_hours - $used;
    }

    public function render()
    {
        return view('livewire.class-session');
    }
}
