@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root {
        --page-bg: #f5f7fb;
        --card-bg: #ffffff;
        --text-main: #172033;
        --text-soft: #7b8497;
        --border-color: #e8ecf4;
        --primary-color: #4e73df;
        --primary-soft: rgba(78, 115, 223, 0.10);
        --info-color: #36b9cc;
        --success-color: #1cc88a;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --shadow-sm: 0 8px 20px rgba(18, 38, 63, 0.06);
        --shadow-md: 0 14px 36px rgba(18, 38, 63, 0.10);
        --radius-xl: 24px;
        --radius-lg: 20px;
        --radius-md: 16px;
        --radius-sm: 12px;
    }

    body {
        background: var(--page-bg);
    }

    .create-project-page {
        padding: 10px 0 24px;
    }

    .page-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 26px 28px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .page-title {
        margin: 0;
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .page-subtitle {
        margin: 8px 0 0;
        color: var(--text-soft);
        font-size: 0.96rem;
    }

    .custom-alert {
        border: none;
        border-radius: 14px;
        box-shadow: var(--shadow-sm);
    }

    .reset-btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
        padding: 10px 18px;
        background: #eef2f8;
        color: #344054;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .reset-btn:hover {
        color: #344054;
        text-decoration: none;
    }

    .search-btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
        padding: 10px 18px;
    }

    .main-panel {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .panel-head {
        padding: 22px 24px 10px;
        border-bottom: 1px solid rgba(232, 236, 244, 0.7);
    }

    .panel-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .panel-subtitle {
        margin-top: 6px;
        color: var(--text-soft);
        font-size: 0.9rem;
    }

    .table-wrap {
        padding: 20px 24px 26px;
    }

    .form-label-custom {
        font-size: 0.82rem;
        color: var(--text-soft);
        font-weight: 700;
        margin-bottom: 8px;
        display: block;
    }

    .form-control.custom-input,
    .form-select.custom-input {
        min-height: 46px;
        border-radius: 14px;
        border: 1px solid #dfe5ef;
        box-shadow: none;
        padding: 12px 14px;
    }

    .form-control.custom-input:focus,
    .form-select.custom-input:focus {
        border-color: rgba(78, 115, 223, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.12);
    }

    textarea.custom-input {
        min-height: 120px;
        resize: vertical;
    }

    .helper-text {
        font-size: 12px;
        color: #64748b;
        margin-top: 6px;
    }

    .section-note {
        background: #f8fbff;
        border: 1px solid #dbeafe;
        color: #335c85;
        padding: 14px 16px;
        border-radius: 14px;
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 18px;
    }

    .preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 12px;
    }

    .preview-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px;
    }

    .preview-card img,
    .preview-card video {
        display: block;
        max-width: 180px;
        border-radius: 10px;
        border: 1px solid #dbe4f0;
    }

    .preview-card video {
        max-width: 320px;
    }

    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    @media (max-width: 991px) {
        .page-header-card {
            padding: 22px 20px;
        }

        .panel-head,
        .table-wrap {
            padding-left: 18px;
            padding-right: 18px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.3rem;
        }
    }
</style>

