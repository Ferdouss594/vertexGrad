@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<style>
    .projects-page .page-header-card {
        background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
        border-radius: 20px;
        padding: 26px 28px;
        color: #fff;
        box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
    }

    .projects-page .page-header-card h3 {
        margin: 0;
        font-weight: 700;
        color: #fff;
        font-size: 28px;
    }

    .projects-page .page-header-card p {
        margin: 8px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .projects-page .stats-card {
        background: #fff;
        border-radius: 18px;
        padding: 20px;
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
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 12px;
        color: #fff;
    }

    .projects-page .stats-icon.primary { background: linear-gradient(135deg, #1b00ff, #4f46e5); }
    .projects-page .stats-icon.success { background: linear-gradient(135deg, #16a34a, #22c55e); }
    .projects-page .stats-icon.warning { background: linear-gradient(135deg, #d97706, #f59e0b); }
    .projects-page .stats-icon.info { background: linear-gradient(135deg, #0891b2, #06b6d4); }

    .projects-page .stats-number {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .projects-page .stats-label {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0;
        font-size: 13px;
    }

    .projects-page .table-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .projects-page .table-card-header {
        padding: 18px 22px;
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
        font-size: 18px;
    }

    .projects-page .modern-table {
        margin-bottom: 0;
        width: 100%;
        table-layout: fixed;
    }

    .projects-page .modern-table thead th {
        background: #f8fafc;
        color: #334155;
        font-weight: 800;
        border-bottom: 1px solid #e2e8f0;
        padding: 11px 6px;
        vertical-align: middle;
   
    white-space: normal;
    line-height: 1.25;
    text-align: center;
    font-size: 12px;

    }

    .projects-page .modern-table tbody td {
        padding: 11px 6px;
        vertical-align: middle;
        border-color: #f1f5f9;
        font-size: 16px;
        overflow: hidden;
    }

    .projects-page .modern-table tbody tr:hover {
        background: #fafcff;
    }

    .projects-page .col-id { width: 38px; }
    .projects-page .col-project { width: 160px; }
    .projects-page .col-student { width: 130px; }
    .projects-page .col-scan { width: 92px; }
    .projects-page .col-score { width: 72px; }
    .projects-page .col-reviews { width: 95px; }
    .projects-page .col-supervisor-score { width: 82px; }
    .projects-page .col-final-decision { width: 108px; }
    .projects-page .col-budget { width: 78px; }
    .projects-page .col-date { width: 88px; }
    .projects-page .col-actions { width: 124px; }

    .projects-page .project-name {
        font-weight: 700;
        color: #1e293b;
        text-decoration: none;
        display: block;
        max-width: 140px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 12px;
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
        font-size: 9px;
        color: #64748b;
        margin-top: 2px;
        line-height: 1.35;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .projects-page .badge-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 8px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .2px;
        white-space: nowrap;
        max-width: 100%;
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

    .projects-page .badge-status-default {
        background: #f1f5f9;
        color: #475569;
    }

    .projects-page .badge-final-published {
        background: #dcfce7;
        color: #166534;
    }

    .projects-page .badge-final-revision {
        background: #fef3c7;
        color: #92400e;
    }

    .projects-page .badge-final-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .projects-page .badge-final-pending {
        background: #e2e8f0;
        color: #334155;
    }

    .projects-page .review-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 22px;
        border-radius: 7px;
        font-weight: 800;
        font-size: 9px;
        margin-right: 2px;
    }

    .projects-page .review-approved {
        background: #dcfce7;
        color: #166534;
    }

    .projects-page .review-revision {
        background: #fef3c7;
        color: #92400e;
    }

    .projects-page .review-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .projects-page .score-box {
        font-weight: 800;
        color: #0f172a;
        font-size: 12px;
    }

    .projects-page .btn-add {
        background: linear-gradient(135deg, #1b00ff, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 20px rgba(27, 0, 255, 0.15);
        font-size: 13px;
    }

    .projects-page .btn-add:hover {
        color: #fff;
        text-decoration: none;
        opacity: 0.95;
    }

    .projects-page .action-buttons {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }

    .projects-page .icon-action {
        width: 28px;
        height: 28px;
        border: none;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.10);
        font-size: 11px;
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

    .projects-page .pagination-wrapper {
        padding: 22px 20px 26px;
        border-top: 1px solid #eef2f7;
        background: #fff;
        text-align: center;
    }

    .projects-page .pagination-info {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 14px;
    }

    .projects-page .clean-pagination {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .projects-page .clean-page-link {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 1px solid #dbe4f0;
        background: #fff;
        color: #334155;
        font-weight: 800;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        transition: all 0.22s ease;
    }

    .projects-page .clean-page-link:hover {
        text-decoration: none;
        color: #1b00ff;
        border-color: #c7d2fe;
        background: #f8fafc;
        transform: translateY(-1px);
    }

    .projects-page .clean-page-link.active {
        background: linear-gradient(135deg, #1b00ff, #4f46e5);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 10px 18px rgba(79, 70, 229, 0.25);
    }

    @media (max-width: 1400px) {
        .projects-page .modern-table thead th,
        .projects-page .modern-table tbody td {
            font-size: 10px;
            padding: 9px 5px;
        }

        .projects-page .project-name {
            max-width: 128px;
            font-size: 11px;
        }

        .projects-page .mini-text {
            font-size: 8px;
        }

        .projects-page .col-project { width: 150px; }
        .projects-page .col-student { width: 120px; }
        .projects-page .col-final-decision { width: 100px; }
        .projects-page .col-actions { width: 116px; }
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 projects-page">
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
                    <h3>Projects Management</h3>
                    <p>Clean professional overview of projects, scan results, supervisor reviews, final decisions, and actions.</p>
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
                    <div class="stats-number">{{ $totalProjects ?? 0 }}</div>
                    <p class="stats-label">Total Projects</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon success">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="stats-number">{{ $completedProjects ?? 0 }}</div>
                    <p class="stats-label">Completed Projects</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon warning">
                        <i class="fa fa-clock"></i>
                    </div>
                    <div class="stats-number">{{ $pendingProjects ?? 0 }}</div>
                    <p class="stats-label">Pending / Review</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon info">
                        <i class="fa fa-chart-line"></i>
                    </div>
                    <div class="stats-number">{{ isset($avgScore) && $avgScore !== null ? number_format($avgScore, 1) : '0.0' }}</div>
                    <p class="stats-label">Average Scan Score</p>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <h5>All Projects</h5>
                    <small class="text-muted">Compact clean view without unnecessary columns.</small>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th class="col-id">#</th>
                            <th class="col-project">Project</th>
                           <th class="col-student">Student<br>Team</th>
                            <th class="col-scan">Scan</th>
                            <th class="col-score">Score</th>
                            <th class="col-reviews">Reviews</th>
                            <th class="col-supervisor-score">Supervisor<br>Avg</th>
                        <th class="col-final-decision">Final<br>Decision</th>
                            <th class="col-budget">Budget</th>
                            <th class="col-date">Created</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($projects as $project)
                            @php
                                $scanClass = match($project->scanner_status) {
                                    'completed' => 'badge-scan-completed',
                                    'failed' => 'badge-scan-failed',
                                    'pending' => 'badge-scan-pending',
                                    default => 'badge-status-default',
                                };

                                $approvedReviews = $project->reviews->where('decision', 'approved')->count();
                                $revisionReviews = $project->reviews->where('decision', 'revision_requested')->count();
                                $rejectedReviews = $project->reviews->where('decision', 'rejected')->count();
                                $supervisorAvgScore = round($project->reviews->whereNotNull('score')->avg('score') ?? 0, 1);

                                $finalDecisionClass = match($project->final_decision) {
                                    'published' => 'badge-final-published',
                                    'revision_requested' => 'badge-final-revision',
                                    'rejected' => 'badge-final-rejected',
                                    default => 'badge-final-pending',
                                };

                                $finalDecisionText = match($project->final_decision) {
                                    'published' => 'Published',
                                    'revision_requested' => 'Revision Requested',
                                    'rejected' => 'Rejected',
                                    default => 'Pending',
                                };
                            @endphp

                            <tr>
                                <td>{{ $projects->firstItem() + $loop->index }}</td>

                                <td>
                                    <a href="{{ route('admin.projects.show', $project) }}" class="project-name">
                                        {{ $project->name ?? 'Untitled Project' }}
                                    </a>
                                    <div class="mini-text td-ellipsis">#{{ $project->project_id ?? $project->id }}</div>
                                    <div class="mini-text td-ellipsis">{{ $project->category ?? 'No category' }}</div>
                                </td>

                                <td>
                                    <div class="td-ellipsis">{{ $project->student->name ?? '—' }}</div>
                                    <div class="mini-text td-ellipsis">{{ $project->student->email ?? 'No email' }}</div>
                                    <div class="mini-text td-ellipsis">{{ $project->supervisor->name ?? 'No supervisor' }}</div>
                                </td>

                                <td>
                                    <span class="badge-soft {{ $scanClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $project->scanner_status ?? 'not scanned')) }}
                                    </span>
                                    <div class="mini-text td-ellipsis">ID: {{ $project->scanner_project_id ?? '—' }}</div>
                                </td>

                                <td>
                                    <div class="score-box">
                                        {{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '—' }}
                                    </div>
                                    <div class="mini-text td-ellipsis">{{ $project->grade ?? 'No grade' }}</div>
                                </td>

                                <td>
                                    <span class="review-chip review-approved" title="Approved">{{ $approvedReviews }}</span>
                                    <span class="review-chip review-revision" title="Revision Requested">{{ $revisionReviews }}</span>
                                    <span class="review-chip review-rejected" title="Rejected">{{ $rejectedReviews }}</span>
                                </td>

                                <td>
                                    <div class="score-box">
                                        {{ $project->reviews->count() ? number_format($supervisorAvgScore, 1) : '—' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge-soft {{ $finalDecisionClass }}">
                                        {{ $finalDecisionText }}
                                    </span>
                                    <div class="mini-text td-ellipsis">{{ $project->finalDecisionMaker->name ?? '—' }}</div>
                                </td>

                                <td>
                                    {{ $project->budget !== null ? number_format($project->budget, 0) : '—' }}
                                </td>

                                <td>
                                    <div>{{ optional($project->created_at)->format('Y-m-d') ?? '—' }}</div>
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

                                        @if(in_array($project->status, ['active', 'approved']))
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
                                <td colspan="11">
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

            @if(method_exists($projects, 'links') && $projects->lastPage() > 1)
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing {{ $projects->firstItem() ?? 0 }} to {{ $projects->lastItem() ?? 0 }}
                        of {{ $projects->total() ?? 0 }} projects
                    </div>

                    <div class="clean-pagination">
                        @for($page = 1; $page <= $projects->lastPage(); $page++)
                            <a href="{{ $projects->url($page) }}"
                               class="clean-page-link {{ $projects->currentPage() === $page ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endfor
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection