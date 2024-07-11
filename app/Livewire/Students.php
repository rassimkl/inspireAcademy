<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\UserType;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Students')]
class Students extends Main
{

    protected $listeners = [
        'deleteStudent' => 'deleteStudent',

    ];
    public $userId;

    public function deleteStudent()
    {
        try {
            $userToDelete = User::findOrFail($this->userId);
            $this->authorize('deleteUser', $userToDelete->userType);

            if ($userToDelete->coursesAsStudent()->count() > 0) {
                $this->dispatch('showAlert', [
                    'title' => "Cannot delete Student",
                    'text' => 'This Student has courses in the system',
                    'icon' => 'error'
                ]);
                return;
            }

            $userToDelete->delete();

            $this->dispatch('showAlert', [
                'title' => "Student Deleted",
                'text' => 'The Student has been successfully deleted',
                'icon' => 'success'
            ]);

            $this->userId = null;
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'title' => "Error",
                'text' => 'Failed to delete Student',
                'icon' => 'error'
            ]);
        }
    }

    public function confirmDelete($userId)
    {
        $this->userId = $userId;
        $this->dispatch('confirmTask', 'Are you sure you want to Delete This Student?', 'deleteStudent');

    }

    public function render()
    {
        // Retrieve the user type with the name "Student"
        $userType = UserType::where('name', 'Student')->firstOrFail();
        // Retrieve the users associated with the "Student" user type
        // Retrieve the users associated with the "Student" user type
        // $this->students = $userType->users()->paginate($this->perPage);

        $students = User::where('user_type_id', 3)
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

        return view('livewire.students', ['students' => $students]);
    }
}
