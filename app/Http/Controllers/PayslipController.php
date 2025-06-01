<?php

namespace App\Http\Controllers;

use App\Models\Payslip;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payslips = Payslip::with('employee')->paginate(10);
        return view('payslips.index', compact('payslips'));
    }

    /**
     * Display employee's payslips
     */
    public function employeeIndex()
    {
        $employee = Auth::user()->employee;
        $payslips = Payslip::where('employee_id', $employee->id)
            ->orderBy('payment_date', 'desc')
            ->paginate(10);
        return view('payslips.employee-index', compact('payslips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::orderBy('last_name')->get();
        return view('payslips.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payment_date' => 'required|date',
            'period_start' => 'required|date',
            'period_end' => 'required|date',
            'gross_salary' => 'required|numeric',
            'net_salary' => 'required|numeric',
            'payment_method' => 'required|string',
            'bank_account' => 'nullable|string',
            'concepts_json' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $concepts = json_decode($request->input('concepts_json'), true);
        if (!is_array($concepts)) {
            return back()->withErrors(['concepts_json' => 'El formato de conceptos no es válido.'])->withInput();
        }
        
        $allowances = array_filter($concepts, fn($c) => ($c['haberes'] ?? 0) > 0 || ($c['adicionales'] ?? 0) > 0);
        $deductions = array_filter($concepts, fn($c) => ($c['retenciones'] ?? 0) > 0);

        $payslip = Payslip::create([
            'employee_id' => $validated['employee_id'],
            'payment_date' => $validated['payment_date'],
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'gross_salary' => $validated['gross_salary'],
            'net_salary' => $validated['net_salary'],
            'payment_method' => $validated['payment_method'],
            'bank_account' => $validated['bank_account'],
            'allowances' => $allowances,
            'deductions' => $deductions,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('payslips.show', $payslip)
            ->with('success', 'Recibo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payslip $payslip)
    {
        return view('payslips.show', compact('payslip'));
    }

    /**
     * Display employee's payslip
     */
    public function employeeShow(Payslip $payslip)
    {
        if ($payslip->employee_id !== Auth::user()->employee->id) {
            abort(403);
        }
        return view('payslips.employee-show', compact('payslip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payslip $payslip)
    {
        return view('payslips.edit', compact('payslip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payslip $payslip)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payment_date' => 'required|date',
            'period_start' => 'required|date',
            'period_end' => 'required|date',
            'gross_salary' => 'required|numeric',
            'net_salary' => 'required|numeric',
            'payment_method' => 'required|string',
            'bank_account' => 'nullable|string',
            'concepts_json' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $concepts = json_decode($request->input('concepts_json'), true);
        if (!is_array($concepts)) {
            return back()->withErrors(['concepts_json' => 'El formato de conceptos no es válido.'])->withInput();
        }
        
        $allowances = array_filter($concepts, fn($c) => ($c['haberes'] ?? 0) > 0 || ($c['adicionales'] ?? 0) > 0);
        $deductions = array_filter($concepts, fn($c) => ($c['retenciones'] ?? 0) > 0);

        $payslip->update([
            'employee_id' => $validated['employee_id'],
            'payment_date' => $validated['payment_date'],
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'gross_salary' => $validated['gross_salary'],
            'net_salary' => $validated['net_salary'],
            'payment_method' => $validated['payment_method'],
            'bank_account' => $validated['bank_account'],
            'allowances' => $allowances,
            'deductions' => $deductions,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('payslips.index')
            ->with('success', 'Recibo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payslip $payslip)
    {
        $payslip->delete();

        return redirect()->route('payslips.index')
            ->with('success', 'Recibo eliminado exitosamente.');
    }

    /**
     * Download payslip as PDF
     */
    public function downloadPdf(Payslip $payslip)
    {
        $payslip->load('employee', 'employee.position');
        $pdf = Pdf::loadView('payslips.pdf', compact('payslip'))->setPaper('a4', 'landscape');
        $filename = 'Recibo_'.$payslip->employee->last_name.'_'.$payslip->employee->first_name.'_'.$payslip->period_start->format('Ym').'.pdf';
        return $pdf->download($filename);
    }

    /**
     * Download employee's payslip as PDF
     */
    public function employeeDownload(Payslip $payslip)
    {
        if ($payslip->employee_id !== Auth::user()->employee->id) {
            abort(403);
        }
        return $this->downloadPdf($payslip);
    }
}
