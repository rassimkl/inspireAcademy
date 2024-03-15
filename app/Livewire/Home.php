<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserType;
use Livewire\Attributes\Title;

#[Title('Home')]
class Home extends Component
{
    public $studentCount;
    public $teacherCount;
    public function render()
    {
        $this->studentCount = UserType::where('name', 'Student')->firstOrFail()->users()->count();
        $this->teacherCount = UserType::where('name', 'Teacher')->firstOrFail()->users()->count();

        return view('livewire.dashboard.home');
    }
}
