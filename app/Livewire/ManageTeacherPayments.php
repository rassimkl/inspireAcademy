<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Livewire\Component;
use App\Models\ClassSession;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Manage Payments')]
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

        $this->loadTeachers(Carbon::today()->format('m-Y'));
        $this->selectedMonth = Carbon::today()->format('m-Y');


    }

    public function loadClasses($teacherId, $selectedMonth)
    {
        $date = Carbon::createFromFormat('m-Y', $selectedMonth)->startOfMonth();



        $this->lessons = ClassSession::whereHas('course', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })

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
                        ->where('payment_status', 1)
                    ;
                }
            ])
            ->whereHas('classes', function ($query) use ($month, $year) {
                $query->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->where('payment_status', 1);

            })
            ->orderBy('first_name', 'asc')->get();



    }

    public function updatedSelectedMonth($value)
    {
        $this->loadTeachers($value);
        $this->lessons = [];

        $this->validate();
        $this->loadClasses($this->Selectedteacher, $value);



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

    public function updatePaymentStatus()
    {

        $this->dispatch('confirmPaymentTask', 'Are you sure you want to set as Paid ?', 'updateStatusPayment');

    }



    public function updateStatusPayment()
    {

        DB::beginTransaction();
        $allsubmited = true;
        try {
            foreach ($this->lessons as $lesson) {

                if ($lesson->status == 1) {
                    $allsubmited = false;

                }
            }

            if (!$allsubmited) {

                $this->addError('paid', 'Please Validate all Classes Before.');
                return;
            }




            foreach ($this->lessons as $lesson) {
                $lesson->timestamps = false;
                $lesson->payment_status = 2;
                $lesson->save();
            }

            $date = Carbon::createFromFormat('m-Y', $this->selectedMonth)->startOfMonth();


            Payment::create([
                'user_id' => $this->Selectedteacher,
                'amount' => $this->totalPayment,
                'hours' => $this->totalHours,
                'payment_date' => $date
            ]);

            DB::commit();

            $this->dispatch('showAlert', [
                'title' => "Classes assigned Paid Successfully",
                'text' => '',
                'icon' => 'success'
            ]);

            $this->reset(['Selectedteacher', 'totalPayment', 'lessons', 'totalHours']);

            $this->loadTeachers(Carbon::today()->format('m-Y'));
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
