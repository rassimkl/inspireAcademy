<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\UserType;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;

#[Title('Edit Course')]
class EditCourse extends Component
{
    public $course;
    public $course_type;
    public $name;
    public $info;
    public $totalHours;
    public $teachers;
    public $students;
    public $selectedStudents;
    public $teacher;
    public $chargePerHour;
    public $userType;

    public $doneHours;
    public $pendingHours;

    public function rules()
    {
        return [
            'name' => 'required',
            'course_type' => [
                'required',
                Rule::in([1, 2]),
            ],
            'totalHours' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'chargePerHour' => 'required|numeric',
            'teacher' => 'required|exists:users,id',
            'selectedStudents' => ['required', 'array'],

        ];
    }

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->authorize('addCourse', $this->course);
        if ($course->status_id == 3) {

            return back();
        }
        $this->course_type = $course->course_type;
        $this->name = $course->name;
        $this->info = $course->info;
        $this->totalHours = $course->total_hours;
        $this->teacher = $course->teacher_id;
        $this->chargePerHour = $course->charge_per_hour;

        $this->students = User::where('user_type_id', UserType::where('name', 'Student')->firstOrFail()->id)->orderBy('first_name', 'asc')->get();
        $this->teachers = User::where('user_type_id', UserType::where('name', 'Teacher')->firstOrFail()->id)->orderBy('first_name', 'asc')->get();

       


        $this->selectedStudents = $course->students->pluck('id')->toArray();
        $this->teacher = $course->teacher->id;

        $this->doneHours = $this->course->classes->where('status', 2)->sum('hours');
        $this->pendingHours = $this->course->classes->where('status', 1)->sum('hours');


    }


    public function updateCourse()
    {
        $this->validate();

        if ($this->totalHours < ($this->doneHours + $this->pendingHours)) {
            $this->addError('totalHours', 'Cant be less than the Pending Hours + Done Hours. Please submit or cancel pending classes');
            return;
        }

    
        $this->course->update([
            'name' => $this->name,
            'info' => $this->info,
            'total_hours' => $this->totalHours,
            'charge_per_hour' => $this->chargePerHour,
            'teacher_id' => $this->teacher,
            'course_type' => $this->course_type,
        ]);

        // Sync students with the course
        $this->course->students()->sync($this->selectedStudents);

        $this->dispatch('showAlert', [
            'title' => "Course Updated Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);


    }

    public function render()
    {
        return view('livewire.edit-course');
    }
}
