<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\UserType;
use Livewire\Attributes\Title;

#[Title('Admins')]
class AdminList extends Main
{

    protected $listeners = [
        'deleteAdmin' => 'deleteAdmin',

    ];
    public $userId;

    public function deleteAdmin()
    {
        try {
            $userToDelete = User::findOrFail($this->userId);
            $this->authorize('deleteUser', $userToDelete->userType);

            if (User::where('user_type_id', 1)->count() == 1) {
                $this->dispatch('showAlert', [
                    'title' => "Cannot delete Admin",
                    'text' => 'This is the only admin in the system',
                    'icon' => 'error'
                ]);
                return;
            }


            $userToDelete->delete();

            $this->dispatch('showAlert', [
                'title' => "Student Deleted",
                'text' => 'The Admin has been successfully deleted',
                'icon' => 'success'
            ]);

            $this->userId = null;
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'title' => "Error",
                'text' => 'Failed to delete Admin',
                'icon' => 'error'
            ]);
        }
    }

    public function confirmDelete($userId)
    {
        $this->userId = $userId;
        $this->dispatch('confirmTask', 'Are you sure you want to Delete This Admin?', 'deleteAdmin');

    }

    public function render()
    {

        // Retrieve the user type with the name "Student"
        $userType = UserType::where('name', 'Admin')->firstOrFail();
        // Retrieve the users associated with the "Student" user type
        // Retrieve the users associated with the "Student" user type
        // $this->students = $userType->users()->paginate($this->perPage);

        $admins = User::where('user_type_id', 1)
            ->where(function ($query) {
                $searchTerm = mb_strtolower($this->search); // Convert search term to lowercase
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchTerm . '%')
                    ->orWhereRaw("LOWER(languages) LIKE '%$searchTerm%'"); // Convert column data to lowercase
            })
            ->withCount('coursesAsStudent as ccount') // Eager load count of courses
            ->paginate($this->perPage);

        return view('livewire.admin-list', ['admins' => $admins]);
    }
}
