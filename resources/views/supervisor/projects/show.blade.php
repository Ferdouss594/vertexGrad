@extends('supervisor.layout.app_super')
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

    $meetings = $project->meetings ?? collect();

    $projectRequests = method_exists($project, 'requests')
        ? $project->requests()->with(['latestResponse', 'student'])->latest()->get()
        : collect();

    $latestSystemRequest = $projectRequests->first(function ($item) {
        return strtolower($item->request_type ?? '') === 'system_verification'
            && $item->latestResponse;
    });

    $parsedSystemResponse = [
        'frontend_url'     => null,
        'backend_url'      => null,
        'api_health_url'   => null,
        'admin_panel_url'  => null,
        'demo_account'     => null,
        'demo_password'    => null,
        'deployment_notes' => null,
    ];

    if ($latestSystemRequest && !empty($latestSystemRequest->latestResponse?->response_text)) {
        $responseText = $latestSystemRequest->latestResponse->response_text;

        if (preg_match('/Frontend URL:\s*(.+)/i', $responseText, $m)) {
            $parsedSystemResponse['frontend_url'] = trim($m[1]);
        }

        if (preg_match('/Backend URL:\s*(.+)/i', $responseText, $m)) {
            $parsedSystemResponse['backend_url'] = trim($m[1]);
        }

        if (preg_match('/API Health \/ API Base URL:\s*(.+)/i', $responseText, $m)) {
            $parsedSystemResponse['api_health_url'] = trim($m[1]);
        } elseif (preg_match('/API Health URL:\s*(.+)/i', $responseText, $m)) {
            $parsedSystemResponse['api_health_url'] = trim($m[1]);
        } elseif (preg_match('/API URL:\s*(.+)/i', $responseText, $m)) {
            $parsedSystemResponse['api_health_url'] = trim($m[1]);
        }

        if (preg_match('/Admin Panel URL:\s*(.+)/i', $responseText, $m)) {
            $parsedSystemResponse['admin_panel_url'] = trim($m[1]);
        }

        if (preg_match('/Demo Account:\s*(.+)/i', $responseText, $m)) {
            $parsedSystemResponse['demo_account'] = trim($m[1]);
        }

        if (preg_match('/Demo Password:\s*(.+)/i', $responseText, $m)) {
            $parsedSystemResponse['demo_password'] = trim($m[1]);
        }

        if (preg_match('/Deployment Notes:\s*([\s\S]+)/i', $responseText, $m)) {
            $parsedSystemResponse['deployment_notes'] = trim($m[1]);
        }
    }

    $finalFrontendUrl = old('frontend_url', $project->frontend_url ?: $parsedSystemResponse['frontend_url']);
    $finalBackendUrl = old('backend_url', $project->backend_url ?: $parsedSystemResponse['backend_url']);
    $finalApiHealthUrl = old('api_health_url', $project->api_health_url ?: $parsedSystemResponse['api_health_url']);
    $finalAdminPanelUrl = old('admin_panel_url', $project->admin_panel_url ?: $parsedSystemResponse['admin_panel_url']);
    $finalDemoAccount = old('demo_account', $project->demo_account ?: $parsedSystemResponse['demo_account']);
    $finalDemoPassword = old('demo_password', $project->demo_password ?: $parsedSystemResponse['demo_password']);
    $finalDeploymentNotes = old('deployment_notes', $project->deployment_notes ?: $parsedSystemResponse['deployment_notes']);
@endphp

