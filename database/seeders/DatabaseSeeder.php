<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatusSeeder::class,
            UserTypeSeeder::class,
            UserSeeder::class,
            InternsTableSeeder::class,
            StudentSeeder::class,
            TeachersTableSeeder::class,
            RoomSeeder::class
        ]);
    }
}
