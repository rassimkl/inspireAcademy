<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserType;
use Livewire\Attributes\Title;

#[Title('Interns')]
class Interns extends Main
{


    public function render()
    {
        // Retrieve the user type with the name "Student"
        $userType = UserType::where('name', 'Intern')->firstOrFail()->id;

        $this->interns = User::where('user_type_id', $userType)
            ->where(function ($query) {
                $searchTerm = mb_strtolower($this->search); // Convert search term to lowercase
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchTerm . '%')
                    ->orWhereRaw("LOWER(languages) LIKE '%$searchTerm%'"); // Convert column data to lowercase
            })
            ->paginate($this->perPage);



        return view('livewire.interns', ['interns' => $this->interns]);
    }
}
