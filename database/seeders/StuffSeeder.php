<?php

namespace Database\Seeders;

use App\Models\Stuff;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StuffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stuff::factory()->count(10)->create();
    }
}
