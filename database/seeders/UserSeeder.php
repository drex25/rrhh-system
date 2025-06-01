<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@company.com',
            'password' => Hash::make('password'),
        ])->assignRole('Admin');

        // Crear usuario HR
        User::create([
            'name' => 'HR',
            'email' => 'hr@company.com',
            'password' => Hash::make('password'),
        ])->assignRole('HR');

        // Crear usuario Manager
        User::create([
            'name' => 'Manager',
            'email' => 'manager@company.com',
            'password' => Hash::make('password'),
        ])->assignRole('Manager');

        // Crear usuario Employee
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@company.com',
            'password' => Hash::make('password'),
        ])->assignRole('Employee');
    }
} 