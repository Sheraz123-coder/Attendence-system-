<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Student User',
            'email' => 'student@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'student',
        ]);
    }
}
