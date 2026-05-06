@extends('layouts.app')
@section('title', __('backend.project_details.page_title'))

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
    :root {
        --page-bg: #f5f7fb;
        --card-bg: #ffffff;
        --text-main: #172033;
        --text-soft: #7b8497;
        --border-color: #e8ecf4;
        --primary-color: #4e73df;
        --primary-soft: rgba(78, 115, 223, 0.10);
        --success-soft: rgba(28, 200, 138, 0.12);
        --warning-soft: rgba(246, 194, 62, 0.16);
        --danger-soft: rgba(231, 74, 59, 0.12);
        --shadow-sm: 0 8px 20px rgba(18, 38, 63, 0.06);
        --shadow-md: 0 16px 38px rgba(18, 38, 63, 0.10);
        --radius-xl: 24px;
        --radius-lg: 20px;
        --radius-md: 16px;
    }

    body {
        background: var(--page-bg);
    }

    .project-details-page {
        padding: 10px 0 32px;
    }

    .page-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        padding: 28px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .page-title {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--text-main);
        line-height: 1.25;
    }

    .page-subtitle {
        margin: 10px 0 0;
        color: var(--text-soft);
        line-height: 1.8;
        max-width: 900px;
    }

    .hero-badges {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    .hero-badges .badge {
        font-size: 0.78rem;
        padding: 9px 13px;
        border-radius: 999px;
        font-weight: 800;
        letter-spacing: 0.2px;
    }

    .info-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        height: 100%;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .info-card .card-body {
        padding: 22px;
    }

    .mini-stat-label {
        color: var(--text-soft);
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.35px;
        margin-bottom: 8px;
    }

    .mini-stat-value {
        color: var(--text-main);
        font-size: 1.28rem;
        font-weight: 900;
        line-height: 1.35;
        word-break: break-word;
    }

    .section-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .section-card .card-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 18px 22px;
    }

    .section-card .card-header h3,
    .section-card .card-header h5 {
        margin: 0;
        font-weight: 900;
        color: var(--text-main);
        font-size: 1.12rem;
    }

    .section-card .card-body {
        padding: 24px 22px;
    }

    .detail-grid .item {
        padding: 14px 12px;
        border-bottom: 1px dashed #e5e7eb;
    }

    .detail-label {
        font-size: 0.76rem;
        color: var(--text-soft);
        font-weight: 900;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.35px;
    }

    .detail-value {
        font-size: 0.95rem;
        color: var(--text-main);
        font-weight: 800;
        word-break: break-word;
    }

    .summary-box {
        background: #f8faff;
        border: 1px solid #edf1f7;
        border-radius: var(--radius-md);
        padding: 18px;
        height: 100%;
    }

    .summary-box h6 {
        font-weight: 900;
        margin-bottom: 12px;
        color: var(--text-main);
    }

    .summary-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .summary-list li {
        padding: 9px 0;
        border-bottom: 1px dashed #e5e7eb;
        color: #334155;
        font-size: 0.92rem;
    }

    .summary-list li:last-child {
        border-bottom: 0;
    }

    .scan-score-box {
        background: linear-gradient(135deg, #eef4ff, #dbeafe);
        border-radius: 20px;
        padding: 24px 18px;
        text-align: center;
        border: 1px solid #c7d8ff;
        height: 100%;
    }

    .scan-score-number {
        font-size: 2.5rem;
        font-weight: 900;
        color: #1d4ed8;
        line-height: 1;
    }

    .scan-score-label {
        margin-top: 10px;
        color: #475569;
        font-weight: 800;
    }

    .highlight-list,
    .recommend-list {
        padding-left: 1.2rem;
    }

    .highlight-list li,
    .recommend-list li {
        margin-bottom: 10px;
        color: #334155;
        line-height: 1.7;
    }

    .section-card .table {
        margin-bottom: 0;
    }

    .section-card .table thead th {
        background: #172033;
        color: #fff;
        border: none;
        white-space: nowrap;
        font-size: 0.82rem;
        padding: 14px;
    }

    .section-card .table tbody td {
        padding: 14px;
        vertical-align: middle;
        border-color: #eef2f7;
        font-size: 0.92rem;
    }

    .section-card .table tbody tr:hover {
        background: #fafcff;
    }

    .section-card .table-bordered {
        border-color: #eef2f7;
        overflow: hidden;
        border-radius: 16px;
    }

    .action-btns form {
        display: inline-block;
    }

    .action-btns .btn,
    .section-card .btn {
        border-radius: 12px;
        font-weight: 800;
        padding: 8px 14px;
    }

    .project-details-page img {
        border-radius: 16px !important;
        box-shadow: var(--shadow-sm);
    }

    video {
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 991px) {
        .page-header-card {
            padding: 22px;
        }

        .hero-badges {
            justify-content: flex-start;
        }

        .section-card .card-body {
            padding: 20px 18px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.35rem;
        }

        .page-subtitle {
            font-size: 0.92rem;
        }

        .info-card .card-body {
            padding: 18px;
        }

        .mini-stat-value {
            font-size: 1.1rem;
        }

        .section-card .card-header {
            padding: 16px 18px;
        }

        .section-card .card-header h3,
        .section-card .card-header h5 {
            font-size: 1rem;
        }

        .section-card .table {
            min-width: 760px;
        }
    }
</style>

<div class="container-fluid project-details-page">

    <div class="page-header-card">
        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:16px;">
            <div>
                <h1 class="page-title">{{ $project->name }}</h1>
                <p class="page-subtitle mb-0">{{ $project->description ?? '-' }}</p>
            </div>

            <div class="hero-badges text-md-right">
                <span class="badge badge-{{ $statusClass }}">{{ __('backend.project_details.project_status') }}: {{ ucfirst(str_replace('_', ' ', $project->status ?? 'unknown')) }}</span>
                <span class="badge badge-{{ $scannerStatusClass }}">{{ __('backend.project_details.scan_status') }}: {{ ucfirst(str_replace('_', ' ', $project->scanner_status ?? __('backend.project_details.not_scanned'))) }}</span>
                <span class="badge badge-{{ $riskClass }}">{{ __('backend.project_details.risk') }}: {{ $riskLevel ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">{{ __('backend.project_details.scan_score') }}</div>
                    <div class="mini-stat-value">{{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">{{ __('backend.project_details.scanner_project_id') }}</div>
                    <div class="mini-stat-value">{{ $project->scanner_project_id ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">{{ __('backend.project_details.scanned_at') }}</div>
                    <div class="mini-stat-value">{{ $project->scanned_at ? \Carbon\Carbon::parse($project->scanned_at)->format('d/m/Y H:i') : '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">{{ __('backend.project_details.investors_count') }}</div>
                    <div class="mini-stat-value">{{ $project->investors->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card section-card">
        <div class="card-header">
            <h3>{{ __('backend.project_details.project_overview') }}</h3>
        </div>
        <div class="card-body">
            <div class="row detail-grid">
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.status') }}</div>
                    <div class="detail-value">{{ $project->status ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.progress') }}</div>
                    <div class="detail-value">{{ $project->progress ?? 0 }}%</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.category') }}</div>
                    <div class="detail-value">{{ $project->category ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.budget') }}</div>
                    <div class="detail-value">{{ $project->budget ?? '-' }}</div>
                </div>

                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.priority') }}</div>
                    <div class="detail-value">{{ $project->priority ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.start_date') }}</div>
                    <div class="detail-value">{{ optional($project->start_date)->format('d/m/Y') ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.end_date') }}</div>
                    <div class="detail-value">{{ optional($project->end_date)->format('d/m/Y') ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.created_at') }}</div>
                    <div class="detail-value">{{ optional($project->created_at)->format('d/m/Y H:i') ?? '-' }}</div>
                </div>

                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.scanner_status') }}</div>
                    <div class="detail-value">{{ $project->scanner_status ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.scanner_project_id') }}</div>
                    <div class="detail-value">{{ $project->scanner_project_id ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.scan_score') }}</div>
                    <div class="detail-value">{{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.risk_level') }}</div>
                    <div class="detail-value">{{ $riskLevel ?? '-' }}</div>
                </div>
            </div>

            @if($project->status === 'pending')
                <hr class="my-3">
                <div class="d-flex gap-2 action-btns flex-wrap">
                    <form method="POST" action="{{ route('admin.projects.approve', $project) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">{{ __('backend.project_details.approve_project') }}</button>
                    </form>

                    <form method="POST" action="{{ route('admin.projects.reject', $project) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">{{ __('backend.project_details.reject_project') }}</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="card section-card">
        <div class="card-header">
            <h3>{{ __('backend.project_details.people_assignment') }}</h3>
        </div>
        <div class="card-body">
            <div class="row detail-grid">
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.student') }}</div>
                    <div class="detail-value">{{ $project->student?->name ?? '-' }}</div>
                    <div class="text-muted small">{{ $project->student?->email ?? '' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.supervisor') }}</div>
                    <div class="detail-value">{{ $project->supervisor?->name ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.manager') }}</div>
                    <div class="detail-value">{{ $project->manager?->name ?? '-' }}</div>
                </div>
                <div class="col-md-3 item">
                    <div class="detail-label">{{ __('backend.project_details.total_investors') }}</div>
                    <div class="detail-value">{{ $project->investors->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card section-card">
        <div class="card-header">
            <h3>{{ __('backend.project_details.scan_intelligence_summary') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="scan-score-box">
                        <div class="scan-score-number">{{ $project->scan_score !== null ? number_format($project->scan_score, 0) : '-' }}</div>
                        <div class="scan-score-label">{{ __('backend.project_details.overall_score') }}</div>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="summary-box">
                        <h6>{{ __('backend.project_details.scan_metadata') }}</h6>
                        <ul class="summary-list">
                            <li><strong>{{ __('backend.project_details.event') }}:</strong> {{ data_get($scanReport, 'event', '-') }}</li>
                            <li><strong>{{ __('backend.project_details.version') }}:</strong> {{ data_get($scanReport, 'version', '-') }}</li>
                            <li><strong>{{ __('backend.project_details.grade') }}:</strong> {{ data_get($scanInfo, 'grade', $project->grade ?? '-') }}</li>
                            <li><strong>{{ __('backend.project_details.status') }}:</strong> {{ data_get($scanInfo, 'status', $project->scanner_status ?? '-') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="summary-box">
                        <h6>{{ __('backend.project_details.issue_summary') }}</h6>
                        <ul class="summary-list">
                            <li><strong>{{ __('backend.project_details.total_files') }}:</strong> {{ data_get($scanSummary, 'total_files', '-') }}</li>
                            <li><strong>{{ __('backend.project_details.total_issues') }}:</strong> {{ data_get($scanSummary, 'issues_total', '-') }}</li>
                            <li><strong>{{ __('backend.project_details.critical') }}:</strong> {{ data_get($scanSummary, 'critical', '-') }}</li>
                            <li><strong>{{ __('backend.project_details.high') }}:</strong> {{ data_get($scanSummary, 'high', '-') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="summary-box">
                        <h6>{{ __('backend.project_details.more_details') }}</h6>
                        <ul class="summary-list">
                            <li><strong>{{ __('backend.project_details.medium') }}:</strong> {{ data_get($scanSummary, 'medium', '-') }}</li>
                            <li><strong>{{ __('backend.project_details.low') }}:</strong> {{ data_get($scanSummary, 'low', '-') }}</li>
                            <li><strong>{{ __('backend.project_details.language') }}:</strong> {{ data_get($scanProject, 'language', '-') }}</li>
                            <li><strong>{{ __('backend.project_details.scanned_at') }}:</strong> {{ $project->scanned_at ? \Carbon\Carbon::parse($project->scanned_at)->format('d/m/Y H:i') : '-' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="mb-3">{{ __('backend.project_details.highlights') }}</h5>
                    @if(!empty($highlights))
                        <ul class="highlight-list mb-0">
                            @foreach($highlights as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">{{ __('backend.project_details.no_highlights_available') }}</p>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <h5 class="mb-3">{{ __('backend.project_details.recommendations') }}</h5>
                    @if(!empty($recommendations))
                        <ul class="recommend-list mb-0">
                            @foreach($recommendations as $recommendation)
                                <li>{{ $recommendation }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">{{ __('backend.project_details.no_recommendations_available') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card section-card">
        <div class="card-header">
            <h3 class="mb-0">{{ __('backend.project_details.interested_investors') }}</h3>
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
                            <th>{{ __('backend.project_details.investor') }}</th>
                            <th>{{ __('backend.project_details.email') }}</th>
                            <th>{{ __('backend.project_details.status') }}</th>
                            <th>{{ __('backend.project_details.amount') }}</th>
                            <th>{{ __('backend.project_details.expressed') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interested as $investor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $investor->name }}</td>
                                <td>{{ $investor->email }}</td>
                                <td><span class="badge bg-warning text-dark">{{ __('backend.project_details.interested') }}</span></td>
                                <td>{{ $investor->pivot->amount ?? '-' }}</td>
                                <td>{{ optional($investor->pivot->created_at)->format('d M Y H:i') ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mb-0">{{ __('backend.project_details.no_interest_yet') }}</p>
            @endif
        </div>
    </div>

    <div class="card section-card">
        <div class="card-header">
            <h3 class="mb-0">{{ __('backend.project_details.funding_requests') }}</h3>
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
                            <th>{{ __('backend.project_details.investor') }}</th>
                            <th>{{ __('backend.project_details.email') }}</th>
                            <th>{{ __('backend.project_details.amount') }}</th>
                            <th>{{ __('backend.project_details.message') }}</th>
                            <th>{{ __('backend.project_details.requested') }}</th>
                            <th width="220">{{ __('backend.project_details.action') }}</th>
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
                                                {{ __('backend.project_details.approve') }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.projects.investors.reject', ['project' => $project->project_id, 'user' => $investor->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                {{ __('backend.project_details.reject') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mb-0">{{ __('backend.project_details.no_funding_requests_yet') }}</p>
            @endif
        </div>
    </div>

    <div class="card section-card">
        <div class="card-header">
            <h3 class="mb-0">{{ __('backend.project_details.project_media') }}</h3>
        </div>
        <div class="card-body">
            @php
                $images = $project->getMedia('images');
                $videoUrl = $project->getFirstMediaUrl('videos');
            @endphp

            <h5 class="mb-3">{{ __('backend.project_details.images') }} ({{ $images->count() }})</h5>

            @if($images->count())
                <div class="row">
                    @foreach($images as $img)
                        <div class="col-md-3 mb-3">
                            <a href="{{ $img->getUrl() }}" target="_blank" class="d-block">
                                <img src="{{ $img->getUrl() }}" class="img-fluid rounded border" alt="{{ __('backend.project_details.project_image') }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">{{ __('backend.project_details.no_images_uploaded') }}</p>
            @endif

            <hr>

            <h5 class="mb-3">{{ __('backend.project_details.video') }}</h5>

            @if($videoUrl)
                <video class="w-100 rounded border" controls style="max-height:420px;">
                    <source src="{{ $videoUrl }}" type="video/mp4">
                    {{ __('backend.project_details.video_not_supported') }}
                </video>
            @else
                <p class="text-muted">{{ __('backend.project_details.no_video_uploaded') }}</p>
            @endif
        </div>
    </div>

</div>
@endsection