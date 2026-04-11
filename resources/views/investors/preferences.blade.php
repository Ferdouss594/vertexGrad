@extends('layouts.app')

@section('title', 'Investor Preferences')

@section('content')
<style>
    :root {
        --page-bg: #f5f7fb;
        --card-bg: #ffffff;
        --text-main: #172033;
        --text-soft: #7b8497;
        --border-color: #e8ecf4;
        --primary-color: #4e73df;
        --primary-soft: rgba(78, 115, 223, 0.10);
        --success-soft: rgba(28, 200, 138, 0.12);
        --shadow-sm: 0 8px 20px rgba(18, 38, 63, 0.06);
        --radius-xl: 24px;
    }

    body { background: var(--page-bg); }

    .investor-preferences-page {
        padding: 10px 0 24px;
    }

    .page-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        padding: 26px 28px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .page-title {
        margin: 0;
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .page-subtitle {
        margin: 8px 0 0;
        color: var(--text-soft);
        font-size: 0.96rem;
    }

    .main-panel {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .panel-head {
        padding: 22px 24px 10px;
        border-bottom: 1px solid rgba(232, 236, 244, 0.7);
    }

    .panel-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .panel-subtitle {
        margin-top: 6px;
        color: var(--text-soft);
        font-size: 0.9rem;
    }

    .table-wrap {
        padding: 20px 24px 26px;
    }

    .reset-btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
        padding: 10px 18px;
        background: #eef2f8;
        color: #344054;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .reset-btn:hover {
        color: #344054;
        text-decoration: none;
    }

    .search-btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
        padding: 10px 18px;
    }

    .preference-item {
        border: 1px solid #e8ecf4;
        border-radius: 18px;
        padding: 18px 18px;
        background: #fff;
        transition: all .2s ease;
    }

    .preference-item:hover {
        background: #fafcff;
        border-color: #dfe6f2;
    }

    .preference-title {
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 4px;
    }

    .preference-desc {
        color: var(--text-soft);
        font-size: .9rem;
        margin: 0;
    }

    .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }
</style>

<div class="container-fluid investor-preferences-page">
    <div class="page-header-card">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="page-title">Investor Preferences</h1>
                <p class="page-subtitle">Manage communication preferences for {{ $investor->user?->name }}.</p>
            </div>

            <div>
                <a href="{{ route('admin.investors.show', $investor->user_id) }}" class="reset-btn px-4">
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="main-panel">
        <div class="panel-head">
            <h2 class="panel-title">Notification Preferences</h2>
            <div class="panel-subtitle">Control how this investor receives platform communication and reminders.</div>
        </div>

        <div class="table-wrap">
            <form action="{{ route('admin.investors.preferences.update', $investor->user_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="preference-item d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="preference-title">Enable In-App Notifications</div>
                            <p class="preference-desc mb-0">Allow notifications inside the platform dashboard.</p>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="pref_in_app_notifications" value="1"
                                   {{ $investor->pref_in_app_notifications ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="preference-item d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="preference-title">Enable Email Notifications</div>
                            <p class="preference-desc mb-0">Send important notifications by email as well.</p>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="pref_email_notifications" value="1"
                                   {{ $investor->pref_email_notifications ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="preference-item d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="preference-title">Enable Meeting Reminders</div>
                            <p class="preference-desc mb-0">Notify the investor before important meetings.</p>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="pref_meeting_reminders" value="1"
                                   {{ $investor->pref_meeting_reminders ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="preference-item d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="preference-title">Enable Announcements</div>
                            <p class="preference-desc mb-0">Receive general announcements and broadcast updates.</p>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="pref_announcements" value="1"
                                   {{ $investor->pref_announcements ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary search-btn">
                    Save Preferences
                </button>
            </form>
        </div>
    </div>
</div>
@endsection