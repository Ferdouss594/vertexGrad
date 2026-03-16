@extends('layouts.app')
@section('title','Project Details')

@section('content')
@php
    $scanReport = $project->scan_report;

    if (is_string($scanReport)) {
        $decoded = json_decode($scanReport, true);
        $scanReport = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }

    $scanSummary = data_get($scanReport, 'summary', []);
    $scanInfo = data_get($scanReport, 'scan', []);
    $scanProject = data_get($scanReport, 'project', []);
    $highlights = data_get($scanReport, 'highlights', []);
    $recommendations = data_get($scanReport, 'recommendations', []);

    $statusClass = match($project->status) {
        'pending', 'scan_requested', 'awaiting_manual_review' => 'warning',
        'active', 'approved', 'published' => 'primary',
        'completed' => 'success',
        'rejected', 'scan_failed', 'failed' => 'danger',
        default => 'secondary',
    };

    $scannerStatusClass = match($project->scanner_status) {
        'completed' => 'success',
        'pending' => 'warning',
        'failed' => 'danger',
        default => 'secondary',
    };

    $riskLevel = $project->risk_level ?? data_get($scanInfo, 'risk_level');
    $riskClass = match(strtolower($riskLevel ?? '')) {
        'low' => 'success',
        'medium' => 'warning',
        'high' => 'danger',
        default => 'secondary',
    };
@endphp

<style>
    .project-details-page .hero-card {
        border: 0;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
        color: #fff;
    }

    .project-details-page .hero-card .card-body {
        padding: 32px;
    }

    .project-details-page .hero-title {
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 10px;
        color: #fff;
    }

    .project-details-page .hero-desc {
        color: rgba(255,255,255,.9);
        max-width: 900px;
        line-height: 1.8;
        margin-bottom: 18px;
    }

    .project-details-page .hero-badges .badge {
        font-size: 13px;
        padding: 8px 12px;
        border-radius: 999px;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .project-details-page .info-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        height: 100%;
    }

    .project-details-page .info-card .card-body {
        padding: 22px;
    }

    .project-details-page .mini-stat-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .project-details-page .mini-stat-value {
        color: #0f172a;
        font-size: 20px;
        font-weight: 800;
        line-height: 1.3;
    }

    .project-details-page .section-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .project-details-page .section-card .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px 20px;
    }

    .project-details-page .section-card .card-header h3,
    .project-details-page .section-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #0f172a;
    }

    .project-details-page .detail-grid .item {
        padding: 14px 0;
        border-bottom: 1px dashed #e5e7eb;
    }

    .project-details-page .detail-grid .item:last-child {
        border-bottom: 0;
    }

    .project-details-page .detail-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .project-details-page .detail-value {
        font-size: 15px;
        color: #0f172a;
        font-weight: 600;
        word-break: break-word;
    }

    .project-details-page .summary-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
        height: 100%;
    }

    .project-details-page .summary-box h6 {
        font-weight: 700;
        margin-bottom: 12px;
        color: #0f172a;
    }

    .project-details-page .summary-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .project-details-page .summary-list li {
        padding: 8px 0;
        border-bottom: 1px dashed #e5e7eb;
        color: #334155;
    }

    .project-details-page .summary-list li:last-child {
        border-bottom: 0;
    }

    .project-details-page .scan-score-box {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-radius: 18px;
        padding: 20px;
        text-align: center;
        border: 1px solid #bfdbfe;
    }

    .project-details-page .scan-score-number {
        font-size: 36px;
        font-weight: 800;
        color: #1d4ed8;
        line-height: 1;
    }

    .project-details-page .scan-score-label {
        margin-top: 8px;
        color: #475569;
        font-weight: 600;
    }

    .project-details-page .highlight-list li,
    .project-details-page .recommend-list li {
        margin-bottom: 10px;
        color: #334155;
    }

    .project-details-page .table thead th {
        white-space: nowrap;
    }

    .project-details-page .action-btns form {
        display: inline-block;
    }
</style>

