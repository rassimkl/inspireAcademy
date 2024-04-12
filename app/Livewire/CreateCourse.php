<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\UserType;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;


#[Title('Create Course')]

class CreateCourse extends Component
{
    public $course_type = 1;
    public $name;
    public $info;
    public $totalHours;
    public $teachers;
    public $students;
    public $selectedStudents;
    public $teacher;
    public $chargePerHour = 10;
    public $userType;


    public function rules()
    {
        return [
            'name' => 'required',
            'course_type' => [
                'required',
                Rule::in([1, 2]),
            ],
            'totalHours' => 'required|numeric',
            'chargePerHour' => 'required|numeric',
            'teacher' => 'required|exists:users,id',
            'selectedStudents' => ['required', 'array'],

        ];
    }

    public function mount()
    {
        $userType = UserType::where('name', 'Teacher')->firstOrFail()->id;
        $this->teachers = User::where('user_type_id', $userType)->get();
        $userType = UserType::where('name', 'Student')->firstOrFail()->id;
        $this->students = User::where('user_type_id', $userType)->get();

    }

    public function createCourse()
    {

        $this->validate();

        foreach ($this->selectedStudents as $userId) {
            $user = User::find($userId);
            if (!$user || $user->user_type_id !== 3) {
                $this->addError('selectedStudents', 'One or more selected users are not students.');
                return;
            }
        }

        $user = User::find($this->teacher);
        if (!$user || $user->user_type_id !== 2) {
            $this->addError('teacher', 'please selecta teacher');
            return;
        }


        $course = Course::create([
            'teacher_id' => $this->teacher,
            'name' => $this->name,
            'info' => $this->info,
            'total_hours' => $this->totalHours,
            'charge_per_hour' => $this->chargePerHour,
            'course_type' => $this->course_type
        ]);
        // Attach students to the course
        $course->students()->attach($this->selectedStudents);


        $this->reset(['name', 'info', 'totalHours', 'teacher', 'chargePerHour']);
        $this->dispatch('showAlert', [
            'title' => "Course Created Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);
        $this->dispatch('resetSelect2');
    }

    public function render()
    {
        return view('livewire.create-course');
    }
}
