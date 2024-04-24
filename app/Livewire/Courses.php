<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Status;
use Livewire\Attributes\Title;

#[Title('Courses')]
class Courses extends Main
{

    public $courseStatuses;
    public $status = 0;

    public function mount()
    {
        $this->courseStatuses = Status::all();
    }
    public function render()
    {
        $searchTerm = mb_strtolower($this->search);
        $user = auth()->user();

        $query = Course::query()
            ->with('teacher', 'students')->latest()
            ->withSum([
                'classes' => function ($query) {
                    $query->where('status', 2);
                }
            ], 'hours')
            ->withCount('students');

        if ($this->status != 0) {
            $query->where('status_id', $this->status);
        }

        if ($user->user_type_id != 1) {
            // If the user is a teacher, filter courses by the teacher's ID
            $query->where('teacher_id', $user->id);
        }

        $courses = $query->where(function ($query) use ($searchTerm) {
            $query->orWhereHas('teacher', function ($subQuery) use ($searchTerm) {
                $subQuery->whereRaw('lower(first_name) like ?', ['%' . $searchTerm . '%'])
                    ->orWhereRaw('lower(last_name) like ?', ['%' . $searchTerm . '%']);
            })->orWhere('name', 'like', '%' . $searchTerm . '%');
        })
            ->paginate($this->perPage);


        return view('livewire.courses', ['courses' => $courses]);
    }
}
