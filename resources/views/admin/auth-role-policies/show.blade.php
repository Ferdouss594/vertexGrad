@extends('layouts.app')

@section('title', 'Manage Role Authentication Policy')

@section('content')
<style>
    .role-auth-policy-page .hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #3b82f6 100%);
        border-radius: 24px;
        padding: 28px 30px;
        color: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.18);
        margin-bottom: 24px;
    }

    .role-auth-policy-page .hero-title {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
        color: #fff;
    }

    .role-auth-policy-page .hero-text {
        font-size: 14px;
        opacity: .92;
        margin-bottom: 0;
        max-width: 820px;
        line-height: 1.8;
    }

    .role-auth-policy-page .section-card {
        background: #fff;
        border-radius: 22px;
        border: 1px solid #eef2f7;
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.06);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .role-auth-policy-page .section-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .role-auth-policy-page .section-header h4,
    .role-auth-policy-page .section-header h5 {
        margin: 0;
        font-weight: 800;
        color: #0f172a;
    }

    .role-auth-policy-page .section-subtext {
        margin-top: 6px;
        color: #64748b;
        font-size: 13px;
    }

    .role-auth-policy-page .section-body {
        padding: 24px;
    }

    .role-auth-policy-page .info-box {
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        height: 100%;
    }

    .role-auth-policy-page .info-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .role-auth-policy-page .info-value {
        color: #0f172a;
        font-size: 16px;
        font-weight: 800;
        line-height: 1.4;
    }

    .role-auth-policy-page .save-btn {
        border: none;
        border-radius: 14px;
        padding: 12px 22px;
        font-weight: 800;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 14px 24px rgba(37, 99, 235, 0.20);
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 role-auth-policy-page">
    <div class="min-height-200px">
        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 14px;">
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="hero-card">
            <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 16px;">
                <div>
                    <div class="hero-title">Manage Role Authentication Policy</div>
                    <p class="hero-text">
                        Update the default authentication behavior for the <strong>{{ $rolePolicy->role_name }}</strong> role.
                        Any new user in this role will inherit these settings automatically.
                    </p>
                </div>

                <a href="{{ route('admin.auth-role-policies.index') }}"
                   class="btn btn-light btn-sm"
                   style="border-radius: 10px; font-weight: 700;">
                    Back
                </a>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h4>Role Policy Summary</h4>
                <div class="section-subtext">
                    This is the current default security policy for the selected role.
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Role Name</div>
                            <div class="info-value">{{ $rolePolicy->role_name }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Email Verification</div>
                            <div class="info-value">{{ ucfirst($rolePolicy->email_verification_mode) }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">OTP Mode</div>
                            <div class="info-value">{{ ucfirst($rolePolicy->otp_mode) }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Trusted Devices</div>
                            <div class="info-value">{{ $rolePolicy->trusted_devices_enabled ? 'Enabled' : 'Disabled' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Recovery Codes</div>
                            <div class="info-value">{{ $rolePolicy->recovery_codes_enabled ? 'Enabled' : 'Disabled' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Suspicious Login Alerts</div>
                            <div class="info-value">{{ $rolePolicy->suspicious_login_alerts_enabled ? 'Enabled' : 'Disabled' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Remember Me</div>
                            <div class="info-value">{{ $rolePolicy->remember_me_enabled ? 'Enabled' : 'Disabled' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Emergency Bypass</div>
                            <div class="info-value">{{ $rolePolicy->emergency_bypass_enabled ? 'Enabled' : 'Disabled' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h5>Edit Role Default Policy</h5>
                <div class="section-subtext">
                    Changing this affects new users in this role, and existing users who still use role defaults.
                </div>
            </div>

            <div class="section-body">
                <form action="{{ route('admin.auth-role-policies.update', $rolePolicy->id) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="font-weight-bold">Email Verification Mode</label>
                            <select name="email_verification_mode" class="form-control" style="border-radius: 12px;">
                                <option value="required" {{ $rolePolicy->email_verification_mode === 'required' ? 'selected' : '' }}>Required</option>
                                <option value="optional" {{ $rolePolicy->email_verification_mode === 'optional' ? 'selected' : '' }}>Optional</option>
                                <option value="disabled" {{ $rolePolicy->email_verification_mode === 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="font-weight-bold">OTP Mode</label>
                            <select name="otp_mode" class="form-control" style="border-radius: 12px;">
                                <option value="required" {{ $rolePolicy->otp_mode === 'required' ? 'selected' : '' }}>Required</option>
                                <option value="optional" {{ $rolePolicy->otp_mode === 'optional' ? 'selected' : '' }}>Optional</option>
                                <option value="disabled" {{ $rolePolicy->otp_mode === 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="font-weight-bold">Trusted Devices</label>
                            <select name="trusted_devices_enabled" class="form-control" style="border-radius: 12px;">
                                <option value="1" {{ $rolePolicy->trusted_devices_enabled ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ ! $rolePolicy->trusted_devices_enabled ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="font-weight-bold">Recovery Codes</label>
                            <select name="recovery_codes_enabled" class="form-control" style="border-radius: 12px;">
                                <option value="1" {{ $rolePolicy->recovery_codes_enabled ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ ! $rolePolicy->recovery_codes_enabled ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="font-weight-bold">Suspicious Login Alerts</label>
                            <select name="suspicious_login_alerts_enabled" class="form-control" style="border-radius: 12px;">
                                <option value="1" {{ $rolePolicy->suspicious_login_alerts_enabled ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ ! $rolePolicy->suspicious_login_alerts_enabled ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="font-weight-bold">Remember Me</label>
                            <select name="remember_me_enabled" class="form-control" style="border-radius: 12px;">
                                <option value="1" {{ $rolePolicy->remember_me_enabled ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ ! $rolePolicy->remember_me_enabled ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="font-weight-bold">Emergency Bypass</label>
                            <select name="emergency_bypass_enabled" class="form-control" style="border-radius: 12px;">
                                <option value="1" {{ $rolePolicy->emergency_bypass_enabled ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ ! $rolePolicy->emergency_bypass_enabled ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">Notes</label>
                            <textarea name="notes" rows="4" class="form-control" style="border-radius: 12px;">{{ old('notes', $rolePolicy->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary save-btn">
                            Save Role Policy
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection