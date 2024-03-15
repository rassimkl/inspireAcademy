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

    public function render()
    {
        // Retrieve the user type with the name "Student"
        $userType = UserType::where('name', 'Student')->firstOrFail();
        // Retrieve the users associated with the "Student" user type
        // Retrieve the users associated with the "Student" user type
        // $this->students = $userType->users()->paginate($this->perPage);

        $this->students = User::where('user_type_id', 3)
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('phone_number', 'like', '%' . $this->search . '%')
                    ->orWhere('languages', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.students', ['students' => $this->students]);
    }
}
