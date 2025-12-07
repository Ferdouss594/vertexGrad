@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
<h1>Add New Student</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('students.store') }}" method="POST">
    @csrf
    {{-- البيانات الأساسية في جدول users --}}
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Active</option>
            <option value="pending" {{ old('status')=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="disabled" {{ old('status')=='disabled' ? 'selected' : '' }}>Disabled</option>
        </select>
    </div>

    {{-- البيانات الإضافية في جدول students --}}
    <div class="mb-3">
        <label>Major</label>
        <input type="text" name="major" class="form-control" value="{{ old('major') }}">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
    </div>

    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
    </div>

    <button type="submit" class="btn btn-success">Create Student</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
