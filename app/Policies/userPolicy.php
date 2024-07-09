<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserType;

class userPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewTeacher(User $user, UserType $usert)
    {
        return $user->user_type_id === 2; // Assuming user_type_id 1 represents admins
    }

    public function viewAdmin(User $user, UserType $usert)
    {
        return $user->user_type_id === 1; // Assuming user_type_id 1 represents admins
    }

    public function viewStudent(User $user, UserType $usert)
    {
        return $user->user_type_id === 1; // Assuming user_type_id 1 represents admins
    }

    public function deleteUser(User $user, User $userToDelete)
    {
        // Only admins (user_type_id 1) can delete users
        return $user->user_type_id == 1;
    }

    
}
