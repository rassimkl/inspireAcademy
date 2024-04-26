<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Course')]
class CourseDetails extends Component
{

    public $course;
    public $classCount;
    public $hoursGiven;
    public $hoursRemainig;



    public function mount(Course $course)
    {
        $this->authorize('addClass', $this->course);

        if (!$course) {

            return back();
        }

        $this->authorize('addClass', $this->course);


        $this->classCount = $course->classes->where('status', 2)->count();
        $this->hoursGiven = $course->classes->where('status', 2)->sum('hours');

    }
    public function render()
    {
        return view('livewire.course-details');
    }
}
