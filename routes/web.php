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
use App\Http\Controllers\PublicJobPostingController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Root landing (principal)
// (Si se desea redirigir a vacantes se puede hacer condicional después)

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Onboarding para nuevos usuarios
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/onboarding', [App\Http\Controllers\OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('/onboarding', [App\Http\Controllers\OnboardingController::class, 'store'])->name('onboarding.store');
});

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
            // Companies overview page (admin/HR roles typical)
            Route::get('/admin/companies', function(){
                return view('admin.companies');
            })->name('admin.companies');
            
        // Settings routes (only for Admin)
        Route::middleware(['role:Admin'])->group(function () {
            Route::get('/settings/company', [SettingsController::class, 'company'])->name('settings.company');
            Route::put('/settings/company', [SettingsController::class, 'updateCompany'])->name('settings.company.update');
            Route::delete('/settings/company/logo', [SettingsController::class, 'removeLogo'])->name('settings.company.remove-logo');
        });
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

    // Rutas de Reclutamiento
    Route::get('/job-postings', [JobPostingController::class, 'index'])->name('job-postings.index');
    Route::get('/job-postings/create', [JobPostingController::class, 'create'])->name('job-postings.create');
    Route::post('/job-postings', [JobPostingController::class, 'store'])->name('job-postings.store');
    Route::get('/job-postings/{jobPosting}', [JobPostingController::class, 'show'])->name('job-postings.show');
    Route::get('/job-postings/{jobPosting}/edit', [JobPostingController::class, 'edit'])->name('job-postings.edit');
    Route::put('/job-postings/{jobPosting}', [JobPostingController::class, 'update'])->name('job-postings.update');
    Route::delete('/job-postings/{jobPosting}', [JobPostingController::class, 'destroy'])->name('job-postings.destroy');
    Route::post('/job-postings/{jobPosting}/toggle-status', [JobPostingController::class, 'toggleStatus'])->name('job-postings.toggle-status');
    Route::post('/job-postings/{jobPosting}/toggle-featured', [JobPostingController::class, 'toggleFeatured'])->name('job-postings.toggle-featured');

    // Rutas de Candidatos
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::get('/candidates/create', [CandidateController::class, 'create'])->name('candidates.create');
    Route::post('/candidates', [CandidateController::class, 'store'])->name('candidates.store');
    Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
    Route::get('/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
    Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('candidates.update');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
    Route::get('/candidates/{candidate}/resume', [CandidateController::class, 'downloadResume'])->name('candidates.download-resume');
    Route::put('/candidates/{candidate}/status', [CandidateController::class, 'updateStatus'])->name('candidates.update-status');
    Route::put('/candidates/{candidate}/notes', [CandidateController::class, 'updateNotes'])->name('candidates.update-notes');

    // Rutas para entrevistas
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/interviews', [InterviewController::class, 'index'])->name('interviews.index');
        Route::get('/interviews/create', [InterviewController::class, 'create'])->name('interviews.create');
        Route::get('/candidates/{candidate}/interviews/create', [InterviewController::class, 'createFromCandidate'])->name('interviews.create-from-candidate');
        Route::post('/interviews', [InterviewController::class, 'store'])->name('interviews.store');
        Route::get('/interviews/{interview}', [InterviewController::class, 'show'])->name('interviews.show');
        Route::get('/interviews/{interview}/edit', [InterviewController::class, 'edit'])->name('interviews.edit');
        Route::put('/interviews/{interview}', [InterviewController::class, 'update'])->name('interviews.update');
        Route::delete('/interviews/{interview}', [InterviewController::class, 'destroy'])->name('interviews.destroy');
        Route::post('/interviews/{interview}/complete', [InterviewController::class, 'complete'])->name('interviews.complete');
        Route::post('/interviews/{interview}/cancel', [InterviewController::class, 'cancel'])->name('interviews.cancel');
        Route::post('/interviews/{interview}/reschedule', [InterviewController::class, 'reschedule'])->name('interviews.reschedule');
    });
});



Route::get('/employees/{id}/pdf', [App\Http\Controllers\EmployeeController::class, 'downloadPdf'])->name('employees.downloadPdf')->middleware('auth');

// Rutas públicas para vacantes
Route::get('/vacantes', [PublicJobPostingController::class, 'index'])->name('public.job-postings.index');
Route::get('/vacantes/{jobPosting}', [PublicJobPostingController::class, 'show'])->name('public.job-postings.show');
Route::post('/vacantes/{jobPosting}/apply', [PublicJobPostingController::class, 'apply'])->name('public.job-postings.apply');

// Billing / Pricing
use App\Http\Controllers\BillingController; // appended import inline (PHP allows after other code though style-wise could move up)
Route::get('/pricing', [BillingController::class,'pricing'])->name('pricing');
Route::middleware(['auth','verified'])->group(function(){
    Route::post('/billing/subscribe', [BillingController::class,'subscribe'])->name('billing.subscribe');
    Route::post('/billing/cancel', [BillingController::class,'cancel'])->name('billing.cancel');
});

// Landing Page Routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
// Ruta demo auto-login
Route::get('/demo', [DemoController::class, 'login'])->name('demo.login');
// Rutas de signup para nuevas empresas
Route::get('/signup', [SignupController::class, 'show'])->name('signup.show');
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
Route::post('/contact', [LandingPageController::class, 'store'])->name('landing.store');

require __DIR__.'/auth.php';
