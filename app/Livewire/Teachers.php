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
