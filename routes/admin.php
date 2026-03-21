<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Manager\UserApproveController;
use App\Http\Controllers\Manager\UserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ManagerController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\Report\PlatformReportController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Supervisor\SupervisorDashboardController;
use App\Http\Controllers\Supervisor\SupervisorProjectController;
use App\Http\Controllers\Supervisor\SupervisorProfileController;
use App\Http\Controllers\Admin\ManagerProjectDecisionController;

// ------------------------
// Backend Auth (Managers / Supervisors)
// ------------------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ------------------------
// Backend Profile + Admin CRUD
// ------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {

    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    // Students
    Route::resource('students', StudentController::class);
    Route::get('students/{id}/status/{status}', [StudentController::class, 'updateStatus'])->name('students.status');

    // Investors
    Route::put('investors/{user}', [InvestorController::class, 'update'])->name('investors.update');
    Route::post('investors/{investor}/notes', [InvestorController::class, 'storeNote'])->name('investors.notes.store');
    Route::delete('investors/{investor}/notes/{note}', [InvestorController::class, 'deleteNote'])->name('investors.notes.delete');
    Route::post('investors/{investor}/files', [InvestorController::class, 'uploadFile'])->name('investors.files.upload');
    Route::delete('investors/{investor}/files/{file}', [InvestorController::class, 'deleteFile'])->name('investors.files.delete');
    Route::post('investors/import', [InvestorController::class, 'import'])->name('investors.import');
    Route::get('investors/export/{format?}', [InvestorController::class, 'export'])->name('investors.export');
    Route::post('investors/{investor}/restore', [InvestorController::class, 'restore'])->name('investors.restore');
    Route::delete('investors/{investor}/force-delete', [InvestorController::class, 'forceDelete'])->name('investors.forceDelete');
    Route::resource('investors', InvestorController::class)->parameters(['investors' => 'investor']);
Route::middleware(['role:Manager'])->prefix('projects/final-decisions')->name('projects.final-decisions.')->group(function () {
    Route::get('/', [ManagerProjectDecisionController::class, 'index'])->name('index');
    Route::get('/{project}', [ManagerProjectDecisionController::class, 'show'])->name('show');
    Route::post('/{project}/store', [ManagerProjectDecisionController::class, 'storeDecision'])->name('store');
});
    // Projects
    Route::resource('projects', AdminProjectController::class);

    Route::post('projects/{project}/approve', [AdminProjectController::class, 'approve'])
        ->name('projects.approve');

    Route::post('projects/{project}/reject', [AdminProjectController::class, 'reject'])
        ->name('projects.reject');

     Route::post('projects/{project}/funding-requests/{user}/approve',
    [AdminProjectController::class, 'approveInvestor'])
    ->name('projects.investors.approve');

Route::post('projects/{project}/funding-requests/{user}/reject',
    [AdminProjectController::class, 'rejectInvestor'])
    ->name('projects.investors.reject');


    // Project Tasks
    Route::prefix('projects/{project}')->group(function () {
        Route::post('tasks', [ProjectTaskController::class, 'store'])->name('projects.tasks.store');
        Route::put('tasks/{task}', [ProjectTaskController::class, 'update'])->name('projects.tasks.update');
        Route::delete('tasks/{task}', [ProjectTaskController::class, 'destroy'])->name('projects.tasks.destroy');
        
    });

    // Admin Notifications
    Route::get('notifications', [AdminNotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('notifications/unread-count', [AdminNotificationController::class, 'unreadCount'])
        ->name('notifications.count');

    Route::post('notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])
        ->name('notifications.markAllRead');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('platform', [PlatformReportController::class, 'index'])->name('platform');
        Route::get('investors/excel', [PlatformReportController::class, 'exportInvestorsExcel'])->name('investors.excel');
        Route::get('investors/pdf', [PlatformReportController::class, 'exportInvestorsPdf'])->name('investors.pdf');
        Route::get('students/excel', [PlatformReportController::class, 'exportStudentsExcel'])->name('students.excel');
        Route::get('students/pdf', [PlatformReportController::class, 'exportStudentsPdf'])->name('students.pdf');
        Route::get('projects/excel', [PlatformReportController::class, 'exportProjectsExcel'])->name('projects.excel');
        Route::get('projects/pdf', [PlatformReportController::class, 'exportProjectsPdf'])->name('projects.pdf');
    });
});

