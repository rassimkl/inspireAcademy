<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\UserType;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination;
    protected $students;
    public $perPage = 10;
    public $search;

    public function clearSearch()
    {
        $this->search = '';
    }

    public function updatedSearch()
    {
        if ($this->search == '') {
            $this->refresh();
        }
    }
    public function render()
    {
        // Retrieve the user type with the name "Student"
        $userType = UserType::where('name', 'Student')->firstOrFail();
        // Retrieve the users associated with the "Student" user type
        // Retrieve the users associated with the "Student" user type
        // $this->students = $userType->users()->paginate($this->perPage);

        $this->students = User::where('user_type_id', 3)
            ->where(function ($query) {
                $searchTerm = mb_strtolower($this->search); // Convert search term to lowercase
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchTerm . '%')
                    ->orWhereRaw("LOWER(languages) LIKE '%$searchTerm%'"); // Convert column data to lowercase
            })
            ->paginate($this->perPage);

        return view('livewire.students', ['students' => $this->students]);
    }
}
