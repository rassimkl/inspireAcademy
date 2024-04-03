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
        $courses = Course::with('teacher', 'students')
            ->where(function ($query) {
                $searchTerm = mb_strtolower($this->search);
                $query->whereHas('teacher', function ($subQuery) use ($searchTerm) {
                    $subQuery->whereRaw('lower(first_name) like ?', ['%' . $searchTerm . '%'])
                        ->orWhereRaw('lower(last_name) like ?', ['%' . $searchTerm . '%']);
                });
            })->orWhere('name', 'like', '%' . $searchTerm . '%')
            ->withCount('students')
            ->paginate($this->perPage);

        return view('livewire.courses', ['courses' => $courses]);
    }
}
