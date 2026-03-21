<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\Auth\AuthController as FrontendAuth;
use App\Http\Controllers\Frontend\ProjectSubmissionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProjectController as FrontendProjectController;
use App\Http\Controllers\Frontend\NotificationController as FrontNotificationController;
use App\Http\Controllers\Frontend\InvestorDashboardController;
use App\Http\Controllers\Frontend\AcademicDashboardController;
use App\Http\Controllers\Admin\ProjectController;

// ------------------------
// FRONTEND PUBLIC PAGES
// ------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

// ------------------------
// FRONTEND AUTH (Students / Investors)
// ------------------------
Route::prefix('auth')->group(function () {
    Route::get('/login', [FrontendAuth::class, 'showLogin'])->name('login.show');
    Route::post('/login', [FrontendAuth::class, 'login'])->name('login.post');
    Route::post('/logout', [FrontendAuth::class, 'logout'])->name('frontend.logout');

    Route::get('/register', fn() => view('frontend.auth.register'))->name('register.show');

    Route::get('/register/investor', fn() => view('frontend.auth.register_investor'))->name('register.investor');
    Route::post('/register/investor', [FrontendAuth::class, 'registerInvestor'])->name('register.investor.post');

    Route::get('/register/academic', fn() => view('frontend.auth.register_academic'))->name('register.academic');
    Route::post('/register/student', [FrontendAuth::class, 'registerStudent'])->name('register.student.post');
});

// ------------------------
// FRONTEND MARKETPLACE (Investor browsing)
// ------------------------
Route::get('/projects', [FrontendProjectController::class, 'index'])->name('frontend.projects.index');
Route::get('/projects/{project}', [FrontendProjectController::class, 'show'])->name('frontend.projects.show');

// ------------------------
// FRONTEND DASHBOARDS (web guard)
// ------------------------
Route::middleware(['auth:web'])->group(function () {

    Route::post('/projects/{project}/request-funding', [FrontendProjectController::class, 'requestFunding'])
    ->name('frontend.projects.requestFunding');

    Route::get('/dashboard/investor', [InvestorDashboardController::class, 'index'])->name('dashboard.investor');

    Route::get('/dashboard/academic', [AcademicDashboardController::class, 'index'])
        ->name('dashboard.academic');

    Route::get('/projects/{project}/media', [FrontendProjectController::class, 'mediaForm'])
        ->name('projects.media.form');

    Route::post('/projects/{project}/media', [FrontendProjectController::class, 'mediaUpload'])
        ->name('projects.media.upload');


    Route::post('/projects/{project}/invest', [FrontendProjectController::class, 'invest'])
        ->name('frontend.projects.invest');

    Route::delete('/projects/{project}/interest', [FrontendProjectController::class, 'removeInterest'])
        ->name('frontend.projects.interest.remove');

        Route::get('/investor/investments',
    [InvestorDashboardController::class,'investments']
)->name('investor.investments');

});

// ------------------------
// FRONTEND NOTIFICATIONS
// ------------------------
Route::middleware(['auth:web'])->group(function () {
    Route::get('/notifications', [FrontNotificationController::class, 'index'])
        ->name('frontend.notifications.index');

    Route::get('/notifications/unread-count', [FrontNotificationController::class, 'unreadCount'])
        ->name('frontend.notifications.count');

    Route::post('/notifications/{id}/read', [FrontNotificationController::class, 'markAsRead'])
        ->name('frontend.notifications.read');

    Route::post('/notifications/mark-all-read', [FrontNotificationController::class, 'markAllRead'])
        ->name('frontend.notifications.markAllRead');
});

// ------------------------
// FRONTEND PROFILE (web only)
// ------------------------
Route::middleware(['auth:web'])->get('/profile', function () {
    $user = auth('web')->user();

    return match ($user->role) {
        'Investor' => redirect()->route('dashboard.investor'),
        'Student'  => redirect()->route('dashboard.academic'),
        default    => redirect()->route('home'),
    };
})->name('profile');

// ------------------------
// PASSWORD RESET ROUTES
// ------------------------
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// ------------------------
// STATIC / UTILITY
// ------------------------
Route::prefix('/')->name('utility.')->group(function () {
    Route::get('about', fn() => view('frontend.utility.about'))->name('about');
    Route::get('careers', fn() => view('frontend.utility.careers'))->name('careers');
    Route::get('contact', fn() => view('frontend.utility.contact'))->name('contact');
    Route::get('how-it-works', fn() => view('frontend.utility.how-it-works'))->name('how-it-works');
    Route::get('partnerships', fn() => view('frontend.utility.partnerships'))->name('partnerships');
    Route::get('privacy', fn() => view('frontend.utility.privacy'))->name('privacy');
    Route::get('support', fn() => view('frontend.utility.support'))->name('support');
    Route::get('terms', fn() => view('frontend.utility.terms'))->name('terms');
    Route::get('disclosures', fn() => view('frontend.utility.disclosures'))->name('disclosures');
});

// ------------------------
// ACADEMIC SUBMISSION FLOW
// ------------------------
Route::prefix('submit-project')->name('project.submit.')->group(function () {
    Route::get('/', [ProjectSubmissionController::class, 'step1'])->name('step1');
    Route::post('/', [ProjectSubmissionController::class, 'postStep1'])->name('step1.post');

    Route::get('/step2', [ProjectSubmissionController::class, 'step2'])->name('step2');
    Route::post('/step2', [ProjectSubmissionController::class, 'postStep2'])->name('step2.post');

    Route::get('/step3', [ProjectSubmissionController::class, 'step3'])->name('step3');
    Route::post('/step3', [ProjectSubmissionController::class, 'postStep3'])->name('step3.post');

    Route::get('/step4', [ProjectSubmissionController::class, 'step4'])->name('step4');
    Route::post('/step4', [ProjectSubmissionController::class, 'postStep4'])->name('step4.post');

    Route::get('/confirm', [ProjectSubmissionController::class, 'confirm'])->name('confirm');
    Route::post('/final', [ProjectSubmissionController::class, 'submitFinal'])->name('final');

    Route::get('/resume', [ProjectSubmissionController::class, 'resume'])->name('resume');
});
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::patch('/projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
    Route::patch('/projects/{project}/publish', [ProjectController::class, 'publish'])->name('projects.publish');
 Route::get('projects/{project}/scanner-review', [\App\Http\Controllers\Admin\ProjectController::class, 'scannerReview'])
    ->name('projects.scannerReview');

Route::post('projects/{project}/start-scan', [\App\Http\Controllers\Admin\ProjectController::class, 'startScan'])
    ->name('projects.startScan');
} );
Route::middleware(['auth:web'])->group(function () {
    Route::post('/student/requests/{requestItem}/respond', [\App\Http\Controllers\Frontend\AcademicDashboardController::class, 'respondToRequest'])
        ->name('student.requests.respond');
});

// DEBUG
// ------------------------
Route::get('/_debug/auth', function () {
    return response()->json([
        'web'   => auth('web')->check(),
        'admin' => auth('admin')->check(),
        'user'  => auth('admin')->user(),
    ]);
})->middleware('web');