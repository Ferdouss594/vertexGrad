<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestmentRequest extends Model
{
    use SoftDeletes;

    protected $table = 'investment_requests';

    protected $fillable = [
        'investor_id',
        'request_number',
        'amount',
        'description',
        'notes',
        'status',
        'processed_at',
        'approved_at',
        'rejected_at',
        'processed_by',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =============== العلاقات ===============
    
    /**
     * المستثمر صاحب الطلب
     */
    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    /**
     * المشروع المرتبط بالطلب (اختياري)
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * المستخدم الذي قام بمعالجة الطلب
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * سجل النشاطات المرتبطة بالطلب
     */
    public function activities()
    {
        return $this->morphMany(InvestorActivityLog::class, 'loggable');
    }

    /**
     * الرسائل المرتبطة بالطلب
     */
    public function messages()
    {
        return $this->hasMany(InvestorMessage::class, 'investment_request_id');
    }

    /**
     * الإشعارات المرتبطة بالطلب
     */
    public function notifications()
    {
        return $this->hasMany(InvestorNotification::class, 'investment_request_id');
    }

    // =============== Scopes ===============

    /**
     * Scope للطلبات المعلقة
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope للطلبات قيد الدراسة
     */
    public function scopeUnderProcess($query)
    {
        return $query->where('status', 'under_process');
    }

    /**
     * Scope للطلبات المقبولة
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope للطلبات المرفوضة
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope للطلبات الملغاة
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope للطلبات التي لم تعالج بعد
     */
    public function scopeUnprocessed($query)
    {
        return $query->whereNull('processed_at');
    }

    /**
     * Scope للطلبات التي تمت معالجتها
     */
    public function scopeProcessed($query)
    {
        return $query->whereNotNull('processed_at');
    }

    // =============== Accessors ===============

    /**
     * الحصول على نص الحالة بالعربية
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'قيد الانتظار',
            'under_process' => 'قيد الدراسة',
            'approved' => 'تمت الموافقة',
            'rejected' => 'مرفوض',
            'cancelled' => 'ملغي',
            default => $this->status
        };
    }

    /**
     * الحصول على لون الحالة
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'under_process' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * الحصول على badge الحالة
     */
    public function getStatusBadgeAttribute()
    {
        return "<span class='badge bg-{$this->status_color}'>{$this->status_text}</span>";
    }

    /**
     * الحصول على المبلغ منسق
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' ج.م';
    }

    /**
     * الحصول على وقت المعالجة
     */
    public function getProcessedTimeAttribute()
    {
        return $this->processed_at ? $this->processed_at->format('Y-m-d H:i') : '—';
    }

    // =============== Methods ===============

    /**
     * توليد رقم طلب فريد
     */
    public static function generateRequestNumber()
    {
        $prefix = 'INV-' . date('Ymd');
        $lastRequest = self::where('request_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRequest) {
            $lastNumber = intval(substr($lastRequest->request_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . '-' . $newNumber;
    }

    /**
     * الموافقة على الطلب
     */
    public function approve($userId = null)
    {
        $this->update([
            'status' => 'approved',
            'processed_by' => $userId ?? auth()->id(),
            'processed_at' => now(),
            'approved_at' => now(),
        ]);

        // تسجيل النشاط
        InvestorActivityLog::create([
            'investor_id' => $this->investor_id,
            'user_id' => $userId ?? auth()->id(),
            'action' => 'investment_approved',
            'description' => 'تمت الموافقة على طلب الاستثمار رقم: ' . $this->request_number,
            'loggable_type' => self::class,
            'loggable_id' => $this->id,
        ]);

        return $this;
    }

    /**
     * رفض الطلب
     */
    public function reject($reason, $userId = null)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'processed_by' => $userId ?? auth()->id(),
            'processed_at' => now(),
            'rejected_at' => now(),
        ]);

        // تسجيل النشاط
        InvestorActivityLog::create([
            'investor_id' => $this->investor_id,
            'user_id' => $userId ?? auth()->id(),
            'action' => 'investment_rejected',
            'description' => 'تم رفض طلب الاستثمار رقم: ' . $this->request_number . ' - السبب: ' . $reason,
            'loggable_type' => self::class,
            'loggable_id' => $this->id,
        ]);

        return $this;
    }

    /**
     * بدء دراسة الطلب
     */
    public function startProcess($userId = null)
    {
        $this->update([
            'status' => 'under_process',
            'processed_by' => $userId ?? auth()->id(),
            'processed_at' => now(),
        ]);

        // تسجيل النشاط
        InvestorActivityLog::create([
            'investor_id' => $this->investor_id,
            'user_id' => $userId ?? auth()->id(),
            'action' => 'investment_processing',
            'description' => 'بدأ دراسة طلب الاستثمار رقم: ' . $this->request_number,
            'loggable_type' => self::class,
            'loggable_id' => $this->id,
        ]);

        return $this;
    }

    /**
     * إلغاء الطلب
     */
    public function cancel($userId = null)
    {
        $this->update([
            'status' => 'cancelled',
            'processed_by' => $userId ?? auth()->id(),
            'processed_at' => now(),
        ]);

        // تسجيل النشاط
        InvestorActivityLog::create([
            'investor_id' => $this->investor_id,
            'user_id' => $userId ?? auth()->id(),
            'action' => 'investment_cancelled',
            'description' => 'تم إلغاء طلب الاستثمار رقم: ' . $this->request_number,
            'loggable_type' => self::class,
            'loggable_id' => $this->id,
        ]);

        return $this;
    }

    /**
     * التحقق مما إذا كان الطلب معلقاً
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * التحقق مما إذا كان الطلب قيد الدراسة
     */
    public function isUnderProcess()
    {
        return $this->status === 'under_process';
    }

    /**
     * التحقق مما إذا كان الطلب مقبولاً
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * التحقق مما إذا كان الطلب مرفوضاً
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * التحقق مما إذا كان الطلب ملغياً
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}