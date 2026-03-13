@extends('layouts.app')

@section('title', 'Students - VertexGrad')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4" style="padding-top: 20px;">
        <div>
            <h1 class="fw-bold mb-1" style="color: #1b2c3f; font-size: 28px; letter-spacing: -0.5px;">
                Students
            </h1>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Manage and oversee all students enrolled in the platform
            </p>
        </div>
        <a href="{{ route('admin.students.create') }}" 
           class="btn d-flex align-items-center gap-2"
           style="background: #00b0f0; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 500; font-size: 14px;">
            <i class="bi bi-plus-circle" style="font-size: 16px;"></i>
            Add New Student
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0" style="background: linear-gradient(135deg, #1b2c3f 0%, #2d3e50 100%); border-radius: 12px; height: 100px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <div class="rounded-2 d-flex align-items-center justify-content-center" 
                             style="width: 48px; height: 48px; background: rgba(255,255,255,0.1); border-radius: 10px;">
                            <i class="bi bi-mortarboard-fill text-white" style="font-size: 22px;"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-white-50 mb-0" style="font-size: 12px;">Active Students</p>
                            <h4 class="text-white mb-0 fw-bold" style="font-size: 22px;">{{ $stats['active'] ?? 0 }}</h4>
                            <span style="color: rgba(255,255,255,0.7); font-size: 11px;">
                                {{ $stats['active_percentage'] ?? 0 }}% of total
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); height: 100px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <div class="rounded-2 d-flex align-items-center justify-content-center" 
                             style="width: 48px; height: 48px; background: #e8f4ff; border-radius: 10px;">
                            <i class="bi bi-folder-check" style="color: #00b0f0; font-size: 22px;"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0" style="font-size: 12px;">Total Projects</p>
                            <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $stats['total_projects'] ?? 0 }}</h4>
                            <span style="color: #28a745; font-size: 11px;">
                                ↑ {{ $stats['projects_increase'] ?? 0 }}% this month
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); height: 100px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <div class="rounded-2 d-flex align-items-center justify-content-center" 
                             style="width: 48px; height: 48px; background: #fff4e8; border-radius: 10px;">
                            <i class="bi bi-award" style="color: #ff9800; font-size: 22px;"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0" style="font-size: 12px;">Universities</p>
                            <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $stats['universities_count'] ?? 0 }}</h4>
                            <span style="color: #ff9800; font-size: 11px;">represented</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); height: 100px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <div class="rounded-2 d-flex align-items-center justify-content-center" 
                             style="width: 48px; height: 48px; background: #ffe8e8; border-radius: 10px;">
                            <i class="bi bi-clock-history" style="color: #dc3545; font-size: 22px;"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0" style="font-size: 12px;">Pending Approval</p>
                            <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $stats['pending'] ?? 0 }}</h4>
                            <span style="color: #dc3545; font-size: 11px;">need review</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 mb-4" style="border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.students.index') }}" id="filterForm">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <select name="status" class="form-select" style="height: 40px; border-radius: 8px; border: 1px solid #e9ecef; font-size: 13px;">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="university" class="form-select" style="height: 40px; border-radius: 8px; border: 1px solid #e9ecef; font-size: 13px;">
                            <option value="">All Universities</option>
                            @foreach($universities ?? [] as $university)
                                <option value="{{ $university }}" {{ request('university') == $university ? 'selected' : '' }}>
                                    {{ $university }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="major" class="form-select" style="height: 40px; border-radius: 8px; border: 1px solid #e9ecef; font-size: 13px;">
                            <option value="">All Majors</option>
                            @foreach($majors ?? [] as $major)
                                <option value="{{ $major }}" {{ request('major') == $major ? 'selected' : '' }}>
                                    {{ $major }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="year" class="form-select" style="height: 40px; border-radius: 8px; border: 1px solid #e9ecef; font-size: 13px;">
                            <option value="">All Years</option>
                            <option value="1" {{ request('year') == '1' ? 'selected' : '' }}>1st Year</option>
                            <option value="2" {{ request('year') == '2' ? 'selected' : '' }}>2nd Year</option>
                            <option value="3" {{ request('year') == '3' ? 'selected' : '' }}>3rd Year</option>
                            <option value="4" {{ request('year') == '4' ? 'selected' : '' }}>4th Year</option>
                            <option value="graduate" {{ request('year') == 'graduate' ? 'selected' : '' }}>Graduate</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="verification" class="form-select" style="height: 40px; border-radius: 8px; border: 1px solid #e9ecef; font-size: 13px;">
                            <option value="">All Verification</option>
                            <option value="verified" {{ request('verification') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="unverified" {{ request('verification') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn" style="background: #00b0f0; color: white; height: 40px; padding: 0 25px; border-radius: 8px; font-size: 13px;">
                            Apply
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.students.index') }}" class="btn btn-light" style="height: 40px; padding: 0 20px; border-radius: 8px; font-size: 13px;">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card border-0" style="border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 1000px;">
                    <thead style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                        <tr>
                            <th class="py-3 px-3" style="color: #1b2c3f; font-weight: 600; font-size: 13px;">Student</th>
                            <th class="py-3" style="color: #1b2c3f; font-weight: 600; font-size: 13px;">Contact</th>
                            <th class="py-3" style="color: #1b2c3f; font-weight: 600; font-size: 13px;">University/Major</th>
                            <th class="py-3 text-center" style="color: #1b2c3f; font-weight: 600; font-size: 13px;">Status</th>
                            <th class="py-3 text-center" style="color: #1b2c3f; font-weight: 600; font-size: 13px;">Projects</th>
                            <th class="py-3 text-center" style="color: #1b2c3f; font-weight: 600; font-size: 13px;">GPA</th>
                            <th class="py-3 text-center" style="color: #1b2c3f; font-weight: 600; font-size: 13px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $user)
                        @php
                            $student = $user->student;
                            // جلب المشاريع المرتبطة بهذا الطالب
                            $projects = $user->projects ?? collect();
                            $totalProjects = $projects->count();
                            $completedProjects = $projects->where('status', 'completed')->count();
                            
                            // الحصول على أول 3 مشاريع لعرضها في الـ Tooltip (اختياري)
                            $projectNames = $projects->take(3)->pluck('name')->implode(', ');
                        @endphp
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td class="px-3 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-2 d-flex align-items-center justify-content-center" 
                                         style="width: 36px; height: 36px; background: #e8f4ff; color: #00b0f0; font-weight: 600; font-size: 14px;">
                                        {{ substr($user->name, 0, 1) }}{{ substr($user->name, strpos($user->name, ' ') + 1, 1) ?? substr($user->name, 1, 1) }}
                                    </div>
                                    <div class="ms-2">
                                        <div style="font-weight: 500; font-size: 14px; color: #1b2c3f;">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2" style="font-size: 13px;">
                                <div>{{ $user->email }}</div>
                                <div style="font-size: 11px; color: #6c757d;">{{ $student->phone ?? '—' }}</div>
                            </td>
                            <td class="py-2" style="font-size: 13px;">
                                <div style="font-weight: 500;">{{ $student->university ?? '—' }}</div>
                                <div style="font-size: 11px; color: #6c757d;">
                                    {{ $student->major ?? '—' }}
                                    @if($student && $student->academic_year)
                                        • Year {{ $student->academic_year }}
                                    @endif
                                </div>
                            </td>
                            <td class="py-2 text-center">
                                @php
                                $statusColors = [
                                    'active' => ['bg' => '#e8f5e9', 'text' => '#2e7d32'],
                                    'pending' => ['bg' => '#fff3e0', 'text' => '#f57c00'],
                                    'inactive' => ['bg' => '#f5f5f5', 'text' => '#757575'],
                                    'banned' => ['bg' => '#ffebee', 'text' => '#c62828']
                                ];
                                $color = $statusColors[$user->status] ?? ['bg' => '#f5f5f5', 'text' => '#757575'];
                                @endphp
                                <span style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 4px 12px; border-radius: 30px; font-size: 12px; font-weight: 500;">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="py-2 text-center" style="font-size: 13px;">
                                @if($totalProjects > 0)
                                    <span style="font-weight: 600; color: #1b2c3f; cursor: help;" 
                                          title="Projects: {{ $projectNames }}">
                                        {{ $totalProjects }}
                                    </span>
                                    <span style="font-size: 11px; color: #6c757d; display: block;">
                                        {{ $completedProjects }} completed
                                    </span>
                                    <!-- رابط سريع لعرض كل المشاريع -->
                                    <a href="{{ route('admin.students.projects', $user->id) }}" 
                                       style="font-size: 10px; color: #00b0f0; text-decoration: none;">
                                        View all →
                                    </a>
                                @else
                                    <span style="font-weight: 600; color: #6c757d;">0</span>
                                    <span style="font-size: 11px; color: #6c757d; display: block;">no projects</span>
                                @endif
                            </td>
                            <td class="py-2 text-center">
                                <span style="font-weight: 600; color: #00b0f0; font-size: 15px;">{{ number_format($student->gpa ?? 0, 1) }}</span>
                            </td>
                            <td class="py-2 text-center">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" 
                                            style="padding: 4px 10px; border-radius: 6px; background: transparent; border: 1px solid #e9ecef;">
                                        <i class="bi bi-three-dots-vertical" style="font-size: 14px;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" style="border-radius: 8px; min-width: 180px;">
                                        <li>
                                            <a class="dropdown-item py-1" href="{{ route('admin.students.show', $user->id) }}" style="font-size: 13px;">
                                                <i class="bi bi-eye me-2" style="color: #00b0f0;"></i>View Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-1" href="{{ route('admin.students.edit', $user->id) }}" style="font-size: 13px;">
                                                <i class="bi bi-pencil me-2" style="color: #1b2c3f;"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-1" href="#" onclick="sendMessage({{ $user->id }}); return false;" style="font-size: 13px;">
                                                <i class="bi bi-envelope me-2" style="color: #ff9800;"></i>Message
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-1" href="{{ route('admin.students.projects', $user->id) }}" style="font-size: 13px;">
                                                <i class="bi bi-folder me-2" style="color: #4caf50;"></i>View Projects 
                                                @if($totalProjects > 0)
                                                    <span class="badge bg-primary rounded-pill ms-1" style="font-size: 10px;">{{ $totalProjects }}</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('admin.students.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item py-1 text-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this student?')"
                                                        style="font-size: 13px; width: 100%; text-align: left;">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div style="width: 80px; height: 80px; background: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                    <i class="bi bi-people fs-1" style="color: #1b2c3f; opacity: 0.3;"></i>
                                </div>
                                <h5 style="color: #1b2c3f;">No Students Found</h5>
                                <p class="text-muted mb-3">Get started by adding your first student</p>
                                <a href="{{ route('admin.students.create') }}" class="btn" style="background: #00b0f0; color: white; border-radius: 8px; padding: 10px 30px;">
                                    <i class="bi bi-plus-circle me-2"></i>Add Student
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="card-footer bg-white py-2 px-3" style="border-top: 1px solid #e9ecef;">
            <div class="d-flex justify-content-between align-items-center">
                <div style="font-size: 13px; color: #6c757d;">
                    Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} entries
                </div>
                <div>
                    {{ $students->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* تحسين المظهر العام */
.table > :not(caption) > * > * {
    padding: 0.5rem 0.75rem;
    border-bottom-width: 0;
}

.table-hover tbody tr:hover {
    background-color: #f8f9ff !important;
}

.dropdown-item {
    padding: 6px 16px;
}

.dropdown-item i {
    width: 18px;
    display: inline-block;
}

/* تحسين الـ cards */
.card {
    transition: all 0.2s ease;
}

/* تحسين الـ input */
.form-select, .form-control {
    font-size: 13px;
}

.form-select:focus, .form-control:focus {
    border-color: #00b0f0;
    box-shadow: 0 0 0 3px rgba(0, 176, 240, 0.1);
}

/* ضبط المسافات */
.container-fluid {
    max-width: 1600px;
    margin: 0 auto;
}

/* تنسيق badge المشاريع */
.badge.bg-primary {
    background-color: #00b0f0 !important;
}
</style>

@section('scripts')
<script>
function sendMessage(userId) {
    alert('Message feature coming soon! User ID: ' + userId);
    return false;
}

// تفعيل القوائم المنسدلة
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap !== 'undefined') {
        var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        dropdownElementList.forEach(function(dropdownToggleEl) {
            new bootstrap.Dropdown(dropdownToggleEl);
        });
    }
});
</script>
@endsection
@endsection