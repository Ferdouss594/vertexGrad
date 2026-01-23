@extends('layouts.app')

@section('title','Edit Manager')

@section('content')
<div class="container">
    <h1>Edit Manager</h1>

    <form action="{{ route('manager.update', $manager) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>User</label>
            <input type="text" class="form-control" value="{{ $manager->user->name }} ({{ $manager->user->email }})" disabled>
        </div>

        <div class="mb-3">
            <label>Department</label>
            <input type="text" name="department" class="form-control" value="{{ $manager->department }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('manager.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
