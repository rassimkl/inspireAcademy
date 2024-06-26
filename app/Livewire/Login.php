<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    public $remember = true;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            $user = Auth::user();
            // Log out other devices
            Auth::logoutOtherDevices($this->password);
            // Regenerate session to ensure it's up-to-date
            session()->regenerate();
            // Redirect based on user type
            if ($user->user_type_id === 1) {
                return redirect()->route('home');
            } elseif ($user->user_type_id === 2) {
                return redirect()->route('teacher/home');
            } elseif ($user->user_type_id === 3) {
                return redirect()->route('student/home');
            }
        }
        $this->addError('email', 'These credentials do not match our records.');

    }
    #[Layout('components.layouts.Log')]
    public function render()
    {
        return view('livewire.login');
    }
}
