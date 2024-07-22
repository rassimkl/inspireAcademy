<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Status;
use Livewire\Attributes\Title;

#[Title('Courses')]
class Courses extends Main
{
    public $courseId;
    protected $listeners = [
        'deleteCourse' => 'deleteCourse',

    ];

    public $courseStatuses;
    public $status = 0;

    public $teachers;

    public $Selectedteacher;

    public function mount()
    {

        $this->courseStatuses = Status::all();

        if (auth()->user()->user_type_id == 1) {
            $this->teachers = User::where('user_type_id', 2)->orderBy('first_name', 'asc')->get();
        }
    }

    public function confirmDelete($courseId)
    {
        $this->courseId = $courseId;
        $this->dispatch('confirmTask', 'Are you sure you want to Delete Course', 'deleteCourse');

    }
    public function deleteCourse()
    {

        $course = Course::findOrFail($this->courseId);
        $this->authorize('addCourse', $course);
        // Check if the status is 1
        if ($course->status_id !== 1) {

            return;
        }

        // Detach students from the course
        $course->students()->detach();

        // Delete the course
        $course->delete();

        $this->dispatch('showAlert', [
            'title' => "Course Deleted Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);
        $this->reset(['courseId']);

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

        if ($this->status != 0) {
            $query->where('status_id', $this->status);
        }
        if ($this->Selectedteacher != 0 && $user->user_type_id == 1) {

            $query->where('teacher_id', $this->Selectedteacher);
        }

        if ($user->user_type_id == 2) {
            // If the user is a teacher, filter courses by the teacher's ID
            $query->where('teacher_id', $user->id);
        } elseif ($user->user_type_id == 3) {
            $query->whereHas('students', function ($subQuery) use ($user) {
                $subQuery->where('student_id', $user->id);
            });
        }

        $courses = $query->where(function ($query) use ($searchTerm) {
            $query->orWhereHas('teacher', function ($subQuery) use ($searchTerm) {
                $subQuery->whereRaw('lower(first_name) like ?', ['%' . $searchTerm . '%'])
                    ->orWhereRaw('lower(last_name) like ?', ['%' . $searchTerm . '%']);
            })->orWhere('name', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('students', function ($subQuery) use ($searchTerm) {
                    $subQuery->whereRaw('lower(first_name) like ?', ['%' . $searchTerm . '%'])
                        ->orWhereRaw('lower(last_name) like ?', ['%' . $searchTerm . '%']);
                });
        })
            ->with(['latestClassDate'])
            ->withCount([
                'classes as classes_ucount' => function ($subQuery) use ($today) {
                    $subQuery->where('status', 1)
                        ->where('date', '<', $today);
                }
            ]) // Eager load the latest class date relationship
            ->paginate($this->perPage);

        return view('livewire.courses', ['courses' => $courses]);
    }
}
