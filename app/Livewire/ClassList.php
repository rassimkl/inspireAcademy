<?php

namespace App\Livewire;

use App\Models\ClassSession;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Classes')]
class ClassList extends Main
{

    public $status;

    public function mount()
    {



        // Fetch paginated classes associated with the authenticated user

    }
    public function render()
    {
        $user = Auth::user();
        if ($user->user_type_id == 1) {
            $classesQuery = ClassSession::with('course')->orderBy('date', 'desc');
        } else {
            $classesQuery = $user->classes()->with('course')->orderBy('date', 'desc');
        }
        // Check the value of $status and apply appropriate filtering
        if ($this->status == 1) {
            $classesQuery->where('status', 1);
        } elseif ($this->status == 2) {
            $classesQuery->where('status', 2);
        }

        $classes = $classesQuery->paginate($this->perPage);


        return view('livewire.class-list', ['classes' => $classes]);
    }
}
