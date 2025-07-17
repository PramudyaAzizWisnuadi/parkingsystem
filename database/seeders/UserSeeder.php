<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin Parkir',
            'email' => 'admin@parkir.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Petugas user
        User::create([
            'name' => 'Petugas Parkir',
            'email' => 'petugas@parkir.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'email_verified_at' => now(),
        ]);
    }
}
