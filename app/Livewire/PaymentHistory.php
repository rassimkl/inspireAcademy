<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\ClassSession;
use Livewire\Attributes\Title;


#[Title('Invoice')]
class PaymentHistory extends Component
{

    public $teachers;
    public $totalAllPayment;

    public $Selectedteacher;
    public $selectedMonth;

    public $totalHours = 0;
    public $totalPayment = 0;

    public $totalVPayment = 0;
    public $totalVHours = 0;
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

        $this->loadTeachers(Carbon::today()->format('m-Y'));
        $this->selectedMonth = Carbon::today()->format('m-Y');

        // Parse the selected month into a Carbon instance
        $date = Carbon::createFromFormat('m-Y', $this->selectedMonth)->startOfMonth();


        $classesToPayThisMonth = ClassSession::where('status', '=', 2)
            ->where('payment_status', '=', 2)
            ->whereMonth('date', Carbon::parse($date)->format('m'))
            ->whereYear('date', Carbon::parse($date)->format('Y'))
            ->with('course') // Preload the 'course' relationship
            ->get();


        $totalPayment = 0;

        foreach ($classesToPayThisMonth as $class) {
            // Calculate the total payment for each class
            $courseChargePerHour = $class->course->charge_per_hour;
            $classHours = $class->hours;
            $totalPayment += $courseChargePerHour * $classHours;
        }
        $this->totalAllPayment = $totalPayment;


    }

    public function loadClasses($teacherId, $selectedMonth)
    {

        if ($teacherId == "0") {

            $this->lessons = [];
            return;
        }
        $date = Carbon::createFromFormat('m-Y', $selectedMonth)->startOfMonth();



        $this->lessons = ClassSession::whereHas('course', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })

            ->where('payment_status', 2)
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
    public function loadTeachers($date)
    {

        $this->Selectedteacher = null;
        // Parse the input date
        $parsedDate = Carbon::createFromFormat('m-Y', $date);
        $month = $parsedDate->format('m');
        $year = $parsedDate->format('Y');

        $this->teachers = User::where('user_type_id', 2)
            ->with([
                'classes' => function ($query) use ($month, $year) {
                    $query->whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->where('payment_status', 2)
                    ;
                }
            ])
            ->whereHas('classes', function ($query) use ($month, $year) {
                $query->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->where('payment_status', 2);

            })
            ->orderBy('first_name', 'asc')->get();



    }

    public function updatedSelectedMonth($value)
    {
        $this->loadTeachers($value);
        $this->lessons = [];

        $this->validate();
        $this->loadClasses($this->Selectedteacher, $value);

        // Parse the selected month into a Carbon instance
        $date = Carbon::createFromFormat('m-Y', $value)->startOfMonth();


        $classesToPayThisMonth = ClassSession::where('status', '=', 2)
            ->where('payment_status', '=', 2)
            ->whereMonth('date', Carbon::parse($date)->format('m'))
            ->whereYear('date', Carbon::parse($date)->format('Y'))
            ->with('course') // Preload the 'course' relationship
            ->get();


        $totalPayment = 0;

        foreach ($classesToPayThisMonth as $class) {
            // Calculate the total payment for each class
            $courseChargePerHour = $class->course->charge_per_hour;
            $classHours = $class->hours;
            $totalPayment += $courseChargePerHour * $classHours;
        }
        $this->totalAllPayment = $totalPayment;

    }

    public function updatedSelectedTeacher($value)
    {

        $this->validate();
        $this->loadClasses($value, $this->selectedMonth);

        foreach ($this->lessons as $lesson) {

            if ($lesson->status == 1) {

                $this->addError('Selectedteacher', 'One or more classes have to be submitted.');

            }
        }


    }






    public function render()
    {




        return view('livewire.payment-history');
    }
}