// ------------------------
// Manager Area (Role: Manager)
// ------------------------
Route::prefix('manager')->name('manager.')->middleware(['auth:admin', 'role:Manager'])->group(function () {
    Route::get('/dashboard', [UserApproveController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending-users', [UserApproveController::class, 'pendingUsers'])->name('pending.users');
    Route::post('/approve-direct/{user}', [UserApproveController::class, 'approveDirect'])->name('users.approve-direct');
    Route::post('/reject/{user}', [UserController::class, 'reject'])->name('users.reject');

    Route::resource('users', UserController::class)->except(['index']);
    Route::post('/users/{user}/force-logout', [UserController::class, 'forceLogout'])->name('users.force-logout');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'getEvents']);
    Route::post('/calendar/add-event', [CalendarController::class, 'addEvent']);
    Route::post('/calendar/delete-events', [CalendarController::class, 'deleteEvents']);
     Route::get('/manager/sync', [ManagerController::class, 'sync'])->name('manager.sync');
    Route::get('/migrate-managers', [ManagerController::class, 'migrateUsersToManagers'])->name('manager.migrate');
    Route::resource('manager', ManagerController::class);
});

// ------------------------
// Manager Sync & Migration
// ------------------------
Route::middleware(['auth:admin', 'role:Manager'])->group(function () {
    Route::get('/manager/sync', [ManagerController::class, 'sync'])->name('manager.sync');
    Route::get('/migrate-managers', [ManagerController::class, 'migrateUsersToManagers'])->name('manager.migrate');
    Route::resource('manager', ManagerController::class);
});

// ------------------------
// Supervisor Area (Role: Supervisor)
// ------------------------
Route::prefix('admin/supervisor')
    ->name('supervisor.')
    ->middleware(['auth:admin', 'role:Supervisor'])
    ->group(function () {

        Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('dashboard');

        Route::get('/projects', [SupervisorProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/pending', [SupervisorProjectController::class, 'pending'])->name('projects.pending');
        Route::get('/projects/approved', [SupervisorProjectController::class, 'approved'])->name('projects.approved');
        Route::get('/projects/revisions', [SupervisorProjectController::class, 'revisions'])->name('projects.revisions');
        Route::get('/projects/{project}', [SupervisorProjectController::class, 'show'])->name('projects.show');
        

        Route::get('/profile', [SupervisorProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [SupervisorProfileController::class, 'update'])->name('profile.update');
       // ===============================
// System Verification
// ===============================
Route::post('/projects/{project}/system-verification',
    [SupervisorProjectController::class, 'updateSystemVerification']
)->name('projects.system-verification.update');


// ===============================
// Meetings
// ===============================
Route::post('/projects/meetings/store', [SupervisorProjectController::class, 'storeMeeting'])
    ->name('projects.meetings.store');

Route::post('/projects/{project}/meetings/{meeting}/status',
    [SupervisorProjectController::class, 'updateMeetingStatus']
)->name('projects.meetings.status');
// Meetings Pages
Route::get('/meetings', [SupervisorProjectController::class, 'meetingsIndex'])->name('meetings.index');
Route::get('/meetings/upcoming', [SupervisorProjectController::class, 'meetingsUpcoming'])->name('meetings.upcoming');
Route::get('/meetings/completed', [SupervisorProjectController::class, 'meetingsCompleted'])->name('meetings.completed');
Route::get('/meetings/create', [SupervisorProjectController::class, 'meetingsCreate'])->name('meetings.create');
Route::get('/requests', [SupervisorProjectController::class, 'requestsIndex'])->name('requests.index');
Route::get('/requests/pending', [SupervisorProjectController::class, 'requestsPending'])->name('requests.pending');
Route::get('/requests/completed', [SupervisorProjectController::class, 'requestsCompleted'])->name('requests.completed');

Route::post('/projects/{project}/requests/store', [SupervisorProjectController::class, 'storeRequest'])
    ->name('projects.requests.store');

Route::post('/requests/{requestItem}/status', [SupervisorProjectController::class, 'updateRequestStatus'])
    ->name('requests.status');
    Route::post('/projects/{project}/evaluation', [SupervisorProjectController::class, 'storeEvaluation'])
    ->name('projects.evaluation.store');
    Route::get('/file/{id}', function ($id) {
    $file = \App\Models\ProjectRequestResponse::findOrFail($id);

    return response()->file(storage_path('app/public/' . $file->attachment_path));
})->name('file.view');;
    });