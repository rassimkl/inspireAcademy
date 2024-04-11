<?php

namespace App\Livewire;

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
        $classesQuery = $user->classes()->with('course');

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
