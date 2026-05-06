@extends('layouts.app')

@section('title', __('backend.users_management.edit'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root {
        --page-bg: #f5f7fb;
        --card-bg: #ffffff;
        --text-main: #172033;
        --text-soft: #7b8497;
        --border-color: #e8ecf4;
        --primary-color: #4e73df;
        --success-color: #1cc88a;
        --danger-color: #e74a3b;
        --shadow-sm: 0 8px 20px rgba(18, 38, 63, 0.06);
        --shadow-md: 0 14px 36px rgba(18, 38, 63, 0.10);
    }

    body {
        background: var(--page-bg);
    }

    .user-form-page {
        padding: 10px 0 28px;
    }

    .page-header-card,
    .form-panel {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        box-shadow: var(--shadow-sm);
    }

    .page-header-card {
        padding: 26px 28px;
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

    .form-panel {
        overflow: hidden;
    }

    .form-panel-head {
        padding: 22px 24px;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
    }

    .form-panel-title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .form-panel-body {
        padding: 26px 24px 28px;
    }

    .avatar-preview-wrap {
        width: 132px;
        height: 132px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #edf1f7;
        box-shadow: var(--shadow-sm);
        background: #f8faff;
        margin: 0 auto 18px;
    }

    .avatar-preview-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-label {
        font-weight: 700;
        color: var(--text-main);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        min-height: 48px;
        border-radius: 14px;
        border-color: var(--border-color);
        color: var(--text-main);
        font-weight: 600;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.12);
    }

    .readonly-soft {
        background: #f7f9fd;
        color: var(--text-soft);
    }

    .btn-main {
        min-height: 48px;
        border-radius: 999px;
        padding: 10px 28px;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color), #6f8df3);
        color: #fff;
        border: none;
        box-shadow: 0 8px 18px rgba(78, 115, 223, 0.24);
    }

    .btn-main:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-back {
        min-height: 48px;
        border-radius: 999px;
        padding: 10px 24px;
        font-weight: 800;
        border: 1px solid var(--border-color);
        background: #fff;
        color: var(--text-main);
    }

    .custom-alert {
        border: none;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 576px) {
        .page-header-card,
        .form-panel-body,
        .form-panel-head {
            padding-left: 18px;
            padding-right: 18px;
        }

        .page-title {
            font-size: 1.35rem;
        }

        .btn-main,
        .btn-back {
            width: 100%;
        }
    }
</style>

<div class="container-fluid user-form-page">

    <div class="page-header-card">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="page-title">
                    {{ __('backend.users_management.edit') }}
                </h1>
                <p class="page-subtitle">
                    {{ $user->name }} — {{ $user->email }}
                </p>
            </div>

            <a href="{{ route('manager.pending.users') }}" class="btn btn-back">
                <i class="bi bi-arrow-left me-2"></i>
                {{ __('backend.users_management.users_directory') }}
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger custom-alert alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success custom-alert alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger custom-alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-panel">
        <div class="form-panel-head">
            <h2 class="form-panel-title">
                <i class="bi bi-pencil-square me-2 text-primary"></i>
                {{ __('backend.users_management.edit') }}
            </h2>
        </div>

        <div class="form-panel-body">
            <form action="{{ route('manager.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="text-center mb-4">
                    <div class="avatar-preview-wrap">
                        <img
                            src="{{ $user->profile_image ? asset($user->profile_image) : asset('src/images/avatar.png') }}"
                            alt="{{ $user->name }}"
                        >
                    </div>
                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                    <div class="text-muted small">{{ $user->role }}</div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">
                            {{ __('backend.users_management.username') ?? 'Username' }}
                        </label>
                        <input
                            type="text"
                            value="{{ $user->username }}"
                            class="form-control readonly-soft"
                            readonly
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ __('backend.users_management.full_name') ?? 'Full Name' }}
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ __('backend.users_management.email') }}
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ __('backend.users_management.role') }}
                        </label>
                        <select name="role" class="form-select">
                            @foreach(['Student', 'Supervisor', 'Manager', 'Investor', 'Admin'] as $role)
                                <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ __('backend.users_management.status') }}
                        </label>
                        <select name="status" class="form-select" required>
                            @foreach(['active', 'inactive', 'pending', 'disabled'] as $status)
                                <option value="{{ $status }}" {{ old('status', $user->status) === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-end gap-3 mt-5">
                    <a href="{{ route('manager.pending.users') }}" class="btn btn-back">
                        {{ __('backend.users_management.close') }}
                    </a>

                    <button type="submit" class="btn btn-main">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ __('backend.users_management.edit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection