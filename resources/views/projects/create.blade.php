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

<form action="{{ route('projects.store') }}" method="POST">
    @csrf

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
   
</select>
<label>Student</label>
<select name="student_id" class="form-select" required>
    <option value="">Select Student</option>
    @foreach($students as $student)
        <option value="{{ $student->id }}">{{ $student->name }}</option>
    @endforeach
</select>



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
<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-select" required>
        <option value="">Select Status</option>
        <option value="Pending" {{ old('status')=='Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Active" {{ old('status')=='Active' ? 'selected' : '' }}>Active</option>
        <option value="Completed" {{ old('status')=='Completed' ? 'selected' : '' }}>Completed</option>
    </select>
</div>

    <!-- باقي الحقول مثل Budget, Dates, Priority, Featured -->
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

    <button type="submit" class="btn btn-success">Create Project</button>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
