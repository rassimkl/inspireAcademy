<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Status;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Add Class')]
class AddClass extends Main
{
    public $courseId;
    protected $listeners = [
        'deleteCourse' => 'deleteCourse',

    ];



    public function mount()
    {


    }



    public function render()
    {
        $today = Carbon::today();
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


        $query->whereIn('status_id', [1, 2]);

        // If the user is a teacher, filter courses by the teacher's ID
        $query->where('teacher_id', $user->id);


        $courses = $query->where(function ($query) use ($searchTerm) {
            $query->orWhereHas('teacher', function ($subQuery) use ($searchTerm) {
                $subQuery->whereRaw('lower(first_name) like ?', ['%' . $searchTerm . '%'])
                    ->orWhereRaw('lower(last_name) like ?', ['%' . $searchTerm . '%']);
            })->orWhere('name', 'like', '%' . $searchTerm . '%');
        })
            ->with(['latestClassDate']) // Eager load the latest class date relationship
            ->withCount([
                'classes as classes_ucount' => function ($subQuery) use ($today) {
                    $subQuery->where('status', 1)
                        ->where('date', '<', $today);
                }
            ])
            ->paginate($this->perPage);

        return view('livewire.add-class', ['courses' => $courses]);
    }
}