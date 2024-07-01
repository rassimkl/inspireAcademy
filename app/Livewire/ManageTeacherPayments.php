<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Livewire\Component;
use App\Models\ClassSession;
use Illuminate\Support\Facades\DB;


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
        DB::beginTransaction();

        try {
            foreach ($this->lessons as $lesson) {
                $lesson->payment_status = 2;
                $lesson->save();
            }

            Payment::create([
                'user_id' => $this->Selectedteacher,
                'amount' => $this->totalPayment,
                'hours' => $this->totalHours,
            ]);

            DB::commit();

            $this->dispatch('showAlert', [
                'title' => "Classes assigned Paid Successfully",
                'text' => '',
                'icon' => 'success'
            ]);

            $this->reset(['Selectedteacher', 'totalPayment', 'lessons', 'totalHours']);

            $this->loadTeachers();
        } catch (\Exception $e) {
            DB::rollBack();

            // Handle the exception (e.g., log the error, display a message)
            $errorMessage = $e->getMessage();
            $this->dispatch('showAlert', [
                'title' => "Error occurred",
                'text' => $errorMessage,
                'icon' => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.manage-teacher-payments');
    }
}
