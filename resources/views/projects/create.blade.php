@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<div class="container">
    <h1 class="mb-4">Create New Project</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Basic Info --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Project Information</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Project Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">Select category</option>
                        <option value="ai_ml"     {{ old('category')=='ai_ml' ? 'selected' : '' }}>Artificial Intelligence & Machine Learning</option>
                        <option value="biotech"   {{ old('category')=='biotech' ? 'selected' : '' }}>Biotechnology & Life Sciences</option>
                        <option value="materials" {{ old('category')=='materials' ? 'selected' : '' }}>Advanced Materials & Nanotech</option>
                        <option value="energy"    {{ old('category')=='energy' ? 'selected' : '' }}>Renewable Energy & Sustainability</option>
                        <option value="quantum"   {{ old('category')=='quantum' ? 'selected' : '' }}>Quantum Computing & Physics</option>
                        <option value="aero"      {{ old('category')=='aero' ? 'selected' : '' }}>Aerospace & Robotics</option>
                        <option value="other"     {{ old('category')=='other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Roles --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Assign Users</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
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

                    <div class="col-md-6">
                        <label class="form-label">Supervisor</label>
                        <select name="supervisor_id" class="form-select">
                            <option value="">Select Supervisor</option>
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                    {{ $supervisor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Manager</label>
                        <select name="manager_id" class="form-select">
                            <option value="">Select Manager</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Investor</label>
                        <select name="investor_id" class="form-select">
                            <option value="">Select Investor</option>
                            @foreach($investors as $investor)
                                <option value="{{ $investor->id }}" {{ old('investor_id') == $investor->id ? 'selected' : '' }}>
                                    {{ $investor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status / Meta --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Status & Meta</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="Pending" {{ old('status')=='Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Active" {{ old('status')=='Active' ? 'selected' : '' }}>Active</option>
                            <option value="Completed" {{ old('status')=='Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Budget</label>
                        <input type="number" step="0.01" min="100" name="budget" class="form-control" value="{{ old('budget') }}">                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="Low" {{ old('priority')=='Low'?'selected':'' }}>Low</option>
                            <option value="Medium" {{ old('priority','Medium')=='Medium'?'selected':'' }}>Medium</option>
                            <option value="High" {{ old('priority')=='High'?'selected':'' }}>High</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Progress (%)</label>
                        <input type="number" name="progress" class="form-control" value="{{ old('progress', 0) }}" min="0" max="100">
                    </div>

                    <div class="col-md-12">
                        <div class="form-check mt-2">
                            <input type="checkbox" name="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label">Featured Project</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Media (Spatie) --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Media Upload (Same as Student)</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Project Photos (multiple)</label>
                    <input type="file" name="project_photos[]" multiple accept="image/*" class="form-control" onchange="previewSpecific(this,'images_preview')">
                    <div id="images_preview" class="mt-2"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Project Video (single)</label>
                    <input type="file" name="project_video" accept="video/*" class="form-control" onchange="previewSpecific(this,'videos_preview')">
                    <div id="videos_preview" class="mt-2"></div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Create Project</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back</a>
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
        const div = document.createElement('div');
        div.style.marginBottom = '10px';

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '180px';
            img.style.borderRadius = '10px';
            img.style.border = '1px solid #ddd';
            div.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.style.maxWidth = '420px';
            video.controls = true;
            video.style.borderRadius = '10px';
            video.style.border = '1px solid #ddd';
            div.appendChild(video);
        } else {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.textContent = 'File: ' + file.name;
            link.target = '_blank';
            div.appendChild(link);
        }

        preview.appendChild(div);
    }
}
</script>
@endsection