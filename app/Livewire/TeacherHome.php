<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class TeacherHome extends Component
{
    public $teacher;
    public $totalStudents;
    public $totalClasses;
    public $courses;
    public function mount()
    {


        $this->teacher = User::with(['coursesAsTeacher.students', 'coursesAsTeacher.classes'])->find(auth()->id());


        $this->totalStudents = $this->teacher->coursesAsTeacher->flatMap->students->unique()->count();
        $this->totalClasses = $this->teacher->coursesAsTeacher->flatMap->classes->unique()->count();



        $this->courses = $this->teacher->coursesAsTeacher()
            ->whereIn('status_id', [1, 2])
            ->withSum('classes', 'hours')
            ->get();

    }
    public function render()
    {
        return view('livewire.teacher-home');
    }
}
