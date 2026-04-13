@extends('layouts.app')

@section('title', 'Role Authentication Policies')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">

        <div class="card-box mb-30" style="border-radius: 18px; overflow: hidden;">
            <div class="pd-20 d-flex justify-content-between align-items-center flex-wrap"
                 style="background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%); color: white;">
                <div>
                    <h4 class="mb-1 text-white">Role Authentication Policies</h4>
                    <p class="mb-0" style="opacity: .9;">
                        Manage the default authentication behavior for each system role.
                    </p>
                </div>
            </div>

            <div class="pb-20">
                <div class="table-responsive">
                    <table class="table table-striped hover nowrap mb-0">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Email Verification</th>
                                <th>OTP</th>
                                <th>Trusted Devices</th>
                                <th>Recovery Codes</th>
                                <th>Remember Me</th>
                                <th width="170">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rolePolicies as $index => $rolePolicy)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        <span class="badge badge-primary" style="padding: 8px 12px; border-radius: 999px;">
                                            {{ $rolePolicy->role_name }}
                                        </span>
                                    </td>

                                    <td>{{ ucfirst($rolePolicy->email_verification_mode) }}</td>
                                    <td>{{ ucfirst($rolePolicy->otp_mode) }}</td>
                                    <td>{{ $rolePolicy->trusted_devices_enabled ? 'Enabled' : 'Disabled' }}</td>
                                    <td>{{ $rolePolicy->recovery_codes_enabled ? 'Enabled' : 'Disabled' }}</td>
                                    <td>{{ $rolePolicy->remember_me_enabled ? 'Enabled' : 'Disabled' }}</td>

                                    <td>
                                        <a href="{{ route('admin.auth-role-policies.show', $rolePolicy->id) }}"
                                           class="btn btn-primary btn-sm"
                                           style="border-radius: 10px; font-weight: 600;">
                                            Manage Role Policy
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">No role policies found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection