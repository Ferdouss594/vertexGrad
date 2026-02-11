<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Manager\UserApproveController;
use App\Http\Controllers\Manager\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Frontend\Auth\AuthController as FrontendAuth;
use App\Http\Controllers\Frontend\ProjectSubmissionController;
/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/

// I. HOME
Route::get('/', fn () => view('frontend.pages.home'))->name('home');

// II. FRONTEND AUTH (Students / Investors)
Route::prefix('auth')->group(function () {
    Route::get('/login', [FrontendAuth::class, 'showLogin'])->name('login.show'); 
    Route::post('/login', [FrontendAuth::class, 'login'])->name('login.post');

    Route::get('/register', fn() => view('frontend.auth.register'))->name('register.show');
    
    Route::get('/register/investor', fn() => view('frontend.auth.register_investor'))->name('register.investor');
    Route::post('/register/investor', [FrontendAuth::class, 'registerInvestor'])->name('register.investor.post');

    Route::get('/register/academic', fn() => view('frontend.auth.register_academic'))->name('register.academic');
    Route::post('/register/student', [FrontendAuth::class, 'registerStudent'])->name('register.student.post');
});

// III. BACKEND AUTH (Managers / Supervisors)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// IV. PROTECTED DASHBOARDS
// Frontend Dashboards: Uses the 'web' guard
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard/investor', fn() => view('frontend.dashboard.investor'))->name('dashboard.investor');
    Route::get('/dashboard/academic', fn() => view('frontend.dashboard.academic'))->name('dashboard.academic');
});

// Backend Dashboards: Uses the 'admin' guard
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/manager/dashboard', fn() => view('manager.dashboard'))->name('manager.dashboard');
    Route::get('/Supervisior/supervisior_page', fn() => view('supervisior.page'))->name('supervisor.dashboard');
});

/*
|--------------------------------------------------------------------------
| Dashboard عام
|--------------------------------------------------------------------------
*/
// Updated to use web guard for general dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth:web'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Supervisor Page
|--------------------------------------------------------------------------
*/
// Protected this with admin guard so it doesn't leak
Route::get('/Supervisior/supervisior_page', fn() => view('Supervisior.supervisior_page'))->middleware('auth:admin');

/*
|--------------------------------------------------------------------------
| Password Reset Routes
|--------------------------------------------------------------------------
*/
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
*/
// UPDATED: Now uses 'auth:admin' and 'role:Manager' correctly
Route::prefix('manager')->name('manager.')->middleware(['auth:admin', 'role:Manager'])->group(function () {

        Route::get('/dashboard', [UserApproveController::class,'dashboard'])->name('dashboard');
        Route::get('/pending-users', [UserApproveController::class,'pendingUsers'])->name('pending.users');
        Route::get('/users/create', [UserController::class,'create'])->name('users.create');
        Route::post('/users/store', [UserController::class,'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/force-logout', [UserController::class, 'forceLogout'])->name('users.force-logout');
        Route::post('/approve-direct/{user}', [UserApproveController::class,'approveDirect'])->name('users.approve-direct');
        Route::post('/reject/{user}', [UserApproveController::class,'reject'])->name('users.reject');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});

/*
|--------------------------------------------------------------------------
| Profile Page
|--------------------------------------------------------------------------
*/
// Updated to a flexible auth check
Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:web,admin')->name('profile');

/*
|--------------------------------------------------------------------------
| API JSON
|--------------------------------------------------------------------------
*/
Route::get('/manager/users/{id}', function ($id) {
    $user = \App\Models\User::find($id);
    if (!$user) { return response()->json(['error' => 'User not found'], 404); }
    return response()->json($user);
})->name('manager.users.json');

Route::middleware(['auth:web'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::get('students/{id}/status/{status}', [StudentController::class, 'updateStatus'])->name('students.status');
});

//investor
Route::put('investors/{user}', [InvestorController::class, 'update'])->name('investors.update');
Route::post('investors/{investor}/notes', [InvestorController::class,'storeNote'])->name('investors.notes.store');
Route::delete('investors/{investor}/notes/{note}', [InvestorController::class,'deleteNote'])->name('investors.notes.delete');
Route::post('investors/{investor}/files', [InvestorController::class,'uploadFile'])->name('investors.files.upload');
Route::delete('investors/{investor}/files/{file}', [InvestorController::class,'deleteFile'])->name('investors.files.delete');
Route::post('investors/import', [InvestorController::class,'import'])->name('investors.import');
Route::get('investors/export/{format?}', [InvestorController::class,'export'])->name('investors.export');
Route::post('investors/{investor}/restore', [InvestorController::class,'restore'])->name('investors.restore');
Route::delete('investors/{investor}/force-delete', [InvestorController::class,'forceDelete'])->name('investors.forceDelete');
Route::resource('investors', InvestorController::class)->parameters([
    'investors' => 'investor'
]);

Route::resource('projects', ProjectController::class);
use App\Http\Controllers\ProjectTaskController;

Route::prefix('projects/{project}')->group(function(){
    Route::post('tasks', [ProjectTaskController::class,'store'])->name('projects.tasks.store');
    Route::put('tasks/{task}', [ProjectTaskController::class,'update'])->name('projects.tasks.update');
    Route::delete('tasks/{task}', [ProjectTaskController::class,'destroy'])->name('projects.tasks.destroy');
});

Route::prefix('dashboard')->middleware(['auth:web'])->group(function() {
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
});

Route::prefix('reports')->group(function () {
    Route::get('/platform', [\App\Http\Controllers\Report\PlatformReportController::class, 'index'])->name('reports.platform');
});
Route::get('/reports/platform/export/excel', function () {
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PlatformReportExport, 'platform_report.xlsx');
})->name('reports.platform.excel');
Route::get('/reports/platform/export/pdf', [\App\Http\Controllers\Report\PlatformReportController::class, 'exportPdf'])->name('reports.platform.pdf');

use App\Http\Controllers\Report\PlatformReportController;

Route::prefix('reports')->name('reports.')->group(function() {
    Route::get('platform', [PlatformReportController::class,'index'])->name('platform');
    Route::get('investors/excel', [PlatformReportController::class,'exportInvestorsExcel'])->name('investors.excel');
    Route::get('investors/pdf', [PlatformReportController::class,'exportInvestorsPdf'])->name('investors.pdf');
    Route::get('students/excel', [PlatformReportController::class,'exportStudentsExcel'])->name('students.excel');
    Route::get('students/pdf', [PlatformReportController::class,'exportStudentsPdf'])->name('students.pdf');
    Route::get('projects/excel', [PlatformReportController::class,'exportProjectsExcel'])->name('projects.excel');
    Route::get('projects/pdf', [PlatformReportController::class,'exportProjectsPdf'])->name('projects.pdf');
});

Route::prefix('manager')->group(function(){
    Route::get('/calendar', [CalendarController::class, 'index'])->name('manager.calendar.index')->middleware('auth:admin');
    Route::get('/calendar/events', [CalendarController::class, 'getEvents']); 
    Route::post('/calendar/add-event', [CalendarController::class, 'addEvent']); 
    Route::post('/calendar/delete-events', [CalendarController::class, 'deleteEvents']);
});

Route::get('/manager/sync', [ManagerController::class, 'sync'])->name('manager.sync');
Route::get('/migrate-managers', [ManagerController::class, 'migrateUsersToManagers'])->name('manager.migrate');
Route::resource('manager', ManagerController::class);

// II. STATIC / UTILITY
Route::prefix('/')->name('utility.')->group(function () {
    Route::get('about', fn () => view('frontend.utility.about'))->name('about');
    Route::get('careers', fn () => view('frontend.utility.careers'))->name('careers');
    Route::get('contact', fn () => view('frontend.utility.contact'))->name('contact');
    Route::get('how-it-works', fn () => view('frontend.utility.how-it-works'))->name('how-it-works');
    Route::get('partnerships', fn () => view('frontend.utility.partnerships'))->name('partnerships');
    Route::get('privacy', fn () => view('frontend.utility.privacy'))->name('privacy');
    Route::get('support', fn () => view('frontend.utility.support'))->name('support');
    Route::get('terms', fn () => view('frontend.utility.terms'))->name('terms');
    Route::get('disclosures', fn () => view('frontend.utility.disclosures'))->name('disclosures');
});

// Academic Submission Flow
Route::prefix('submit-project')->name('project.submit.')->group(function () {
    Route::get('/', [ProjectSubmissionController::class, 'step1'])->name('step1');
    Route::post('/step1', [ProjectSubmissionController::class, 'postStep1']);

    Route::get('/step2', [ProjectSubmissionController::class, 'step2'])->name('step2');
    Route::post('/step2', [ProjectSubmissionController::class, 'postStep2']);

    Route::get('/step3', [ProjectSubmissionController::class, 'step3'])->name('step3');
    Route::post('/step3', [ProjectSubmissionController::class, 'postStep3']);

    Route::get('/step4', [ProjectSubmissionController::class, 'step4'])->name('step4');
    Route::post('/step4', [ProjectSubmissionController::class, 'postStep4']);

    Route::get('/confirm', [ProjectSubmissionController::class, 'confirm'])->name('confirm');
    Route::post('/submit-project/final', [ProjectSubmissionController::class, 'submitFinal'])->name('final');
    
    Route::get('/submit-project/resume', [ProjectSubmissionController::class, 'resume'])->name('resume');

// ADD THIS LINE HERE:
});
Route::get('/project/details/{id}', [ProjectController::class, 'show'])->name('project.details')->middleware('auth:web');