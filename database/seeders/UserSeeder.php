<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'example@gmail.com',
            'password' => Hash::make('password'),
            'user_type_id' => 1,
            'first_name' => "admin",
            'last_name' => 'family name',
            'gender' => 'male',
            'languages' => json_encode(['English']), // Convert array to JSON string            
        ]);
    }
}