<div class="container project-details-page">

    <div class="card hero-card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 16px;">
                <div>
                    <h1 class="hero-title">{{ $project->name }}</h1>
                    <p class="hero-desc mb-0">{{ $project->description ?? '-' }}</p>
                </div>

                <div class="hero-badges text-md-right">
                    <span class="badge badge-{{ $statusClass }}">Project: {{ ucfirst(str_replace('_', ' ', $project->status ?? 'unknown')) }}</span>
                    <span class="badge badge-{{ $scannerStatusClass }}">Scan: {{ ucfirst(str_replace('_', ' ', $project->scanner_status ?? 'not scanned')) }}</span>
                    <span class="badge badge-{{ $riskClass }}">Risk: {{ $riskLevel ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">Scan Score</div>
                    <div class="mini-stat-value">{{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">Scanner Project ID</div>
                    <div class="mini-stat-value">{{ $project->scanner_project_id ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">Scanned At</div>
                    <div class="mini-stat-value">{{ $project->scanned_at ? \Carbon\Carbon::parse($project->scanned_at)->format('d/m/Y H:i') : '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">Investors Count</div>
                    <div class="mini-stat-value">{{ $project->investors->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card section-card mb-4">
        <div class="card-header">
            <h3>Project Overview</h3>
        </div>
        <div class="card-body">
            <div class="row detail-grid">
                <div class="col-md-3 item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">{{ $project->status ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Progress</div>
                    <div class="detail-value">{{ $project->progress ?? 0 }}%</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Category</div>
                    <div class="detail-value">{{ $project->category ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Budget</div>
                    <div class="detail-value">{{ $project->budget ?? '-' }}</div>
                </div>

                <div class="col-md-3 item">
                    <div class="detail-label">Priority</div>
                    <div class="detail-value">{{ $project->priority ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Start Date</div>
                    <div class="detail-value">{{ optional($project->start_date)->format('d/m/Y') ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">End Date</div>
                    <div class="detail-value">{{ optional($project->end_date)->format('d/m/Y') ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Created At</div>
                    <div class="detail-value">{{ optional($project->created_at)->format('d/m/Y H:i') ?? '-' }}</div>
                </div>

                <div class="col-md-3 item">
                    <div class="detail-label">Scanner Status</div>
                    <div class="detail-value">{{ $project->scanner_status ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Scanner Project ID</div>
                    <div class="detail-value">{{ $project->scanner_project_id ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Scan Score</div>
                    <div class="detail-value">{{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Risk Level</div>
                    <div class="detail-value">{{ $riskLevel ?? '-' }}</div>
                </div>
            </div>

            @if($project->status === 'pending')
                <hr class="my-3">
                <div class="d-flex gap-2 action-btns flex-wrap">
                    <form method="POST" action="{{ route('admin.projects.approve', $project) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Approve Project</button>
                    </form>

                    <form method="POST" action="{{ route('admin.projects.reject', $project) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Reject Project</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="card section-card mb-4">
        <div class="card-header">
            <h3>People & Assignment</h3>
        </div>
        <div class="card-body">
            <div class="row detail-grid">
                <div class="col-md-3 item">
                    <div class="detail-label">Student</div>
                    <div class="detail-value">{{ $project->student?->name ?? '-' }}</div>
                    <div class="text-muted small">{{ $project->student?->email ?? '' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Supervisor</div>
                    <div class="detail-value">{{ $project->supervisor?->name ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Manager</div>
                    <div class="detail-value">{{ $project->manager?->name ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">Total Investors</div>
                    <div class="detail-value">{{ $project->investors->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card section-card mb-4">
        <div class="card-header">
            <h3>Scan Intelligence Summary</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="scan-score-box">
                        <div class="scan-score-number">{{ $project->scan_score !== null ? number_format($project->scan_score, 0) : '-' }}</div>
                        <div class="scan-score-label">Overall Score</div>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="summary-box">
                        <h6>Scan Metadata</h6>
                        <ul class="summary-list">
                            <li><strong>Event:</strong> {{ data_get($scanReport, 'event', '-') }}</li>
                            <li><strong>Version:</strong> {{ data_get($scanReport, 'version', '-') }}</li>
                            <li><strong>Grade:</strong> {{ data_get($scanInfo, 'grade', $project->grade ?? '-') }}</li>
                            <li><strong>Status:</strong> {{ data_get($scanInfo, 'status', $project->scanner_status ?? '-') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="summary-box">
                        <h6>Issue Summary</h6>
                        <ul class="summary-list">
                            <li><strong>Total Files:</strong> {{ data_get($scanSummary, 'total_files', '-') }}</li>
                            <li><strong>Total Issues:</strong> {{ data_get($scanSummary, 'issues_total', '-') }}</li>
                            <li><strong>Critical:</strong> {{ data_get($scanSummary, 'critical', '-') }}</li>
                            <li><strong>High:</strong> {{ data_get($scanSummary, 'high', '-') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="summary-box">
                        <h6>More Details</h6>
                        <ul class="summary-list">
                            <li><strong>Medium:</strong> {{ data_get($scanSummary, 'medium', '-') }}</li>
                            <li><strong>Low:</strong> {{ data_get($scanSummary, 'low', '-') }}</li>
                            <li><strong>Language:</strong> {{ data_get($scanProject, 'language', '-') }}</li>
                            <li><strong>Scanned At:</strong> {{ $project->scanned_at ? \Carbon\Carbon::parse($project->scanned_at)->format('d/m/Y H:i') : '-' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="mb-3">Highlights</h5>
                    @if(!empty($highlights))
                        <ul class="highlight-list mb-0">
                            @foreach($highlights as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">No highlights available.</p>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <h5 class="mb-3">Recommendations</h5>
                    @if(!empty($recommendations))
                        <ul class="recommend-list mb-0">
                            @foreach($recommendations as $recommendation)
                                <li>{{ $recommendation }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">No recommendations available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card section-card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Interested Investors</h3>
        </div>
        <div class="card-body">
            @php
                $interested = $project->investors->where('pivot.status', 'interested');
            @endphp

            @if($interested->count())
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Investor</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Expressed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interested as $investor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $investor->name }}</td>
                                <td>{{ $investor->email }}</td>
                                <td><span class="badge bg-warning text-dark">Interested</span></td>
                                <td>{{ $investor->pivot->amount ?? '-' }}</td>
                                <td>{{ optional($investor->pivot->created_at)->format('d M Y H:i') ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mb-0">No interest yet.</p>
            @endif
        </div>
    </div>

    <div class="card section-card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Funding Requests</h3>
        </div>
        <div class="card-body">
            @php
                $requests = $project->investors->where('pivot.status', 'requested');
            @endphp

            @if($requests->count())
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Investor</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Message</th>
                            <th>Requested</th>
                            <th width="220">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $investor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $investor->name }}</td>
                                <td>{{ $investor->email }}</td>
                                <td>${{ number_format($investor->pivot->amount ?? 0, 2) }}</td>
                                <td>{{ $investor->pivot->message ?? '-' }}</td>
                                <td>{{ optional($investor->pivot->created_at)->format('d M Y H:i') ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form method="POST" action="{{ route('admin.projects.investors.approve', ['project' => $project->project_id, 'user' => $investor->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.projects.investors.reject', ['project' => $project->project_id, 'user' => $investor->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mb-0">No funding requests yet.</p>
            @endif
        </div>
    </div>

    <div class="card section-card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Project Media</h3>
        </div>
        <div class="card-body">
            @php
                $images = $project->getMedia('images');
                $videoUrl = $project->getFirstMediaUrl('videos');
            @endphp

            <h5 class="mb-3">Images ({{ $images->count() }})</h5>

            @if($images->count())
                <div class="row">
                    @foreach($images as $img)
                        <div class="col-md-3 mb-3">
                            <a href="{{ $img->getUrl() }}" target="_blank" class="d-block">
                                <img src="{{ $img->getUrl() }}" class="img-fluid rounded border" alt="Project image">
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No images uploaded.</p>
            @endif

            <hr>

            <h5 class="mb-3">Video</h5>

            @if($videoUrl)
                <video class="w-100 rounded border" controls style="max-height:420px;">
                    <source src="{{ $videoUrl }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <p class="text-muted">No video uploaded.</p>
            @endif
        </div>
    </div>

</div>
@endsection