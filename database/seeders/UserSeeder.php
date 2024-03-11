<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            'email' => 'example@gmail.com',
            'password' => Hash::make('password'),
            'user_type_id' => 1,
            'first_name' => "admin",
            'last_name' => 'family name',
            'gender' => 'male'
            // Add other columns as needed
        ]);
    }
}
