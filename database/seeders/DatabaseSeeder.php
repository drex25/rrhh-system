<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            LeaveTypeSeeder::class,
        ]);

        // Obtener roles existentes
        $adminRole = Role::where('name', 'Admin')->first();
        $hrRole = Role::where('name', 'HR')->first();
        $managerRole = Role::where('name', 'Manager')->first();
        $employeeRole = Role::where('name', 'Employee')->first();

        // Crear departamentos de ejemplo
        $departments = [
            'Recursos Humanos' => Department::firstOrCreate(
                ['code' => 'RH'],
                [
                    'name' => 'Recursos Humanos',
                    'code' => 'RH'
                ]
            ),
            'Desarrollo' => Department::firstOrCreate(
                ['code' => 'DEV'],
                [
                    'name' => 'Desarrollo',
                    'code' => 'DEV'
                ]
            ),
            'Ventas' => Department::firstOrCreate(
                ['code' => 'VTS'],
                [
                    'name' => 'Ventas',
                    'code' => 'VTS'
                ]
            ),
            'Marketing' => Department::firstOrCreate(
                ['code' => 'MKT'],
                [
                    'name' => 'Marketing',
                    'code' => 'MKT'
                ]
            )
        ];

        // Crear posiciones de ejemplo
        $positions = [
            'Director' => Position::firstOrCreate(
                ['code' => 'DIR'],
                [
                    'title' => 'Director',
                    'code' => 'DIR',
                    'department_id' => $departments['Recursos Humanos']->id,
                    'description' => 'Director del departamento',
                    'min_salary' => 5000,
                    'max_salary' => 8000
                ]
            ),
            'Gerente' => Position::firstOrCreate(
                ['code' => 'GER'],
                [
                    'title' => 'Gerente',
                    'code' => 'GER',
                    'department_id' => $departments['Desarrollo']->id,
                    'description' => 'Gerente de departamento',
                    'min_salary' => 4000,
                    'max_salary' => 6000
                ]
            ),
            'Desarrollador Senior' => Position::firstOrCreate(
                ['code' => 'DSR'],
                [
                    'title' => 'Desarrollador Senior',
                    'code' => 'DSR',
                    'department_id' => $departments['Desarrollo']->id,
                    'description' => 'Desarrollador con experiencia avanzada',
                    'min_salary' => 3500,
                    'max_salary' => 5000
                ]
            ),
            'Desarrollador Junior' => Position::firstOrCreate(
                ['code' => 'DJR'],
                [
                    'title' => 'Desarrollador Junior',
                    'code' => 'DJR',
                    'department_id' => $departments['Desarrollo']->id,
                    'description' => 'Desarrollador en formación',
                    'min_salary' => 2500,
                    'max_salary' => 3500
                ]
            ),
            'Analista de RRHH' => Position::firstOrCreate(
                ['code' => 'ARR'],
                [
                    'title' => 'Analista de RRHH',
                    'code' => 'ARR',
                    'department_id' => $departments['Recursos Humanos']->id,
                    'description' => 'Analista de Recursos Humanos',
                    'min_salary' => 3000,
                    'max_salary' => 4500
                ]
            ),
            'Vendedor' => Position::firstOrCreate(
                ['code' => 'VND'],
                [
                    'title' => 'Vendedor',
                    'code' => 'VND',
                    'department_id' => $departments['Ventas']->id,
                    'description' => 'Vendedor del departamento de ventas',
                    'min_salary' => 2000,
                    'max_salary' => 3000
                ]
            )
        ];

        // Crear usuario Admin
        $admin = User::firstOrCreate([
            'email' => 'admin@company.com',
        ], [
            'name' => 'Admin Demo',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);
        
        // Crear perfil de empleado para Admin
        Employee::firstOrCreate(
            ['file_number' => 'EMP001'],
            [
                'user_id' => $admin->id,
                'department_id' => $departments['Recursos Humanos']->id,
                'position_id' => $positions['Director']->id,
                'hire_date' => now(),
                'base_salary' => 5000,
                'is_active' => true,
                'file_number' => 'EMP001',
                'first_name' => 'Admin',
                'last_name' => 'Demo',
                'dni' => '12345678',
                'cuit' => '20-12345678-9',
                'birth_date' => '1990-01-01',
                'address' => 'Calle Principal 123',
                'phone' => '1234567890',
                'email' => 'admin@company.com',
                'employment_type' => 'full-time',
                'work_schedule_from' => '09:00',
                'work_schedule_to' => '18:00'
            ]
        );

        // Crear usuario HR
        $hr = User::firstOrCreate([
            'email' => 'hr@company.com',
        ], [
            'name' => 'HR Demo',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $hr->assignRole($hrRole);
        
        // Crear perfil de empleado para HR
        Employee::firstOrCreate(
            ['file_number' => 'EMP002'],
            [
                'user_id' => $hr->id,
                'department_id' => $departments['Recursos Humanos']->id,
                'position_id' => $positions['Analista de RRHH']->id,
                'hire_date' => now(),
                'base_salary' => 4000,
                'is_active' => true,
                'file_number' => 'EMP002',
                'first_name' => 'HR',
                'last_name' => 'Demo',
                'dni' => '23456789',
                'cuit' => '20-23456789-0',
                'birth_date' => '1991-01-01',
                'address' => 'Calle Principal 124',
                'phone' => '2345678901',
                'email' => 'hr@company.com',
                'employment_type' => 'full-time',
                'work_schedule_from' => '09:00',
                'work_schedule_to' => '18:00'
            ]
        );

        // Crear usuario Manager
        $manager = User::firstOrCreate([
            'email' => 'manager@company.com',
        ], [
            'name' => 'Manager Demo',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $manager->assignRole($managerRole);
        
        // Crear perfil de empleado para Manager
        Employee::firstOrCreate(
            ['file_number' => 'EMP003'],
            [
                'user_id' => $manager->id,
                'department_id' => $departments['Desarrollo']->id,
                'position_id' => $positions['Gerente']->id,
                'hire_date' => now(),
                'base_salary' => 4500,
                'is_active' => true,
                'file_number' => 'EMP003',
                'first_name' => 'Manager',
                'last_name' => 'Demo',
                'dni' => '34567890',
                'cuit' => '20-34567890-1',
                'birth_date' => '1992-01-01',
                'address' => 'Calle Principal 125',
                'phone' => '3456789012',
                'email' => 'manager@company.com',
                'employment_type' => 'full-time',
                'work_schedule_from' => '09:00',
                'work_schedule_to' => '18:00'
            ]
        );

        // Crear usuario Employee
        $employee = User::firstOrCreate([
            'email' => 'employee@company.com',
        ], [
            'name' => 'Employee Demo',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $employee->assignRole($employeeRole);
        
        // Crear perfil de empleado para Employee
        Employee::firstOrCreate(
            ['file_number' => 'EMP004'],
            [
                'user_id' => $employee->id,
                'department_id' => $departments['Desarrollo']->id,
                'position_id' => $positions['Desarrollador Junior']->id,
                'hire_date' => now(),
                'base_salary' => 3000,
                'is_active' => true,
                'file_number' => 'EMP004',
                'first_name' => 'Employee',
                'last_name' => 'Demo',
                'dni' => '45678901',
                'cuit' => '20-45678901-2',
                'birth_date' => '1993-01-01',
                'address' => 'Calle Principal 126',
                'phone' => '4567890123',
                'email' => 'employee@company.com',
                'employment_type' => 'full-time',
                'work_schedule_from' => '09:00',
                'work_schedule_to' => '18:00'
            ]
        );
    }
}
