<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['name' => 'Admin'],
            ['name' => 'Teacher'],
            ['name' => 'Student'],
            ['name' => 'Intern'],
        ];

        foreach ($userTypes as $userType) {
            UserType::create($userType);
        }
    }
}
