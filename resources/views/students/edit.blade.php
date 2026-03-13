@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
<h1>Edit Student</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('students.update', $student->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- بيانات المستخدم الأساسية --}}
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" required>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select" required>
            <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
            <option value="pending" {{ old('status', $student->status) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="disabled" {{ old('status', $student->status) == 'disabled' ? 'selected' : '' }}>Disabled</option>
        </select>
    </div>

    {{-- البيانات الأكاديمية --}}
    <div class="mb-3">
        <label>Major</label>
        <input type="text" name="major" class="form-control" value="{{ old('major', $student->student->major ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->student->phone ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $student->student->address ?? '') }}">
    </div>

    {{-- معلومات أكاديمية إضافية --}}
    <div class="mb-3">
        <label>Current Courses</label>
        <input type="text" name="current_courses" class="form-control" value="{{ old('current_courses', $student->student->current_courses ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Completed Courses</label>
        <input type="text" name="completed_courses" class="form-control" value="{{ old('completed_courses', $student->student->completed_courses ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Academic Advisor</label>
        <input type="text" name="academic_advisor" class="form-control" value="{{ old('academic_advisor', $student->student->academic_advisor ?? '') }}">
    </div>

    <button type="submit" class="btn btn-primary">Update Student</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
