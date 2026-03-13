@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* ===== تنسيقات صفحة الطلاب بالضبط ===== */
    .container-fluid {
        max-width: 1600px;
        margin: 0 auto;
    }
     .modal-backdrop {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
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

    .stats-card.all-users {
        background: linear-gradient(135deg, #1b2c3f 0%, #2d3e50 100%);
    }

    .stats-card.add-user {
        background: #00b0f0;
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

    /* Filter Card - مثل صفحة الطلاب */
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

    /* Tabs - مثل صفحة الطلاب */
    .nav-tabs {
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .nav-tabs .nav-link {
        border: none;
        padding: 12px 20px;
        font-weight: 500;
        color: #6c757d;
        font-size: 14px;
        background: transparent;
        position: relative;
    }

    .nav-tabs .nav-link.active {
        color: #00b0f0;
        background: transparent;
    }

    .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #00b0f0;
    }

    /* Table - مثل صفحة الطلاب بالضبط */
    .table-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: none;
        overflow: hidden;
    }

    #usersTable {
        border-collapse: collapse;
        width: 100%;
    }

    /* تثبيت عرض الأعمدة */
    #usersTable th:nth-child(1) { width: 5%; }   /* # */
    #usersTable th:nth-child(2) { width: 15%; }  /* User */
    #usersTable th:nth-child(3) { width: 20%; }  /* Email */
    #usersTable th:nth-child(4) { width: 10%; }  /* Status */
    #usersTable th:nth-child(5) { width: 10%; }  /* Role */
    #usersTable th:nth-child(6) { width: 15%; }  /* Last Login */
    #usersTable th:nth-child(7) { width: 15%; }  /* Actions */

    /* رأس الجدول */
    #usersTable thead th {
        background: #f8f9fa;
        color: #1b2c3f;
        font-weight: 600;
        font-size: 13px;
        padding: 15px 12px;
        border-bottom: 1px solid #e9ecef;
        white-space: nowrap;
    }

    /* خلايا الجدول */
    #usersTable tbody td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
        font-size: 13px;
        color: #1b2c3f;
    }

    /* صفوف الجدول */
    #usersTable tbody tr {
        height: 70px;
        transition: all 0.2s;
    }

    #usersTable tbody tr:hover {
        background: #f8f9fa;
    }

    /* Avatar - مثل صفحة الطلاب */
    .user-avatar {
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

    .user-name {
        font-weight: 500;
        font-size: 14px;
        color: #1b2c3f;
    }

    .user-email {
        font-size: 12px;
        color: #6c757d;
    }

    /* Status Badges - مثل صفحة الطلاب */
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

    .status-pending {
        background: #fff3e0;
        color: #f57c00;
    }

    .status-inactive {
        background: #f5f5f5;
        color: #757575;
    }

    .status-disabled {
        background: #ffebee;
        color: #c62828;
    }

    /* Role Badges */
    .role-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
        background: #e8f4ff;
        color: #00b0f0;
    }

    /* Action Buttons - مثل صفحة الطلاب */
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
    }

    .action-btn:hover {
        background: #f8f9fa !important;
        border-color: #00b0f0 !important;
    }

    .action-btn i {
        font-size: 18px !important;
        color: #1b2c3f;
    }

    .action-btn:hover i {
        color: #00b0f0;
    }

    /* Dropdown - مثل صفحة الطلاب */
    .dropdown-menu {
        padding: 8px 0;
        margin-top: 5px;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        z-index: 1000;
    }

    .dropdown-item {
        padding: 8px 16px;
        font-size: 13px;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .dropdown-item i {
        width: 18px;
        margin-right: 8px;
        font-size: 14px;
    }

    .dropdown-item.text-danger i {
        color: #dc3545;
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

    /* Sort Arrows - مثل صفحة الطلاب */
    .sortable {
        cursor: pointer;
        user-select: none;
        transition: background-color 0.2s;
    }

    .sortable:hover {
        background-color: #e9ecef !important;
    }

    .sort-icon {
        font-size: 12px;
        color: #6c757d;
        margin-left: 5px;
    }

    .sortable.active .sort-icon {
        color: #00b0f0;
    }

    /* Details Row - مثل صفحة الطلاب */
    .details-row td {
        padding: 0 !important;
        background: #f8f9fa;
    }

    .user-details {
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .detail-item {
        padding: 10px;
        background: white;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .detail-item strong {
        font-size: 11px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: block;
        margin-bottom: 5px;
    }

    .detail-item span {
        font-size: 13px;
        color: #1b2c3f;
        font-weight: 500;
    }

    /* Pagination - مثل صفحة الطلاب */
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

    /* Modal - مثل صفحة الطلاب */
    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 15px 20px;
    }

    .modal-header .modal-title {
        color: #1b2c3f;
        font-weight: 600;
        font-size: 16px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 12px 20px;
    }
</style>

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4" style="padding-top: 20px;">
        <div>
            <h1 class="fw-bold mb-1" style="color: #1b2c3f; font-size: 28px; letter-spacing: -0.5px;">
                Users Management
            </h1>
            <p class="text-muted mb-0" style="font-size: 14px;">
                Manage and oversee all users in the system
            </p>
        </div>
    </div>

    <!-- Stats Cards - مثل صفحة الطلاب -->
    <div class="row g-3 mb-4">
        <!-- All Users -->
        <div class="col-md-2">
            <div class="stats-card all-users p-3 d-flex align-items-center" onclick="showTab('allTab')">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-white-50 mb-0" style="font-size: 12px;">Total Users</p>
                        <h4 class="text-white mb-0 fw-bold" style="font-size: 22px;">{{ $allUsers->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-md-2">
            <div class="stats-card p-3 d-flex align-items-center" onclick="showTab('pendingTab')">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-orange">
                        <i class="bi bi-clock-history" style="color: #ff9800;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Pending</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $pendingCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active -->
        <div class="col-md-2">
            <div class="stats-card p-3 d-flex align-items-center" onclick="showTab('activeTab')">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-blue">
                        <i class="bi bi-check-circle-fill" style="color: #00b0f0;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Active</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $activeCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inactive -->
        <div class="col-md-2">
            <div class="stats-card p-3 d-flex align-items-center" onclick="showTab('inactiveTab')">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon" style="background: #f5f5f5;">
                        <i class="bi bi-pause-circle-fill" style="color: #757575;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Inactive</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $inactiveCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disabled -->
        <div class="col-md-2">
            <div class="stats-card p-3 d-flex align-items-center" onclick="showTab('disabledTab')">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon light-red">
                        <i class="bi bi-x-circle-fill" style="color: #dc3545;"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Disabled</p>
                        <h4 class="mb-0 fw-bold" style="color: #1b2c3f; font-size: 22px;">{{ $disabledCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New User -->
        <div class="col-md-2">
            <div class="stats-card add-user p-3 d-flex align-items-center" onclick="window.location.href='{{ route('manager.users.create') }}'">
                <div class="d-flex align-items-center w-100">
                    <div class="stats-icon">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-white-50 mb-0" style="font-size: 12px;">Add New</p>
                        <h4 class="text-white mb-0 fw-bold" style="font-size: 22px;"><i class="bi bi-plus-circle"></i></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter - مثل صفحة الطلاب -->
    <div class="filter-card p-3">
        <div class="row g-2 align-items-center">
            <div class="col">
                <input type="text" class="filter-select w-100" id="searchInput" placeholder="Search by name or email...">
            </div>
            <div class="col">
                <select class="filter-select w-100" id="roleFilter">
                    <option value="">All Roles</option>
                    <option value="Student">Student</option>
                    <option value="Investor">Investor</option>
                    <option value="Manager">Manager</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <div class="col">
                <select class="filter-select w-100" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                    <option value="disabled">Disabled</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn-apply" id="applyFilters">Apply</button>
            </div>
            <div class="col-auto">
            
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#allTab">All Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pendingTab">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#activeTab">Active</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#inactiveTab">Inactive</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#disabledTab">Disabled</a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content">
        @php
            $tabs = [
                'allTab' => $allUsers,
                'pendingTab' => $pendingUsers,
                'activeTab' => $activeUsers,
                'inactiveTab' => $inactiveUsers,
                'disabledTab' => $disabledUsers,
            ];
        @endphp

        @foreach ($tabs as $tabId => $users)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}">
            <div class="table-card">
                <div class="table-responsive">
                    <table class="table" id="usersTable">
                        <thead>
                            <tr>
                                <th class="sortable" data-column="id"># <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th class="sortable" data-column="name">User <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th class="sortable" data-column="email">Email <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th class="sortable" data-column="status">Status <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th class="sortable" data-column="role">Role <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th class="sortable" data-column="last_login">Last Login <i class="bi bi-arrow-down-up sort-icon"></i></th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr class="user-row" data-user-id="{{ $user->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="ms-2">
                                            <div class="user-name">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-email">{{ $user->email }}</div>
                                </td>
                                <td>
                                    @php
                                    $statusClass = match($user->status) {
                                        'active' => 'status-active',
                                        'pending' => 'status-pending',
                                        'inactive' => 'status-inactive',
                                        'disabled' => 'status-disabled',
                                        default => 'status-inactive'
                                    };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="role-badge">{{ $user->role }}</span>
                                </td>
                                <td>
                                    <div class="last-login">
                                        {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('Y-m-d H:i') : '—' }}
                                        <small>{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->diffForHumans() : '' }}</small>
                                    </div>
                                </td>
                                <td class="action-cell">
                                    <div class="action-wrapper">
                                        <div class="dropdown">
                                            <button class="action-btn" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('manager.users.edit', $user->id) }}">
                                                        <i class="bi bi-pencil" style="color: #00b0f0;"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item btn-show-details" data-user-id="{{ $user->id }}">
                                                        <i class="bi bi-info-circle" style="color: #1b2c3f;"></i> Details
                                                    </button>
                                                </li>
                                                <li>
                                                    <form action="{{ route('manager.users.force-logout', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Force logout this user?')">
                                                            <i class="bi bi-box-arrow-right" style="color: #ff9800;"></i> Force Logout
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('manager.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="details-row" style="display:none;" data-user-id="{{ $user->id }}">
                                <td colspan="7">
                                    <div class="user-details" id="details-{{ $user->id }}">
                                        <div class="text-center p-3">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2">No Users Found</h5>
                                        <p class="text-muted mb-3">There are no users in this category</p>
                                        <a href="{{ route('manager.users.create') }}" class="btn" style="background: #00b0f0; color: white; padding: 8px 20px; border-radius: 8px; font-size: 13px;">
                                            <i class="bi bi-plus-circle me-2"></i>Add New User
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer with Pagination -->
              
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-badge me-2"></i>
                    User Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetailsModalBody">
                <div class="text-center p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabId) {
    const tabTriggerEl = document.querySelector(`a[href="#${tabId}"]`);
    if (tabTriggerEl) {
        const tab = new bootstrap.Tab(tabTriggerEl);
        tab.show();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Search and filter
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const applyBtn = document.getElementById('applyFilters');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const role = roleFilter.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        
        const rows = document.querySelectorAll('.tab-pane.active .user-row');
        
        rows.forEach(row => {
            const name = row.querySelector('.user-name')?.textContent.toLowerCase() || '';
            const email = row.querySelector('.user-email')?.textContent.toLowerCase() || '';
            const roleText = row.querySelector('.role-badge')?.textContent.toLowerCase() || '';
            const statusText = row.querySelector('.status-badge')?.textContent.toLowerCase() || '';
            
            const matchesSearch = searchTerm === '' || name.includes(searchTerm) || email.includes(searchTerm);
            const matchesRole = role === '' || roleText.includes(role);
            const matchesStatus = status === '' || statusText.includes(status);
            
            row.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
        });
    }

    applyBtn.addEventListener('click', applyFilters);
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') applyFilters();
    });

    // Show details
    document.querySelectorAll('.btn-show-details').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.stopPropagation();
            const userId = this.dataset.userId;
            const modalBody = document.getElementById('userDetailsModalBody');
            
            const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
            modal.show();

            try {
                const response = await fetch(`/manager/users/${userId}`);
                const data = await response.json();

                modalBody.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Full Name</strong>
                                <span>${data.name || '—'}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Email</strong>
                                <span>${data.email || '—'}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Role</strong>
                                <span>${data.role || '—'}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Status</strong>
                                <span class="status-badge status-${data.status || 'inactive'}">${data.status || '—'}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Last Login</strong>
                                <span>${data.last_login || '—'}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>IP Address</strong>
                                <span>${data.login_ip || '—'}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Device</strong>
                                <span>${data.device || '—'}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Browser</strong>
                                <span>${data.browser || '—'}</span>
                            </div>
                        </div>
                    </div>
                `;
            } catch (error) {
                modalBody.innerHTML = '<div class="alert alert-danger m-3">Failed to load user details</div>';
            }
        });
    });

    // Toggle details row
    document.querySelectorAll('.user-row').forEach(row => {
        row.addEventListener('click', async function(e) {
            if (e.target.closest('.dropdown') || e.target.closest('.btn-show-details') || e.target.closest('a') || e.target.closest('button')) {
                return;
            }

            const userId = this.dataset.userId;
            const detailsRow = document.querySelector(`.details-row[data-user-id="${userId}"]`);
            const detailsDiv = document.getElementById(`details-${userId}`);
            
            document.querySelectorAll('.details-row').forEach(r => {
                if (r !== detailsRow) r.style.display = 'none';
            });
            
            if (detailsRow.style.display === 'none') {
                detailsRow.style.display = '';
                
                try {
                    const response = await fetch(`/manager/users/${userId}`);
                    const data = await response.json();
                    
                    detailsDiv.innerHTML = `
                        <div class="detail-item">
                            <strong>Last Activity</strong>
                            <span>${data.last_activity || '—'}</span>
                        </div>
                        <div class="detail-item">
                            <strong>IP Address</strong>
                            <span>${data.login_ip || '—'}</span>
                        </div>
                        <div class="detail-item">
                            <strong>Device</strong>
                            <span>${data.device || '—'}</span>
                        </div>
                        <div class="detail-item">
                            <strong>Browser</strong>
                            <span>${data.browser || '—'}</span>
                        </div>
                        <div class="detail-item">
                            <strong>OS</strong>
                            <span>${data.os || '—'}</span>
                        </div>
                        <div class="detail-item">
                            <strong>Gender</strong>
                            <span>${data.gender || '—'}</span>
                        </div>
                        <div class="detail-item">
                            <strong>City</strong>
                            <span>${data.city || '—'}</span>
                        </div>
                        <div class="detail-item">
                            <strong>State</strong>
                            <span>${data.state || '—'}</span>
                        </div>
                    `;
                } catch (error) {
                    detailsDiv.innerHTML = '<div class="alert alert-danger">Failed to load details</div>';
                }
            } else {
                detailsRow.style.display = 'none';
            }
        });
    });

    // Sorting
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const column = this.dataset.column;
            const currentUrl = new URL(window.location.href);
            const currentSort = currentUrl.searchParams.get('sort');
            const currentDir = currentUrl.searchParams.get('direction');
            
            document.querySelectorAll('.sortable').forEach(h => h.classList.remove('active'));
            this.classList.add('active');
            
            if (currentSort === column) {
                currentUrl.searchParams.set('direction', currentDir === 'asc' ? 'desc' : 'asc');
            } else {
                currentUrl.searchParams.set('sort', column);
                currentUrl.searchParams.set('direction', 'asc');
            }
            
            window.location.href = currentUrl;
        });
    });
});
</script>
@endsection