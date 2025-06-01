<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'position']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('file_number', 'like', "%{$search}%")
                  ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->input('department'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status'));
        }

        $employees = $query->paginate(10);
        $departments = \App\Models\Department::all();

        return view('employees.index', compact('employees', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();

        return view('employees.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_number' => 'required|string|max:255|unique:employees',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'required|string|max:255|unique:employees',
            'cuit' => 'required|string|max:255|unique:employees',
            'birth_date' => 'required|date',
            'birth_country' => 'required|string|max:255',
            'birth_province' => 'nullable|string|max:255',
            'birth_city' => 'nullable|string|max:255',
            'nationality' => 'required|string|max:255',
            'gender' => 'required|string|in:Masculino,Femenino,Sin género',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'hire_date' => 'required|date',
            'employment_type' => 'required|string|max:255',
            'work_schedule_from' => 'required|string|max:255',
            'work_schedule_to' => 'required|string|max:255',
            'social_security_number' => 'nullable|string',
            'health_insurance' => 'nullable|string',
            'union' => 'nullable|string',
            'base_salary' => 'required|numeric|min:0',
            'bank_account' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:25600',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'mother_name' => 'nullable|string',
            'father_name' => 'nullable|string',
            'spouse_name' => 'nullable|string',
            'children' => 'nullable|string',
            'cbu_attachment' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,webp,heic,heif,doc,docx',
        ]);

        // Crear usuario con contraseña temporal
        $user = \App\Models\User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt('password123'), // Contraseña temporal
            'force_password_change' => true, // Forzar cambio de contraseña al primer inicio de sesión
        ]);

        // Asignar rol de Employee al usuario
        $user->assignRole('Employee');

        // Crear empleado
        $employee = new Employee($validated);
        $employee->user_id = $user->id;

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $employee->profile_photo = $path;
        }

        Log::info('Request received for employee store', $request->all());
        if ($request->hasFile('cbu_attachment')) {
            Log::info('Archivo CBU recibido', ['file' => $request->file('cbu_attachment')]);
            $cbuPath = $request->file('cbu_attachment')->store('cbu-attachments', 'public');
            Log::info('Archivo CBU guardado en storage', ['path' => $cbuPath]);
            $employee->cbu_attachment = $cbuPath;
        } else {
            Log::info('NO se recibió archivo CBU');
        }

        $employee->save();

        return redirect()->route('employees.index')
            ->with('success', 'Empleado creado exitosamente. Credenciales temporales: Email: ' . $validated['email'] . ', Contraseña: password123');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load(['department', 'position', 'payslips', 'leaveRequests']);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();

        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'file_number' => 'required|string|unique:employees,file_number,' . $employee->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'required|string|unique:employees,dni,' . $employee->id,
            'cuit' => 'required|string|unique:employees,cuit,' . $employee->id,
            'birth_date' => 'required|date',
            'birth_country' => 'required|string|max:255',
            'birth_province' => 'nullable|string|max:255',
            'birth_city' => 'nullable|string|max:255',
            'nationality' => 'required|string|max:255',
            'gender' => 'required|string|in:Masculino,Femenino,Sin género',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'hire_date' => 'required|date',
            'employment_type' => 'required|string',
            'work_schedule_from' => 'required|string',
            'work_schedule_to' => 'required|string',
            'social_security_number' => 'nullable|string',
            'health_insurance' => 'nullable|string',
            'union' => 'nullable|string',
            'base_salary' => 'required|numeric|min:0',
            'bank_account' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:25600',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'mother_name' => 'nullable|string',
            'father_name' => 'nullable|string',
            'spouse_name' => 'nullable|string',
            'children' => 'nullable|string',
            'cbu_attachment' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,webp,heic,heif,doc,docx',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($employee->profile_photo) {
                Storage::disk('public')->delete($employee->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        if ($request->hasFile('cbu_attachment')) {
            if ($employee->cbu_attachment) {
                Storage::disk('public')->delete($employee->cbu_attachment);
            }
            $cbuPath = $request->file('cbu_attachment')->store('cbu-attachments', 'public');
            $validated['cbu_attachment'] = $cbuPath;
        }

        $employee->update($validated);

        // Asegurarnos de que la sesión se guarde antes de la redirección
        session()->flash('success', 'Empleado actualizado exitosamente.');
        
        return redirect()->route('employees.show', $employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->profile_photo) {
            Storage::disk('public')->delete($employee->profile_photo);
        }

        if ($employee->cbu_attachment) {
            Storage::disk('public')->delete($employee->cbu_attachment);
        }

        $employee->delete();

        // Asegurarnos de que la sesión se guarde antes de la redirección
        session()->flash('success', 'Empleado eliminado exitosamente.');
        
        return redirect()->route('employees.index');
    }

    /**
     * Show the form for terminating (inactivating) an employee.
     */
    public function bajaForm(Employee $employee)
    {
        return view('employees.baja', compact('employee'));
    }

    /**
     * Process the termination (baja) of an employee.
     */
    public function baja(Request $request, Employee $employee)
    {
        $request->validate([
            'termination_date' => 'required|date',
            'termination_reason' => 'nullable|string|max:255',
        ]);
        $employee->is_active = false;
        $employee->termination_date = $request->termination_date;
        $employee->termination_reason = $request->termination_reason;
        $employee->save();
        return redirect()->route('employees.show', $employee)->with('success', 'Empleado dado de baja correctamente.');
    }

    public function downloadPdf($id)
    {
        $employee = Employee::with(['department', 'position'])->findOrFail($id);
        $pdf = Pdf::loadView('employees.pdf', compact('employee'));
        $filename = 'Ficha_Empleado_' . $employee->dni . '.pdf';
        return $pdf->download($filename);
    }
}
