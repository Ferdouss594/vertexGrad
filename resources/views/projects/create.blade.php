@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<h1>Create New Project</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Project Basic Info -->
    <div class="mb-3">
        <label>Project Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Category</label>
        <input type="text" name="category" class="form-control" value="{{ old('category') }}">
    </div>

    <!-- Users Selection -->
    <div class="mb-3">
        <label>Supervisor</label>
        <select name="supervisor_id" class="form-select">
            <option value="">Select Supervisor</option>
            @foreach($supervisors as $supervisor)
                <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                    {{ $supervisor->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Student</label>
        <select name="student_id" class="form-select" required>
            <option value="">Select Student</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Manager</label>
        <select name="manager_id" class="form-select">
            <option value="">Select Manager</option>
            @foreach($managers as $manager)
                <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                    {{ $manager->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Investor</label>
        <select name="investor_id" class="form-select">
            <option value="">Select Investor</option>
            @foreach($investors as $investor)
                <option value="{{ $investor->id }}" {{ old('investor_id') == $investor->id ? 'selected' : '' }}>
                    {{ $investor->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Status, Budget, Dates, Priority -->
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select" required>
            <option value="">Select Status</option>
            <option value="Pending" {{ old('status')=='Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Active" {{ old('status')=='Active' ? 'selected' : '' }}>Active</option>
            <option value="Completed" {{ old('status')=='Completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Budget</label>
        <input type="number" step="0.01" name="budget" class="form-control" value="{{ old('budget') }}">
    </div>

    <div class="mb-3">
        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
    </div>

    <div class="mb-3">
        <label>End Date</label>
        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
    </div>

    <div class="mb-3">
        <label>Priority</label>
        <select name="priority" class="form-select">
            <option value="Low" {{ old('priority')=='Low'?'selected':'' }}>Low</option>
            <option value="Medium" {{ old('priority')=='Medium'?'selected':'' }}>Medium</option>
            <option value="High" {{ old('priority')=='High'?'selected':'' }}>High</option>
        </select>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
        <label class="form-check-label">Featured Project</label>
    </div>

    <!-- File Uploads -->
    <div class="mb-4">
        <h5>Upload Files</h5>

        <!-- Images -->
        <label>Images</label>
        <input type="file" name="project_files[images][]" multiple accept="image/*" class="form-control mb-2" onchange="previewSpecific(this,'images_preview')">
        <div id="images_preview" class="mb-3"></div>

        <!-- Videos -->
        <label>Videos</label>
        <input type="file" name="project_files[videos][]" multiple accept="video/*" class="form-control mb-2" onchange="previewSpecific(this,'videos_preview')">
        <div id="videos_preview" class="mb-3"></div>

        <!-- PDFs -->
        <label>PDF Files</label>
        <input type="file" name="project_files[pdfs][]" multiple accept="application/pdf" class="form-control mb-2" onchange="previewSpecific(this,'pdfs_preview')">
        <div id="pdfs_preview" class="mb-3"></div>

        <!-- PPT Files -->
        <label>PPT / PPTX Files</label>
        <input type="file" name="project_files[ppts][]" multiple accept="application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation" class="form-control mb-2" onchange="previewSpecific(this,'ppts_preview')">
        <div id="ppts_preview" class="mb-3"></div>
    </div>

    <button type="submit" class="btn btn-success">Create Project</button>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
</form>

<!-- Script Preview لكل نوع -->
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
            img.width = 150;
            div.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.width = 300;
            video.controls = true;
            div.appendChild(video);
        } else if (file.type === 'application/pdf') {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.textContent = 'Preview PDF: ' + file.name;
            link.target = '_blank';
            div.appendChild(link);
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
