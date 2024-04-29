<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Generate random data for students
        $faker = \Faker\Factory::create();

        // 3. Create student records in the database
        for ($i = 0; $i < 10; $i++) { // Create 10 student records
            User::create([
                'user_type_id' => 2,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'gender' => $faker->randomElement(['male', 'female']),
                'date_of_birth' => $faker->date(),
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'phone_number' => $faker->phoneNumber,
                'blood_group' => $faker->randomElement(['A+', 'B+', 'O+', 'AB+', 'A-', 'B-', 'O-', 'AB-']),
                'address' => $faker->address,
                'city' => $faker->city,
                'zip_code' => $faker->postcode,
                'country' => $faker->country,
                'info' => $faker->text,
                'languages' => json_encode($faker->randomElements(['English', 'French', 'Spanish', 'German'], rand(1, 3))), // Convert array to JSON
                'profile_picture' => null,

            ]);
        }
    }
}