<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investor;
use App\Models\User;
use App\Models\InvestorActivityLog;
use App\Models\InvestorVerification;
use App\Models\InvestorBlockHistory;
use App\Models\InvestorInterestedProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InvestorController extends Controller
{
    /**
     * عرض جميع المستثمرين
     */
    public function index(Request $request)
    {
        $query = Investor::with(['user', 'investmentRequests' => function($q) {
            $q->latest();
        }]);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب التحقق
        if ($request->filled('verification')) {
            $query->whereHas('verifications', function($q) use ($request) {
                $q->where('verification_status', $request->verification);
            });
        }

        // بحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('company', 'like', "%{$search}%");
        }

        $investors = $query->paginate($request->get('per_page', 10));

        // إحصائيات
        $stats = [
            'total' => Investor::count(),
            'active' => Investor::where('status', 'Active')->count(),
            'inactive' => Investor::where('status', 'Inactive')->count(),
            'pending_verification' => InvestorVerification::where('verification_status', 'pending')->count(),
            'verified' => InvestorVerification::where('verification_status', 'verified')->count(),
            'total_budget' => Investor::sum('budget') ?? 0,
        ];

        return view('admin.investors.index', compact('investors', 'stats'));
    }

    /**
     * عرض نموذج إضافة مستثمر جديد
     */
    public function create()
    {
        return view('admin.investors.create');
    }

    /**
     * حفظ مستثمر جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:150',
            'position' => 'nullable|string|max:150',
            'investment_type' => 'nullable|string|max:100',
            'budget' => 'nullable|numeric|min:0',
            'source' => 'nullable|string|max:100',
            'status' => 'required|in:Active,Inactive',
        ]);

        DB::beginTransaction();
        try {
            // إنشاء المستخدم
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Investor',
                'status' => strtolower($request->status),
            ]);

            // إنشاء المستثمر
            $investor = Investor::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'company' => $request->company,
                'position' => $request->position,
                'investment_type' => $request->investment_type,
                'budget' => $request->budget,
                'source' => $request->source,
                'notes' => $request->notes,
                'status' => $request->status,
            ]);

            // تسجيل النشاط
            InvestorActivityLog::create([
                'investor_id' => $investor->id,
                'user_id' => auth()->id(),
                'action' => 'create',
                'description' => 'تم إضافة مستثمر جديد',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();
            return redirect()->route('admin.investors.index')
                ->with('success', 'تم إضافة المستثمر بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * عرض تفاصيل مستثمر
     */
    public function show(Investor $investor)
    {
        $investor->load([
            'user',
            'investmentRequests' => function($q) {
                $q->latest();
            },
            'interestedProjects.project',
            'activityLogs' => function($q) {
                $q->latest()->limit(20);
            },
            'verifications',
            'blockHistory' => function($q) {
                $q->latest();
            }
        ]);

        $interestedProjects = Project::whereIn('id', 
            $investor->interestedProjects->pluck('project_id')
        )->get();

        return view('admin.investors.show', compact('investor', 'interestedProjects'));
    }

    /**
     * عرض نموذج تعديل مستثمر
     */
    public function edit(Investor $investor)
    {
        $investor->load('user');
        return view('admin.investors.edit', compact('investor'));
    }

    /**
     * تحديث بيانات مستثمر
     */
    public function update(Request $request, Investor $investor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $investor->user_id,
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:150',
            'position' => 'nullable|string|max:150',
            'investment_type' => 'nullable|string|max:100',
            'budget' => 'nullable|numeric|min:0',
            'source' => 'nullable|string|max:100',
            'status' => 'required|in:Active,Inactive',
        ]);

        DB::beginTransaction();
        try {
            $oldData = $investor->toArray();

            // تحديث المستخدم
            $investor->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'status' => strtolower($request->status),
            ]);

            // تحديث المستثمر
            $investor->update([
                'phone' => $request->phone,
                'company' => $request->company,
                'position' => $request->position,
                'investment_type' => $request->investment_type,
                'budget' => $request->budget,
                'source' => $request->source,
                'notes' => $request->notes,
                'status' => $request->status,
            ]);

            // تسجيل النشاط
            InvestorActivityLog::create([
                'investor_id' => $investor->id,
                'user_id' => auth()->id(),
                'action' => 'update',
                'description' => 'تم تحديث بيانات المستثمر',
                'old_data' => json_encode($oldData),
                'new_data' => json_encode($investor->toArray()),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();
            return redirect()->route('admin.investors.index')
                ->with('success', 'تم تحديث بيانات المستثمر بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف مستثمر
     */
    public function destroy(Investor $investor)
    {
        DB::beginTransaction();
        try {
            // تسجيل النشاط قبل الحذف
            InvestorActivityLog::create([
                'investor_id' => $investor->id,
                'user_id' => auth()->id(),
                'action' => 'delete',
                'description' => 'تم حذف المستثمر',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // حذف المستخدم (سيحذف المستثمر تلقائياً بسبب cascade)
            $investor->user->delete();

            DB::commit();
            return redirect()->route('admin.investors.index')
                ->with('success', 'تم حذف المستثمر بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حظر مستثمر
     */
    public function block(Request $request, Investor $investor)
    {
        $request->validate([
            'block_type' => 'required|in:temporary,permanent',
            'reason' => 'required|string',
            'blocked_until' => 'required_if:block_type,temporary|nullable|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            // تحديث حالة المستخدم
            $investor->user->update([
                'account_status' => 'blocked',
                'blocked_until' => $request->blocked_until,
                'block_reason' => $request->reason,
            ]);

            // تسجيل في سجل الحظر
            InvestorBlockHistory::create([
                'investor_id' => $investor->id,
                'block_type' => $request->block_type,
                'action' => 'blocked',
                'reason' => $request->reason,
                'blocked_until' => $request->blocked_until,
                'performed_by' => auth()->id(),
                'created_at' => now(),
            ]);

            // تسجيل النشاط
            InvestorActivityLog::create([
                'investor_id' => $investor->id,
                'user_id' => auth()->id(),
                'action' => 'block',
                'description' => 'تم حظر المستثمر - ' . $request->reason,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();
            return back()->with('success', 'تم حظر المستثمر بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * فك حظر مستثمر
     */
    public function unblock(Request $request, Investor $investor)
    {
        DB::beginTransaction();
        try {
            // تحديث حالة المستخدم
            $investor->user->update([
                'account_status' => 'active',
                'blocked_until' => null,
                'block_reason' => null,
            ]);

            // تسجيل في سجل الحظر
            InvestorBlockHistory::create([
                'investor_id' => $investor->id,
                'block_type' => 'temporary',
                'action' => 'unblocked',
                'reason' => $request->reason ?? 'تم فك الحظر',
                'performed_by' => auth()->id(),
                'created_at' => now(),
            ]);

            // تسجيل النشاط
            InvestorActivityLog::create([
                'investor_id' => $investor->id,
                'user_id' => auth()->id(),
                'action' => 'unblock',
                'description' => 'تم فك حظر المستثمر',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();
            return back()->with('success', 'تم فك حظر المستثمر بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تحديث حالة التحقق
     */
    public function updateVerification(Request $request, Investor $investor)
    {
        $request->validate([
            'verification_status' => 'required|in:pending,verified,rejected',
            'rejection_reason' => 'required_if:verification_status,rejected|nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $verification = $investor->verifications()->firstOrNew([]);
            
            $oldStatus = $verification->verification_status;
            
            $verification->fill([
                'verification_status' => $request->verification_status,
                'verified_by' => auth()->id(),
                'verified_at' => $request->verification_status === 'verified' ? now() : null,
                'rejected_at' => $request->verification_status === 'rejected' ? now() : null,
                'rejection_reason' => $request->rejection_reason,
            ])->save();

            // تسجيل النشاط
            InvestorActivityLog::create([
                'investor_id' => $investor->id,
                'user_id' => auth()->id(),
                'action' => 'verification_update',
                'description' => 'تم تحديث حالة التحقق: ' . $request->verification_status,
                'old_data' => json_encode(['status' => $oldStatus]),
                'new_data' => json_encode(['status' => $request->verification_status]),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();
            return back()->with('success', 'تم تحديث حالة التحقق بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * إضافة مشروع يهتم به المستثمر
     */
    public function addInterestedProject(Request $request, Investor $investor)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'interest_level' => 'required|in:low,medium,high',
        ]);

        try {
            InvestorInterestedProject::updateOrCreate(
                [
                    'investor_id' => $investor->id,
                    'project_id' => $request->project_id,
                ],
                [
                    'interest_level' => $request->interest_level,
                    'notes' => $request->notes,
                    'last_viewed_at' => now(),
                ]
            );

            return back()->with('success', 'تم إضافة المشروع إلى قائمة اهتمامات المستثمر');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * إزالة مشروع من اهتمامات المستثمر
     */
    public function removeInterestedProject(Investor $investor, $projectId)
    {
        try {
            InvestorInterestedProject::where('investor_id', $investor->id)
                ->where('project_id', $projectId)
                ->delete();

            return back()->with('success', 'تم إزالة المشروع من قائمة الاهتمامات');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}