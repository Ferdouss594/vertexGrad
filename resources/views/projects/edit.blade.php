@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 14px;">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 14px;">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <style>
            .edit-project-page .page-header-card {
                background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
                border-radius: 20px;
                padding: 28px 30px;
                color: #fff;
                box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
                margin-bottom: 24px;
            }

            .edit-project-page .page-header-card h3 {
                margin: 0;
                font-weight: 700;
                color: #fff;
            }

            .edit-project-page .page-header-card p {
                margin: 8px 0 0;
                opacity: 0.9;
            }

            .edit-project-page .form-card {
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
                border: 1px solid #edf2f7;
                overflow: hidden;
                margin-bottom: 24px;
            }

            .edit-project-page .form-card-header {
                padding: 20px 24px;
                border-bottom: 1px solid #eef2f7;
                background: #f8fafc;
            }

            .edit-project-page .form-card-header h5 {
                margin: 0;
                font-weight: 700;
                color: #0f172a;
            }

            .edit-project-page .form-card-body {
                padding: 24px;
            }

            .edit-project-page .section-title {
                font-size: 16px;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 16px;
                padding-bottom: 8px;
                border-bottom: 1px solid #eef2f7;
            }

            .edit-project-page .form-group label {
                font-weight: 700;
                color: #334155;
                margin-bottom: 8px;
            }

            .edit-project-page .form-control,
            .edit-project-page .custom-select,
            .edit-project-page textarea {
                border-radius: 12px;
                border: 1px solid #dbe4f0;
                min-height: 46px;
                box-shadow: none;
            }

            .edit-project-page .form-control:focus,
            .edit-project-page .custom-select:focus,
            .edit-project-page textarea:focus {
                border-color: #4f46e5;
                box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.10);
            }

            .edit-project-page textarea.form-control {
                min-height: 120px;
            }

            .edit-project-page .info-box {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                padding: 16px;
                height: 100%;
            }

            .edit-project-page .info-label {
                font-size: 12px;
                font-weight: 700;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: .4px;
                margin-bottom: 6px;
            }

            .edit-project-page .info-value {
                font-size: 16px;
                font-weight: 700;
                color: #0f172a;
                word-break: break-word;
            }

            .edit-project-page .badge-soft {
                display: inline-block;
                padding: 7px 12px;
                border-radius: 999px;
                font-size: 12px;
                font-weight: 700;
            }

            .edit-project-page .badge-status-pending {
                background: #fff7ed;
                color: #c2410c;
            }

            .edit-project-page .badge-status-approved {
                background: #ecfdf5;
                color: #15803d;
            }

            .edit-project-page .badge-status-rejected {
                background: #fef2f2;
                color: #dc2626;
            }

            .edit-project-page .badge-status-default {
                background: #eff6ff;
                color: #1d4ed8;
            }

            .edit-project-page .btn-main {
                background: linear-gradient(135deg, #1b00ff, #4338ca);
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 11px 20px;
                font-weight: 700;
                box-shadow: 0 10px 20px rgba(27, 0, 255, 0.15);
            }

            .edit-project-page .btn-main:hover {
                color: #fff;
                opacity: 0.95;
            }

            .edit-project-page .btn-add-student {
                background: linear-gradient(135deg, #16a34a, #22c55e);
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 10px 16px;
                font-weight: 700;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 46px;
            }

            .edit-project-page .btn-add-student:hover {
                color: #fff;
                text-decoration: none;
                opacity: 0.95;
            }

            .edit-project-page .btn-light-custom {
                border-radius: 12px;
                padding: 11px 20px;
                font-weight: 700;
            }

            .edit-project-page .notice-box {
                border-radius: 16px;
                padding: 16px 18px;
                margin-bottom: 18px;
                border: 1px solid transparent;
            }

            .edit-project-page .notice-info {
                background: #eff6ff;
                border-color: #bfdbfe;
                color: #1e40af;
            }

            .edit-project-page .notice-success {
                background: #ecfdf5;
                border-color: #bbf7d0;
                color: #166534;
            }

            .edit-project-page .student-row {
                display: grid;
                grid-template-columns: 1fr auto;
                gap: 12px;
                align-items: end;
            }

            @media (max-width: 768px) {
                .edit-project-page .student-row {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="edit-project-page">

            <div class="page-header-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                    <div>
                        <h3>Edit Project</h3>
                        <p>Update project details, assign related users, manage workflow status, and keep the record organized professionally.</p>
                    </div>

                    <div class="d-flex flex-wrap" style="gap: 10px;">
                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-light btn-light-custom">
                            <i class="fa fa-eye mr-1"></i> View Project
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-light btn-light-custom">
                            <i class="fa fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            @if(in_array($project->status, ['pending', 'active', 'draft']))
                <div class="notice-box notice-info">
                    <strong>Scanner Action Available:</strong>
                    This project can be sent to the scanner platform for technical analysis when you are ready.
                </div>
            @endif

            @if(in_array($project->status, ['scan_requested', 'awaiting_manual_review']))
                <div class="notice-box notice-info">
                    <strong>Project Under Review:</strong>
                    This project has already entered the scanning/review workflow.
                </div>
            @endif

            @if(in_array($project->status, ['approved', 'published', 'completed']))
                <div class="notice-box notice-success">
                    <strong>Approved Workflow:</strong>
                    This project has already passed the approval stage and the student can now upload media files.
                </div>
            @endif

            <div class="form-card">
                <div class="form-card-header">
                    <h5>Project Actions</h5>
                </div>

                <div class="form-card-body">
                    <div class="d-flex flex-wrap" style="gap: 12px;">
                   <a href="{{ route('admin.projects.scannerReview', $project) }}" class="btn btn-outline-info">
    <i class="fa fa-search mr-1"></i> Go to Scan Page
</a>

                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-primary">
                            <i class="fa fa-folder-open mr-1"></i> Open Details
                        </a>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-card">
                    <div class="form-card-header">
                        <h5>Project Overview</h5>
                    </div>

                    <div class="form-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="section-title">Basic Information</div>

                                <div class="form-group mb-3">
                                    <label for="name">Project Name</label>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control"
                                           value="{{ old('name', $project->name) }}"
                                           required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="category">Category</label>
                                    <input type="text"
                                           id="category"
                                           name="category"
                                           class="form-control"
                                           value="{{ old('category', $project->category) }}"
                                           placeholder="e.g. Software, Healthcare, AI">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="budget">Budget</label>
                                    <input type="number"
                                           step="0.01"
                                           id="budget"
                                           name="budget"
                                           class="form-control"
                                           value="{{ old('budget', $project->budget) }}"
                                           placeholder="0.00">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="priority">Priority</label>
                                    <select id="priority" name="priority" class="custom-select form-control">
                                        <option value="Low" {{ old('priority', $project->priority) === 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Medium" {{ old('priority', $project->priority) === 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="High" {{ old('priority', $project->priority) === 'High' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="description">Description</label>
                                    <textarea id="description"
                                              name="description"
                                              class="form-control"
                                              rows="6"
                                              placeholder="Write a clear description of the project...">{{ old('description', $project->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="section-title">Status & System Information</div>

                                @php
                                    $statusClass = match($project->status) {
                                        'pending', 'scan_requested', 'awaiting_manual_review' => 'badge-status-pending',
                                        'approved', 'published', 'completed' => 'badge-status-approved',
                                        'rejected', 'scan_failed' => 'badge-status-rejected',
                                        default => 'badge-status-default',
                                    };
                                @endphp

                                <div class="mb-3">
                                    <span class="badge-soft {{ $statusClass }}">
                                        Current Status: {{ ucfirst(str_replace('_', ' ', $project->status ?? 'unknown')) }}
                                    </span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Project Status</label>
                                    <select id="status" name="status" class="custom-select form-control" required>
                                        <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="pending" {{ old('status', $project->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="scan_requested" {{ old('status', $project->status) === 'scan_requested' ? 'selected' : '' }}>Scan Requested</option>
                                        <option value="awaiting_manual_review" {{ old('status', $project->status) === 'awaiting_manual_review' ? 'selected' : '' }}>Awaiting Manual Review</option>
                                        <option value="approved" {{ old('status', $project->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="active" {{ old('status', $project->status) === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="rejected" {{ old('status', $project->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="scan_failed" {{ old('status', $project->status) === 'scan_failed' ? 'selected' : '' }}>Scan Failed</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <div class="info-box">
                                            <div class="info-label">Project ID</div>
                                            <div class="info-value">{{ $project->project_id ?? $project->id }}</div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="info-box">
                                            <div class="info-label">Scanner Status</div>
                                            <div class="info-value">{{ $project->scanner_status ?? '—' }}</div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="info-box">
                                            <div class="info-label">Scanner Project ID</div>
                                            <div class="info-value">{{ $project->scanner_project_id ?? '—' }}</div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="info-box">
                                            <div class="info-label">Scan Score</div>
                                            <div class="info-value">{{ $project->scan_score ?? '—' }}</div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="info-box">
                                            <div class="info-label">Created At</div>
                                            <div class="info-value">{{ optional($project->created_at)->format('Y-m-d h:i A') ?? '—' }}</div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="info-box">
                                            <div class="info-label">Updated At</div>
                                            <div class="info-value">{{ optional($project->updated_at)->format('Y-m-d h:i A') ?? '—' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-header">
                        <h5>Assignments</h5>
                    </div>

                    <div class="form-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="student_id">Student</label>
                                    <div class="student-row">
                                        <select id="student_id" name="student_id" class="custom-select form-control">
                                            <option value="">Select Student</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}"
                                                    {{ (string) old('student_id', $project->student_id) === (string) $student->id ? 'selected' : '' }}>
                                                    {{ $student->name }} - {{ $student->email }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <a href="{{ route('register.academic') }}" class="btn-add-student">
                                            <i class="fa fa-user-plus mr-1"></i> Add New Student
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="supervisor_id">Supervisor</label>
                                    <select id="supervisor_id" name="supervisor_id" class="custom-select form-control">
                                        <option value="">Select Supervisor</option>
                                        @foreach($supervisors as $supervisor)
                                            <option value="{{ $supervisor->id }}"
                                                {{ (string) old('supervisor_id', $project->supervisor_id) === (string) $supervisor->id ? 'selected' : '' }}>
                                                {{ $supervisor->name }} - {{ $supervisor->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="manager_id">Manager</label>
                                    <select id="manager_id" name="manager_id" class="custom-select form-control">
                                        <option value="">Select Manager</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}"
                                                {{ (string) old('manager_id', $project->manager_id) === (string) $manager->id ? 'selected' : '' }}>
                                                {{ $manager->name }} - {{ $manager->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="investor_id">Investor</label>
                                    <select id="investor_id" name="investor_id" class="custom-select form-control">
                                        <option value="">Select Investor</option>
                                        @foreach($investors as $investor)
                                            <option value="{{ $investor->id }}"
                                                {{ (string) old('investor_id', $project->investor_id) === (string) $investor->id ? 'selected' : '' }}>
                                                {{ $investor->name }} - {{ $investor->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap" style="gap: 12px;">
                    <button type="submit" class="btn btn-main">
                        <i class="fa fa-save mr-1"></i> Save Changes
                    </button>

                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-primary btn-light-custom">
                        <i class="fa fa-eye mr-1"></i> View
                    </a>

                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary btn-light-custom">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection