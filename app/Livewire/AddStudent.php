<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class AddStudent extends Component
{
    public $first_name = "gogo";
    public $last_name;
    public $gender;
    public $date_of_birth;
    public $email;
    public $password;
    public $phone_number;
    public $blood_group;
    public $address;
    public $city;
    public $zip_code;
    public $country;
    public $info;
    public $languages;
    public $profile_picture;

    protected $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'gender' => 'required|in:Male,Female',
        'date_of_birth' => 'required|date',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'phone_number' => 'required|string',
        'blood_group' => 'nullable|string',
        'address' => 'nullable|string',
        'city' => 'nullable|string',
        'zip_code' => 'nullable|string',
        'country' => 'nullable|string',
        'info' => 'nullable|string',
        'languages' => 'nullable|string',
        'profile_picture' => 'nullable|string',
    ];

    public function createStudent()
    {
        $validatedData = $this->validate(); // Validate input data based on defined rules
        dd($validatedData);
        // Hash the password before storing it in the database
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create a new student record
        User::create($validatedData);

        // Optionally, you can reset the input fields after creating the student
        $this->reset();


    }


    public function render()
    {
        return view('livewire.add-student');
    }
}
