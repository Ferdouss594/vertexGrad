<?php
// app/Http/Controllers/InvestmentRequestController.php

namespace App\Http\Controllers;

use App\Models\InvestmentRequest;
use App\Models\Investor;
use App\Models\Project;
use App\Models\MarketplaceProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvestmentRequestController extends Controller
{
    /**
     * عرض جميع طلبات الاستثمار (للمدير فقط)
     */
    public function index(Request $request)
    {
        // التحقق من تسجيل الدخول في guard admin
        if (!Auth::guard('admin')->check()) {
            abort(403, 'غير مصرح لك بالوصول');
        }
        
        $query = InvestmentRequest::with(['investor.user', 'project']);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب المستثمر
        if ($request->filled('investor_id')) {
            $query->where('investor_id', $request->investor_id);
        }

        // بحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhereHas('investor.user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('project', function($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // إحصائيات
        $stats = [
            'total' => InvestmentRequest::count(),
            'pending' => InvestmentRequest::where('status', 'pending')->count(),
            'under_process' => InvestmentRequest::where('status', 'under_process')->count(),
            'approved' => InvestmentRequest::where('status', 'approved')->count(),
            'rejected' => InvestmentRequest::where('status', 'rejected')->count(),
        ];

        $investors = Investor::with('user')->get();

        return view('admin.investment-requests.index', compact('requests', 'stats', 'investors'));
    }

    /**
     * عرض طلبات المستثمر الحالي (للمستثمر فقط)
     */
    public function myRequests(Request $request)
    {
        // التحقق من تسجيل الدخول في guard web
        if (!Auth::guard('web')->check()) {
            abort(403, 'غير مصرح لك بالوصول');
        }
        
        // التحقق أن المستخدم هو مستثمر
        if (Auth::guard('web')->user()->role !== 'investor' && Auth::guard('web')->user()->role !== 'Investor') {
            abort(403, 'غير مصرح لك بالوصول');
        }
        
        $investorId = Auth::guard('web')->user()->investor->id;
        
        $query = InvestmentRequest::where('investor_id', $investorId)
                    ->with(['project']);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // بحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhereHas('project', function($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('investor.requests.index', compact('requests'));
    }

    /**
     * عرض نموذج إنشاء طلب جديد (للمدير)
     */
    public function create()
    {
        // التحقق من تسجيل الدخول في guard admin
        if (!Auth::guard('admin')->check()) {
            abort(403, 'غير مصرح لك بالوصول');
        }
        
        $investors = Investor::with('user')->get();
        $projects = Project::where('status', 'approved')->get(); // المشاريع المقبولة فقط
        
        return view('admin.investment-requests.create', compact('investors', 'projects'));
    }

    /**
     * عرض نموذج تقديم طلب (للمستثمر)
     */
    public function createInvestorRequest($projectId)
    {
        // التحقق من تسجيل الدخول في guard web
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login.show')->with('error', 'يجب تسجيل الدخول أولاً');
        }
        
        // التحقق أن المستخدم هو مستثمر
        if (Auth::guard('web')->user()->role !== 'investor' && Auth::guard('web')->user()->role !== 'Investor') {
            abort(403, 'هذه الصفحة مخصصة للمستثمرين فقط');
        }
        
        $project = MarketplaceProject::findOrFail($projectId);
        
        return view('investor.requests.create', compact('project'));
    }

    /**
     * حفظ طلب جديد (للمدير أو المستثمر)
     */
    public function store(Request $request)
    {
        // قواعد التحقق الأساسية
        $rules = [
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1000',
            'message' => 'nullable|string|max:500',
            'equity_percentage' => 'nullable|numeric|min:0|max:100',
        ];

        // تحديد نوع المستخدم (admin أو web)
        $isAdmin = Auth::guard('admin')->check();
        $isInvestor = Auth::guard('web')->check() && 
                     (Auth::guard('web')->user()->role === 'investor' || 
                      Auth::guard('web')->user()->role === 'Investor');

        if (!$isAdmin && !$isInvestor) {
            abort(403, 'غير مصرح لك بالوصول');
        }

        // إذا كان المستخدم مدير، يجب اختيار المستثمر
        if ($isAdmin) {
            $rules['investor_id'] = 'required|exists:investors,id';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            // تحديد المستثمر
            if ($isAdmin) {
                $investorId = $request->investor_id;
            } else {
                // المستثمر الحالي
                $investorId = Auth::guard('web')->user()->investor->id;
            }

            // إنشاء رقم طلب فريد
            $requestNumber = 'INV-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $investmentRequest = InvestmentRequest::create([
                'investor_id' => $investorId,
                'project_id' => $request->project_id,
                'request_number' => $requestNumber,
                'amount' => $request->amount,
                'message' => $request->message,
                'equity_percentage' => $request->equity_percentage,
                'status' => 'pending',
            ]);

            DB::commit();

            // توجيه مختلف حسب نوع المستخدم
            if ($isAdmin) {
                return redirect()->route('admin.investment-requests.index')
                    ->with('success', 'تم إنشاء طلب الاستثمار بنجاح');
            } else {
                return redirect()->route('investor.requests.index')
                    ->with('success', 'تم تقديم طلب الاستثمار بنجاح');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * عرض تفاصيل طلب (للمدير أو المستثمر صاحب الطلب)
     */
    public function show(InvestmentRequest $investmentRequest)
    {
        $isAdmin = Auth::guard('admin')->check();
        $isOwner = Auth::guard('web')->check() && 
                  Auth::guard('web')->user()->investor && 
                  Auth::guard('web')->user()->investor->id === $investmentRequest->investor_id;

        if (!$isAdmin && !$isOwner) {
            abort(403, 'غير مصرح لك بالوصول');
        }
        
        $investmentRequest->load(['investor.user', 'project']);
        
        // اختيار الـ View حسب نوع المستخدم
        if ($isAdmin) {
            return view('admin.investment-requests.show', compact('investmentRequest'));
        } else {
            return view('investor.requests.show', compact('investmentRequest'));
        }
    }

    /**
     * عرض نموذج تعديل طلب (للمدير فقط)
     */
    public function edit(InvestmentRequest $investmentRequest)
    {
        // التحقق من تسجيل الدخول في guard admin
        if (!Auth::guard('admin')->check()) {
            abort(403, 'غير مصرح لك بالوصول');
        }
        
        $investors = Investor::with('user')->get();
        $projects = Project::where('status', 'approved')->get();
        
        return view('admin.investment-requests.edit', compact('investmentRequest', 'investors', 'projects'));
    }

    /**
     * تحديث طلب (للمدير فقط)
     */
    public function update(Request $request, InvestmentRequest $investmentRequest)
    {
        // التحقق من تسجيل الدخول في guard admin
        if (!Auth::guard('admin')->check()) {
            abort(403, 'غير مصرح لك بالوصول');
        }
        
        $request->validate([
            'investor_id' => 'required|exists:investors,id',
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'message' => 'nullable|string',
            'status' => 'required|in:pending,under_process,approved,rejected,cancelled',
        ]);

        DB::beginTransaction();
        try {
            $investmentRequest->update([
                'investor_id' => $request->investor_id,
                'project_id' => $request->project_id,
                'amount' => $request->amount,
                'message' => $request->message,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('admin.investment-requests.index')
                ->with('success', 'تم تحديث طلب الاستثمار بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف طلب (للمدير فقط)
     */
    public function destroy(InvestmentRequest $investmentRequest)
    {
        // التحقق من تسجيل الدخول في guard admin
        if (!Auth::guard('admin')->check()) {
            abort(403, 'غير مصرح لك بالوصول');
        }
        
        try {
            $investmentRequest->delete();
            return redirect()->route('admin.investment-requests.index')
                ->with('success', 'تم حذف طلب الاستثمار بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تغيير حالة الطلب (للمدير)
     */
    public function changeStatus(Request $request, InvestmentRequest $investmentRequest)
    {
        // التحقق من تسجيل الدخول في guard admin
        if (!Auth::guard('admin')->check()) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }
        
        $request->validate([
            'status' => 'required|in:pending,under_process,approved,rejected,cancelled',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'status' => $request->status,
                'processed_at' => now(),
            ];

            if ($request->status == 'approved') {
                $updateData['approved_at'] = now();
            } elseif ($request->status == 'rejected') {
                $updateData['rejected_at'] = now();
                $updateData['rejection_reason'] = $request->rejection_reason;
            }

            $investmentRequest->update($updateData);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'تم تحديث الحالة بنجاح']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * إرسال رسالة للمستثمر بخصوص الطلب
     */
    public function sendMessage(Request $request, InvestmentRequest $investmentRequest)
    {
        $isAdmin = Auth::guard('admin')->check();
        $isOwner = Auth::guard('web')->check() && 
                  Auth::guard('web')->user()->investor && 
                  Auth::guard('web')->user()->investor->id === $investmentRequest->investor_id;

        if (!$isAdmin && !$isOwner) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }
        
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            // هنا يمكن إرسال إشعار أو حفظ رسالة
            // InvestorNotification::create([...]);

            return back()->with('success', 'تم إرسال الرسالة بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}