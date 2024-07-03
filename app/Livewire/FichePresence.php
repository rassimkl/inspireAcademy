<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Livewire\Main;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Title('Fiche')]
class FichePresence extends Main
{

    public $courses;
    public $course = "0";
    public $selectedMonth;
    public $selectedTeacher;
    public $teachers;

    public $user;

    protected $rules = [
        'course' => 'required|exists:courses,id',
        'selectedMonth' => 'required',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->selectedMonth = Carbon::today()->format('m-Y');

        $this->teachers = User::where('user_type_id', 2)->get();
        // Fetch paginated classes associated with the authenticated user
        $selectedMonth = $this->selectedMonth; // e.g., '05-2024'
        list($month, $year) = explode('-', $selectedMonth);

        // Convert to integers
        $month = (int) $month;
        $year = (int) $year;

        $this->courses = Course::where('teacher_id', $this->user->id)->whereHas('classes', function ($query) use ($month, $year) {
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        })->get();
    }

    public function downloadFiche()
    {

        $this->validate();





    }
    public function updatedSelectedMonth($value)
    {

        $selectedMonth = $value; // e.g., '05-2024'
        list($month, $year) = explode('-', $selectedMonth);

        // Convert to integers
        $month = (int) $month;
        $year = (int) $year;

        $this->courses = Course::where('teacher_id', $this->user->id)->whereHas('classes', function ($query) use ($month, $year) {
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        })->get();

        $this->course = "0";

    }
    public function render()
    {
        //dd($this->selectedMonth);


        $classesQuery = $this->user->classes()->with('course')->orderBy('date', 'desc');
        $classesQuery->where('course_id', $this->course);
        // Check the value of $status and apply appropriate filtering

        // Parse the selected month and year from the date string
        if ($this->selectedMonth) {
            list($month, $year) = explode('-', $this->selectedMonth);

            // Add condition to filter by selected month and year
            $classesQuery->whereYear('date', '=', $year)
                ->whereMonth('date', '=', $month);
        }

        $classes = $classesQuery->paginate($this->perPage);


        return view('livewire.fiche-presence', ['classes' => $classes]);
    }
}
