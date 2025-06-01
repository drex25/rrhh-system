<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\EmployeeLeaveBalance;
use Illuminate\Http\Request;

class EmployeeLeaveBalanceController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->get();
        $leaveTypes = LeaveType::where('is_active', true)->get();
        $balances = EmployeeLeaveBalance::with(['employee.user', 'leaveType'])
            ->where('year', request('year', date('Y')))
            ->get();

        return view('employee-leave-balances.index', compact('employees', 'leaveTypes', 'balances'));
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        $leaveTypes = LeaveType::where('is_active', true)->get();
        return view('employee-leave-balances.create', compact('employees', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'total_days' => 'required|integer|min:0',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        // Verificar si ya existe un saldo para este empleado, tipo de licencia y año
        $existingBalance = EmployeeLeaveBalance::where('employee_id', $request->employee_id)
            ->where('leave_type_id', $request->leave_type_id)
            ->where('year', $request->year)
            ->first();

        if ($existingBalance) {
            return back()->with('error', 'Ya existe un saldo configurado para este empleado, tipo de licencia y año.');
        }

        EmployeeLeaveBalance::create([
            'employee_id' => $request->employee_id,
            'leave_type_id' => $request->leave_type_id,
            'total_days' => $request->total_days,
            'used_days' => 0,
            'remaining_days' => $request->total_days,
            'year' => $request->year,
        ]);

        return redirect()->route('employee-leave-balances.index')
            ->with('success', 'Saldo de licencia creado exitosamente.');
    }

    public function edit(EmployeeLeaveBalance $employeeLeaveBalance)
    {
        $employees = Employee::with('user')->get();
        $leaveTypes = LeaveType::where('is_active', true)->get();
        return view('employee-leave-balances.edit', compact('employeeLeaveBalance', 'employees', 'leaveTypes'));
    }

    public function update(Request $request, EmployeeLeaveBalance $employeeLeaveBalance)
    {
        $request->validate([
            'total_days' => 'required|integer|min:' . $employeeLeaveBalance->used_days,
        ]);

        $difference = $request->total_days - $employeeLeaveBalance->total_days;
        
        $employeeLeaveBalance->update([
            'total_days' => $request->total_days,
            'remaining_days' => $employeeLeaveBalance->remaining_days + $difference,
        ]);

        return redirect()->route('employee-leave-balances.index')
            ->with('success', 'Saldo de licencia actualizado exitosamente.');
    }

    public function destroy(EmployeeLeaveBalance $employeeLeaveBalance)
    {
        if ($employeeLeaveBalance->used_days > 0) {
            return back()->with('error', 'No se puede eliminar un saldo que ya tiene días utilizados.');
        }

        $employeeLeaveBalance->delete();
        return back()->with('success', 'Saldo de licencia eliminado exitosamente.');
    }
} 