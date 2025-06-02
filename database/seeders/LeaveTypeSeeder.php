<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Vacaciones',
                'max_days' => 14,
                'description' => 'Licencia anual por vacaciones',
                'is_active' => true,
            ],
            [
                'name' => 'Enfermedad',
                'max_days' => 30,
                'description' => 'Licencia por enfermedad con certificado médico',
                'is_active' => true,
            ],
            [
                'name' => 'Duelo',
                'max_days' => 3,
                'description' => 'Licencia por fallecimiento de familiar directo',
                'is_active' => true,
            ],
            [
                'name' => 'Matrimonio',
                'max_days' => 10,
                'description' => 'Licencia por matrimonio del empleado',
                'is_active' => true,
            ],
            [
                'name' => 'Nacimiento',
                'max_days' => 2,
                'description' => 'Licencia por nacimiento de hijo',
                'is_active' => true,
            ],
            [
                'name' => 'Examen',
                'max_days' => 1,
                'description' => 'Licencia para rendir examen',
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            LeaveType::firstOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
} 