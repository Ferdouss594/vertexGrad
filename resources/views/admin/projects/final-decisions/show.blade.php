@extends('layouts.app')

@section('title', 'Final Decision Review')

@section('content')
@php
    $finalDecisionClass = match($project->final_decision) {
        'published' => 'badge-published',
        'revision_requested' => 'badge-revision',
        'rejected' => 'badge-rejected',
        default => 'badge-pending',
    };

    $finalDecisionText = match($project->final_decision) {
        'published' => 'Published',
        'revision_requested' => 'Revision Requested',
        'rejected' => 'Rejected',
        default => 'Pending',
    };

    $statusClass = match($project->status) {
        'published' => 'badge-published',
        'revision_requested' => 'badge-revision',
        'rejected' => 'badge-rejected',
        default => 'badge-pending',
    };
@endphp

<style>
    .manager-decision-page .hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
        border-radius: 22px;
        padding: 28px 30px;
        color: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.16);
        margin-bottom: 24px;
        border: none;
    }

    .manager-decision-page .hero-title {
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .manager-decision-page .hero-text {
        font-size: 14px;
        color: rgba(255,255,255,.88);
        margin-bottom: 0;
        max-width: 780px;
    }

    .manager-decision-page .section-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 22px;
    }

    .manager-decision-page .section-card .card-header {
        background: #fff;
        padding: 18px 22px;
        border-bottom: 1px solid #eef2f7;
    }

    .manager-decision-page .section-card .card-header h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .manager-decision-page .stats-card {
        background: #fff;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        height: 100%;
    }

    .manager-decision-page .stats-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .manager-decision-page .stats-value {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .manager-decision-page .badge-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .manager-decision-page .badge-published {
        background: #dcfce7;
        color: #166534;
    }

    .manager-decision-page .badge-revision {
        background: #fef3c7;
        color: #92400e;
    }

    .manager-decision-page .badge-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .manager-decision-page .badge-pending {
        background: #e2e8f0;
        color: #334155;
    }

    .manager-decision-page .detail-grid .item {
        padding: 14px 0;
        border-bottom: 1px dashed #e5e7eb;
    }

    .manager-decision-page .detail-grid .item:last-child {
        border-bottom: 0;
    }

    .manager-decision-page .detail-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .manager-decision-page .detail-value {
        font-size: 15px;
        color: #0f172a;
        font-weight: 600;
        word-break: break-word;
    }

    .manager-decision-page .review-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
        background: #fff;
        margin-bottom: 14px;
    }

    .manager-decision-page .review-title {
        font-weight: 800;
        font-size: 15px;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .manager-decision-page .review-meta {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .manager-decision-page .review-notes {
        color: #334155;
        white-space: pre-line;
    }

    .manager-decision-page .decision-form-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
    }

    .manager-decision-page .decision-form-box label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
        display: block;
    }

    .manager-decision-page .action-btn {
        border-radius: 12px;
        font-weight: 700;
        padding: 10px 16px;
    }
</style>

