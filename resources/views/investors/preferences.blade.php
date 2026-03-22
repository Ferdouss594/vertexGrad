@extends('layouts.app')

@section('title', 'Investor Preferences')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="gap:12px;">
            <div>
                <h4 class="mb-1">Notification Preferences</h4>
                <p class="text-muted mb-0">Manage communication preferences for {{ $investor->user?->name }}.</p>
            </div>

            <a href="{{ route('admin.investors.show', $investor->user_id) }}" class="btn btn-light border">
                Back
            </a>
        </div>

        <form action="{{ route('admin.investors.preferences.update', $investor->user_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="pref_in_app_notifications" value="1"
                       {{ $investor->pref_in_app_notifications ? 'checked' : '' }}>
                <label class="form-check-label">Enable In-App Notifications</label>
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="pref_email_notifications" value="1"
                       {{ $investor->pref_email_notifications ? 'checked' : '' }}>
                <label class="form-check-label">Enable Email Notifications</label>
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="pref_meeting_reminders" value="1"
                       {{ $investor->pref_meeting_reminders ? 'checked' : '' }}>
                <label class="form-check-label">Enable Meeting Reminders</label>
            </div>

            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" name="pref_announcements" value="1"
                       {{ $investor->pref_announcements ? 'checked' : '' }}>
                <label class="form-check-label">Enable Announcements</label>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Preferences
            </button>
        </form>
    </div>
</div>
@endsection