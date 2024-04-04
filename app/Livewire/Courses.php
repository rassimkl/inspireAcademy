<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Courses')]
class Courses extends Main
{

    public function render()
    {
        $searchTerm = mb_strtolower($this->search);
        $user = auth()->user();

        $query = Course::query()
            ->with('teacher', 'students')
            ->withCount('students');

        if ($user->user_type_id == 2) {
            // If the user is a teacher, filter courses by the teacher's ID
            $query->where('teacher_id', $user->id);
        } else {
            // If the user is not a teacher, show all courses
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
