@extends('layouts.app')

@section('title', 'Send Notification')

@section('content')
<style>
    .investor-notify-page .page-header-card {
        background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
        border-radius: 22px;
        padding: 30px 32px;
        color: #fff;
        box-shadow: 0 14px 34px rgba(27, 0, 255, 0.18);
        margin-bottom: 24px;
    }

    .investor-notify-page .page-header-card h3 {
        margin: 0;
        font-weight: 800;
        color: #fff;
    }

    .investor-notify-page .page-header-card p {
        margin: 10px 0 0;
        opacity: 0.92;
    }

    .investor-notify-page .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .investor-notify-page .section-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eef2f7;
        font-weight: 700;
        color: #0f172a;
    }

    .investor-notify-page .section-body {
        padding: 22px;
    }

    .investor-notify-page .form-label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }

    .investor-notify-page .form-control {
        border-radius: 12px;
        border: 1px solid #dbe4f0;
        min-height: 44px;
        box-shadow: none;
    }

    .investor-notify-page textarea.form-control {
        min-height: 150px;
    }

    .investor-notify-page .btn-back {
        background: #fff;
        border: 1px solid #dbe4f0;
        color: #0f172a;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 700;
        text-decoration: none;
    }

    .investor-notify-page .btn-back:hover {
        text-decoration: none;
        color: #0f172a;
        background: #f8fafc;
    }

    .investor-notify-page .btn-send {
        background: linear-gradient(135deg, #1b00ff, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 700;
    }

    .investor-notify-page .btn-send:hover {
        color: #fff;
        opacity: 0.95;
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 investor-notify-page">
    <div class="min-height-200px">

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 14px;">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                <div>
                    <h3>Send Notification</h3>
                    <p>
                        Send a direct notification to
                        <strong>{{ $investor->user?->name ?? 'Investor' }}</strong>
                        from the manager panel.
                    </p>
                </div>

                <a href="{{ route('admin.investors.show', $investor->user_id) }}" class="btn-back">
                    <i class="fa fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>

        <div class="form-card">
            <div class="section-header">
                <i class="fa fa-envelope mr-1"></i> Notification Form
            </div>

            <div class="section-body">
                <form action="{{ route('admin.investors.notify.store', $investor->user_id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title') }}"
                               placeholder="Enter notification title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message"
                                  class="form-control"
                                  placeholder="Write your message here...">{{ old('message') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Optional URL</label>
                        <input type="text"
                               name="url"
                               class="form-control"
                               value="{{ old('url') }}"
                               placeholder="Optional link for the investor to open">
                    </div>

                    <button type="submit" class="btn-send">
                        <i class="fa fa-paper-plane mr-1"></i> Send Notification
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection