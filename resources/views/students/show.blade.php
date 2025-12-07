@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<h1>Student Details</h1>

<div class="card mb-3">
    <div class="card-header">
        Basic Information
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Status:</strong> {{ ucfirst($student->status) }}</p>
        <p><strong>Major:</strong> {{ $student->student->major ?? '—' }}</p>
        <p><strong>Phone:</strong> {{ $student->student->phone ?? '—' }}</p>
        <p><strong>Address:</strong> {{ $student->student->address ?? '—' }}</p>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        Projects
    </div>
    <div class="card-body">
        {{-- عرض المشاريع إذا كانت مرتبطة --}}
    </div>
</div>

<a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
@endsection
