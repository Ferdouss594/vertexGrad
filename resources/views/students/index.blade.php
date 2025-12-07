@extends('layouts.app')

@section('title', 'Students')

@section('content')
<h1>Students</h1>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('students.create') }}" class="btn btn-primary mb-3">+ Add Student</a>

<form method="GET" action="{{ route('students.index') }}" class="mb-3 d-flex gap-2">
    <input type="text" name="search" placeholder="Search by name or email" class="form-control" value="{{ request('search') }}">

    <select name="status" class="form-select">
        <option value="">All Status</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>

    <button type="submit" class="btn btn-secondary">Search</button>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Major</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $user)
        <tr>
            <td>{{ $user->name ?? '—' }}</td>
            <td>{{ $user->email ?? '—' }}</td>
            <td>{{ $user->student?->major ?? '—' }}</td>
            <td>{{ $user->student?->phone ?? '—' }}</td>
            <td>{{ $user->student?->address ?? '—' }}</td>
            <td>{{ ucfirst($user->status ?? '—') }}</td>
            <td class="d-flex gap-1 flex-wrap">
                <a href="{{ route('students.show', $user->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('students.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('students.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                @if(($user->status ?? null) != 'active')
                    <a href="{{ route('students.status', [$user->id, 'active']) }}" class="btn btn-sm btn-success">Activate</a>
                @endif
                @if(($user->status ?? null) != 'inactive')
                    <a href="{{ route('students.status', [$user->id, 'inactive']) }}" class="btn btn-sm btn-warning">Deactivate</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $students->links() }}
@endsection
