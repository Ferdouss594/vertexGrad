@extends('supervisor.layout.app_super')
@section('title','Supervisor Project Review')

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

    $statusClass = match(strtolower($project->status ?? '')) {
        'pending', 'scan_requested', 'awaiting_manual_review' => 'warning',
        'active', 'approved', 'published' => 'primary',
        'completed' => 'success',
        'rejected', 'scan_failed', 'failed' => 'danger',
        default => 'secondary',
    };

    $scannerStatusClass = match(strtolower($project->scanner_status ?? '')) {
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

    .project-details-page .review-panel {
        position: sticky;
        top: 20px;
    }

    .project-details-page .table thead th {
        white-space: nowrap;
    }
</style>

<div class="container-fluid project-details-page">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 14px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 14px;">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="gap: 12px;">
        <div>
            <h4 class="mb-1">Project Review</h4>
            <p class="text-muted mb-0">Full supervisor view for reviewing the project, technical scan, and decision.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('supervisor.projects.index') }}" class="btn btn-outline-primary btn-sm">
                Back to Projects
            </a>
            <a href="{{ route('supervisor.projects.pending') }}" class="btn btn-primary btn-sm">
                Pending Reviews
            </a>
        </div>
    </div>

    <div class="card hero-card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 16px;">
                <div>
                    <h1 class="hero-title">{{ $project->name }}</h1>
                    <p class="hero-desc mb-0">{{ $project->description ?? '-' }}</p>
                </div>

                <div class="hero-badges text-md-right">
                    <span class="badge badge-{{ $statusClass }}">
                        Project: {{ ucfirst(str_replace('_', ' ', $project->status ?? 'unknown')) }}
                    </span>
                    <span class="badge badge-{{ $scannerStatusClass }}">
                        Scan: {{ ucfirst(str_replace('_', ' ', $project->scanner_status ?? 'not scanned')) }}
                    </span>
                    <span class="badge badge-{{ $riskClass }}">
                        Risk: {{ $riskLevel ?? '-' }}
                    </span>
                    <span class="badge badge-light text-dark">
                        Supervisor Review: {{ ucfirst(str_replace('_', ' ', $project->supervisor_status ?? 'not reviewed')) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">Scan Score</div>
                    <div class="mini-stat-value">
                        {{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card info-card">
                <div class="card-body">
                    <div class="mini-stat-label">Supervisor Score</div>
                    <div class="mini-stat-value">
                        {{ $project->supervisor_score !== null ? $project->supervisor_score . '/100' : '-' }}
                    </div>
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
                    <div class="mini-stat-value">
                        {{ $project->scanned_at ? \Carbon\Carbon::parse($project->scanned_at)->format('d/m/Y H:i') : '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Left Side --}}
        <div class="col-lg-8">

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
                            <div class="detail-value">
                                {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 item">
                            <div class="detail-label">End Date</div>
                            <div class="detail-value">
                                {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 item">
                            <div class="detail-label">Created At</div>
                            <div class="detail-value">
                                {{ $project->created_at ? $project->created_at->format('d/m/Y H:i') : '-' }}
                            </div>
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
                            <div class="detail-value">
                                {{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 item">
                            <div class="detail-label">Risk Level</div>
                            <div class="detail-value">{{ $riskLevel ?? '-' }}</div>
                        </div>
                    </div>
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
                            <div class="text-muted small">{{ $project->supervisor?->email ?? '' }}</div>
                        </div>
                        <div class="col-md-3 item">
                            <div class="detail-label">Manager</div>
                            <div class="detail-value">{{ $project->manager?->name ?? '-' }}</div>
                            <div class="text-muted small">{{ $project->manager?->email ?? '' }}</div>
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
                                <div class="scan-score-number">
                                    {{ $project->scan_score !== null ? number_format($project->scan_score, 0) : '-' }}
                                </div>
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
                        <div class="table-responsive">
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
                        </div>
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
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Investor</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Message</th>
                                        <th>Requested</th>
                                        <th>Status</th>
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
                                                <span class="badge bg-info text-dark">Requested</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                        $images = method_exists($project, 'getMedia') ? $project->getMedia('images') : collect();
                        $videoUrl = method_exists($project, 'getFirstMediaUrl') ? $project->getFirstMediaUrl('videos') : null;
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

        {{-- Right Side --}}
        <div class="col-lg-4">
            <div class="review-panel">
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h3>Supervisor Review</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('supervisor.projects.review', $project->project_id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Technical Score / 100</label>
                                <input
                                    type="number"
                                    name="supervisor_score"
                                    class="form-control"
                                    min="0"
                                    max="100"
                                    value="{{ old('supervisor_score', $project->supervisor_score) }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Supervisor Notes</label>
                                <textarea
                                    name="supervisor_notes"
                                    rows="8"
                                    class="form-control"
                                    required
                                >{{ old('supervisor_notes', $project->supervisor_notes) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Decision</label>
                                <select name="supervisor_decision" class="form-select" required>
                                    <option value="">Select decision</option>
                                    <option value="approved" {{ old('supervisor_decision', $project->supervisor_decision) === 'approved' ? 'selected' : '' }}>Approve</option>
                                    <option value="revision_requested" {{ old('supervisor_decision', $project->supervisor_decision) === 'revision_requested' ? 'selected' : '' }}>Needs Revision</option>
                                    <option value="rejected" {{ old('supervisor_decision', $project->supervisor_decision) === 'rejected' ? 'selected' : '' }}>Reject</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Submit Review
                                </button>
                            </div>
                        </form>

                        <hr>

                        <h6 class="mb-3">Current Review Summary</h6>

                        <div class="mb-2">
                            <strong>Status:</strong>
                            {{ $project->supervisor_status ?? 'Not reviewed' }}
                        </div>

                        <div class="mb-2">
                            <strong>Score:</strong>
                            {{ $project->supervisor_score ?? '—' }}
                        </div>

                        <div class="mb-2">
                            <strong>Decision:</strong>
                            {{ $project->supervisor_decision ?? '—' }}
                        </div>

                        <div class="mb-2">
                            <strong>Reviewed At:</strong>
                            {{ $project->supervisor_reviewed_at ?? '—' }}
                        </div>

                        <div class="mb-0">
                            <strong>Last Notes:</strong>
                            <div class="mt-2 text-muted">
                                {{ $project->supervisor_notes ?? 'No notes yet.' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card section-card">
                    <div class="card-header">
                        <h3>Quick Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Student:</strong>
                            <div>{{ $project->student?->name ?? '-' }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Project Status:</strong>
                            <div>{{ $project->status ?? '-' }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Scanner Status:</strong>
                            <div>{{ $project->scanner_status ?? '-' }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Risk Level:</strong>
                            <div>{{ $riskLevel ?? '-' }}</div>
                        </div>

                        <div class="mb-0">
                            <strong>Investors:</strong>
                            <div>{{ $project->investors->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection