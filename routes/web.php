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

/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login.show'));

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| Dashboard عام
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([Authenticate::class])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Supervisor Page
|--------------------------------------------------------------------------
*/

Route::get('/Supervisior/supervisior_page', fn() => view('Supervisior.supervisior_page'));

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

Route::prefix('manager')->name('manager.')
    ->middleware([Authenticate::class, 'role:Manager'])
    ->group(function () {

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

Route::get('/profile', [AuthController::class, 'profile'])
    ->middleware(Authenticate::class)
    ->name('profile');

/*
|--------------------------------------------------------------------------
| API JSON
|--------------------------------------------------------------------------
*/

Route::get('/manager/users/{id}', function ($id) {
    $user = \App\Models\User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    return response()->json($user);
})->name('manager.users.json');

/*
|--------------------------------------------------------------------------
| Student Routes  (✔ بصيغة resource فقط — بدون تكرار)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // هذا هو الراوت الصحيح ولا تحتاج أي إضافات أخرى
    Route::resource('students', StudentController::class);

    // حالة الطالب (اختياري إذا تستخدمه فعلاً)
    Route::get('students/{id}/status/{status}', [StudentController::class, 'updateStatus'])
        ->name('students.status');
});
use App\Http\Controllers\InvestorController;

Route::resource('investors', InvestorController::class);

Route::post('investors/{investor}/notes', [InvestorController::class,'storeNote'])->name('investors.notes.store');
Route::delete('investors/{investor}/notes/{note}', [InvestorController::class,'deleteNote'])->name('investors.notes.delete');

Route::post('investors/{investor}/files', [InvestorController::class,'uploadFile'])->name('investors.files.upload');
Route::delete('investors/{investor}/files/{file}', [InvestorController::class,'deleteFile'])->name('investors.files.delete');

Route::post('investors/import', [InvestorController::class,'import'])->name('investors.import');
Route::get('investors/export/{format?}', [InvestorController::class,'export'])->name('investors.export');

Route::post('investors/{id}/restore', [InvestorController::class,'restore'])->name('investors.restore');
Route::delete('investors/{id}/force-delete', [InvestorController::class,'forceDelete'])->name('investors.forceDelete');
Route::post('investors', [InvestorController::class,'store'])->name('investors.store');
use App\Http\Controllers\ProjectController;

Route::resource('projects', ProjectController::class);
use App\Http\Controllers\ProjectTaskController;

Route::prefix('projects/{project}')->group(function(){
    Route::post('tasks', [ProjectTaskController::class,'store'])->name('projects.tasks.store');
    Route::put('tasks/{task}', [ProjectTaskController::class,'update'])->name('projects.tasks.update');
    Route::delete('tasks/{task}', [ProjectTaskController::class,'destroy'])->name('projects.tasks.destroy');
});
Route::get('/investors/create', [InvestorController::class, 'create'])->name('investors.create');
Route::post('/investors', [InvestorController::class, 'store'])->name('investors.store');
// routes/web.php
Route::prefix('dashboard')->middleware(['auth'])->group(function() {
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
});

Route::prefix('reports')->group(function () {
    Route::get('/platform', [\App\Http\Controllers\Report\PlatformReportController::class, 'index'])
        ->name('reports.platform');
});
Route::get('/reports/platform/export/excel', function () {
    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\PlatformReportExport,
        'platform_report.xlsx'
    );
})->name('reports.platform.excel');
Route::get('/reports/platform/export/pdf',
    [\App\Http\Controllers\Report\PlatformReportController::class, 'exportPdf']
)->name('reports.platform.pdf');

use App\Http\Controllers\Report\PlatformReportController;

Route::prefix('reports')->name('reports.')->group(function() {
    // الصفحة الرئيسية للتقارير
    Route::get('platform', [PlatformReportController::class,'index'])->name('platform');

    // Investors
    Route::get('investors/excel', [PlatformReportController::class,'exportInvestorsExcel'])->name('investors.excel');
    Route::get('investors/pdf', [PlatformReportController::class,'exportInvestorsPdf'])->name('investors.pdf');

    // Students
    Route::get('students/excel', [PlatformReportController::class,'exportStudentsExcel'])->name('students.excel');
    Route::get('students/pdf', [PlatformReportController::class,'exportStudentsPdf'])->name('students.pdf');

    // Projects
    Route::get('projects/excel', [PlatformReportController::class,'exportProjectsExcel'])->name('projects.excel');
    Route::get('projects/pdf', [PlatformReportController::class,'exportProjectsPdf'])->name('projects.pdf');
});
use App\Http\Controllers\CalendarController;



Route::prefix('manager')->group(function(){
    Route::get('/calendar', [CalendarController::class, 'index'])->name('manager.calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'getEvents']); // لجلب الأحداث
 // لجلب الأحداث
    Route::post('/calendar/add-event', [CalendarController::class, 'addEvent']); 
    Route::post('/calendar/delete-events', [CalendarController::class, 'deleteEvents']);
// إضافة حدث جديد
});