<div class="container-fluid manager-decision-page">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm" style="border-radius: 16px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 16px;">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="hero-card">
        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 16px;">
            <div>
                <div class="hero-title">{{ $project->name }}</div>
                <p class="hero-text">
                    Review all supervisor evaluations and record the final management decision for this project.
                </p>
            </div>

            <div class="d-flex flex-wrap" style="gap: 10px;">
                <span class="badge-soft {{ $statusClass }}">
                    Project Status: {{ ucfirst(str_replace('_', ' ', $project->status ?? 'draft')) }}
                </span>

                <span class="badge-soft {{ $finalDecisionClass }}">
                    Final Decision: {{ $finalDecisionText }}
                </span>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-label">Average Score</div>
                <div class="stats-value">{{ $averageScore }}</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-label">Approved Reviews</div>
                <div class="stats-value">{{ $approvedCount }}</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-label">Revision Requests</div>
                <div class="stats-value">{{ $revisionCount }}</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-label">Rejected Reviews</div>
                <div class="stats-value">{{ $rejectedCount }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="section-card">
                <div class="card-header">
                    <h5>Project Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row detail-grid">
                        <div class="col-md-6 item">
                            <div class="detail-label">Project ID</div>
                            <div class="detail-value">#{{ $project->project_id }}</div>
                        </div>

                        <div class="col-md-6 item">
                            <div class="detail-label">Category</div>
                            <div class="detail-value">{{ $project->category ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 item">
                            <div class="detail-label">Student</div>
                            <div class="detail-value">{{ $project->student?->name ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 item">
                            <div class="detail-label">Student Email</div>
                            <div class="detail-value">{{ $project->student?->email ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 item">
                            <div class="detail-label">Budget</div>
                            <div class="detail-value">{{ $project->budget ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 item">
                            <div class="detail-label">Priority</div>
                            <div class="detail-value">{{ $project->priority ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 item">
                            <div class="detail-label">Current Status</div>
                            <div class="detail-value">{{ ucfirst(str_replace('_', ' ', $project->status ?? 'draft')) }}</div>
                        </div>

                        <div class="col-md-6 item">
                            <div class="detail-label">Current Final Decision</div>
                            <div class="detail-value">{{ $finalDecisionText }}</div>
                        </div>

                        <div class="col-md-12 item">
                            <div class="detail-label">Project Description</div>
                            <div class="detail-value">{{ $project->description ?? '-' }}</div>
                        </div>

                        <div class="col-md-12 item">
                            <div class="detail-label">Last Decision By</div>
                            <div class="detail-value">
                                @if($project->finalDecisionMaker)
                                    {{ $project->finalDecisionMaker->name }}
                                    @if($project->final_decided_at)
                                        • {{ $project->final_decided_at->format('d/m/Y h:i A') }}
                                    @endif
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 item">
                            <div class="detail-label">Last Final Notes</div>
                            <div class="detail-value">{{ $project->final_notes ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="card-header">
                    <h5>Final Decision Form</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.projects.final-decisions.store', $project->project_id) }}">
                        @csrf

                        <div class="decision-form-box mb-3">
                            <label>Final Decision</label>
                            <select name="final_decision" class="form-control" required>
                                <option value="">Select final decision</option>
                                <option value="published" {{ old('final_decision', $project->final_decision) === 'published' ? 'selected' : '' }}>
                                    Publish Project
                                </option>
                                <option value="revision_requested" {{ old('final_decision', $project->final_decision) === 'revision_requested' ? 'selected' : '' }}>
                                    Request Revision
                                </option>
                                <option value="rejected" {{ old('final_decision', $project->final_decision) === 'rejected' ? 'selected' : '' }}>
                                    Reject Project
                                </option>
                            </select>
                        </div>

                        <div class="decision-form-box mb-3">
                            <label>Manager Notes</label>
                            <textarea name="final_notes" rows="6" class="form-control" placeholder="Write the final management justification, summary of supervisor evaluations, and final publication/revision/rejection rationale...">{{ old('final_notes', $project->final_notes) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary action-btn">
                            Save Final Decision
                        </button>

                        <a href="{{ route('admin.projects.final-decisions.index') }}" class="btn btn-light action-btn">
                            Back to List
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="section-card">
                <div class="card-header">
                    <h5>Supervisor Evaluations</h5>
                </div>
                <div class="card-body">
                    @forelse($project->reviews as $review)
                        @php
                            $decisionClass = match($review->decision) {
                                'approved' => 'badge-published',
                                'revision_requested' => 'badge-revision',
                                'rejected' => 'badge-rejected',
                                default => 'badge-pending',
                            };

                            $decisionText = ucfirst(str_replace('_', ' ', $review->decision ?? 'pending'));
                        @endphp

                        <div class="review-card">
                            <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 10px;">
                                <div>
                                    <div class="review-title">
                                        {{ $review->supervisor?->name ?? 'Supervisor' }}
                                    </div>
                                    <div class="review-meta">
                                        @if(!is_null($review->score))
                                            Score: <strong>{{ $review->score }}/100</strong>
                                        @else
                                            Score: <strong>-</strong>
                                        @endif

                                        @if($review->reviewed_at)
                                            • Reviewed: {{ $review->reviewed_at->format('d/m/Y h:i A') }}
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <span class="badge-soft {{ $decisionClass }}">
                                        {{ $decisionText }}
                                    </span>
                                </div>
                            </div>

                            <div class="review-notes">
                                {{ $review->notes ?? '-' }}
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No supervisor reviews available yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection