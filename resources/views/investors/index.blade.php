@extends('layouts.app')

@section('title', 'Investors')

@section('content')
<style>
    .investors-page .page-header-card {
        background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
        border-radius: 20px;
        padding: 28px 30px;
        color: #fff;
        box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
    }
    .badge-funding-requested {
    background: #eff6ff;
    color: #1d4ed8;
}

.badge-funding-interested {
    background: #fff7ed;
    color: #c2410c;
}

.badge-funding-approved {
    background: #ecfdf5;
    color: #15803d;
}

.badge-funding-rejected {
    background: #fef2f2;
    color: #dc2626;
}

    .investors-page .page-header-card h3 {
        margin: 0;
        font-weight: 700;
        color: #fff;
    }

    .investors-page .page-header-card p {
        margin: 8px 0 0;
        opacity: 0.9;
    }

    .investors-page .stats-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        border: 1px solid #eef2ff;
        height: 100%;
        transition: 0.3s ease;
    }

    .investors-page .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
    }

    .investors-page .stats-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 14px;
        color: #fff;
    }

    .investors-page .stats-icon.primary { background: linear-gradient(135deg, #1b00ff, #4f46e5); }
    .investors-page .stats-icon.success { background: linear-gradient(135deg, #16a34a, #22c55e); }
    .investors-page .stats-icon.danger { background: linear-gradient(135deg, #dc2626, #ef4444); }
    .investors-page .stats-icon.warning { background: linear-gradient(135deg, #d97706, #f59e0b); }
    .investors-page .stats-icon.info { background: linear-gradient(135deg, #0891b2, #06b6d4); }

    .investors-page .stats-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .investors-page .stats-label {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0;
    }

    .investors-page .table-card,
    .investors-page .filter-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .investors-page .table-card-header,
    .investors-page .filter-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .investors-page .table-card-header h5,
    .investors-page .filter-card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #0f172a;
    }
    .modern-table th {
    white-space: nowrap;
}

    .investors-page .modern-table {
        margin-bottom: 0;
        width: 100%;
        table-layout: auto;
    }
    .investors-page .modern-table thead th {
        background: #f8fafc;
        color: #334155;
        font-weight: 700;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 10px;
        vertical-align: middle;
        white-space: nowrap;
        font-size: 13px;
    }

    .investors-page .modern-table tbody td {
        padding: 14px 10px;
        vertical-align: middle;
        border-color: #f1f5f9;
        font-size: 13px;
        overflow: hidden;
    }

    .investors-page .modern-table tbody tr:hover {
        background: #fafcff;
    }
.col-id { width: 50px; }
.col-name { width: 200px; }
.col-company { width: 160px; }
.col-contact { width: 150px; }
.col-type { width: 130px; }
.col-budget { width: 110px; }
.col-status { width: 100px; }

/* 🔥 IMPORTANT */
.col-engagement { width: 220px; }

/* 🔥 FIX OVERLAP */
.col-date { width: 140px; }

/* 🔥 REDUCE THIS */
.col-actions { width: 160px; }

    .investors-page .investor-name {
        font-weight: 700;
        color: #1e293b;
        text-decoration: none;
        display: block;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .investors-page .investor-name:hover {
        color: #1b00ff;
        text-decoration: none;
    }

    .investors-page .td-ellipsis {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .investors-page .mini-text {
        font-size: 11px;
        color: #64748b;
        margin-top: 3px;
        line-height: 1.5;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .investors-page .badge-soft {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2px;
        white-space: nowrap;
    }

    .investors-page .badge-status-active {
        background: #ecfdf5;
        color: #15803d;
    }

    .investors-page .badge-status-inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    .investors-page .badge-status-default {
        background: #f1f5f9;
        color: #475569;
    }

    .investors-page .badge-archived {
        background: #fff7ed;
        color: #c2410c;
    }

    .investors-page .btn-add {
        background: linear-gradient(135deg, #1b00ff, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 20px rgba(27, 0, 255, 0.15);
    }

    .investors-page .btn-add:hover {
        color: #fff;
        text-decoration: none;
        opacity: 0.95;
    }

    .investors-page .btn-soft {
        border-radius: 12px;
        font-weight: 600;
        padding: 9px 14px;
        text-decoration: none;
        border: 1px solid #dbe4f0;
        background: #fff;
        color: #0f172a;
    }

    .investors-page .btn-soft:hover {
        text-decoration: none;
        color: #0f172a;
        background: #f8fafc;
    }

    .investors-page .btn-soft.active-filter {
        background: linear-gradient(135deg, #1b00ff, #4f46e5);
        color: #fff !important;
        border-color: transparent;
    }

    .investors-page .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .investors-page .icon-action {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.10);
    }

    .investors-page .icon-action:hover {
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .investors-page .icon-show { background: linear-gradient(135deg, #1b00ff, #4338ca); }
    .investors-page .icon-edit { background: linear-gradient(135deg, #0ea5e9, #2563eb); }
    .investors-page .icon-delete { background: linear-gradient(135deg, #dc2626, #ef4444); }
    .investors-page .icon-restore { background: linear-gradient(135deg, #16a34a, #22c55e); }
    .investors-page .icon-force { background: linear-gradient(135deg, #7f1d1d, #b91c1c); }

    .investors-page .empty-state {
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
    }

    .investors-page .empty-state i {
        font-size: 42px;
        margin-bottom: 12px;
        color: #cbd5e1;
    }

    .investors-page .filter-label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }

    .investors-page .form-control,
    .investors-page .form-select {
        border-radius: 12px;
        min-height: 42px;
        border: 1px solid #dbe4f0;
        box-shadow: none;
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 investors-page">
    <div class="min-height-200px">

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm" style="border-radius: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 14px;">
                {{ session('error') }}
            </div>
        @endif

        <div class="page-header-card mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                <div>
                    <h3>Investors Management</h3>
                    <p>Professional overview of investor profiles, budgets, statuses, archived records, and management actions.</p>
                </div>

                <div class="d-flex flex-wrap" style="gap: 10px;">
                    <a href="{{ route('admin.investors.export', 'xlsx') }}" class="btn btn-light btn-soft">
                        <i class="fa fa-file-excel mr-1"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.investors.create') }}" class="btn-add">
                        <i class="fa fa-plus mr-1"></i> Add Investor
                    </a>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon primary">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="stats-number">{{ $stats['total'] ?? 0 }}</div>
                    <p class="stats-label">Total Investors</p>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon success">
                        <i class="fa fa-user-check"></i>
                    </div>
                    <div class="stats-number">{{ $stats['active'] ?? 0 }}</div>
                    <p class="stats-label">Active</p>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon danger">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <div class="stats-number">{{ $stats['inactive'] ?? 0 }}</div>
                    <p class="stats-label">Inactive</p>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon info">
                        <i class="fa fa-archive"></i>
                    </div>
                    <div class="stats-number">{{ $stats['archived'] ?? 0 }}</div>
                    <p class="stats-label">Archived</p>
                </div>
            </div>

            <div class="col-xl-2 col-md-6 col-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon warning">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                    <div class="stats-number">${{ number_format($stats['budget'] ?? 0, 2) }}</div>
                    <p class="stats-label">Total Budget</p>
                </div>
            </div>

            <div class="col-xl-2 col-md-6 col-12 mb-3">
                <div class="stats-card">
                    <div class="stats-icon primary">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="stats-number" style="font-size: 16px;">
                        {{ $stats['top_company']->company ?? 'N/A' }}
                    </div>
                    <p class="stats-label">Top Company</p>
                </div>
            </div>
        </div>

        <div class="filter-card mb-4">
            <div class="filter-card-header">
                <div>
                    <h5>Filters</h5>
                    <small class="text-muted">Search and navigate active, archived, or all investors.</small>
                </div>

                <div class="d-flex flex-wrap" style="gap: 10px;">
                    <a href="{{ route('admin.investors.index', ['view' => 'active']) }}"
                       class="btn-soft {{ $view === 'active' ? 'active-filter' : '' }}">
                        <i class="fa fa-users mr-1"></i> Active Investors
                    </a>

                    <a href="{{ route('admin.investors.index', ['view' => 'archived']) }}"
                       class="btn-soft {{ $view === 'archived' ? 'active-filter' : '' }}">
                        <i class="fa fa-archive mr-1"></i> Archived Investors
                    </a>

                    <a href="{{ route('admin.investors.index', ['view' => 'all']) }}"
                       class="btn-soft {{ $view === 'all' ? 'active-filter' : '' }}">
                        <i class="fa fa-list mr-1"></i> All
                    </a>
                </div>
            </div>

            <div class="p-4">
                <form method="GET" action="{{ route('admin.investors.index') }}">
                    <input type="hidden" name="view" value="{{ request('view', 'active') }}">

                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="filter-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Name, email, or username" value="{{ request('search') }}">
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="filter-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="filter-label">City</label>
                            <input type="text" name="city" class="form-control" placeholder="City" value="{{ request('city') }}">
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="filter-label">Per Page</label>
                            <select name="per_page" class="form-select">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-12 mb-3 d-flex align-items-end">
                            <div class="w-100 d-flex" style="gap: 10px;">
                                <button type="submit" class="btn btn-primary w-100" style="border-radius: 12px; font-weight: 700;">
                                    <i class="fa fa-search mr-1"></i> Filter
                                </button>
                                <a href="{{ route('admin.investors.index', ['view' => request('view', 'active')]) }}"
                                   class="btn btn-light w-100"
                                   style="border-radius: 12px; font-weight: 700; border: 1px solid #dbe4f0;">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <h5>
                        @if($view === 'archived')
                            Archived Investors
                        @elseif($view === 'all')
                            All Investors
                        @else
                            Active Investors
                        @endif
                    </h5>
                    <small class="text-muted">Professional investor listing with archive and restore actions.</small>
                </div>
            </div>

            <div class="table-responsive">
<table class="table modern-table">
    <thead>
        <tr>
            <th class="col-id">#</th>
            <th class="col-name">Investor</th>
            <th class="col-company">Company</th>
            <th class="col-contact">Contact</th>
            <th class="col-type">Type</th>
            <th class="col-budget">Budget</th>
            <th class="col-status">Status</th>
            <th class="col-engagement">Engagement</th>
            <th class="col-date">Created</th>
            <th class="col-actions">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($investors as $inv)

            @php
                $profile = $inv->investor;

                $statusClass = match($inv->status) {
                    'active' => 'badge-status-active',
                    'inactive' => 'badge-status-inactive',
                    default => 'badge-status-default',
                };

                $engagement = [
                    'interested' => $profile?->investmentRequests?->where('status', 'interested')->count() ?? 0,
                    'requested'  => $profile?->investmentRequests?->where('status', 'requested')->count() ?? 0,
                    'approved'   => $profile?->investmentRequests?->where('status', 'approved')->count() ?? 0,
                    'rejected'   => $profile?->investmentRequests?->where('status', 'rejected')->count() ?? 0,
                ];
            @endphp

            <tr>
                <td>{{ $loop->iteration + ($investors->currentPage() - 1) * $investors->perPage() }}</td>

                {{-- Investor --}}
                <td>
                    @if($profile)
                        <a href="{{ route('admin.investors.show', $profile->user_id) }}" class="investor-name">
                            {{ $inv->name }}
                        </a>
                    @else
                        <span class="investor-name">{{ $inv->name }}</span>
                    @endif

                    <div class="mini-text">{{ $inv->email }}</div>
                    <div class="mini-text">Username: {{ $inv->username }}</div>
                </td>

                {{-- Company --}}
                <td>
                    <div>{{ $profile?->company ?? '—' }}</div>
                    <div class="mini-text">Position: {{ $profile?->position ?? '—' }}</div>
                </td>

                {{-- Contact --}}
                <td>
                    <div>{{ $profile?->phone ?? '—' }}</div>
                    <div class="mini-text">{{ $inv->city ?? '—' }}</div>
                </td>

                {{-- Type --}}
                <td>
                    <div>{{ $profile?->investment_type ?? '—' }}</div>
                    <div class="mini-text">Source: {{ $profile?->source ?? '—' }}</div>
                </td>

                {{-- Budget --}}
                <td>
                    {{ $profile && $profile->budget ? '$'.number_format($profile->budget,2) : '—' }}
                </td>

                {{-- Status --}}
                <td>
                    @if($profile && $profile->trashed())
                        <span class="badge-soft badge-archived">Archived</span>
                    @else
                        <span class="badge-soft {{ $statusClass }}">
                            {{ $inv->status }}
                        </span>
                    @endif
                </td>

                {{-- Engagement --}}
<td class="col-engagement">
    <div style="font-size:11px; max-width:200px; overflow:hidden;">

        <div style="display:flex; gap:4px; flex-wrap:wrap;">
            <span class="badge-soft badge-funding-interested">I: {{ $engagement['interested'] }}</span>
            <span class="badge-soft badge-funding-requested">R: {{ $engagement['requested'] }}</span>
            <span class="badge-soft badge-funding-approved">A: {{ $engagement['approved'] }}</span>
            <span class="badge-soft badge-funding-rejected">X: {{ $engagement['rejected'] }}</span>
        </div>

        @if($profile && $profile->investmentRequests->count())
            <div style="font-size:10px; color:#64748b;">
                @foreach($profile->investmentRequests->take(2) as $invItem)
                    <div style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        • {{ optional($invItem->project)->name }}
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</td>

                {{-- Created --}}
                <td>
                    <div>{{ $inv->created_at?->format('Y-m-d') }}</div>
                    <div class="mini-text">{{ $inv->created_at?->format('h:i A') }}</div>
                </td>

                {{-- Actions --}}
                <td>
                    <div class="action-buttons">
                        @if($profile)

                            <a href="{{ route('admin.investors.show', $profile->user_id) }}" class="icon-action icon-show">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.investors.edit', $profile->user_id) }}" class="icon-action icon-edit">
                                <i class="fa fa-pencil-alt"></i>
                            </a>

                            @if($profile->trashed())
                                <form action="{{ route('admin.investors.restore', $profile->user_id) }}" method="POST">
                                    @csrf
                                    <button class="icon-action icon-restore">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.investors.destroy', $profile->user_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="icon-action icon-delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            @endif

                        @endif
                    </div>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="10">
                    <div class="empty-state">
                        <i class="fa fa-users"></i>
                        <div>No investors found.</div>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
            </div>

            <div class="p-3">
                {{ $investors->links() }}
            </div>
        </div>

    </div>
</div>
@endsection