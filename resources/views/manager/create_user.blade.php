@extends('layouts.app')

@section('title', __('backend.manager_users_create.page_title'))

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
        --primary-soft: rgba(78, 115, 223, 0.10);
        --info-color: #36b9cc;
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
    .user-form-panel {
        background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
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
        font-size: .96rem;
    }

    .user-form-panel {
        overflow: hidden;
    }

    .panel-head {
        padding: 24px 28px;
        border-bottom: 1px solid var(--border-color);
    }

    .panel-title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .panel-subtitle {
        margin-top: 6px;
        color: var(--text-soft);
        font-size: .9rem;
    }

    .panel-body-custom {
        padding: 28px;
    }

    .avatar-wrap {
        display: inline-block;
        position: relative;
        width: 150px;
        height: 150px;
    }

    .avatar-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: var(--shadow-md);
        background: #eef2f8;
    }

    .avatar-upload-btn {
        position: absolute;
        right: 4px;
        bottom: 4px;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), #6f8df3);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        border: 3px solid #fff;
        font-size: 1.25rem;
    }

    .form-label {
        font-weight: 700;
        color: var(--text-main);
        font-size: .9rem;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        min-height: 48px;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        color: var(--text-main);
        font-weight: 600;
        box-shadow: none !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px var(--primary-soft) !important;
    }

    .form-section-title {
        font-size: .8rem;
        font-weight: 800;
        color: var(--text-soft);
        text-transform: uppercase;
        letter-spacing: .08em;
        margin: 26px 0 14px;
    }

    .btn-main {
        min-height: 48px;
        border: none;
        border-radius: 999px;
        padding: 12px 28px;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color), #6f8df3);
        color: #fff;
        box-shadow: 0 10px 20px rgba(78, 115, 223, .22);
    }

    .btn-main:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(78, 115, 223, .28);
    }

    .btn-soft {
        min-height: 48px;
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 800;
        background: #eef2f8;
        color: #344054;
        border: none;
    }

    .custom-alert {
        border: none;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 768px) {
        .page-header-card,
        .panel-head,
        .panel-body-custom {
            padding: 20px;
        }

        .page-title {
            font-size: 1.35rem;
        }

        .avatar-wrap {
            width: 130px;
            height: 130px;
        }
    }
</style>

<div class="container-fluid user-form-page">

    <div class="page-header-card">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="page-title">{{ __('backend.manager_users_create.heading') }}</h1>
                <p class="page-subtitle">
                    {{ __('backend.users_management.users_directory_subtitle') ?? '' }}
                </p>
            </div>

            <a href="{{ route('manager.pending.users') }}" class="btn btn-soft">
                <i class="bi bi-arrow-left me-2"></i>
                {{ __('backend.users_management.users_directory') }}
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger custom-alert alert-dismissible fade show mb-4">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger custom-alert mb-4">
            <strong>{{ __('backend.users_management.failed_fetch_user_data') }}</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="user-form-panel">
        <div class="panel-head">
            <h2 class="panel-title">
                <i class="bi bi-person-plus-fill me-2 text-primary"></i>
                {{ __('backend.manager_users_create.add_user') }}
            </h2>
            <div class="panel-subtitle">
                {{ __('backend.manager_users_create.heading') }}
            </div>
        </div>

        <div class="panel-body-custom">
            <form action="{{ route('manager.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="text-center mb-4">
                    <div class="avatar-wrap">
                        <img id="imagePreview"
                             src="{{ asset('src/images/avatar.png') }}"
                             alt="{{ __('backend.manager_users_create.profile_preview') }}"
                             class="avatar-preview">

                        <label for="profileImage" class="avatar-upload-btn">
                            <i class="bi bi-camera-fill"></i>
                        </label>

                        <input type="file" name="profile_image" id="profileImage" class="d-none" accept="image/*">
                    </div>
                </div>

                <div class="form-section-title">Account Information</div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.username') }}</label>
                        <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.full_name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.email') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.role') }}</label>
                        <select name="role" class="form-select">
                            <option value="Student" {{ old('role') === 'Student' ? 'selected' : '' }}>{{ __('backend.manager_users_create.roles.student') }}</option>
                            <option value="Supervisor" {{ old('role') === 'Supervisor' ? 'selected' : '' }}>{{ __('backend.manager_users_create.roles.supervisor') }}</option>
                            <option value="Manager" {{ old('role') === 'Manager' ? 'selected' : '' }}>{{ __('backend.manager_users_create.roles.manager') }}</option>
                            <option value="Investor" {{ old('role') === 'Investor' ? 'selected' : '' }}>{{ __('backend.manager_users_create.roles.investor') }}</option>
                            <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>{{ __('backend.manager_users_create.roles.admin') }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-section-title">Profile Details</div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.status') }}</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('backend.manager_users_create.statuses.active') }}</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('backend.manager_users_create.statuses.inactive') }}</option>
                            <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>{{ __('backend.manager_users_create.statuses.pending') }}</option>
                            <option value="disabled" {{ old('status') === 'disabled' ? 'selected' : '' }}>{{ __('backend.manager_users_create.statuses.disabled') }}</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.gender') }}</label>
                        <select name="gender" class="form-select">
                            <option value="">{{ __('backend.manager_users_create.select') }}</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>{{ __('backend.manager_users_create.genders.male') }}</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>{{ __('backend.manager_users_create.genders.female') }}</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.city') }}</label>
                        <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.state_country') }}</label>
                        <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                    </div>
                </div>

                <div class="form-section-title">Security</div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('backend.manager_users_create.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="mt-5 d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="{{ route('manager.pending.users') }}" class="btn btn-soft">
                        {{ __('backend.users_management.close') }}
                    </a>

                    <button type="submit" class="btn btn-main">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        {{ __('backend.manager_users_create.add_user') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const profileImage = document.getElementById('profileImage');
    const imagePreview = document.getElementById('imagePreview');

    profileImage?.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "{{ asset('src/images/avatar.png') }}";
        }
    });
</script>
@endsection