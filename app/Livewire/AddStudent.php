<?php

namespace App\Livewire;

use Livewire\Component;

class AddStudent extends Component
{
    public $first_name;
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
        'gender' => 'required|in:male,female',
        'date_of_birth' => 'nullable|date',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'phone_number' => 'nullable|string',
        'blood_group' => 'nullable|string',
        'address' => 'nullable|string',
        'city' => 'nullable|string',
        'zip_code' => 'nullable|string',
        'country' => 'nullable|string',
        'info' => 'nullable|string',
        'languages' => 'nullable|string',
        'profile_picture' => 'nullable|string',
    ];
    public function render()
    {
        return view('livewire.add-student');
    }
}
