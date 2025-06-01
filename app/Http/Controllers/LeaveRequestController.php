<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\EmployeeLeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->hasRole(['Admin', 'HR'])) {
            $query = LeaveRequest::with(['employee.user', 'leaveType']);
            
            // Aplicar filtros
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('employee_id')) {
                $query->where('employee_id', $request->employee_id);
            }
            if ($request->filled('leave_type_id')) {
                $query->where('leave_type_id', $request->leave_type_id);
            }
            
            $leaveRequests = $query->latest()->paginate(10);
            $employees = Employee::with('user')->get();
            $leaveTypes = LeaveType::where('is_active', true)->get();
            
            return view('leave-requests.admin-index', compact('leaveRequests', 'employees', 'leaveTypes'));
        } else {
            $employee = $user->employee;
            
            if (!$employee) {
                return redirect()->route('dashboard')
                    ->with('error', 'No tienes un perfil de empleado asociado. Por favor, contacta al administrador.');
            }

            $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
                ->with('leaveType')
                ->latest()
                ->get();
            $leaveBalances = EmployeeLeaveBalance::where('employee_id', $employee->id)
                ->where('year', date('Y'))
                ->with('leaveType')
                ->get();
            
            return view('leave-requests.employee-index', compact('leaveRequests', 'leaveBalances'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes un perfil de empleado asociado. Por favor, contacta al administrador.');
        }

        $leaveTypes = LeaveType::where('is_active', true)->get();
        return view('leave-requests.create', compact('leaveTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes un perfil de empleado asociado. Por favor, contacta al administrador.');
        }

        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $total_days = $startDate->diffInDays($endDate) + 1;

        // Verificar saldo disponible
        $balance = EmployeeLeaveBalance::where('employee_id', $employee->id)
            ->where('leave_type_id', $request->leave_type_id)
            ->where('year', date('Y'))
            ->first();

        if (!$balance || $balance->remaining_days < $total_days) {
            return back()->with('error', 'No tienes suficientes días disponibles para este tipo de licencia.');
        }

        $leaveRequest = LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $total_days,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leave-requests.index')
            ->with('success', 'Solicitud de licencia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        $leaveRequest->load(['employee', 'leaveType', 'approver']);
        return view('leave-requests.show', compact('leaveRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        $employees = Employee::where('is_active', true)->orderBy('last_name')->get();
        $leaveTypes = LeaveType::where('is_active', true)->get();
        return view('leave-requests.edit', compact('leaveRequest', 'employees', 'leaveTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);

        $oldStatus = $leaveRequest->status;
        $newStatus = $request->status;

        // Si se está aprobando la solicitud
        if ($newStatus === 'approved' && $oldStatus === 'pending') {
            // Verificar saldo disponible
            $employee = $leaveRequest->employee;
            $year = Carbon::parse($leaveRequest->start_date)->year;
            $balance = $employee->getLeaveBalance($leaveRequest->leave_type_id, $year);

            if (!$balance) {
                return back()->with('error', 'No hay saldo configurado para este tipo de licencia.');
            }

            if ($balance->remaining_days < $leaveRequest->total_days) {
                return back()->with('error', 'No hay suficientes días disponibles. Saldo restante: ' . $balance->remaining_days . ' días.');
            }

            // Actualizar saldo
            $balance->addUsedDays($leaveRequest->total_days);
        }
        // Si se está rechazando una solicitud aprobada
        else if ($newStatus === 'rejected' && $oldStatus === 'approved') {
            // Restaurar saldo
            $employee = $leaveRequest->employee;
            $year = Carbon::parse($leaveRequest->start_date)->year;
            $balance = $employee->getLeaveBalance($leaveRequest->leave_type_id, $year);
            
            if ($balance) {
                $balance->removeUsedDays($leaveRequest->total_days);
            }
        }

        $leaveRequest->update([
            'status' => $newStatus,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('leave-requests.index')
            ->with('success', 'Solicitud de licencia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Solo se pueden cancelar solicitudes pendientes.');
        }

        $leaveRequest->delete();
        return back()->with('success', 'Solicitud cancelada exitosamente.');
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update(['status' => 'approved']);
        
        // Actualizar saldo de licencia
        $balance = EmployeeLeaveBalance::where('employee_id', $leaveRequest->employee_id)
            ->where('leave_type_id', $leaveRequest->leave_type_id)
            ->where('year', date('Y'))
            ->first();
            
        if ($balance) {
            $balance->used_days += $leaveRequest->total_days;
            $balance->remaining_days = $balance->total_days - $balance->used_days;
            $balance->save();
        }

        return back()->with('success', 'Solicitud aprobada exitosamente.');
    }

    public function reject(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update(['status' => 'rejected']);
        return back()->with('success', 'Solicitud rechazada exitosamente.');
    }
}
