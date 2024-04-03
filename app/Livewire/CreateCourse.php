<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\UserType;
use Livewire\Attributes\Title;

#[Title('Create Course')]

class CreateCourse extends Component
{
    public $name;
    public $info;
    public $totalHours;
    public $teachers;
    public $teacher;
    public $chargePerHour;
    public $userType;

    public function rules()
    {
        return [
            'name' => 'required',
            'info' => 'required',
            'totalHours' => 'required|numeric',
            'chargePerHour' => 'required|numeric',
            'teacher' => 'required|exists:users,id',
        ];
    }

    public function mount()
    {
        $this->userType = UserType::where('name', 'Teacher')->firstOrFail()->id;
        $this->teachers = User::where('user_type_id', $this->userType)->get();
    }

    public function createCourse()
    {
        $this->validate();

        Course::create([
            'teacher_id' => $this->teacher,
            'name' => $this->name,
            'info' => $this->info,
            'total_hours' => $this->totalHours,
            'charge_per_hour' => $this->chargePerHour,
        ]);


        $this->reset(['name', 'info', 'totalHours', 'teacher', 'chargePerHour']);
        $this->dispatch('showAlert', [
            'title' => "Course Created Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.create-course');
    }
}
