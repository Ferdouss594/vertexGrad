@extends('layouts.app')

@section('content')
<div class="container-fluid" dir="rtl">
    <h1 class="h3 mb-4">📊 تحليلات المحادثات</h1>
    
    <!-- الإحصائيات -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>إجمالي المحادثات</h5>
                    <h2>{{ $stats['total_chats'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>محادثات اليوم</h5>
                    <h2>{{ $stats['chats_today'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>متوسط التقييم</h5>
                    <h2>{{ number_format($stats['avg_rating'] ?? 0, 1) }}/5</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>نسبة الحل</h5>
                    <h2>{{ number_format($stats['resolved_rate'] ?? 0, 1) }}%</h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- أكثر الأسئلة شيوعاً -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>🔝 أكثر الأسئلة شيوعاً</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>السؤال</th>
                        <th>عدد المرات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commonQuestions ?? [] as $question)
                    <tr>
                        <td>{{ $question->message }}</td>
                        <td><span class="badge bg-primary">{{ $question->count }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center">لا توجد بيانات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- المحادثات غير المحلولة -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>⚠️ محادثات تحتاج متابعة</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>الرسالة</th>
                        <th>التاريخ</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($unresolvedChats ?? [] as $chat)
                    <tr>
                        <td>{{ $chat->user_name ?? 'زائر' }}</td>
                        <td>{{ Str::limit($chat->message, 50) }}</td>
                        <td>{{ isset($chat->created_at) ? \Carbon\Carbon::parse($chat->created_at)->diffForHumans() : '-' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">رد</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">لا توجد محادثات غير محلولة</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- آخر المحادثات -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>🕐 آخر المحادثات</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>المستخدم</th>
                            <th>الرسالة</th>
                            <th>الرد</th>
                            <th>التقييم</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentChats ?? [] as $chat)
                        <tr>
                            <td>{{ $chat->user_name ?? 'زائر' }}</td>
                            <td>{{ Str::limit($chat->message, 30) }}</td>
                            <td>{{ Str::limit($chat->response, 30) }}</td>
                            <td>
                                @if($chat->rating)
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fas fa-star {{ $i <= $chat->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ isset($chat->created_at) ? \Carbon\Carbon::parse($chat->created_at)->diffForHumans() : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">لا توجد محادثات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- زر التصدير -->
    <div class="mt-4">
        <a href="{{ route('admin.chat.export') }}" class="btn btn-success">
            <i class="fas fa-download"></i> تصدير التقرير
        </a>
    </div>
</div>
@endsection