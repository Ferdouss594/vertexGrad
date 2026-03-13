<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ========== API للطلبات العامة ==========
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toIso8601String()
    ]);
});

// ========== API للمستخدمين ==========
Route::prefix('users')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'users' => \App\Models\User::select('id', 'name', 'email', 'type', 'created_at')->get()
        ]);
    })->middleware('auth:sanctum');
    
    Route::get('/{id}', function ($id) {
        $user = \App\Models\User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user);
    })->middleware('auth:sanctum');
});

// ========== API للمشاريع ==========
Route::prefix('projects')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'projects' => \App\Models\Project::with('user')->latest()->get()
        ]);
    });
    
    Route::get('/{id}', function ($id) {
        $project = \App\Models\Project::with('user')->find($id);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }
        return response()->json($project);
    });
    
    Route::get('/category/{category}', function ($category) {
        $projects = \App\Models\Project::where('category', $category)
            ->with('user')
            ->latest()
            ->get();
        return response()->json([
            'category' => $category,
            'projects' => $projects
        ]);
    });
});

// ========== API للمستثمرين ==========
Route::prefix('investors')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'investors' => \App\Models\User::where('type', 'investor')
                ->select('id', 'name', 'email', 'created_at')
                ->get()
        ]);
    });
    
    Route::get('/top', function () {
        // هذا مثال - يمكنك تعديله حسب منطق عملك
        return response()->json([
            'top_investors' => \App\Models\User::where('type', 'investor')
                ->withCount('investments')
                ->orderBy('investments_count', 'desc')
                ->limit(10)
                ->get()
        ]);
    });
});

// ========== API للطلاب ==========
Route::prefix('students')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'students' => \App\Models\User::where('type', 'student')
                ->select('id', 'name', 'email', 'created_at')
                ->get()
        ]);
    });
    
    Route::get('/recent', function () {
        return response()->json([
            'recent_students' => \App\Models\User::where('type', 'student')
                ->latest()
                ->limit(10)
                ->get()
        ]);
    });
});

// ========== API للتقارير ==========
Route::prefix('reports')->group(function () {
    Route::get('/platform', function () {
        $data = [
            'total_users' => \App\Models\User::count(),
            'total_projects' => \App\Models\Project::count(),
            'total_investors' => \App\Models\User::where('type', 'investor')->count(),
            'total_students' => \App\Models\User::where('type', 'student')->count(),
            'recent_users' => \App\Models\User::latest()->limit(5)->get(),
            'recent_projects' => \App\Models\Project::with('user')->latest()->limit(5)->get()
        ];
        
        return response()->json($data);
    });
    
    Route::get('/stats', function () {
        return response()->json([
            'users_by_month' => \App\Models\User::selectRaw('YEAR(created_at) year, MONTH(created_at) month, count(*) total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get(),
            'projects_by_category' => \App\Models\Project::selectRaw('category, count(*) total')
                ->groupBy('category')
                ->get()
        ]);
    });
});

// ========== API للتقويم ==========
Route::prefix('calendar')->group(function () {
    Route::get('/events', function () {
        $events = \App\Models\Calendar::where('start', '>=', now())
            ->orderBy('start')
            ->get();
        
        return response()->json([
            'events' => $events
        ]);
    });
    
    Route::get('/events/upcoming', function () {
        $events = \App\Models\Calendar::where('start', '>=', now())
            ->where('start', '<=', now()->addDays(30))
            ->orderBy('start')
            ->limit(5)
            ->get();
        
        return response()->json([
            'upcoming_events' => $events
        ]);
    });
});

// ========== API للبحث ==========
Route::get('/search', function (Request $request) {
    $query = $request->get('q');
    
    if (!$query) {
        return response()->json(['error' => 'Search query required'], 400);
    }
    
    $results = [
        'users' => \App\Models\User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name', 'email', 'type']),
        
        'projects' => \App\Models\Project::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('user')
            ->limit(5)
            ->get()
    ];
    
    return response()->json([
        'query' => $query,
        'results' => $results
    ]);
});

// ========== API للشات بوت ==========
use App\Http\Controllers\Api\ChatbotController;

Route::prefix('chatbot')->group(function () {
    // إرسال رسالة واستقبال رد
    Route::post('/message', [ChatbotController::class, 'message']);
    
    // تقييم رد البوت
    Route::post('/feedback', [ChatbotController::class, 'feedback']);
    
    // سجل المحادثات للمستخدم (يتطلب تسجيل الدخول)
    Route::get('/history', [ChatbotController::class, 'history'])->middleware('auth:sanctum');
    
    // اقتراحات للأسئلة الشائعة
    Route::get('/suggestions', [ChatbotController::class, 'suggestions']);
    
    // حالة الشات بوت
    Route::get('/status', function () {
        return response()->json([
            'status' => 'active',
            'version' => '1.0',
            'languages' => ['ar', 'en']
        ]);
    });
});

// ========== API للوحة التحكم ==========
Route::prefix('dashboard')->middleware('auth:sanctum')->group(function () {
    Route::get('/stats', function () {
        return response()->json([
            'total_users' => \App\Models\User::count(),
            'new_users_today' => \App\Models\User::whereDate('created_at', today())->count(),
            'total_projects' => \App\Models\Project::count(),
            'pending_projects' => \App\Models\Project::where('status', 'pending')->count(),
            'total_investments' => \App\Models\Investment::sum('amount') ?? 0,
            'recent_activities' => [] // يمكنك إضافة الأنشطة هنا
        ]);
    });
    
    Route::get('/activities', function () {
        // يمكنك إنشاء جدول للأنشطة أو استخدام الـ logs
        return response()->json([
            'activities' => []
        ]);
    });
});

// ========== API للاختبارات (Development Only) ==========
if (app()->environment('local')) {
    Route::get('/test', function () {
        return response()->json([
            'message' => 'API is working!',
            'environment' => app()->environment(),
            'timestamp' => now()->toIso8601String()
        ]);
    });
    
    Route::get('/test/chatbot', function () {
        return response()->json([
            'success' => true,
            'message' => 'هذه رسالة اختبار من الشات بوت',
            'intent' => 'test',
            'confidence' => 1.0,
            'language' => 'ar'
        ]);
    });
}

// ========== API للـ Fallback ==========
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found. Please check the URL.'
    ], 404);
});