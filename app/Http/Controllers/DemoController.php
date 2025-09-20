<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DemoController extends Controller
{
    public function login(Request $request)
    {
        abort_unless(config('demo.enabled'), 404);

        $email = config('demo.user_email');
        $companyName = config('demo.company_name');

        $company = Company::firstOrCreate(['name' => $companyName], [
            'slug' => Str::slug($companyName),
            'plan' => config('demo.plan'),
        ]);

        $user = User::firstOrCreate(['email' => $email], [
            'name' => 'Sarah Johnson',
            'password' => bcrypt('password'),
        ]);
        if (!$user->company_id) {
            $user->company_id = $company->id;
        }
        if (!$user->last_active_company_id) {
            $user->last_active_company_id = $company->id;
        }
        $user->save();

        // Poblar datos demo básicos si no existen
        $this->ensureDemoData($company);

        // Asegurar que Sarah Johnson tenga perfil de empleado
        $this->ensureDemoUserEmployee($company, $user);

        Auth::login($user, false);

        return redirect()->route('dashboard')->with('status','You are in the live demo');
    }

    private function ensureDemoData(Company $company)
    {
        // Crear departamentos demo si no existen para esta compañía
        $departments = [
            ['name' => 'Recursos Humanos', 'code' => 'RH'],
            ['name' => 'Desarrollo', 'code' => 'DEV'],
            ['name' => 'Ventas', 'code' => 'VNT'],
            ['name' => 'Marketing', 'code' => 'MKT'],
        ];

        foreach ($departments as $deptData) {
            $dept = Department::firstOrCreate([
                'company_id' => $company->id,
                'code' => $deptData['code']
            ], [
                'name' => $deptData['name'],
            ]);

            // Crear posición básica si no existe
            Position::firstOrCreate([
                'company_id' => $company->id,
                'department_id' => $dept->id,
                'code' => $deptData['code'] . '_MGR'
            ], [
                'title' => 'Manager',
                'description' => 'Department Manager',
                'min_salary' => 4000,
                'max_salary' => 6000,
            ]);
        }

        // Crear algunos empleados demo si no existen
        $employees = [
            ['name' => 'John Smith', 'email' => 'john.smith@techflow.demo', 'dept_code' => 'DEV'],
            ['name' => 'Maria Garcia', 'email' => 'maria.garcia@techflow.demo', 'dept_code' => 'RH'],
            ['name' => 'Robert Wilson', 'email' => 'robert.wilson@techflow.demo', 'dept_code' => 'VNT'],
        ];

        foreach ($employees as $empData) {
            $dept = Department::where('company_id', $company->id)->where('code', $empData['dept_code'])->first();
            $position = Position::where('company_id', $company->id)->where('department_id', $dept->id)->first();
            
            if ($dept && $position) {
                // Crear usuario para el empleado demo si no existe
                $empUser = User::firstOrCreate([
                    'email' => $empData['email']
                ], [
                    'name' => $empData['name'],
                    'password' => bcrypt('password'),
                    'company_id' => $company->id,
                    'last_active_company_id' => $company->id,
                ]);

                Employee::firstOrCreate([
                    'company_id' => $company->id,
                    'email' => $empData['email']
                ], [
                    'user_id' => $empUser->id,
                    'first_name' => explode(' ', $empData['name'])[0],
                    'last_name' => explode(' ', $empData['name'])[1],
                    'file_number' => 'DEMO' . str_pad(Employee::where('company_id', $company->id)->count() + 1, 3, '0', STR_PAD_LEFT),
                    'department_id' => $dept->id,
                    'position_id' => $position->id,
                    'hire_date' => now()->subDays(rand(30, 365)),
                    'base_salary' => rand(3000, 5000),
                    'is_active' => true,
                    'dni' => '12345' . rand(100, 999),
                    'cuit' => '20-12345' . rand(100, 999) . '-' . rand(1, 9),
                    'birth_date' => now()->subYears(rand(25, 45))->format('Y-m-d'),
                    'address' => 'Demo Address ' . rand(100, 999),
                    'phone' => '555-0' . rand(100, 199),
                    'employment_type' => 'full-time',
                    'work_schedule_from' => '09:00',
                    'work_schedule_to' => '18:00',
                ]);
            }
        }
    }

    private function ensureDemoUserEmployee(Company $company, User $user)
    {
        // Verificar si Sarah Johnson ya tiene perfil de empleado
        $existingEmployee = Employee::where('company_id', $company->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$existingEmployee) {
            // Crear departamento RH si no existe
            $hrDept = Department::where('company_id', $company->id)
                ->where('code', 'RH')
                ->first();

            if ($hrDept) {
                // Crear posición de CEO/Admin si no existe
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

                // Crear perfil de empleado para Sarah Johnson
                Employee::create([
                    'company_id' => $company->id,
                    'user_id' => $user->id,
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
    }
}
