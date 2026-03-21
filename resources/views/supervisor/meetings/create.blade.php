@extends('supervisor.layout.app_super')

@section('title', 'Create Meeting')

@section('content')
@php
    $totalProjects = $projects->count();
    $demoProjects = $projects->filter(function ($project) {
        return strtolower($project->status ?? '') === 'active';
    })->count();
    $completedProjects = $projects->filter(function ($project) {
        return strtolower($project->status ?? '') === 'completed';
    })->count();
    $avgScore = $projects->whereNotNull('scan_score')->avg('scan_score');
@endphp

<style>
    .meeting-page .page-header-card {
        background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
        border-radius: 20px;
        padding: 28px 30px;
        color: #fff;
        box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
    }

    .meeting-page .page-header-card h3 {
        margin: 0;
        font-weight: 700;
        color: #fff;
    }

    .meeting-page .page-header-card p {
        margin: 8px 0 0;
        opacity: 0.9;
    }

    .meeting-page .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .meeting-page .btn-outline-header {
        border: 1px solid rgba(255,255,255,.35);
        color: #fff;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 600;
        text-decoration: none;
        background: rgba(255,255,255,.08);
        transition: all 0.3s ease;
    }

    .meeting-page .btn-outline-header:hover {
        color: #fff;
        text-decoration: none;
        background: rgba(255,255,255,.14);
    }

    .meeting-page .stats-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        border: 1px solid #eef2ff;
        height: 100%;
        transition: 0.3s ease;
    }

    .meeting-page .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
    }

    .meeting-page .stats-icon {
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

    .meeting-page .stats-icon.primary { background: linear-gradient(135deg, #1b00ff, #4f46e5); }
    .meeting-page .stats-icon.success { background: linear-gradient(135deg, #059669, #10b981); }
    .meeting-page .stats-icon.warning { background: linear-gradient(135deg, #d97706, #f59e0b); }
    .meeting-page .stats-icon.info { background: linear-gradient(135deg, #0891b2, #06b6d4); }

    .meeting-page .stats-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .meeting-page .stats-label {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0;
    }

    .meeting-page .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .meeting-page .form-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #eef2f7;
        background: #fff;
    }

    .meeting-page .form-card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #0f172a;
    }

    .meeting-page .form-card-header p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .meeting-page .form-card-body {
        padding: 24px;
    }

    .meeting-page .section-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 16px;
    }

    .meeting-page .form-label {
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }

    .meeting-page .form-control,
    .meeting-page .form-select,
    .meeting-page textarea {
        border-radius: 14px;
        border: 1px solid #dbe4f0;
        min-height: 48px;
        padding: 12px 14px;
        box-shadow: none;
        transition: all 0.25s ease;
        font-size: 14px;
    }

    .meeting-page textarea.form-control {
        min-height: auto;
    }

    .meeting-page .form-control:focus,
    .meeting-page .form-select:focus,
    .meeting-page textarea:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }

    .meeting-page .input-helper {
        font-size: 12px;
        color: #64748b;
        margin-top: 6px;
    }

    .meeting-page .section-box {
        border: 1px solid #eef2ff;
        border-radius: 18px;
        padding: 20px;
        background: #fcfdff;
        margin-bottom: 20px;
    }

    .meeting-page .btn-submit {
        background: linear-gradient(135deg, #1b00ff, #4338ca);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 12px 22px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(27, 0, 255, 0.18);
    }

    .meeting-page .btn-submit:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 25px rgba(27, 0, 255, 0.22);
    }

    .meeting-page .btn-light-alt {
        background: #f8fafc;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 18px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .meeting-page .btn-light-alt:hover {
        text-decoration: none;
        color: #0f172a;
        background: #f1f5f9;
    }

    .meeting-page .alert {
        border-radius: 14px;
    }

    .meeting-page .invalid-feedback {
        display: block;
        font-size: 12px;
        margin-top: 6px;
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 meeting-page">
    <div class="min-height-200px">

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <strong class="d-block mb-2">Please review the form inputs.</strong>
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="page-header-card mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                <div>
                    <h3>Create Meeting</h3>
                    <p>Schedule a demo, viva, or review meeting with the student for a selected project.</p>
                </div>

                <div class="header-actions">
                    <a href="{{ route('supervisor.meetings.index') }}" class="btn-outline-header">
                        <i class="fa fa-calendar mr-1"></i> All Meetings
                    </a>
                    <a href="{{ route('supervisor.projects.index') }}" class="btn-outline-header">
                        <i class="fa fa-folder-open mr-1"></i> My Projects
                    </a>
                </div>
            </div>
        </div>

        
        <div class="form-card">
            <div class="form-card-header">
                <h5>Meeting Details</h5>
                <p>Fill in the required information below to create a new meeting session.</p>
            </div>

            <div class="form-card-body">
                <form method="POST" action="{{ route('supervisor.projects.meetings.store') }}">
                    @csrf

                    <div class="section-box">
                        <div class="section-title">Project & Session Information</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project</label>
                                <select name="project_id" class="form-control @error('project_id') is-invalid @enderror" required>
                                    <option value="">Select project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->project_id }}"
                                            {{ old('project_id') == $project->project_id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-helper">Choose the project this meeting belongs to.</div>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meeting Type</label>
                                <select name="meeting_type" class="form-control @error('meeting_type') is-invalid @enderror" required>
                                    <option value="">Select type</option>
                                    <option value="demo" {{ old('meeting_type') == 'demo' ? 'selected' : '' }}>Demo</option>
                                    <option value="review" {{ old('meeting_type') == 'review' ? 'selected' : '' }}>Review</option>
                                    <option value="viva" {{ old('meeting_type') == 'viva' ? 'selected' : '' }}>Viva</option>
                                    <option value="discussion" {{ old('meeting_type') == 'discussion' ? 'selected' : '' }}>Discussion</option>
                                </select>
                                <div class="input-helper">Define the purpose of this meeting session.</div>
                                @error('meeting_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meeting Title</label>
                                <input
                                    type="text"
                                    name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}"
                                    placeholder="Example: Final Demo Review Session"
                                    required
                                >
                                <div class="input-helper">Use a clear and professional title for the session.</div>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="section-box">
                        <div class="section-title">Date, Time & Link</div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Meeting Date</label>
                                <input
                                    type="date"
                                    name="meeting_date"
                                    class="form-control @error('meeting_date') is-invalid @enderror"
                                    value="{{ old('meeting_date') }}"
                                    required
                                >
                                @error('meeting_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Meeting Time</label>
                                <input
                                    type="time"
                                    name="meeting_time"
                                    class="form-control @error('meeting_time') is-invalid @enderror"
                                    value="{{ old('meeting_time') }}"
                                    required
                                >
                                @error('meeting_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Meeting Link</label>
                                <input
                                    type="url"
                                    name="meeting_link"
                                    class="form-control @error('meeting_link') is-invalid @enderror"
                                    value="{{ old('meeting_link') }}"
                                    placeholder="https://meet.google.com/..."
                                >
                                <div class="input-helper">Optional, but recommended for online meetings.</div>
                                @error('meeting_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="section-box mb-0">
                        <div class="section-title">Additional Notes</div>

                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <label class="form-label">Notes</label>
                                <textarea
                                    name="notes"
                                    rows="5"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Add agenda, review points, required materials, or any instructions for the student..."
                                >{{ old('notes') }}</textarea>
                                <div class="input-helper">This note can help the student understand what is expected during the session.</div>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end flex-wrap mt-4" style="gap: 12px;">
                        <a href="{{ route('supervisor.meetings.index') }}" class="btn-light-alt">
                            <i class="fa fa-arrow-left mr-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="fa fa-calendar-plus-o mr-1"></i> Create Meeting
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection