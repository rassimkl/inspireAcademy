<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{

    public function addClass(User $user, Course $course)
    {

        if ($user->user_type_id == 1) {
            return true;
        } elseif ($course->teacher_id == $user->id) {
            return true;
        } else {
            return false;
        }


    }

    public function addCourse(User $user, Course $course)
    {

        if ($user->user_type_id == 1) {
            return true;
        }
        return false;



    }

    public function addfiletoCourse(User $user, Course $course)
    {

        if ($course->teacher->id == $user->id) {
            return true;
        }
        return false;



    }

}
