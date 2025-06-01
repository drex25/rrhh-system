<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Payslip;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Admin') || $user->hasRole('HR')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('Manager')) {
            return $this->managerDashboard();
        } else {
            return $this->employeeDashboard();
        }
    }

    private function adminDashboard()
    {
        // Obtener conteos totales
        $totalEmployees = Employee::count();
        $totalPayslips = Payslip::count();
        $totalLeaveRequests = LeaveRequest::where('status', 'pending')->count();
        $totalDepartments = Department::count();

        // Obtener empleados por departamento
        $employeesByDepartment = Department::withCount('employees')
            ->get()
            ->map(function ($department) {
                return [
                    'name' => $department->name,
                    'count' => $department->employees_count
                ];
            });

        // Obtener licencias por mes
        $leaveRequestsByMonth = LeaveRequest::select(
            DB::raw('MONTH(start_date) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('start_date', date('Y'))
        ->groupBy('month')
        ->get()
        ->map(function ($item) {
            return [
                'month' => date('F', mktime(0, 0, 0, $item->month, 1)),
                'count' => $item->count
            ];
        });

        return view('dashboard.admin', compact(
            'totalEmployees',
            'totalPayslips',
            'totalLeaveRequests',
            'totalDepartments',
            'employeesByDepartment',
            'leaveRequestsByMonth'
        ));
    }

    private function managerDashboard()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            // Si el usuario no tiene un empleado asociado, mostrar un mensaje de error
            return view('dashboard.manager', [
                'error' => 'No tienes un perfil de empleado asociado. Por favor, contacta al administrador.',
                'departmentEmployees' => 0,
                'pendingLeaveRequests' => 0,
                'leaveRequestsByMonth' => collect(),
                'department' => null
            ]);
        }

        $department = $employee->department;

        if (!$department) {
            // Si el empleado no tiene un departamento asignado, mostrar un mensaje de error
            return view('dashboard.manager', [
                'error' => 'No tienes un departamento asignado. Por favor, contacta al administrador.',
                'departmentEmployees' => 0,
                'pendingLeaveRequests' => 0,
                'leaveRequestsByMonth' => collect(),
                'department' => null
            ]);
        }

        // Obtener empleados del departamento
        $departmentEmployees = Employee::where('department_id', $department->id)->count();
        
        // Obtener licencias pendientes del departamento
        $pendingLeaveRequests = LeaveRequest::whereHas('employee', function($query) use ($department) {
            $query->where('department_id', $department->id);
        })->where('status', 'pending')->count();

        // Obtener licencias por mes del departamento
        $leaveRequestsByMonth = LeaveRequest::whereHas('employee', function($query) use ($department) {
            $query->where('department_id', $department->id);
        })
        ->select(
            DB::raw('MONTH(start_date) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('start_date', date('Y'))
        ->groupBy('month')
        ->get()
        ->map(function ($item) {
            return [
                'month' => date('F', mktime(0, 0, 0, $item->month, 1)),
                'count' => $item->count
            ];
        });

        return view('dashboard.manager', compact(
            'departmentEmployees',
            'pendingLeaveRequests',
            'leaveRequestsByMonth',
            'department'
        ));
    }

    private function employeeDashboard()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            // Si el usuario no tiene un empleado asociado, mostrar un mensaje de error
            return view('dashboard.employee', [
                'error' => 'No tienes un perfil de empleado asociado. Por favor, contacta al administrador.',
                'payslips' => collect(),
                'leaveRequests' => collect(),
                'leaveBalance' => null,
                'employee' => null
            ]);
        }

        // Obtener recibos del empleado
        $payslips = Payslip::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Obtener licencias del empleado
        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Obtener saldo de licencias
        $leaveBalance = $employee->leaveBalance;

        return view('dashboard.employee', compact(
            'payslips',
            'leaveRequests',
            'leaveBalance',
            'employee'
        ));
    }
} 