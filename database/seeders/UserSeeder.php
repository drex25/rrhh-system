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
        User::firstOrCreate(
            ['email' => 'admin@company.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        )->assignRole('Admin');

        // Crear usuario HR
        User::firstOrCreate(
            ['email' => 'hr@company.com'],
            [
                'name' => 'HR',
                'password' => Hash::make('password'),
            ]
        )->assignRole('HR');

        // Crear usuario Manager
        User::firstOrCreate(
            ['email' => 'manager@company.com'],
            [
                'name' => 'Manager',
                'password' => Hash::make('password'),
            ]
        )->assignRole('Manager');

        // Crear usuario Employee
        User::firstOrCreate(
            ['email' => 'john.doe@company.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
            ]
        )->assignRole('Employee');
    }
} 