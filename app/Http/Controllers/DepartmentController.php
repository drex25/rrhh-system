<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with('manager')
            ->latest()
            ->paginate(10);
            
        $employees = Employee::where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('departments.index', compact('departments', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('is_active', true)->get();
        return view('departments.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:departments',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:employees,id',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $department = Department::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Departamento creado exitosamente.',
                'department' => $department
            ]);
        }

        return redirect()->route('departments.show', $department)
            ->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load(['manager', 'employees', 'positions']);
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $employees = Employee::where('is_active', true)->get();
        return view('departments.edit', compact('department', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:employees,id',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $department->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Departamento actualizado exitosamente.',
                'department' => $department
            ]);
        }

        return redirect()->route('departments.show', $department)
            ->with('success', 'Departamento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if ($department->employees()->exists()) {
            return back()->with('error', 'No se puede eliminar un departamento que tiene empleados asociados.');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Departamento eliminado exitosamente.');
    }
}
