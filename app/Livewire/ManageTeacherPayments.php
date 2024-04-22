<?php

namespace App\Livewire;

use App\Models\ClassSession;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;

class ManageTeacherPayments extends Component
{
    protected $listeners = [
        'updateStatusPayment' => 'updateStatusPayment',

    ];
    public $teachers;
    public $Selectedteacher;
    public $selectedMonth;

    public $totalHours = 0;
    public $totalPayment = 0;
    protected $rules = [
        'Selectedteacher' => 'required',
        'selectedMonth' => 'required|date_format:m-Y',
    ];

    protected $messages = [
        'Selectedteacher.required' => 'Please select a Teacher.',
        'selectedMonth.required' => 'Please select a month and year.',
        'selectedMonth.date_format' => 'The month and year must be in the format MM-YYYY.',
    ];

    public $lessons = [];

    public function mount()
    {

        $this->loadTeachers();
        $this->selectedMonth = Carbon::today()->format('m-Y');


    }

    public function loadClasses($teacherId, $selectedMonth)
    {
        $date = Carbon::createFromFormat('m-Y', $selectedMonth)->startOfMonth();



        $this->lessons = ClassSession::whereHas('course', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
            ->where('status', 2)
            ->where('payment_status', 1)
            ->whereMonth('date', Carbon::parse($date)->format('m'))
            ->whereYear('date', Carbon::parse($date)->format('Y'))
            ->get();


        $totalHours = 0;
        $totalCharge = 0;

        foreach ($this->lessons as $lesson) {
            // Sum up the hours
            $totalHours += $lesson->hours;

            // Calculate the total charge for each class
            $totalCharge += $lesson->course->charge_per_hour * $lesson->hours;
        }
        $this->totalHours = $totalHours;
        $this->totalPayment = $totalCharge;
    }
    public function loadTeachers()
    {
        $this->selectedMonth = now()->format('Y-m');
        $this->teachers = User::where('user_type_id', 2)
            ->with([
                'classes' => function ($query) {
                    $query->whereMonth('date', Carbon::parse($this->selectedMonth)->format('m'))
                        ->whereYear('date', Carbon::parse($this->selectedMonth)->format('Y'))
                        ->where('payment_status', 1)->where('status', 2);
                }
            ])
            ->whereHas('classes', function ($query) {
                $query->whereMonth('date', Carbon::parse($this->selectedMonth)->format('m'))
                    ->whereYear('date', Carbon::parse($this->selectedMonth)->format('Y'))
                    ->where('payment_status', 1)->where('status', 2);
            })

            ->get();

    }

    public function updatedSelectedMonth($value)
    {
        $this->validate();
        $this->loadClasses($this->Selectedteacher, $value);



    }

    public function updatedSelectedTeacher($value)
    {

        $this->validate();
        $this->loadClasses($value, $this->selectedMonth);
    }

    public function updatePaymentStatus()
    {

        $this->dispatch('confirmTask', 'Are you sure you want to update Payment Status', 'updateStatusPayment');

    }

    public function updateStatusPayment()
    {
        foreach ($this->lessons as $lesson) {
            $lesson->payment_status = 2;
            $lesson->save();
        }


        $this->dispatch('showAlert', [
            'title' => "Classes assigned Paid Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);

        $this->Selectedteacher = null;

        $this->lessons = [];
        $this->loadTeachers();
        // $this->loadTeachers();



    }
    public function render()
    {
        return view('livewire.manage-teacher-payments');
    }
}
