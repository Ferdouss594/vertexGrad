@extends('layouts.app')

@section('title','Create Manager')

@section('content')
<div class="container">
    <h1>Create Manager</h1>

    <form action="{{ route('manager.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Department</label>
            <input type="text" name="department" class="form-control" placeholder="Department">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('manager.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
