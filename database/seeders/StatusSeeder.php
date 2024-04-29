<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define status data with explicit IDs
        $statuses = [
            ['id' => 1, 'name' => 'Not Started'],
            ['id' => 2, 'name' => 'In Progress'],
            ['id' => 3, 'name' => 'Completed'],
            ['id' => 4, 'name' => 'Cancelled'],
            // Add more statuses as needed
        ];

        // Insert status data into the statuses table
        DB::table('statuses')->insert($statuses);
    }
}
