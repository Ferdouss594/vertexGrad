@extends('layouts.app')

@section('title', 'Projects')

@section('content')
@php
    $totalProjects = $projects->count();
    $completedProjects = $projects->where('status', 'completed')->count();
    $pendingProjects = $projects->whereIn('status', ['pending', 'scan_requested', 'awaiting_manual_review'])->count();
    $avgScore = $projects->whereNotNull('scan_score')->avg('scan_score');
@endphp

<style>
    .projects-page .page-header-card {
        background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
        border-radius: 20px;
        padding: 28px 30px;
        color: #fff;
        box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
    }

    .projects-page .page-header-card h3 {
        margin: 0;
        font-weight: 700;
        color: #fff;
    }

    .projects-page .page-header-card p {
        margin: 8px 0 0;
        opacity: 0.9;
    }

    .projects-page .stats-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        border: 1px solid #eef2ff;
        height: 100%;
        transition: 0.3s ease;
    }

    .projects-page .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
    }

    .projects-page .stats-icon {
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

    .projects-page .stats-icon.primary { background: linear-gradient(135deg, #1b00ff, #4f46e5); }
    .projects-page .stats-icon.success { background: linear-gradient(135deg, #16a34a, #22c55e); }
    .projects-page .stats-icon.warning { background: linear-gradient(135deg, #d97706, #f59e0b); }
    .projects-page .stats-icon.info { background: linear-gradient(135deg, #0891b2, #06b6d4); }

    .projects-page .stats-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .projects-page .stats-label {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0;
    }

    .projects-page .table-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .projects-page .table-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .projects-page .table-card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #0f172a;
    }

    .projects-page .modern-table {
        margin-bottom: 0;
        width: 100%;
        table-layout: fixed;
    }

    .projects-page .modern-table thead th {
        background: #f8fafc;
        color: #334155;
        font-weight: 700;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 10px;
        vertical-align: middle;
        white-space: nowrap;
        font-size: 13px;
    }

    .projects-page .modern-table tbody td {
        padding: 12px 10px;
        vertical-align: middle;
        border-color: #f1f5f9;
        font-size: 13px;
        overflow: hidden;
    }

    .projects-page .modern-table tbody tr:hover {
        background: #fafcff;
    }

    .projects-page .col-id { width: 45px; }
    .projects-page .col-project { width: 190px; }
    .projects-page .col-student { width: 150px; }
    .projects-page .col-status { width: 115px; }
    .projects-page .col-scan { width: 115px; }
    .projects-page .col-score { width: 85px; }
    .projects-page .col-risk { width: 90px; }
    .projects-page .col-budget { width: 95px; }
    .projects-page .col-date { width: 110px; }
    .projects-page .col-actions { width: 165px; }

    .projects-page .project-name {
        font-weight: 700;
        color: #1e293b;
        text-decoration: none;
        display: block;
        max-width: 170px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .projects-page .project-name:hover {
        color: #1b00ff;
        text-decoration: none;
    }

    .projects-page .td-ellipsis {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .projects-page .mini-text {
        font-size: 11px;
        color: #64748b;
        margin-top: 3px;
        line-height: 1.5;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .projects-page .badge-soft {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2px;
        white-space: nowrap;
    }

    .projects-page .badge-status-pending,
    .projects-page .badge-status-scan_requested,
    .projects-page .badge-status-awaiting_manual_review {
        background: #fff7ed;
        color: #c2410c;
    }

    .projects-page .badge-status-active,
    .projects-page .badge-status-approved,
    .projects-page .badge-status-published {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .projects-page .badge-status-completed {
        background: #ecfdf5;
        color: #15803d;
    }

    .projects-page .badge-status-rejected,
    .projects-page .badge-status-scan_failed,
    .projects-page .badge-status-failed {
        background: #fef2f2;
        color: #dc2626;
    }

    .projects-page .badge-status-default {
        background: #f1f5f9;
        color: #475569;
    }

    .projects-page .badge-scan-completed {
        background: #ecfdf5;
        color: #15803d;
    }

    .projects-page .badge-scan-pending {
        background: #fff7ed;
        color: #c2410c;
    }

    .projects-page .badge-scan-failed {
        background: #fef2f2;
        color: #dc2626;
    }

    .projects-page .badge-risk-low {
        background: #ecfdf5;
        color: #15803d;
    }

    .projects-page .badge-risk-medium {
        background: #fef3c7;
        color: #b45309;
    }

    .projects-page .badge-risk-high {
        background: #fee2e2;
        color: #dc2626;
    }

    .projects-page .score-box {
        font-weight: 800;
        color: #0f172a;
    }

    .projects-page .btn-view {
        background: linear-gradient(135deg, #1b00ff, #4338ca);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 7px 14px;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .projects-page .btn-view:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(27, 0, 255, 0.20);
        text-decoration: none;
    }

    .projects-page .btn-add {
        background: linear-gradient(135deg, #1b00ff, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 20px rgba(27, 0, 255, 0.15);
    }

    .projects-page .btn-add:hover {
        color: #fff;
        text-decoration: none;
        opacity: 0.95;
    }

    .projects-page .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .projects-page .icon-action {
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

    .projects-page .icon-action:hover {
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .projects-page .icon-show { background: linear-gradient(135deg, #1b00ff, #4338ca); }
    .projects-page .icon-edit { background: linear-gradient(135deg, #0ea5e9, #2563eb); }
    .projects-page .icon-approve { background: linear-gradient(135deg, #16a34a, #22c55e); }
    .projects-page .icon-publish { background: linear-gradient(135deg, #7c3aed, #a855f7); }
    .projects-page .icon-delete { background: linear-gradient(135deg, #dc2626, #ef4444); }

    .projects-page .action-form {
        display: inline-block;
        margin: 0;
    }

    .projects-page .action-form button {
        cursor: pointer;
    }

    .projects-page .empty-state {
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
    }

    .projects-page .empty-state i {
        font-size: 42px;
        margin-bottom: 12px;
        color: #cbd5e1;
    }

    @media (max-width: 1400px) {
        .projects-page .modern-table thead th,
        .projects-page .modern-table tbody td {
            font-size: 12px;
            padding: 10px 8px;
        }

        .projects-page .project-name {
            max-width: 150px;
        }

        .projects-page .col-actions {
            width: 150px;
        }
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 projects-page">
    <div class="min-height-200px">

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm" style="border-radius: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="page-header-card mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                <div>
                    <h3>Projects Management</h3>
                    <p>Professional overview of all submitted projects, scan status, scores, and responsible users.</p>
                </div>

                <a href="{{ route('admin.projects.create') }}" class="btn-add">
                    <i class="fa fa-plus mr-1"></i> Add Project
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon primary">
                        <i class="fa fa-folder-open"></i>
                    </div>
                    <div class="stats-number">{{ $totalProjects }}</div>
                    <p class="stats-label">Total Projects</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon success">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="stats-number">{{ $completedProjects }}</div>
                    <p class="stats-label">Completed Projects</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon warning">
                        <i class="fa fa-clock"></i>
                    </div>
                    <div class="stats-number">{{ $pendingProjects }}</div>
                    <p class="stats-label">Pending / Review</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon info">
                        <i class="fa fa-chart-line"></i>
                    </div>
                    <div class="stats-number">{{ $avgScore ? number_format($avgScore, 1) : '0.0' }}</div>
                    <p class="stats-label">Average Scan Score</p>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <h5>All Projects</h5>
                    <small class="text-muted">Compact professional view without horizontal scrolling.</small>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th class="col-id">#</th>
                            <th class="col-project">Project</th>
                            <th class="col-student">Student / Team</th>
                            <th class="col-status">Status</th>
                            <th class="col-scan">Scan</th>
                            <th class="col-score">Score</th>
                            <th class="col-risk">Risk</th>
                            <th class="col-budget">Budget</th>
                            <th class="col-date">Created</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($projects as $project)
                            @php
                                $statusClass = match($project->status) {
                                    'pending', 'scan_requested', 'awaiting_manual_review' => 'badge-status-pending',
                                    'active', 'approved', 'published' => 'badge-status-active',
                                    'completed' => 'badge-status-completed',
                                    'rejected', 'scan_failed', 'failed' => 'badge-status-rejected',
                                    default => 'badge-status-default',
                                };

                                $scanClass = match($project->scanner_status) {
                                    'completed' => 'badge-scan-completed',
                                    'failed' => 'badge-scan-failed',
                                    'pending' => 'badge-scan-pending',
                                    default => 'badge-status-default',
                                };

                                $riskClass = match(strtolower($project->risk_level ?? '')) {
                                    'low' => 'badge-risk-low',
                                    'medium' => 'badge-risk-medium',
                                    'high' => 'badge-risk-high',
                                    default => 'badge-status-default',
                                };
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <a href="{{ route('admin.projects.show', $project) }}" class="project-name">
                                        {{ $project->name ?? 'Untitled Project' }}
                                    </a>
                                    <div class="mini-text td-ellipsis">
                                        ID: {{ $project->project_id ?? $project->id }}
                                    </div>
                                    <div class="mini-text td-ellipsis">
                                        {{ $project->category ?? 'No category' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="td-ellipsis">{{ $project->student->name ?? '—' }}</div>
                                    <div class="mini-text td-ellipsis">{{ $project->student->email ?? 'No email' }}</div>
                                    <div class="mini-text td-ellipsis">Supervisor: {{ $project->supervisor->name ?? '—' }}</div>
                                    <div class="mini-text td-ellipsis">Manager: {{ $project->manager->name ?? '—' }}</div>
                                </td>

                                <td>
                                    <span class="badge-soft {{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $project->status ?? 'unknown')) }}
                                    </span>
                                    <div class="mini-text td-ellipsis">
                                        Investor: {{ $project->investor->name ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge-soft {{ $scanClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $project->scanner_status ?? 'not scanned')) }}
                                    </span>
                                    <div class="mini-text td-ellipsis">
                                        Scanner ID: {{ $project->scanner_project_id ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="score-box">
                                        {{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '—' }}
                                    </div>
                                    <div class="mini-text td-ellipsis">
                                        {{ $project->grade ?? 'No grade' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge-soft {{ $riskClass }}">
                                        {{ $project->risk_level ?? '—' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $project->budget !== null ? number_format($project->budget, 2) : '—' }}
                                </td>

                                <td>
                                    <div>{{ optional($project->created_at)->format('Y-m-d') ?? '—' }}</div>
                                    <div class="mini-text">{{ optional($project->created_at)->format('h:i A') ?? '' }}</div>
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.projects.show', $project) }}" class="icon-action icon-show" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.projects.edit', $project) }}" class="icon-action icon-edit" title="Edit">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>

                                        @if(in_array($project->status, ['pending', 'scan_requested', 'awaiting_manual_review']))
                                            <form action="{{ route('admin.projects.approve', $project) }}" method="POST" class="action-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="icon-action icon-approve" title="Approve"
                                                    onclick="return confirm('Approve this project?')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($project->status, ['approved']))
                                            <form action="{{ route('admin.projects.publish', $project) }}" method="POST" class="action-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="icon-action icon-publish" title="Publish"
                                                    onclick="return confirm('Publish this project?')">
                                                    <i class="fa fa-upload"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="action-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-action icon-delete" title="Delete"
                                                onclick="return confirm('Delete this project?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="fa fa-folder-open"></i>
                                        <div>No projects found.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection