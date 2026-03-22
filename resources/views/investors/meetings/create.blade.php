@extends('layouts.app')

@section('title', 'Create Meeting')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box p-4">
        <h4 class="mb-4">Create Meeting for {{ $investor->user?->name }}</h4>

        <form action="{{ route('admin.investors.meetings.store', $investor->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="online">Online</option>
                    <option value="in_person">In Person</option>
                    <option value="call">Call</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="scheduled">Scheduled</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Meeting Date & Time</label>
                <input type="datetime-local" name="meeting_at" class="form-control" value="{{ old('meeting_at') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Meeting Link</label>
                <input type="text" name="meeting_link" class="form-control" value="{{ old('meeting_link') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}">
            </div>

            <div class="mb-4">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="5">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Meeting</button>
        </form>
    </div>
</div>
@endsection