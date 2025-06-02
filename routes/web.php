<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\EmployeeLeaveBalanceController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AcademicHistoryController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas por roles
Route::middleware(['auth', 'verified'])->group(function () {
    // Rutas para Admin y HR
    Route::middleware(['role:Admin|HR'])->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('leave-types', LeaveTypeController::class);
        Route::get('/employee-leave-balances', [EmployeeLeaveBalanceController::class, 'index'])->name('employee-leave-balances.index');
        Route::get('/employee-leave-balances/create', [EmployeeLeaveBalanceController::class, 'create'])->name('employee-leave-balances.create');
        Route::post('/employee-leave-balances', [EmployeeLeaveBalanceController::class, 'store'])->name('employee-leave-balances.store');
        Route::get('/employee-leave-balances/{employeeLeaveBalance}/edit', [EmployeeLeaveBalanceController::class, 'edit'])->name('employee-leave-balances.edit');
        Route::put('/employee-leave-balances/{employeeLeaveBalance}', [EmployeeLeaveBalanceController::class, 'update'])->name('employee-leave-balances.update');
        Route::delete('/employee-leave-balances/{employeeLeaveBalance}', [EmployeeLeaveBalanceController::class, 'destroy'])->name('employee-leave-balances.destroy');
        
        // Rutas de administración de recibos (Admin y HR)
        Route::resource('payslips', PayslipController::class);
        Route::get('/payslips/{payslip}/download-pdf', [PayslipController::class, 'downloadPdf'])->name('payslips.downloadPdf');
    });

    // Rutas para cambio de contraseña forzado
    Route::middleware(['auth'])->group(function () {
        Route::get('/password/change', [PasswordChangeController::class, 'showChangeForm'])->name('password.change');
        Route::post('/password/change', [PasswordChangeController::class, 'change']);
    });

    // Rutas para empleados (acceso a sus propios recibos)
    Route::middleware(['role:Employee'])->group(function () {
        Route::get('/my-payslips', [PayslipController::class, 'employeeIndex'])->name('employee.payslips.index');
        Route::get('/my-payslips/{payslip}', [PayslipController::class, 'employeeShow'])->name('employee.payslips.show');
        Route::get('/my-payslips/{payslip}/download', [PayslipController::class, 'employeeDownload'])->name('employee.payslips.download');
    });

    // Rutas para Admin, HR, Manager y Employee
    Route::middleware(['role:Admin|HR|Manager|Employee'])->group(function () {
        Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
        Route::get('/leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
        Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
        Route::delete('/leave-requests/{leaveRequest}', [LeaveRequestController::class, 'destroy'])->name('leave-requests.destroy');
        
        // Rutas para aprobar/rechazar solicitudes (solo Admin y HR)
        Route::middleware(['role:Admin|HR'])->group(function () {
            Route::patch('/leave-requests/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('leave-requests.approve');
            Route::patch('/leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');
        });
    });

    // Rutas de perfil (accesibles para todos los usuarios autenticados)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para mostrar el formulario de baja y procesar la baja de empleados
    Route::get('employees/{employee}/baja', [\App\Http\Controllers\EmployeeController::class, 'bajaForm'])->name('employees.bajaForm');
    Route::post('employees/{employee}/baja', [\App\Http\Controllers\EmployeeController::class, 'baja'])->name('employees.baja');

    // Document Management
    Route::resource('documents', DocumentController::class);
    
    // Academic History
    Route::resource('academic-history', AcademicHistoryController::class);
    
    // Attendance
    Route::resource('attendance', AttendanceController::class);
    Route::resource('overtime', OvertimeController::class);
    
    // Recruitment
    Route::resource('job-postings', JobPostingController::class);
    Route::resource('candidates', CandidateController::class);
    
    // Development
    Route::resource('training', TrainingController::class);
    Route::resource('performance', PerformanceController::class);
    
    // Reports
    Route::resource('reports', ReportController::class);
    Route::resource('analytics', AnalyticsController::class);
});

Route::get('/api/countries', [LocationController::class, 'getCountries']);
Route::get('/api/provinces', [LocationController::class, 'getProvinces']);
Route::get('/api/cities', [LocationController::class, 'getCities']);

Route::get('/employees/{id}/pdf', [App\Http\Controllers\EmployeeController::class, 'downloadPdf'])->name('employees.downloadPdf')->middleware('auth');

require __DIR__.'/auth.php';
