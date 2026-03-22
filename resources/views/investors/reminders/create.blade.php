@extends('layouts.app')

@section('title', 'Create Reminder')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box p-4">
        <h4 class="mb-4">Create Reminder for {{ $investor->user?->name }}</h4>

        <form action="{{ route('admin.investors.reminders.store', $investor->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="4">{{ old('message') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="meeting">Meeting</option>
                    <option value="follow_up">Follow Up</option>
                    <option value="contract">Contract</option>
                    <option value="custom">Custom</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="pending">Pending</option>
                    <option value="sent">Sent</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Remind At</label>
                <input type="datetime-local" name="remind_at" class="form-control" value="{{ old('remind_at') }}">
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" name="send_in_app" value="1" checked>
                <label class="form-check-label">Send In-App Notification</label>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" name="send_email" value="1">
                <label class="form-check-label">Send Email</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Reminder</button>
        </form>
    </div>
</div>
@endsection