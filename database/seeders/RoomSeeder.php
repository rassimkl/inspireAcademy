<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create(['id' => 1, 'name' => 'Room 1']);
        Room::create(['id' => 2, 'name' => 'Room 2']);
        Room::create(['id' => 102, 'name' => 'Online']);
        Room::create(['id' => 101, 'name' => 'Outside']);
    }
}
