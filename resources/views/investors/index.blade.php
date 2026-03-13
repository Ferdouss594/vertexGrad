@extends('layouts.app')

@section('title', 'Investors - VertexGrad')

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

    .stats-card.total-investors {
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
    .stats-icon.light-purple {
        background: #f3e5f5;
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

    .btn-export {
        background: #28a745;
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

    .btn-export:hover {
        background: #218838;
        color: white;
    }

    .btn-import {
        background: #ffc107;
        color: #1b2c3f;
        height: 40px;
        padding: 0 20px;
        border-radius: 8px;
        font-size: 13px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-import:hover {
        background: #e0a800;
        color: #1b2c3f;
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
    #investorsTable {
        border-collapse: collapse;
        width: 100%;
    }

    /* تثبيت عرض الأعمدة */
    #investorsTable th:nth-child(1) { width: 4%; }  /* # */
    #investorsTable th:nth-child(2) { width: 14%; } /* Name */
    #investorsTable th:nth-child(3) { width: 12%; } /* Company */
    #investorsTable th:nth-child(4) { width: 10%; } /* Phone */
    #investorsTable th:nth-child(5) { width: 14%; } /* Email */
    #investorsTable th:nth-child(6) { width: 10%; } /* Position */
    #investorsTable th:nth-child(7) { width: 8%; }  /* Requests */
    #investorsTable th:nth-child(8) { width: 8%; }  /* Added */
    #investorsTable th:nth-child(9) { width: 20%; } /* Actions */

    /* رأس الجدول */
    #investorsTable thead th {
        background: #f8f9fa;
        color: #1b2c3f;
        font-weight: 600;
        font-size: 13px;
        padding: 15px 8px;
        border-bottom: 1px solid #e9ecef;
        white-space: nowrap;
        text-align: center;
    }

    /* خلايا الجدول */
    #investorsTable tbody td {
        padding: 12px 8px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
        font-size: 13px;
        color: #1b2c3f;
        text-align: center;
    }

    #investorsTable tbody td:first-child {
        text-align: center;
    }

    #investorsTable tbody td:nth-child(2) {
        text-align: left;
    }

    #investorsTable tbody tr {
        height: 70px;
        transition: all 0.2s;
    }

    #investorsTable tbody tr:hover {
        background: #f8f9fa;
    }

    /* Avatar */
    .investor-avatar {
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

    .investor-name {
        font-weight: 500;
        font-size: 14px;
        color: #1b2c3f;
        white-space: nowrap;
    }

    .investor-email {
        font-size: 12px;
        color: #6c757d;
    }

    /* Company Badge */
    .company-badge {
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
        background: #e8f4ff;
        color: #00b0f0;
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Position Badge */
    .position-badge {
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
        background: #f3e5f5;
        color: #7b1fa2;
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Request Badge */
    .request-badge {
        display: inline-block;
        text-decoration: none;
    }
    
    .request-count {
        background: #00b0f0;
        color: white;
        border-radius: 20px;
        padding: 5px 10px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
        min-width: 40px;
    }
    
    .request-label {
        font-size: 10px;
        color: #6c757d;
        margin-top: 2px;
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
        gap: 6px;
        flex-wrap: wrap;
    }

    .action-btn {
        width: 34px !important;
        height: 34px !important;
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
        transform: translateY(-2px);
    }

    .action-btn i {
        font-size: 15px !important;
    }

    .action-btn.view-btn i {
        color: #17a2b8;
    }

    .action-btn.edit-btn i {
        color: #00b0f0;
    }

    .action-btn.requests-btn i {
        color: #fd7e14;
    }

    .action-btn.delete-btn i {
        color: #dc3545;
    }

    .action-btn.delete-btn:hover {
        border-color: #dc3545 !important;
    }

    .action-btn.restore-btn i {
        color: #28a745;
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

    /* Hidden file input */
    #importFile {
        display: none;
    }
</style>

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4" style="padding-top: 20px;">
        <div>
            <h1 class="fw-bold mb-1" style="color: #1b2c3f; font-size: 28px; letter-spacing: -0.5px;">
                Investors
            </h1>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Manage and oversee all investors and their investment requests
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Investors -->
        <div class="col-md-2">
            <div class="stats-card total-investors p-3 d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-white-50 mb-0" style="font-size: 12px;">Total Investors</p>
                        <h4 class="text-white mb-0 fw-bold" style="font-size: 22px;">{{ $stats['total'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Investors -->
        <div class="col-md-2">
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

        <!-- Inactive Investors -->
        <div class="col-md-2">
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

        <!-- Total Budget -->
        <div class="col-md-2">
            <div class="stats-card p-3 d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-orange">
                        <i class="bi bi-cash-stack" style="color: #f57c00;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Total Budget</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">${{ number_format($stats['budget'] ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Requests -->
        <div class="col-md-2">
            <div class="stats-card p-3 d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-purple">
                        <i class="bi bi-files" style="color: #7b1fa2;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Total Requests</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $stats['total_requests'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Company -->
        <div class="col-md-2">
            <div class="stats-card p-3 d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-blue">
                        <i class="bi bi-building" style="color: #00b0f0;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Top Company</p>
                        <h6 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 14px;">{{ $stats['top_company']->company ?? 'N/A' }}</h6>
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

            <!-- Request Status Filter -->
            <div class="col-auto">
                <select class="filter-select" id="requestStatusFilter" style="width: 180px;">
                    <option value="">All Requests</option>
                    <option value="pending">Pending Requests</option>
                    <option value="under_process">Under Process</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <!-- Search -->
            <div class="col">
                <input type="text" class="filter-select" id="searchInput" placeholder="Search by name, email or company...">
            </div>

            <!-- Apply Button -->
            <div class="col-auto">
                <button class="btn-apply" id="applyFilters">Apply Filters</button>
            </div>

            <!-- Reset Button -->
            <div class="col-auto">
                <a href="{{ route('admin.investors.index') }}" class="btn-reset">Reset</a>
            </div>

            <!-- Action Buttons -->
            <div class="col-auto">
                <a href="{{ route('admin.investors.create') }}" class="btn-add">
                    <i class="bi bi-plus-circle"></i>
                    Add Investor
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.investment-requests.create') }}" class="btn-add" style="background: #fd7e14;">
                    <i class="bi bi-plus-circle"></i>
                    New Request
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.investors.export', 'xlsx') }}" class="btn-export">
                    <i class="bi bi-download"></i>
                    Export
                </a>
            </div>
            <div class="col-auto">
                <button class="btn-import" id="importBtn">
                    <i class="bi bi-upload"></i>
                    Import
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden file input for import -->
    <input type="file" id="importFile" accept=".xlsx,.xls,.csv">

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">
                <i class="bi bi-person-badge"></i>
                Investors List
            </h5>
            <div class="d-flex gap-3">
                <span class="text-muted" style="font-size: 13px;">Total: {{ $investors->total() }} investors</span>
                <span class="text-muted" style="font-size: 13px;">Total Requests: {{ $stats['total_requests'] ?? 0 }}</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="investorsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Requests</th>
                        <th>Added</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investors as $user)
                        @php
                            // الوصول إلى بيانات المستثمر من خلال العلاقة
                            $investorData = $user->investor;
                            
                            // طريقة آمنة للوصول إلى طلبات الاستثمار
                            $investmentRequests = optional($investorData)->investmentRequests;
                            
                            $requestCount = $investmentRequests ? $investmentRequests->count() : 0;
                            $pendingCount = $investmentRequests ? $investmentRequests->where('status', 'pending')->count() : 0;
                            $approvedCount = $investmentRequests ? $investmentRequests->where('status', 'approved')->count() : 0;
                        @endphp
                        <tr id="investor-{{ $user->id }}">
                            <td>{{ $loop->iteration + ($investors->currentPage() - 1) * $investors->perPage() }}</td>
                            <td style="text-align: left;">
                                <div class="d-flex align-items-center">
                                    <div class="investor-avatar">
                                        {{ strtoupper(substr($user->name ?? 'I', 0, 1)) }}
                                    </div>
                                    <div class="ms-2">
                                        <div class="investor-name">{{ $user->name ?? '—' }}</div>
                                        <div class="investor-email">{{ Str::limit($user->email ?? '—', 20) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="company-badge" title="{{ $investorData->company ?? '—' }}">
                                    {{ Str::limit($investorData->company ?? '—', 15) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $investorData->phone ?? '—' }}</span>
                            </td>
                            <td>
                                <div class="investor-email">{{ Str::limit($user->email ?? '—', 15) }}</div>
                            </td>
                            <td>
                                <span class="position-badge" title="{{ $investorData->position ?? '—' }}">
                                    {{ Str::limit($investorData->position ?? '—', 10) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.investment-requests.index', ['investor_id' => optional($investorData)->id]) }}" 
                                   class="request-badge text-decoration-none">
                                    <span class="request-count">{{ $requestCount }}</span>
                                    @if($pendingCount > 0)
                                        <span class="badge bg-warning text-dark ms-1" title="Pending requests">{{ $pendingCount }}</span>
                                    @endif
                                    @if($approvedCount > 0)
                                        <span class="badge bg-success ms-1" title="Approved requests">{{ $approvedCount }}</span>
                                    @endif
                                    <div class="request-label">طلبات</div>
                                </a>
                            </td>
                            <td>
                                <span class="text-muted">{{ optional($user->created_at)->format('Y-m-d') ?? '—' }}</span>
                            </td>
                            <td class="action-cell">
                                <div class="action-wrapper">
                                    <a href="{{ route('admin.investors.show', $user->id) }}" class="action-btn view-btn" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.investors.edit', $user->id) }}" class="action-btn edit-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.investment-requests.index', ['investor_id' => optional($investorData)->id]) }}" 
                                       class="action-btn requests-btn" 
                                       title="View Investment Requests ({{ $requestCount }})"
                                       style="border-color: #fd7e14;">
                                        <i class="bi bi-files" style="color: #fd7e14;"></i>
                                    </a>
                                    @if(isset($user->deleted_at) && $user->deleted_at)
                                        <button class="action-btn restore-btn restore-investor" data-id="{{ $user->id }}" title="Restore">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                        <button class="action-btn delete-btn force-delete-investor" data-id="{{ $user->id }}" title="Force Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @else
                                        <button class="action-btn delete-btn delete-investor" data-id="{{ $user->id }}" title="Archive">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2">No Investors Found</h5>
                                    <p class="text-muted mb-3">There are no investors in the system yet</p>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.investors.create') }}" class="btn-add">
                                            <i class="bi bi-plus-circle me-2"></i>Add First Investor
                                        </a>
                                        @if(Route::has('admin.investment-requests.create'))
                                        <a href="{{ route('admin.investment-requests.create') }}" class="btn-add" style="background: #fd7e14;">
                                            <i class="bi bi-plus-circle me-2"></i>Add Investment Request
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        @if($investors->hasPages())
        <div class="table-footer">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="pagination-info">
                    Showing {{ $investors->firstItem() ?? 0 }} to {{ $investors->lastItem() ?? 0 }} of {{ $investors->total() }} entries
                </div>
                <div class="pagination-wrapper">
                    {{ $investors->appends(request()->query())->links('pagination::bootstrap-4') }}
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
    const requestStatusFilter = document.getElementById('requestStatusFilter');
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

        if (requestStatusFilter.value) {
            url.searchParams.set('request_status', requestStatusFilter.value);
        } else {
            url.searchParams.delete('request_status');
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
    if (urlParams.has('request_status')) {
        requestStatusFilter.value = urlParams.get('request_status');
    }

    // Import functionality
    const importBtn = document.getElementById('importBtn');
    const importFile = document.getElementById('importFile');
    
    if (importBtn && importFile) {
        importBtn.addEventListener('click', function() {
            importFile.click();
        });
        
        importFile.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch("{{ route('admin.investors.import') }}", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Import successful!');
                    location.reload();
                } else {
                    alert('Import failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Import failed: ' + error.message);
            });
        });
    }

    // Soft Delete / Archive
    document.querySelectorAll('.delete-investor').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to archive this investor?')) return;
            
            const id = this.dataset.id;
            fetch(`/admin/investors/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById(`investor-${id}`);
                    if (row) row.remove();
                    alert('Investor archived successfully');
                } else {
                    alert('Failed to archive investor');
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });
    });

    // Restore
    document.querySelectorAll('.restore-investor').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/admin/investors/${id}/restore`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById(`investor-${id}`);
                    if (row) row.remove();
                    alert('Investor restored successfully');
                } else {
                    alert('Failed to restore investor');
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });
    });

    // Force Delete
    document.querySelectorAll('.force-delete-investor').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('This will permanently delete the investor! Are you sure?')) return;
            
            const id = this.dataset.id;
            fetch(`/admin/investors/${id}/force-delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById(`investor-${id}`);
                    if (row) row.remove();
                    alert('Investor permanently deleted');
                } else {
                    alert('Failed to delete investor');
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });
    });
});
</script>
@endsection