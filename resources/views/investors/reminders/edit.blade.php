@extends('layouts.app')

@section('title', 'Edit Reminder')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box p-4">
        <h4 class="mb-4">Edit Reminder for {{ $investor->user?->name }}</h4>

        <form action="{{ route('admin.investors.reminders.update', [$investor->id, $reminder->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $reminder->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="4">{{ old('message', $reminder->message) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="meeting" {{ old('type', $reminder->type) === 'meeting' ? 'selected' : '' }}>Meeting</option>
                    <option value="follow_up" {{ old('type', $reminder->type) === 'follow_up' ? 'selected' : '' }}>Follow Up</option>
                    <option value="contract" {{ old('type', $reminder->type) === 'contract' ? 'selected' : '' }}>Contract</option>
                    <option value="custom" {{ old('type', $reminder->type) === 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="pending" {{ old('status', $reminder->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="sent" {{ old('status', $reminder->status) === 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="completed" {{ old('status', $reminder->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $reminder->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Remind At</label>
                <input type="datetime-local" name="remind_at" class="form-control" value="{{ old('remind_at', optional($reminder->remind_at)->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" name="send_in_app" value="1" {{ $reminder->send_in_app ? 'checked' : '' }}>
                <label class="form-check-label">Send In-App Notification</label>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" name="send_email" value="1" {{ $reminder->send_email ? 'checked' : '' }}>
                <label class="form-check-label">Send Email</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Reminder</button>
        </form>
    </div>
</div>
@endsection