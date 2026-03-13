<?php
// app/Http/Controllers/InvestmentRequestController.php

namespace App\Http\Controllers;

use App\Models\InvestmentRequest;
use App\Models\Investor;
use App\Models\Project;
use App\Models\InvestorActivityLog;
use App\Models\InvestorNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestmentRequestController extends Controller
{
    /**
     * عرض جميع طلبات الاستثمار
     */
    public function index(Request $request)
    {
        $query = InvestmentRequest::with(['investor.user', 'processor', 'project']);

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
                  });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15))
            ->withQueryString();

        // إحصائيات
        $stats = [
            'total' => InvestmentRequest::count(),
            'pending' => InvestmentRequest::where('status', 'pending')->count(),
            'under_process' => InvestmentRequest::where('status', 'under_process')->count(),
            'approved' => InvestmentRequest::where('status', 'approved')->count(),
            'rejected' => InvestmentRequest::where('status', 'rejected')->count(),
            'total_amount' => InvestmentRequest::sum('amount') ?? 0,
        ];

        $investors = Investor::with('user')->get();

        return view('investment_requests.index', compact('requests', 'stats', 'investors'));
    }

    /**
     * عرض نموذج إنشاء طلب جديد
     */
    public function create()
    {
        $investors = Investor::with('user')->get();
        $projects = Project::where('status', '!=', 'cancelled')->get();
        
        return view('investment_requests.create', compact('investors', 'projects'));
    }

    /**
     * حفظ طلب جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'investor_id' => 'required|exists:investors,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // إنشاء رقم طلب فريد
            $requestNumber = 'INV-' . date('Ymd') . '-' . str_pad(InvestmentRequest::count() + 1, 4, '0', STR_PAD_LEFT);

            $investmentRequest = InvestmentRequest::create([
                'investor_id' => $request->investor_id,
                'project_id' => $request->project_id,
                'request_number' => $requestNumber,
                'amount' => $request->amount,
                'description' => $request->description,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // تسجيل النشاط
            InvestorActivityLog::create([
                'investor_id' => $request->investor_id,
                'user_id' => auth()->id(),
                'action' => 'investment_request_created',
                'description' => 'تم إنشاء طلب استثمار جديد رقم: ' . $requestNumber,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // إنشاء إشعار للمستثمر
            InvestorNotification::create([
                'investor_id' => $request->investor_id,
                'investment_request_id' => $investmentRequest->id,
                'title' => 'طلب استثمار جديد',
                'message' => 'تم إنشاء طلب استثمار بمبلغ ' . number_format($request->amount, 2) . ' ج.م',
                'type' => 'info',
            ]);

            DB::commit();
            return redirect()->route('investment-requests.index')
                ->with('success', 'تم إنشاء طلب الاستثمار بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * عرض تفاصيل طلب
     */
    public function show(InvestmentRequest $investmentRequest)
    {
        $investmentRequest->load(['investor.user', 'processor', 'project']);
        
        return view('investment_requests.show', compact('investmentRequest'));
    }

    /**
     * عرض نموذج تعديل طلب
     */
    public function edit(InvestmentRequest $investmentRequest)
    {
        $investors = Investor::with('user')->get();
        $projects = Project::where('status', '!=', 'cancelled')->get();
        
        return view('investment_requests.edit', compact('investmentRequest', 'investors', 'projects'));
    }

    /**
     * تحديث طلب
     */
    public function update(Request $request, InvestmentRequest $investmentRequest)
    {
        $request->validate([
            'investor_id' => 'required|exists:investors,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,under_process,approved,rejected,cancelled',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $investmentRequest->status;
            
            $investmentRequest->update([
                'investor_id' => $request->investor_id,
                'project_id' => $request->project_id,
                'amount' => $request->amount,
                'description' => $request->description,
                'notes' => $request->notes,
                'status' => $request->status,
            ]);

            // إذا تغيرت الحالة
            if ($oldStatus != $request->status) {
                $statusMessages = [
                    'under_process' => 'جاري دراسة طلب الاستثمار',
                    'approved' => 'تم الموافقة على طلب الاستثمار',
                    'rejected' => 'تم رفض طلب الاستثمار',
                    'cancelled' => 'تم إلغاء طلب الاستثمار',
                ];

                if (isset($statusMessages[$request->status])) {
                    // تسجيل النشاط
                    InvestorActivityLog::create([
                        'investor_id' => $investmentRequest->investor_id,
                        'user_id' => auth()->id(),
                        'action' => 'investment_request_' . $request->status,
                        'description' => $statusMessages[$request->status],
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);

                    // إنشاء إشعار
                    InvestorNotification::create([
                        'investor_id' => $investmentRequest->investor_id,
                        'investment_request_id' => $investmentRequest->id,
                        'title' => 'تحديث حالة طلب الاستثمار',
                        'message' => $statusMessages[$request->status],
                        'type' => $request->status == 'approved' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'info'),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('investment-requests.index')
                ->with('success', 'تم تحديث طلب الاستثمار بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف طلب
     */
    public function destroy(InvestmentRequest $investmentRequest)
    {
        try {
            $investmentRequest->delete();
            return redirect()->route('investment-requests.index')
                ->with('success', 'تم حذف طلب الاستثمار بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تغيير حالة الطلب (API للأزرار السريعة)
     */
    public function changeStatus(Request $request, InvestmentRequest $investmentRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,under_process,approved,rejected,cancelled',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $investmentRequest->status;
            
            $updateData = [
                'status' => $request->status,
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ];

            if ($request->status == 'approved') {
                $updateData['approved_at'] = now();
            } elseif ($request->status == 'rejected') {
                $updateData['rejected_at'] = now();
                $updateData['rejection_reason'] = $request->rejection_reason;
            }

            $investmentRequest->update($updateData);

            // إشعار حسب الحالة
            $messages = [
                'under_process' => 'طلب الاستثمار قيد الدراسة',
                'approved' => 'تمت الموافقة على طلب الاستثمار',
                'rejected' => 'تم رفض طلب الاستثمار: ' . $request->rejection_reason,
            ];

            if (isset($messages[$request->status])) {
                InvestorNotification::create([
                    'investor_id' => $investmentRequest->investor_id,
                    'investment_request_id' => $investmentRequest->id,
                    'title' => 'تحديث حالة طلب الاستثمار',
                    'message' => $messages[$request->status],
                    'type' => $request->status == 'approved' ? 'success' : 'info',
                ]);
            }

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
        $request->validate([
            'message' => 'required|string',
        ]);

        try {
            InvestorNotification::create([
                'investor_id' => $investmentRequest->investor_id,
                'investment_request_id' => $investmentRequest->id,
                'title' => 'رسالة بخصوص طلب الاستثمار رقم: ' . $investmentRequest->request_number,
                'message' => $request->message,
                'type' => 'info',
            ]);

            return back()->with('success', 'تم إرسال الرسالة بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}