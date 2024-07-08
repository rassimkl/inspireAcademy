<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ClassSession;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Classes')]
class ClassList extends Main
{

    public $status;
    public $selectedMonth;
    public $selectedTeacher;
    public $teachers;
    public function mount()
    {
        $this->selectedMonth = Carbon::today()->format('m-Y');

        $this->teachers = User::where('user_type_id', 2)->orderBy('first_name', 'asc')->get();
        // Fetch paginated classes associated with the authenticated user





    }
    public function render()
    {
        //dd($this->selectedMonth);
        $user = Auth::user();
        if ($user->user_type_id == 1) {
            if ($this->selectedTeacher) {
                $userS = User::find($this->selectedTeacher);
                $classesQuery = $userS->classes()->with('course')->orderBy('date', 'desc');
            } else {
                $classesQuery = ClassSession::with('course')->orderBy('date', 'desc');
            }
        } elseif ($user->user_type_id == 2) {
            $classesQuery = $user->classes()->with('course')->orderBy('date', 'desc');
        }
        // Check the value of $status and apply appropriate filtering
        if ($this->status == 1) {
            $classesQuery->where('status', 1);
        } elseif ($this->status == 2) {
            $classesQuery->where('status', 2);
        }
        // Parse the selected month and year from the date string
        if ($this->selectedMonth) {
            list($month, $year) = explode('-', $this->selectedMonth);

            // Add condition to filter by selected month and year
            $classesQuery->whereYear('date', '=', $year)
                ->whereMonth('date', '=', $month);
        }

        $classes = $classesQuery->paginate($this->perPage);


        return view('livewire.class-list', ['classes' => $classes]);
    }
}
