<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\UserType;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Teachers')]
class Teachers extends Main
{

    protected $listeners = [
        'deleteTeacher' => 'deleteTeacher',

    ];
    public $userId;


    public function deleteTeacher()
    {
        try {
            $userToDelete = User::findOrFail($this->userId);
            $this->authorize('deleteUser', $userToDelete->userType);

            if ($userToDelete->coursesAsTeacher()->count() > 0) {
                $this->dispatch('showAlert', [
                    'title' => "Cannot delete Teacher",
                    'text' => 'This teacher has courses in the system',
                    'icon' => 'error'
                ]);
                return;
            }

            $userToDelete->delete();

            $this->dispatch('showAlert', [
                'title' => "Teacher Deleted",
                'text' => 'The teacher has been successfully deleted',
                'icon' => 'success'
            ]);

            $this->userId = null;
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'title' => "Error",
                'text' => 'Failed to delete teacher: ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }



    public function confirmDelete($userId)
    {
        $this->userId = $userId;
        $this->dispatch('confirmTask', 'Are you sure you want to Delete This Teacher?', 'deleteTeacher');

    }

    public function render()
    {
        // Retrieve the user type with the name "Student"
        $userType = UserType::where('name', 'Teacher')->firstOrFail()->id;


        $this->teachers = User::where('user_type_id', $userType)
            ->where(function ($query) {
                $searchTerm = mb_strtolower($this->search); // Convert search term to lowercase
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchTerm . '%')
                    ->orWhereRaw("LOWER(languages) LIKE '%$searchTerm%'"); // Convert column data to lowercase
            })
            ->paginate($this->perPage);


        return view('livewire.teachers', ['teachers' => $this->teachers]);
    }
}