<div class="container-fluid create-project-page">

    @if ($errors->any())
        <div class="alert alert-danger custom-alert mb-4">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-header-card">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="page-title">Create New Project</h1>
                <p class="page-subtitle">
                    Create a complete project record, assign responsible users, set workflow status, and upload project media professionally.
                </p>
            </div>

            <div>
                <a href="{{ route('admin.projects.index') }}" class="reset-btn px-4">
                    <i class="fa fa-arrow-left mr-1"></i> Back to Projects
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title">Project Information</h2>
                <div class="panel-subtitle">Basic identity, classification, and description for the project.</div>
            </div>
            <div class="table-wrap">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom">Project Name *</label>
                        <input type="text" name="name" class="form-control custom-input" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom">Category</label>
                        <select name="category" class="form-select custom-input">
                            <option value="">Select category</option>
                            <option value="ai_ml" {{ old('category')=='ai_ml' ? 'selected' : '' }}>Artificial Intelligence & Machine Learning</option>
                            <option value="biotech" {{ old('category')=='biotech' ? 'selected' : '' }}>Biotechnology & Life Sciences</option>
                            <option value="materials" {{ old('category')=='materials' ? 'selected' : '' }}>Advanced Materials & Nanotech</option>
                            <option value="energy" {{ old('category')=='energy' ? 'selected' : '' }}>Renewable Energy & Sustainability</option>
                            <option value="quantum" {{ old('category')=='quantum' ? 'selected' : '' }}>Quantum Computing & Physics</option>
                            <option value="aero" {{ old('category')=='aero' ? 'selected' : '' }}>Aerospace & Robotics</option>
                            <option value="other" {{ old('category')=='other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-0">
                        <label class="form-label-custom">Description</label>
                        <textarea name="description" class="form-control custom-input" rows="5">{{ old('description') }}</textarea>
                        <div class="helper-text">
                            Add a short professional description explaining the project idea, purpose, and expected value.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title">Assign Users</h2>
                <div class="panel-subtitle">Select the people associated with this project.</div>
            </div>
            <div class="table-wrap">
                <div class="section-note">
                    Select the users related to this project. Student assignment is required, while other roles are optional and can be updated later.
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom">Student *</label>
                        <select name="student_id" class="form-select custom-input" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom">Supervisor</label>
                        <select name="supervisor_id" class="form-select custom-input">
                            <option value="">Select Supervisor</option>
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                    {{ $supervisor->name }} ({{ $supervisor->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom">Manager</label>
                        <select name="manager_id" class="form-select custom-input">
                            <option value="">Select Manager</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }} ({{ $manager->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-0">
                        <label class="form-label-custom">Investor</label>
                        <select name="investor_id" class="form-select custom-input">
                            <option value="">Select Investor</option>
                            @foreach($investors as $investor)
                                <option value="{{ $investor->id }}" {{ old('investor_id') == $investor->id ? 'selected' : '' }}>
                                    {{ $investor->name }} ({{ $investor->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title">Status & Meta Information</h2>
                <div class="panel-subtitle">Workflow state, progress, dates, budget, and project settings.</div>
            </div>
            <div class="table-wrap">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom">Status *</label>
                        <select name="status" class="form-select custom-input" required>
                            <option value="pending" {{ old('status')=='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="scan_requested" {{ old('status')=='scan_requested' ? 'selected' : '' }}>Scan Requested</option>
                            <option value="awaiting_manual_review" {{ old('status')=='awaiting_manual_review' ? 'selected' : '' }}>Awaiting Manual Review</option>
                            <option value="approved" {{ old('status')=='approved' ? 'selected' : '' }}>Approved</option>
                            <option value="published" {{ old('status')=='published' ? 'selected' : '' }}>Published</option>
                            <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status')=='completed' ? 'selected' : '' }}>Completed</option>
                            <option value="rejected" {{ old('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="scan_failed" {{ old('status')=='scan_failed' ? 'selected' : '' }}>Scan Failed</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom">Budget</label>
                        <input type="number" step="0.01" min="0" name="budget" class="form-control custom-input" value="{{ old('budget') }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom">Priority</label>
                        <select name="priority" class="form-select custom-input">
                            <option value="Low" {{ old('priority')=='Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('priority', 'Medium')=='Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('priority')=='High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom">Start Date</label>
                        <input type="date" name="start_date" class="form-control custom-input" value="{{ old('start_date') }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom">End Date</label>
                        <input type="date" name="end_date" class="form-control custom-input" value="{{ old('end_date') }}">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-custom">Progress (%)</label>
                        <input type="number" name="progress" class="form-control custom-input" value="{{ old('progress', 0) }}" min="0" max="100">
                    </div>

                    <div class="col-md-12 mb-0">
                        <div class="form-check mt-2">
                            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label font-weight-bold" for="is_featured">
                                Featured Project
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-panel form-animate">
            <div class="panel-head">
                <h2 class="panel-title">Media Upload</h2>
                <div class="panel-subtitle">Upload project images and video previews.</div>
            </div>
            <div class="table-wrap">
                <div class="section-note">
                    Upload project photos and a project video if available. These files will be attached to the project using the same media structure used by students.
                </div>

                <div class="mb-4">
                    <label class="form-label-custom">Project Photos (multiple)</label>
                    <input type="file"
                           name="project_photos[]"
                           multiple
                           accept="image/*"
                           class="form-control custom-input"
                           onchange="previewSpecific(this, 'images_preview')">
                    <div id="images_preview" class="preview-grid"></div>
                </div>

                <div class="mb-0">
                    <label class="form-label-custom">Project Video (single)</label>
                    <input type="file"
                           name="project_video"
                           accept="video/*"
                           class="form-control custom-input"
                           onchange="previewSpecific(this, 'videos_preview')">
                    <div id="videos_preview" class="preview-grid"></div>
                </div>
            </div>
        </div>

        <div class="action-bar">
            <button type="submit" class="btn btn-primary search-btn">
                <i class="fa fa-check-circle mr-1"></i> Create Project
            </button>

            <a href="{{ route('admin.projects.index') }}" class="reset-btn">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function previewSpecific(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    const files = input.files;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const wrapper = document.createElement('div');
        wrapper.className = 'preview-card';

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            wrapper.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            wrapper.appendChild(video);
        } else {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.textContent = 'File: ' + file.name;
            link.target = '_blank';
            wrapper.appendChild(link);
        }

        preview.appendChild(wrapper);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.page-header-card, .form-animate').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';

        setTimeout(() => {
            card.style.transition = 'all 0.35s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 80 * (index + 1));
    });
});
</script>
@endsection