@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10 create-project-page">
    <div class="min-height-200px">

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 14px;">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <style>
            .create-project-page .page-header-card {
                background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
                border-radius: 20px;
                padding: 28px 30px;
                color: #fff;
                box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
                margin-bottom: 24px;
            }

            .create-project-page .page-header-card h3 {
                margin: 0;
                font-weight: 700;
                color: #fff;
            }

            .create-project-page .page-header-card p {
                margin: 8px 0 0;
                opacity: 0.9;
            }

            .create-project-page .form-card {
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
                border: 1px solid #edf2f7;
                overflow: hidden;
                margin-bottom: 24px;
            }

            .create-project-page .form-card-header {
                padding: 20px 24px;
                border-bottom: 1px solid #eef2f7;
                background: #f8fafc;
            }

            .create-project-page .form-card-header h5 {
                margin: 0;
                font-weight: 700;
                color: #0f172a;
            }

            .create-project-page .form-card-body {
                padding: 24px;
            }

            .create-project-page .form-group label,
            .create-project-page .form-label {
                font-weight: 700;
                color: #334155;
                margin-bottom: 8px;
            }

            .create-project-page .form-control,
            .create-project-page .form-select,
            .create-project-page textarea,
            .create-project-page select {
                border-radius: 12px;
                border: 1px solid #dbe4f0;
                min-height: 46px;
                box-shadow: none;
            }

            .create-project-page .form-control:focus,
            .create-project-page .form-select:focus,
            .create-project-page textarea:focus,
            .create-project-page select:focus {
                border-color: #4f46e5;
                box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.10);
            }

            .create-project-page textarea.form-control {
                min-height: 120px;
            }

            .create-project-page .helper-text {
                font-size: 12px;
                color: #64748b;
                margin-top: 6px;
            }

            .create-project-page .btn-main {
                background: linear-gradient(135deg, #16a34a, #22c55e);
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 11px 20px;
                font-weight: 700;
                box-shadow: 0 10px 20px rgba(34, 197, 94, 0.18);
            }

            .create-project-page .btn-main:hover {
                color: #fff;
                opacity: 0.95;
            }

            .create-project-page .btn-back {
                border-radius: 12px;
                padding: 11px 20px;
                font-weight: 700;
            }

            .create-project-page .preview-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 12px;
            }

            .create-project-page .preview-card {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                padding: 10px;
            }

            .create-project-page .preview-card img,
            .create-project-page .preview-card video {
                display: block;
                max-width: 180px;
                border-radius: 10px;
                border: 1px solid #dbe4f0;
            }

            .create-project-page .preview-card video {
                max-width: 320px;
            }

            .create-project-page .section-note {
                background: #eff6ff;
                border: 1px solid #bfdbfe;
                color: #1e40af;
                padding: 14px 16px;
                border-radius: 14px;
                font-size: 13px;
                line-height: 1.7;
                margin-bottom: 18px;
            }
        </style>

        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                <div>
                    <h3>Create New Project</h3>
                    <p>Create a complete project record, assign responsible users, set workflow status, and upload project media professionally.</p>
                </div>

                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-light btn-back">
                    <i class="fa fa-arrow-left mr-1"></i> Back to Projects
                </a>
            </div>
        </div>

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Project Information --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h5>Project Information</h5>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Project Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
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
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                            <div class="helper-text">
                                Add a short professional description explaining the project idea, purpose, and expected value.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Assign Users --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h5>Assign Users</h5>
                </div>
                <div class="form-card-body">
                    <div class="section-note">
                        Select the users related to this project. Student assignment is required, while other roles are optional and can be updated later.
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Student *</label>
                            <select name="student_id" class="form-select" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Supervisor</label>
                            <select name="supervisor_id" class="form-select">
                                <option value="">Select Supervisor</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                        {{ $supervisor->name }} ({{ $supervisor->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Manager</label>
                            <select name="manager_id" class="form-select">
                                <option value="">Select Manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }} ({{ $manager->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-0">
                            <label class="form-label">Investor</label>
                            <select name="investor_id" class="form-select">
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

            {{-- Status & Meta --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h5>Status & Meta Information</h5>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select" required>
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
                            <label class="form-label">Budget</label>
                            <input type="number" step="0.01" min="0" name="budget" class="form-control" value="{{ old('budget') }}">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="Low" {{ old('priority')=='Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('priority', 'Medium')=='Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ old('priority')=='High' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Progress (%)</label>
                            <input type="number" name="progress" class="form-control" value="{{ old('progress', 0) }}" min="0" max="100">
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

            {{-- Media Upload --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h5>Media Upload</h5>
                </div>
                <div class="form-card-body">
                    <div class="section-note">
                        Upload project photos and a project video if available. These files will be attached to the project using the same media structure used by students.
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Project Photos (multiple)</label>
                        <input type="file"
                               name="project_photos[]"
                               multiple
                               accept="image/*"
                               class="form-control"
                               onchange="previewSpecific(this, 'images_preview')">
                        <div id="images_preview" class="preview-grid"></div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Project Video (single)</label>
                        <input type="file"
                               name="project_video"
                               accept="video/*"
                               class="form-control"
                               onchange="previewSpecific(this, 'videos_preview')">
                        <div id="videos_preview" class="preview-grid"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap" style="gap: 12px;">
                <button type="submit" class="btn btn-main">
                    <i class="fa fa-check-circle mr-1"></i> Create Project
                </button>

                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary btn-back">
                    Cancel
                </a>
            </div>
        </form>
    </div>
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
</script>
@endsection