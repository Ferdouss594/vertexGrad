@extends('layouts.app')

@section('title', 'Managers - VertexGrad')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* ===== إزالة الشاشة السوداء للـ Modal بشكل نهائي ===== */
    .modal-backdrop {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }
    
    body.modal-open {
        overflow: auto !important;
        padding-right: 0 !important;
    }
    
    .modal {
        background: transparent !important;
    }

    /* ===== تنسيقات صفحة الطلاب ===== */
    .container-fluid {
        max-width: 1600px;
        margin: 0 auto;
    }

    /* Stats Cards - مثل صفحة الطلاب */
    .stats-card {
        border-radius: 12px;
        height: 100px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: none;
        transition: all 0.2s;
        cursor: pointer;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .stats-card.total-managers {
        background: linear-gradient(135deg, #1b2c3f 0%, #2d3e50 100%);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stats-icon i {
        font-size: 22px;
        color: white;
    }

    .stats-icon.light-blue {
        background: #e8f4ff;
    }
    .stats-icon.light-orange {
        background: #fff4e8;
    }
    .stats-icon.light-red {
        background: #ffe8e8;
    }
    .stats-icon.light-green {
        background: #e8f5e9;
    }

    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: none;
        margin-bottom: 20px;
    }

    .filter-select {
        height: 40px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        font-size: 13px;
        padding: 0 12px;
        width: 100%;
    }

    .filter-select:focus {
        border-color: #00b0f0;
        outline: none;
    }

    .btn-apply {
        background: #00b0f0;
        color: white;
        height: 40px;
        padding: 0 25px;
        border-radius: 8px;
        font-size: 13px;
        border: none;
    }

    .btn-apply:hover {
        background: #0099cc;
    }

    .btn-reset {
        background: #f8f9fa;
        color: #1b2c3f;
        height: 40px;
        padding: 0 20px;
        border-radius: 8px;
        font-size: 13px;
        border: 1px solid #e9ecef;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-add {
        background: #00b0f0;
        color: white;
        height: 40px;
        padding: 0 20px;
        border-radius: 8px;
        font-size: 13px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        background: #0099cc;
        color: white;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: none;
        overflow: hidden;
    }

    .table-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .table-title {
        font-weight: 600;
        color: #1b2c3f;
        font-size: 16px;
        margin: 0;
    }

    .table-title i {
        color: #00b0f0;
        margin-right: 8px;
    }

    /* Table */
    #managersTable {
        border-collapse: collapse;
        width: 100%;
    }

    /* تثبيت عرض الأعمدة */
    #managersTable th:nth-child(1) { width: 5%; }
    #managersTable th:nth-child(2) { width: 20%; }
    #managersTable th:nth-child(3) { width: 20%; }
    #managersTable th:nth-child(4) { width: 15%; }
    #managersTable th:nth-child(5) { width: 15%; }
    #managersTable th:nth-child(6) { width: 15%; }

    /* رأس الجدول */
    #managersTable thead th {
        background: #f8f9fa;
        color: #1b2c3f;
        font-weight: 600;
        font-size: 13px;
        padding: 15px 12px;
        border-bottom: 1px solid #e9ecef;
        white-space: nowrap;
    }

    /* خلايا الجدول */
    #managersTable tbody td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
        font-size: 13px;
        color: #1b2c3f;
    }

    #managersTable tbody tr {
        height: 70px;
        transition: all 0.2s;
    }

    #managersTable tbody tr:hover {
        background: #f8f9fa;
    }

    /* Avatar */
    .manager-avatar {
        width: 36px;
        height: 36px;
        background: #e8f4ff;
        color: #00b0f0;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .manager-name {
        font-weight: 500;
        font-size: 14px;
        color: #1b2c3f;
    }

    .manager-email {
        font-size: 12px;
        color: #6c757d;
    }

    /* Status Badges */
    .status-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-inactive {
        background: #ffebee;
        color: #c62828;
    }

    /* Department Badge */
    .department-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
        background: #e8f4ff;
        color: #00b0f0;
    }

    /* Last Login */
    .last-login {
        font-size: 13px;
        color: #1b2c3f;
    }

    .last-login small {
        font-size: 11px;
        color: #6c757d;
        display: block;
    }

    /* Action Buttons */
    .action-cell {
        padding: 0 !important;
        text-align: center !important;
        vertical-align: middle !important;
    }

    .action-wrapper {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        height: 70px !important;
        width: 100%;
        gap: 8px;
    }

    .action-btn {
        width: 36px !important;
        height: 36px !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 6px !important;
        border: 1px solid #e9ecef !important;
        background: white !important;
        transition: all 0.2s;
        cursor: pointer;
        flex-shrink: 0;
        text-decoration: none;
    }

    .action-btn:hover {
        background: #f8f9fa !important;
        border-color: #00b0f0 !important;
    }

    .action-btn i {
        font-size: 16px !important;
    }

    .action-btn.edit-btn i {
        color: #00b0f0;
    }

    .action-btn.delete-btn i {
        color: #dc3545;
    }

    .action-btn.delete-btn:hover {
        border-color: #dc3545 !important;
    }

    /* Pagination */
    .table-footer {
        background: white;
        padding: 15px 20px;
        border-top: 1px solid #e9ecef;
    }

    .pagination-info {
        font-size: 13px;
        color: #6c757d;
    }

    .pagination-wrapper .pagination {
        margin-bottom: 0;
    }

    .pagination-wrapper .page-link {
        border: none;
        color: #1b2c3f;
        font-size: 13px;
        padding: 0.25rem 0.5rem;
        background: transparent;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: transparent;
        color: #00b0f0;
        font-weight: 600;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .empty-icon i {
        font-size: 40px;
        color: #1b2c3f;
        opacity: 0.3;
    }

    /* Show entries select */
    .show-entries {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .show-entries label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 0;
        white-space: nowrap;
    }

    .show-entries select {
        width: 70px;
        height: 36px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        font-size: 13px;
        padding: 0 8px;
    }
</style>

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4" style="padding-top: 20px;">
        <div>
            <h1 class="fw-bold mb-1" style="color: #1b2c3f; font-size: 28px; letter-spacing: -0.5px;">
                Managers
            </h1>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Manage and oversee all managers in the system
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Managers -->
        <div class="col-md-3">
            <div class="stats-card total-managers p-3 d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-white-50 mb-0" style="font-size: 12px;">Total Managers</p>
                        <h4 class="text-white mb-0 fw-bold" style="font-size: 22px;">{{ $stats['total'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Managers -->
        <div class="col-md-3">
            <div class="stats-card p-3 d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-green">
                        <i class="bi bi-check-circle-fill" style="color: #2e7d32;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Active</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $stats['active'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inactive Managers -->
        <div class="col-md-3">
            <div class="stats-card p-3 d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-red">
                        <i class="bi bi-x-circle-fill" style="color: #c62828;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Inactive</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $stats['inactive'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-md-3">
            <div class="stats-card p-3 d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-orange">
                        <i class="bi bi-building" style="color: #f57c00;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Departments</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $stats['departments'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="filter-card p-3">
        <div class="row g-3 align-items-center">
            <!-- Show entries -->
            <div class="col-auto">
                <div class="show-entries">
                    <label>Show</label>
                    <select id="perPageSelect" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
                        <option value="25" {{ request('per_page')==25?'selected':'' }}>25</option>
                        <option value="50" {{ request('per_page')==50?'selected':'' }}>50</option>
                        <option value="100" {{ request('per_page')==100?'selected':'' }}>100</option>
                    </select>
                    <label>entries</label>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="col-auto">
                <select class="filter-select" id="statusFilter" style="width: 150px;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>

            <!-- Search -->
            <div class="col">
                <input type="text" class="filter-select" id="searchInput" placeholder="Search by name or email...">
            </div>

            <!-- Apply Button -->
            <div class="col-auto">
                <button class="btn-apply" id="applyFilters">Apply Filters</button>
            </div>

            <!-- Reset Button -->
            <div class="col-auto">
                <a href="{{ route('manager.index') }}" class="btn-reset">Reset</a>
            </div>

            <!-- Add Button -->
            <div class="col-auto">
                <a href="{{ route('manager.create') }}" class="btn-add">
                    <i class="bi bi-plus-circle"></i>
                    Add Manager
                </a>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">
                <i class="bi bi-person-badge"></i>
                Managers List
            </h5>
            <div class="d-flex gap-2">
                <span class="text-muted" style="font-size: 13px;">Total: {{ $managers->total() }} managers</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="managersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Manager</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Last Login</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($managers as $manager)
                    <tr>
                        <td>{{ $loop->iteration + ($managers->currentPage() - 1) * $managers->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="manager-avatar">
                                    {{ $manager->user ? strtoupper(substr($manager->user->name, 0, 1)) : 'M' }}
                                </div>
                                <div class="ms-2">
                                    <div class="manager-name">{{ $manager->user->name ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="manager-email">{{ $manager->user->email ?? '—' }}</div>
                        </td>
                        <td>
                            <span class="department-badge">{{ $manager->department ?? '—' }}</span>
                        </td>
                        <td>
                            <div class="last-login">
                                {{ $manager->last_login ? \Carbon\Carbon::parse($manager->last_login)->format('Y-m-d H:i') : '—' }}
                                <small>{{ $manager->last_login ? \Carbon\Carbon::parse($manager->last_login)->diffForHumans() : '' }}</small>
                            </div>
                        </td>
                        <td class="action-cell">
                            <div class="action-wrapper">
                                <a href="{{ route('manager.edit', $manager->id) }}" class="action-btn edit-btn" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('manager.destroy', $manager->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this manager?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <h5 class="fw-bold mb-2">No Managers Found</h5>
                                <p class="text-muted mb-3">There are no managers in the system yet</p>
                                <a href="{{ route('manager.create') }}" class="btn-add">
                                    <i class="bi bi-plus-circle me-2"></i>Add First Manager
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        @if($managers->hasPages())
        <div class="table-footer">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="pagination-info">
                    Showing {{ $managers->firstItem() ?? 0 }} to {{ $managers->lastItem() ?? 0 }} of {{ $managers->total() }} entries
                </div>
                <div class="pagination-wrapper">
                    {{ $managers->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// إزالة أي backdrops موجودة
function removeBackdrops() {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
}

// مراقبة إضافة أي backdrops جديدة
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        mutation.addedNodes.forEach(function(node) {
            if (node.nodeType === 1 && node.classList.contains('modal-backdrop')) {
                node.remove();
            }
        });
    });
});

observer.observe(document.body, { childList: true, subtree: true });

// Change per page
function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url;
}

document.addEventListener('DOMContentLoaded', function() {
    // Remove any existing backdrops
    removeBackdrops();
    
    // Filters
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const applyBtn = document.getElementById('applyFilters');

    function applyFilters() {
        const url = new URL(window.location.href);
        
        if (searchInput.value) {
            url.searchParams.set('search', searchInput.value);
        } else {
            url.searchParams.delete('search');
        }
        
        if (statusFilter.value) {
            url.searchParams.set('status', statusFilter.value);
        } else {
            url.searchParams.delete('status');
        }
        
        window.location.href = url;
    }

    applyBtn.addEventListener('click', applyFilters);
    
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') applyFilters();
    });

    // Initialize with URL params
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('search')) {
        searchInput.value = urlParams.get('search');
    }
    if (urlParams.has('status')) {
        statusFilter.value = urlParams.get('status');
    }
});
</script>

@endsection