<style>
.project-details-page .section-card {
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,.06);
    margin-bottom: 20px;
    border: none;
    overflow: hidden;
}
.project-details-page .hero-card {
    border-radius: 20px;
    background: linear-gradient(135deg,#0f172a,#1d4ed8);
    color:#fff;
    border: none;
}
.project-details-page .hero-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 10px;
}
.project-details-page .hero-desc {
    color: rgba(255,255,255,.90);
    max-width: 850px;
    line-height: 1.8;
}
.project-details-page .badge {
    padding: 7px 12px;
    border-radius: 999px;
}
.project-details-page .mini-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
    padding: 20px;
    height: 100%;
}
.project-details-page .mini-label {
    color: #64748b;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 6px;
}
.project-details-page .mini-value {
    color: #0f172a;
    font-size: 22px;
    font-weight: 800;
}
.project-details-page .section-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 16px 20px;
}
.project-details-page .section-card .card-header h4,
.project-details-page .section-card .card-header h5 {
    margin: 0;
    font-weight: 800;
    color: #0f172a;
}
.project-details-page .verification-box,
.project-details-page .request-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px;
    height: 100%;
}
.project-details-page .verification-box label,
.project-details-page .request-box label {
    font-weight: 700;
    font-size: 13px;
    color: #475569;
    margin-bottom: 8px;
    display: block;
}
.project-details-page .verification-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 16px;
}
.project-details-page .verification-btn {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    padding: 9px 14px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}
.project-details-page .verification-btn:hover {
    background: #dbeafe;
    color: #1d4ed8;
    text-decoration: none;
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
.project-details-page .meeting-item,
.project-details-page .request-item {
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 12px;
    background: #fff;
}
.project-details-page .meeting-title,
.project-details-page .request-title {
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 6px;
}
.project-details-page .meeting-meta,
.project-details-page .request-meta {
    color: #64748b;
    font-size: 13px;
    margin-bottom: 10px;
}
.project-details-page .meeting-actions,
.project-details-page .request-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
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
.project-details-page .table thead th {
    white-space: nowrap;
}
.project-details-page .student-response-box {
    margin-top: 14px;
    background: #f8fafc;
    border: 1px solid #dbeafe;
    border-radius: 14px;
    padding: 16px;
}
.project-details-page .student-response-title {
    font-size: 13px;
    font-weight: 800;
    color: #1d4ed8;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 10px;
}
.project-details-page .student-response-meta {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 10px;
}
.project-details-page .student-response-text {
    color: #334155;
    margin-bottom: 10px;
    white-space: pre-line;
}
.project-details-page .student-response-links {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.project-details-page .response-link-btn {
    background: #ecfeff;
    color: #0f766e;
    border: 1px solid #a5f3fc;
    padding: 8px 12px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
}
.project-details-page .response-link-btn:hover {
    text-decoration: none;
    color: #115e59;
    background: #cffafe;
}
.project-details-page .request-template-bar {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
.project-details-page .template-btn {
    border: 1px solid #c7d2fe;
    background: #eef2ff;
    color: #3730a3;
    padding: 10px 14px;
    border-radius: 12px;
    font-weight: 800;
    font-size: 13px;
    transition: .2s ease;
}
.project-details-page .template-btn:hover {
    background: #e0e7ff;
}
.project-details-page .template-btn.system {
    background: #ecfeff;
    border-color: #a5f3fc;
    color: #155e75;
}
.project-details-page .template-btn.system:hover {
    background: #cffafe;
}
.project-details-page .template-helper {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 14px;
    padding: 14px 16px;
    color: #475569;
    font-size: 13px;
    margin-bottom: 18px;
}
.project-details-page .system-sync-alert {
    background: linear-gradient(135deg, #ecfeff, #eff6ff);
    border: 1px solid #bae6fd;
    color: #0f172a;
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 18px;
}
.project-details-page .system-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
    margin-top: 18px;
}
.project-details-page .system-info-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 14px;
}
.project-details-page .system-info-label {
    font-size: 12px;
    font-weight: 800;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 6px;
}
.project-details-page .system-info-value {
    font-size: 14px;
    color: #0f172a;
    font-weight: 600;
    word-break: break-word;
    white-space: pre-line;
}
.project-details-page .response-toggle-btn {
    width: 100%;
    margin-top: 14px;
    border: 1px solid #dbeafe;
    background: #f8fbff;
    color: #1d4ed8;
    border-radius: 12px;
    padding: 12px 14px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: .2s ease;
}
.project-details-page .response-toggle-btn:hover {
    background: #eef6ff;
}
.project-details-page .response-toggle-icon {
    transition: transform .25s ease;
}
.project-details-page .response-toggle-btn.active .response-toggle-icon {
    transform: rotate(180deg);
}
.project-details-page .response-collapse {
    display: none;
}
.project-details-page .response-collapse.show {
    display: block;
}
.project-details-page .badge-soft {
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
}
.project-details-page .badge-review-approved {
    background: #dcfce7;
    color: #166534;
}
.project-details-page .badge-review-revision_requested {
    background: #fef3c7;
    color: #92400e;
}
.project-details-page .badge-review-rejected {
    background: #fee2e2;
    color: #991b1b;
}
.project-details-page .badge-review-pending {
    background: #e5e7eb;
    color: #374151;
}
@media (max-width: 768px) {
    .project-details-page .system-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="container project-details-page">

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

    {{-- HERO --}}
    <div class="card hero-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 16px;">
            <div>
                <h1 class="hero-title">{{ $project->name }}</h1>
                <p class="hero-desc mb-0">{{ $project->description ?? '-' }}</p>
            </div>

            <div class="text-md-right">
                <span class="badge badge-{{ $statusClass }}">Project: {{ ucfirst(str_replace('_', ' ', $project->status ?? 'unknown')) }}</span>
                <span class="badge badge-{{ $scannerStatusClass }}">Scan: {{ ucfirst(str_replace('_', ' ', $project->scanner_status ?? 'not scanned')) }}</span>
                <span class="badge badge-{{ $riskClass }}">Risk: {{ $riskLevel ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- QUICK STATS --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="mini-card">
                <div class="mini-label">Scan Score</div>
                <div class="mini-value">{{ $project->scan_score !== null ? number_format($project->scan_score, 2) : '-' }}</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="mini-card">
                <div class="mini-label">Scanner Project ID</div>
                <div class="mini-value">{{ $project->scanner_project_id ?? '-' }}</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="mini-card">
                <div class="mini-label">Scanned At</div>
                <div class="mini-value" style="font-size:16px;">
                    {{ $project->scanned_at ? \Carbon\Carbon::parse($project->scanned_at)->format('d/m/Y H:i') : '-' }}
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="mini-card">
                <div class="mini-label">Investors Count</div>
                <div class="mini-value">{{ $project->investors->count() }}</div>
            </div>
        </div>
    </div>

    {{-- SYSTEM VERIFICATION --}}
    <div class="card section-card">
        <div class="card-header">
            <h4>System Verification</h4>
        </div>
        <div class="card-body">

            @if($latestSystemRequest && $latestSystemRequest->latestResponse)
                <div class="system-sync-alert">
                    <strong>Latest system verification response detected.</strong>
                    The fields below are automatically pre-filled from the student's latest <strong>System Verification</strong> response when the saved project values are empty.
                </div>
            @endif

            <form method="POST" action="{{ route('supervisor.projects.system-verification.update', $project->project_id) }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="verification-box">
                            <label>Frontend URL</label>
                            <input type="url" class="form-control" name="frontend_url" value="{{ $finalFrontendUrl }}" placeholder="https://your-app.com">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="verification-box">
                            <label>Backend URL</label>
                            <input type="url" class="form-control" name="backend_url" value="{{ $finalBackendUrl }}" placeholder="https://api.your-app.com">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="verification-box">
                            <label>API Health URL</label>
                            <input type="url" class="form-control" name="api_health_url" value="{{ $finalApiHealthUrl }}" placeholder="https://api.your-app.com/health">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="verification-box">
                            <label>Admin Panel URL</label>
                            <input type="url" class="form-control" name="admin_panel_url" value="{{ $finalAdminPanelUrl }}" placeholder="https://your-app.com/admin">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="verification-box">
                            <label>Demo Account</label>
                            <input type="text" class="form-control" name="demo_account" value="{{ $finalDemoAccount }}" placeholder="test@example.com">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="verification-box">
                            <label>Demo Password</label>
                            <input type="text" class="form-control" name="demo_password" value="{{ $finalDemoPassword }}" placeholder="Password">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="verification-box">
                            <label>Deployment Notes</label>
                            <textarea name="deployment_notes" rows="4" class="form-control" placeholder="Write any technical notes, setup instructions, environments, ports, hosting notes, or testing details.">{{ $finalDeploymentNotes }}</textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary">Save Verification</button>
                    </div>
                </div>
            </form>

            <div class="verification-actions">
                @if($finalFrontendUrl)
                    <a href="{{ $finalFrontendUrl }}" target="_blank" class="verification-btn">Open Frontend</a>
                @endif
                @if($finalBackendUrl)
                    <a href="{{ $finalBackendUrl }}" target="_blank" class="verification-btn">Open Backend</a>
                @endif
                @if($finalApiHealthUrl)
                    <a href="{{ $finalApiHealthUrl }}" target="_blank" class="verification-btn">Check API</a>
                @endif
                @if($finalAdminPanelUrl)
                    <a href="{{ $finalAdminPanelUrl }}" target="_blank" class="verification-btn">Open Admin Panel</a>
                @endif
            </div>

            @if($latestSystemRequest && $latestSystemRequest->latestResponse)
                <div class="system-grid">
                    <div class="system-info-card">
                        <div class="system-info-label">Frontend URL</div>
                        <div class="system-info-value">{{ $parsedSystemResponse['frontend_url'] ?: '—' }}</div>
                    </div>
                    <div class="system-info-card">
                        <div class="system-info-label">Backend URL</div>
                        <div class="system-info-value">{{ $parsedSystemResponse['backend_url'] ?: '—' }}</div>
                    </div>
                    <div class="system-info-card">
                        <div class="system-info-label">API Health URL</div>
                        <div class="system-info-value">{{ $parsedSystemResponse['api_health_url'] ?: '—' }}</div>
                    </div>
                    <div class="system-info-card">
                        <div class="system-info-label">Admin Panel URL</div>
                        <div class="system-info-value">{{ $parsedSystemResponse['admin_panel_url'] ?: '—' }}</div>
                    </div>
                    <div class="system-info-card">
                        <div class="system-info-label">Demo Account</div>
                        <div class="system-info-value">{{ $parsedSystemResponse['demo_account'] ?: '—' }}</div>
                    </div>
                    <div class="system-info-card">
                        <div class="system-info-label">Demo Password</div>
                        <div class="system-info-value">{{ $parsedSystemResponse['demo_password'] ?: '—' }}</div>
                    </div>
                    <div class="system-info-card" style="grid-column: 1 / -1;">
                        <div class="system-info-label">Deployment Notes</div>
                        <div class="system-info-value">{{ $parsedSystemResponse['deployment_notes'] ?: '—' }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- SUPERVISOR EVALUATION --}}
    <div class="card section-card">
        <div class="card-header">
            <h4>Supervisor Evaluation</h4>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('supervisor.projects.evaluation.store', $project->project_id) }}" class="mb-4">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="request-box">
                            <label>Score</label>
                            <input
                                type="number"
                                name="score"
                                class="form-control"
                                min="0"
                                max="100"
                                value="{{ old('score', $currentSupervisorReview->score ?? '') }}"
                                placeholder="0 - 100">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="request-box">
                            <label>Decision</label>
                            <select name="decision" class="form-control" required>
                                <option value="">Select decision</option>
                                <option value="approved" {{ old('decision', $currentSupervisorReview->decision ?? '') === 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>
                                <option value="revision_requested" {{ old('decision', $currentSupervisorReview->decision ?? '') === 'revision_requested' ? 'selected' : '' }}>
                                    Revision Requested
                                </option>
                                <option value="rejected" {{ old('decision', $currentSupervisorReview->decision ?? '') === 'rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="request-box">
                            <label>Reviewed At</label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $currentSupervisorReview && $currentSupervisorReview->reviewed_at ? \Carbon\Carbon::parse($currentSupervisorReview->reviewed_at)->format('d/m/Y h:i A') : 'Not reviewed yet' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="request-box">
                            <label>Supervisor Notes</label>
                            <textarea
                                name="notes"
                                rows="5"
                                class="form-control"
                                placeholder="Write your professional evaluation, strengths, issues, academic comments, and final recommendation..."
                                required>{{ old('notes', $currentSupervisorReview->notes ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary">
                            {{ $currentSupervisorReview ? 'Update Evaluation' : 'Submit Evaluation' }}
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <h5 class="mb-3">All Supervisor Evaluations</h5>

            @forelse($project->reviews as $review)
                @php
                    $decisionClass = match($review->decision) {
                        'approved' => 'badge-review-approved',
                        'revision_requested' => 'badge-review-revision_requested',
                        'rejected' => 'badge-review-rejected',
                        default => 'badge-review-pending',
                    };
                @endphp

                <div class="request-item">
                    <div class="request-title">
                        {{ $review->supervisor?->name ?? 'Supervisor' }}
                    </div>

                    <div class="request-meta">
                        Decision:
                        <span class="badge-soft {{ $decisionClass }}">
                            {{ ucfirst(str_replace('_', ' ', $review->decision)) }}
                        </span>

                        @if($review->reviewed_at)
                            • Reviewed: {{ \Carbon\Carbon::parse($review->reviewed_at)->format('d/m/Y h:i A') }}
                        @endif

                        @if(!is_null($review->score))
                            • Score: {{ $review->score }}/100
                        @endif
                    </div>

                    <div class="text-muted" style="white-space: pre-line;">
                        {{ $review->notes }}
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">No supervisor evaluations submitted yet.</p>
            @endforelse

        </div>
    </div>

    {{-- REQUESTS TO STUDENT --}}
    <div class="card section-card">
        <div class="card-header">
            <h4>Requests to Student</h4>
        </div>
        <div class="card-body">

            <div class="template-helper">
                Use a quick template to auto-fill the request form. The <strong>System Request</strong> template asks the student for the core technical system details needed for verification.
            </div>

            <div class="request-template-bar">
                <button type="button" class="template-btn system" onclick="fillSystemRequestTemplate()">
                    <i class="fa fa-cogs me-1"></i> Use System Request Template
                </button>

                <button type="button" class="template-btn" onclick="fillMinimalSystemRequestTemplate()">
                    <i class="fa fa-shield me-1"></i> Use Minimal System Request
                </button>

                <button type="button" class="template-btn" onclick="clearRequestTemplate()">
                    <i class="fa fa-eraser me-1"></i> Clear Form
                </button>
            </div>

            <form method="POST" action="{{ route('supervisor.projects.requests.store', $project->project_id) }}" class="mb-4">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="request-box">
                            <label>Request Title</label>
                            <input type="text" id="request_title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Example: Submit GitHub Repository Link" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="request-box">
                            <label>Request Type</label>
                            <select id="request_type" name="request_type" class="form-control" required>
                                <option value="">Select type</option>
                                <option value="system_verification">System Verification</option>
                                <option value="github_link">GitHub Link</option>
                                <option value="deployment_link">Deployment Link</option>
                                <option value="images">Images</option>
                                <option value="video_demo">Video Demo</option>
                                <option value="documentation">Documentation</option>
                                <option value="pdf_file">PDF File</option>
                                <option value="source_code">Source Code</option>
                                <option value="presentation">Presentation</option>
                                <option value="clarification">Clarification</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="request-box">
                            <label>Description</label>
                            <textarea id="request_description" name="description" rows="8" class="form-control" placeholder="Write exactly what you want from the student...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="request-box">
                            <label>Due Date</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-dark">Send Request</button>
                    </div>
                </div>
            </form>

            <hr>

            <h5 class="mb-3">Student Requests</h5>

            @forelse($projectRequests as $requestItem)
                @php
                    $isSystemRequest = strtolower($requestItem->request_type ?? '') === 'system_verification';
                    $collapseId = 'response-collapse-' . $requestItem->id;
                    $buttonId = 'response-button-' . $requestItem->id;
                @endphp

                <div class="request-item">
                    <div class="request-title">{{ $requestItem->title }}</div>

                    <div class="request-meta">
                        {{ ucfirst(str_replace('_', ' ', $requestItem->request_type)) }}
                        @if($requestItem->due_date)
                            • Due: {{ \Carbon\Carbon::parse($requestItem->due_date)->format('d/m/Y') }}
                        @endif
                    </div>

                    <div class="mb-2 text-muted">
                        {!! nl2br(e($requestItem->description ?: 'No description provided.')) !!}
                    </div>

                    <div class="request-actions">
                        <form method="POST" action="{{ route('supervisor.requests.status', $requestItem->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button class="btn btn-success btn-sm">Mark Completed</button>
                        </form>

                        <form method="POST" action="{{ route('supervisor.requests.status', $requestItem->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button class="btn btn-danger btn-sm">Cancel</button>
                        </form>

                        <form method="POST" action="{{ route('supervisor.requests.status', $requestItem->id) }}">
                            @csrf
                            <input type="hidden" name="status" value="pending">
                            <button class="btn btn-secondary btn-sm">Reset</button>
                        </form>

                        <span class="badge bg-light text-dark border align-self-center">
                            {{ ucfirst($requestItem->status ?? 'pending') }}
                        </span>
                    </div>

                    @if($requestItem->latestResponse)
                        <button type="button"
                                id="{{ $buttonId }}"
                                class="response-toggle-btn"
                                onclick="toggleResponse('{{ $collapseId }}', '{{ $buttonId }}')">
                            <span>
                                {{ $isSystemRequest ? 'View Student System Response' : 'View Student Response' }}
                            </span>
                            <i class="fa fa-chevron-down response-toggle-icon"></i>
                        </button>

                        <div id="{{ $collapseId }}" class="response-collapse">
                            @if($isSystemRequest)
                                @php
                                    $systemText = $requestItem->latestResponse->response_text ?? '';

                                    $reqParsed = [
                                        'frontend_url'     => null,
                                        'backend_url'      => null,
                                        'api_health_url'   => null,
                                        'admin_panel_url'  => null,
                                        'demo_account'     => null,
                                        'demo_password'    => null,
                                        'deployment_notes' => null,
                                    ];

                                    if (preg_match('/Frontend URL:\s*(.+)/i', $systemText, $m)) {
                                        $reqParsed['frontend_url'] = trim($m[1]);
                                    }
                                    if (preg_match('/Backend URL:\s*(.+)/i', $systemText, $m)) {
                                        $reqParsed['backend_url'] = trim($m[1]);
                                    }
                                    if (preg_match('/API Health \/ API Base URL:\s*(.+)/i', $systemText, $m)) {
                                        $reqParsed['api_health_url'] = trim($m[1]);
                                    } elseif (preg_match('/API URL:\s*(.+)/i', $systemText, $m)) {
                                        $reqParsed['api_health_url'] = trim($m[1]);
                                    } elseif (preg_match('/API Health URL:\s*(.+)/i', $systemText, $m)) {
                                        $reqParsed['api_health_url'] = trim($m[1]);
                                    }
                                    if (preg_match('/Admin Panel URL:\s*(.+)/i', $systemText, $m)) {
                                        $reqParsed['admin_panel_url'] = trim($m[1]);
                                    }
                                    if (preg_match('/Demo Account:\s*(.+)/i', $systemText, $m)) {
                                        $reqParsed['demo_account'] = trim($m[1]);
                                    }
                                    if (preg_match('/Demo Password:\s*(.+)/i', $systemText, $m)) {
                                        $reqParsed['demo_password'] = trim($m[1]);
                                    }
                                    if (preg_match('/Deployment Notes:\s*([\s\S]+)/i', $systemText, $m)) {
                                        $reqParsed['deployment_notes'] = trim($m[1]);
                                    }
                                @endphp

                                <div class="student-response-box">
                                    <div class="student-response-title">Latest Student System Verification Response</div>

                                    <div class="student-response-meta">
                                        Student: {{ $requestItem->student?->name ?? 'Student' }}
                                        @if($requestItem->latestResponse->submitted_at)
                                            • Submitted: {{ \Carbon\Carbon::parse($requestItem->latestResponse->submitted_at)->format('d/m/Y h:i A') }}
                                        @endif
                                    </div>

                                    <div class="system-grid">
                                        <div class="system-info-card">
                                            <div class="system-info-label">Frontend URL</div>
                                            <div class="system-info-value">{{ $reqParsed['frontend_url'] ?: '—' }}</div>
                                        </div>

                                        <div class="system-info-card">
                                            <div class="system-info-label">Backend URL</div>
                                            <div class="system-info-value">{{ $reqParsed['backend_url'] ?: '—' }}</div>
                                        </div>

                                        <div class="system-info-card">
                                            <div class="system-info-label">API Health URL</div>
                                            <div class="system-info-value">{{ $reqParsed['api_health_url'] ?: '—' }}</div>
                                        </div>

                                        <div class="system-info-card">
                                            <div class="system-info-label">Admin Panel URL</div>
                                            <div class="system-info-value">{{ $reqParsed['admin_panel_url'] ?: '—' }}</div>
                                        </div>

                                        <div class="system-info-card">
                                            <div class="system-info-label">Demo Account</div>
                                            <div class="system-info-value">{{ $reqParsed['demo_account'] ?: '—' }}</div>
                                        </div>

                                        <div class="system-info-card">
                                            <div class="system-info-label">Demo Password</div>
                                            <div class="system-info-value">{{ $reqParsed['demo_password'] ?: '—' }}</div>
                                        </div>

                                        <div class="system-info-card" style="grid-column: 1 / -1;">
                                            <div class="system-info-label">Deployment Notes</div>
                                            <div class="system-info-value">{{ $reqParsed['deployment_notes'] ?: '—' }}</div>
                                        </div>
                                    </div>

                                    @if($requestItem->latestResponse->attachment_path)
                                        <div class="student-response-links mt-3">
                                            <a href="{{ route('supervisor.file.view', $requestItem->latestResponse->id) }}" target="_blank" class="response-link-btn">
                                                Download Attachment
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="student-response-box">
                                    <div class="student-response-title">Latest Student Response</div>

                                    <div class="student-response-meta">
                                        Student: {{ $requestItem->student?->name ?? 'Student' }}
                                        @if($requestItem->latestResponse->submitted_at)
                                            • Submitted: {{ \Carbon\Carbon::parse($requestItem->latestResponse->submitted_at)->format('d/m/Y h:i A') }}
                                        @endif
                                    </div>

                                    @if($requestItem->latestResponse->response_text)
                                        <div class="student-response-text">
                                            {{ $requestItem->latestResponse->response_text }}
                                        </div>
                                    @endif

                                    @if($requestItem->latestResponse->response_link || $requestItem->latestResponse->attachment_path)
                                        <div class="student-response-links">
                                            @if($requestItem->latestResponse->response_link)
                                                <a href="{{ $requestItem->latestResponse->response_link }}" target="_blank" class="response-link-btn">
                                                    Open Submitted Link
                                                </a>
                                            @endif

                                            @if($requestItem->latestResponse->attachment_path)
                                                <a href="{{ route('supervisor.file.view', $requestItem->latestResponse->id) }}" target="_blank" class="response-link-btn">
                                                    Download Attachment
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="student-response-box">
                            <div class="student-response-title">Student Response</div>
                            <div class="text-muted mb-0">No response submitted by the student yet.</div>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-muted mb-0">No requests sent yet.</p>
            @endforelse
        </div>
    </div>

    {{-- MEETINGS --}}
    <div class="card section-card">
        <div class="card-header">
            <h4>Meetings & Demo</h4>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('supervisor.projects.meetings.store') }}" class="mb-4">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->project_id }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meeting Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Demo Session / Viva / Final Review" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meeting Type</label>
                        <select name="meeting_type" class="form-control" required>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                            <option value="demo">Demo</option>
                            <option value="viva">Viva</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meeting Date</label>
                        <input type="date" name="meeting_date" class="form-control" value="{{ old('meeting_date') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meeting Time</label>
                        <input type="time" name="meeting_time" class="form-control" value="{{ old('meeting_time') }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Meeting Link</label>
                        <input type="url" name="meeting_link" class="form-control" value="{{ old('meeting_link') }}" placeholder="https://meet.google.com/...">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" rows="4" class="form-control" placeholder="Agenda, demo instructions, required features to show, or session notes.">{{ old('notes') }}</textarea>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-success">Schedule Meeting</button>
                    </div>
                </div>
            </form>

            <hr>

            <h5 class="mb-3">Scheduled Meetings</h5>

            @forelse($meetings->sortByDesc('meeting_date') as $meeting)
                <div class="meeting-item">
                    <div class="meeting-title">{{ $meeting->title }}</div>
                    <div class="meeting-meta">
                        {{ ucfirst($meeting->meeting_type) }} • {{ $meeting->meeting_date }} • {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') }}
                    </div>

                    @if($meeting->meeting_link)
                        <div class="mb-2">
                            <a href="{{ $meeting->meeting_link }}" target="_blank" class="verification-btn">Open Meeting Link</a>
                        </div>
                    @endif

                    @if($meeting->notes)
                        <div class="text-muted mb-3">{{ $meeting->notes }}</div>
                    @endif

                    <div class="meeting-actions">
                        <form method="POST" action="{{ route('supervisor.projects.meetings.status', ['project' => $project->project_id, 'meeting' => $meeting->id]) }}">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button class="btn btn-success btn-sm">Complete</button>
                        </form>

                        <form method="POST" action="{{ route('supervisor.projects.meetings.status', ['project' => $project->project_id, 'meeting' => $meeting->id]) }}">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button class="btn btn-danger btn-sm">Cancel</button>
                        </form>

                        <form method="POST" action="{{ route('supervisor.projects.meetings.status', ['project' => $project->project_id, 'meeting' => $meeting->id]) }}">
                            @csrf
                            <input type="hidden" name="status" value="scheduled">
                            <button class="btn btn-secondary btn-sm">Reset</button>
                        </form>

                        <span class="badge bg-light text-dark border align-self-center">
                            {{ ucfirst($meeting->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">No meetings scheduled yet.</p>
            @endforelse
        </div>
    </div>

    {{-- PROJECT OVERVIEW --}}
    <div class="card section-card">
        <div class="card-header">
            <h4>Project Overview</h4>
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
        </div>
    </div>

    {{-- PEOPLE --}}
    <div class="card section-card">
        <div class="card-header">
            <h4>People & Assignment</h4>
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

    {{-- SCAN SUMMARY --}}
    <div class="card section-card">
        <div class="card-header">
            <h4>Scan Intelligence Summary</h4>
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

    {{-- MEDIA --}}
    <div class="card section-card">
        <div class="card-header">
            <h4>Project Media</h4>
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

<script>
    function fillSystemRequestTemplate() {
        document.getElementById('request_title').value = 'Complete System Verification Requirements';
        document.getElementById('request_type').value = 'system_verification';
        document.getElementById('request_description').value =
`Please submit the core system verification details for this project.

Required items:
1. Frontend URL
2. Backend URL
3. API Health URL or API Base URL
4. Demo Account
5. Demo Password

Optional items:
6. Admin Panel URL
7. Deployment Notes / Hosting Notes

Please send all available details clearly in one response. If any item is not available yet, mention that explicitly.`;
    }

    function fillMinimalSystemRequestTemplate() {
        document.getElementById('request_title').value = 'Submit Essential System Access Details';
        document.getElementById('request_type').value = 'system_verification';
        document.getElementById('request_description').value =
`Please provide the minimum required system details for technical verification.

At minimum, send these 4 items:
1. Frontend URL
2. Backend URL or API URL
3. Demo Account
4. Demo Password

You may also include:
- Admin Panel URL
- Deployment Notes

Please reply in a clean and organized format.`;
    }

    function clearRequestTemplate() {
        document.getElementById('request_title').value = '';
        document.getElementById('request_type').value = '';
        document.getElementById('request_description').value = '';
    }

    function toggleResponse(collapseId, buttonId) {
        const collapse = document.getElementById(collapseId);
        const button = document.getElementById(buttonId);

        if (collapse.classList.contains('show')) {
            collapse.classList.remove('show');
            button.classList.remove('active');
        } else {
            collapse.classList.add('show');
            button.classList.add('active');
        }
    }
</script>
@endsection