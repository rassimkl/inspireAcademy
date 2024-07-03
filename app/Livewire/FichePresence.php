<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;

class FichePresence extends Main
{

    public $courses;
    public $course;
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

        $this->courses = Course::whereHas('classes', function ($query) use ($month, $year) {
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        })->get();
    }

    public function downloadFiche()
    {

        $this->validate();

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

        $classes = $classesQuery->get();

        foreach ($classes as $class) {
            if ($class->status == 1) {
                $this->addError('course', 'Please Submit all classes');
                return; // Exit the method to prevent further execution
            }
        }

        $course = Course::findOrFail($this->course);
        $students = $course->students;

        // Load the view with the data
        $data = ['course' => $course, 'teacher' => $this->user, 'students' => $students, 'classes' => $classes, 'date' => $this->selectedMonth];


        $view = view('fiche.fiche', $data)->render();

        // Create a new DOMPDF instance
        $pdf = new Dompdf();
        $pdf->set_option('isHtml5ParserEnabled', true);
        $pdf->set_option('isRemoteEnabled', false); // Disable remote file fetching if not needed

        // Load HTML content into DOMPDF
        $pdf->loadHtml($view);

        // (Optional) Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (important to call this before outputting PDF content)
        $pdf->render();

        // Output PDF to the browser
        return $pdf->stream('fiche.pdf');

        //return view('invoice.invoice', $data);

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

        $this->course = 0;

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
