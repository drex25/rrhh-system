<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        if (!config('demo.enabled')) {
            return; // No correr si demo apagado
        }

        $company = Company::firstOrCreate([
            'name' => config('demo.company_name'),
        ], [
            'slug' => Str::slug(config('demo.company_name')),
            'plan' => config('demo.plan'),
        ]);

        $user = User::firstOrCreate([
            'email' => config('demo.user_email'),
        ], [
            'name' => 'Sarah Johnson',
            'password' => Hash::make('password'),
        ]);

        if (!$user->company_id) {
            $user->company_id = $company->id;
        }
        // Comentar temporalmente hasta que se arreglen las migraciones
        // if (!$user->last_active_company_id) {
        //     $user->last_active_company_id = $company->id;
        // }
        $user->save();

        // Crear departamento RH si no existe
        $hrDept = Department::firstOrCreate([
            'company_id' => $company->id,
            'code' => 'RH'
        ], [
            'name' => 'Recursos Humanos',
        ]);

        // Crear posición CEO si no existe
        $ceoPosition = Position::firstOrCreate([
            'company_id' => $company->id,
            'department_id' => $hrDept->id,
            'code' => 'CEO'
        ], [
            'title' => 'Chief Executive Officer',
            'description' => 'Company CEO and Administrator',
            'min_salary' => 8000,
            'max_salary' => 12000,
        ]);

        // Crear perfil de empleado para Sarah Johnson si no existe
        Employee::firstOrCreate([
            'company_id' => $company->id,
            'user_id' => $user->id,
        ], [
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'email' => $user->email,
            'file_number' => 'CEO001',
            'department_id' => $hrDept->id,
            'position_id' => $ceoPosition->id,
            'hire_date' => now()->subYears(2),
            'base_salary' => 10000,
            'is_active' => true,
            'dni' => '12345000',
            'cuit' => '27-12345000-3',
            'birth_date' => now()->subYears(35)->format('Y-m-d'),
            'address' => 'Demo HQ Address 1',
            'phone' => '555-0100',
            'employment_type' => 'full-time',
            'work_schedule_from' => '09:00',
            'work_schedule_to' => '18:00',
        ]);
    }
}
