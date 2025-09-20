<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Si ya tiene compañía configurada, redirigir al dashboard
        if ($user->company_id && Company::find($user->company_id)->departments()->exists()) {
            return redirect()->route('dashboard');
        }

        // Obtener la empresa si existe
        $company = $user->company_id ? Company::find($user->company_id) : null;

        return view('onboarding.wizard', compact('company'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:100',
            'size' => 'nullable|string|in:1-10,11-50,51-200,201-500,500+',
            'timezone' => 'nullable|string|max:60',
            'currency' => 'nullable|string|size:3',
            'departments' => 'array',
            'departments.*' => 'string|max:100',
            'employee_name' => 'nullable|string|max:255',
            'employee_email' => 'nullable|email|max:255',
            'employee_position' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($request) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            Log::info('Onboarding start', ['user_id' => $user->id, 'company_id' => $user->company_id]);

            // Obtener o crear la compañía
            if ($user->company_id) {
                // Usuario ya tiene compañía, actualizarla
                $company = Company::find($user->company_id);
                Log::info('Updating existing company', ['company_id' => $company->id, 'old_name' => $company->name, 'new_name' => $request->company_name]);
                
                // Actualizar el slug solo si el nombre cambió
                $newSlug = Str::slug($request->company_name);
                if ($company->name !== $request->company_name) {
                    // Verificar que el nuevo slug sea único
                    $counter = 1;
                    $originalSlug = $newSlug;
                    while (Company::where('slug', $newSlug)->where('id', '!=', $company->id)->exists()) {
                        $newSlug = $originalSlug . '-' . $counter;
                        $counter++;
                    }
                }
                
                $company->update([
                    'name' => $request->company_name,
                    'slug' => $newSlug,
                    'industry' => $request->industry,
                    'size' => $request->size,
                    'timezone' => $request->timezone,
                    'currency' => $request->currency ? strtoupper($request->currency) : null,
                    'plan' => $this->determinePlan($request->size),
                ]);
            } else {
                // Crear nueva compañía (caso excepcional)
                Log::info('Creating new company', ['company_name' => $request->company_name]);
                $company = Company::create([
                    'name' => $request->company_name,
                    'slug' => Str::slug($request->company_name),
                    'plan' => $this->determinePlan($request->size),
                    'industry' => $request->industry,
                    'size' => $request->size,
                    'timezone' => $request->timezone,
                    'currency' => $request->currency ? strtoupper($request->currency) : null,
                ]);

                // Asignar al usuario
                $user->company_id = $company->id;
                $user->last_active_company_id = $company->id;
                // Persistir asociación de compañía al usuario
                $user->save();
            }

            // Crear departamentos seleccionados (solo si no existen)
            $departments = $request->departments ?? ['Administración'];
            foreach ($departments as $deptName) {
                Log::info('Processing department', ['department_name' => $deptName, 'company_id' => $company->id]);
                
                // Usar firstOrCreate para evitar duplicados
                $dept = Department::firstOrCreate(
                    [
                        'company_id' => $company->id,
                        'name' => $deptName,
                    ],
                    [
                        'code' => strtoupper(substr($deptName, 0, 3)),
                    ]
                );

                // Crear posición básica solo si no existe
                $positionCode = $dept->code . '_GEN';
                $position = Position::firstOrCreate(
                    [
                        'company_id' => $company->id,
                        'code' => $positionCode,
                    ],
                    [
                        'department_id' => $dept->id,
                        'title' => 'General',
                        'description' => 'Posición general del departamento',
                        'min_salary' => 2500,
                        'max_salary' => 8000,
                    ]
                );
                
                Log::info('Department and position processed', [
                    'department_id' => $dept->id,
                    'position_id' => $position->id,
                    'was_created' => $position->wasRecentlyCreated
                ]);
            }

            // Crear primer empleado si se proporcionó
            if ($request->employee_name) {
                $firstDept = $company->departments()->first();
                $firstPosition = $firstDept->positions()->first();

                if ($firstDept && $firstPosition) {
                    $names = explode(' ', $request->employee_name, 2);
                    \App\Models\Employee::create([
                        'company_id' => $company->id,
                        'department_id' => $firstDept->id,
                        'position_id' => $firstPosition->id,
                        'first_name' => $names[0],
                        'last_name' => $names[1] ?? '',
                        'email' => $request->employee_email ?: $request->employee_name . '@' . Str::slug($company->name) . '.local',
                        'file_number' => 'EMP001',
                        'hire_date' => now(),
                        'base_salary' => 3500,
                        'is_active' => true,
                        'dni' => '00000000',
                        'cuit' => '20-00000000-0',
                        'birth_date' => now()->subYears(30),
                        'address' => 'Dirección pendiente',
                        'phone' => 'Teléfono pendiente',
                        'employment_type' => 'full-time',
                        'work_schedule_from' => '09:00',
                        'work_schedule_to' => '18:00',
                    ]);
                }
            }
        });

        return redirect()->route('dashboard')->with('status', '¡Bienvenido! Tu empresa ha sido configurada exitosamente.');
    }

    private function determinePlan($size)
    {
        return match ($size) {
            '1-10' => 'starter',
            '11-50' => 'professional',
            '51-200' => 'professional',
            default => 'enterprise'
        };
    }
}