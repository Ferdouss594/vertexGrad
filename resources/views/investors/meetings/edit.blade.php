@extends('layouts.app')

@section('title', 'Edit Meeting')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box p-4">
        <h4 class="mb-4">Edit Meeting for {{ $investor->user?->name }}</h4>

        <form action="{{ route('admin.investors.meetings.update', [$investor->id, $meeting->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $meeting->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="online" {{ old('type', $meeting->type) === 'online' ? 'selected' : '' }}>Online</option>
                    <option value="in_person" {{ old('type', $meeting->type) === 'in_person' ? 'selected' : '' }}>In Person</option>
                    <option value="call" {{ old('type', $meeting->type) === 'call' ? 'selected' : '' }}>Call</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="scheduled" {{ old('status', $meeting->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ old('status', $meeting->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $meeting->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Meeting Date & Time</label>
                <input type="datetime-local"
                       name="meeting_at"
                       class="form-control"
                       value="{{ old('meeting_at', optional($meeting->meeting_at)->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Meeting Link</label>
                <input type="text" name="meeting_link" class="form-control" value="{{ old('meeting_link', $meeting->meeting_link) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $meeting->location) }}">
            </div>

            <div class="mb-4">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="5">{{ old('notes', $meeting->notes) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Meeting</button>
        </form>
    </div>
</div>
@endsection