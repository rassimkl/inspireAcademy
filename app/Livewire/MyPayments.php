<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Livewire\Component;
use App\Models\ClassSession;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('My Payments')]
class MyPayments extends Component
{


    public $selectedMonth;

    public $totalHours = 0;
    public $totalPayment = 0;

    public $totalVPayment = 0;
    public $totalVHours = 0;


    protected $rules = [

        'selectedMonth' => 'required|date_format:m-Y',
    ];

    protected $messages = [

        'selectedMonth.required' => 'Please select a month and year.',
        'selectedMonth.date_format' => 'The month and year must be in the format MM-YYYY.',
    ];

    public $lessons = [];

    public function mount()
    {


        $this->selectedMonth = Carbon::today()->format('m-Y');

        $this->loadClasses($this->selectedMonth);



    }

    public function loadClasses($selectedMonth)
    {
        $teacherId = auth()->user()->id;

        $date = Carbon::createFromFormat('m-Y', $selectedMonth)->startOfMonth();

        $this->lessons = ClassSession::whereHas('course', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })


            ->whereMonth('date', Carbon::parse($date)->format('m'))
            ->whereYear('date', Carbon::parse($date)->format('Y'))
            ->get();


        $totalHours = 0;
        $totalVHours = 0;
        $totalCharge = 0;
        $totalVCharge = 0;

        foreach ($this->lessons as $lesson) {
            // Sum up the hours
            $totalHours += $lesson->hours;

            // Calculate the total charge for each class
            $totalCharge += $lesson->course->charge_per_hour * $lesson->hours;
            if ($lesson->status == 2) {
                // Sum up the hours
                $totalVHours += $lesson->hours;

                // Calculate the total charge for each class
                $totalVCharge += $lesson->course->charge_per_hour * $lesson->hours;
            }


        }
        $this->totalHours = $totalHours;
        $this->totalPayment = $totalCharge;

        $this->totalVHours = $totalVHours;
        $this->totalVPayment = $totalVCharge;
    }


    public function updatedSelectedMonth($value)
    {

        $this->lessons = [];

        $this->validate();
        $this->loadClasses($value);



    }




    public function render()
    {
        return view('livewire.my-payments');
    }
}
