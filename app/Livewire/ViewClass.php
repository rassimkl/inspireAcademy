<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClassSession;
use Livewire\Attributes\Title;

#[Title('Class')]
class ViewClass extends Component
{
    public $classSession;
    public $hoursGiven;
    public function mount($classId)
    {
        // Fetch class data from the database based on $classId
        $this->classSession = ClassSession::find($classId);
        $this->hoursGiven = $this->classSession->course->classes->where('status', 2)->sum('hours');
    }
    public function render()
    {
        return view('livewire.view-class');
    }
}
