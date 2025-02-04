<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory()->count(10)->create();

        User::create([
            'id' => '1',
            'username' => 'admin',
            'email' => 'hKk1t@example.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
        ]);
    }
}
