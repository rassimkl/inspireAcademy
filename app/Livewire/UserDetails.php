<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('User')]
class UserDetails extends Component
{

    public $user;
    public $courses;

    public $classesCount;
    public function mount(User $user)
    {
        if (!$user) {

            return back();
        }

        $this->user = $user;
        if ($user->user_type_id == 3) {
            $this->courses = $user->coursesAsStudent()
                ->withCount([
                    'classes' => function ($query) {
                        $query->where('status', '=', '2');
                    }
                ])
                ->get();
        } elseif ($user->user_type_id == 2) {

            $this->courses = $user->coursesAsTeacher()
                ->withCount([
                    'classes' => function ($query) {
                        $query->where('status', '=', '2');
                    }
                ])->withSum(['classes' => function ($query) {
                    $query->where('status', 2);
                }], 'hours')
                ->get();
        } elseif ($user->user_type_id == 4) {

            $this->courses = $user->coursesAsStudent()
            ->withCount([
                'classes' => function ($query) {
                    $query->where('status', '=', '2');
                }
            ])->withSum(['classes' => function ($query) {
                $query->where('status', 2);
            }], 'hours')
            ->get();
        }
     


        
        $classesCount = 0;
        foreach ($this->courses as $course) {


            $classesCount += $course->classes_count;

        }
        $this->classesCount = $classesCount;
    }
    public function render()
    {
        return view('livewire.user-details');
    }
}
