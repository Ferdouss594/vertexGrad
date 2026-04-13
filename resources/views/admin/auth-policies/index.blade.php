@extends('layouts.app')

@section('title', 'Authentication Policy Management')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="card-box mb-30" style="border-radius: 18px; overflow: hidden;">
            <div class="pd-20 d-flex justify-content-between align-items-center flex-wrap" style="background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%); color: white;">
                <div>
                    <h4 class="mb-1 text-white">Authentication Policy Management</h4>
                    <p class="mb-0" style="opacity: .9;">
                        Control OTP, email verification, trusted devices, recovery codes, and login policy per user.
                    </p>
                </div>
            </div>

            <div class="pb-20">
                <div class="table-responsive">
                    <table class="table table-striped hover nowrap mb-0">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Policy Source</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge badge-primary" style="padding: 8px 12px; border-radius: 999px;">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->status === 'active')
                                            <span class="badge badge-success" style="padding: 8px 12px; border-radius: 999px;">
                                                Active
                                            </span>
                                        @elseif($user->status === 'pending')
                                            <span class="badge badge-warning" style="padding: 8px 12px; border-radius: 999px;">
                                                Pending
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" style="padding: 8px 12px; border-radius: 999px;">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $source = $user->effective_auth_policy['source'] ?? 'unknown';
                                        @endphp

                                        @if($source === 'user_override')
                                            <span class="badge badge-info" style="padding: 8px 12px; border-radius: 999px;">
                                                User Override
                                            </span>
                                        @elseif($source === 'role_policy')
                                            <span class="badge badge-primary" style="padding: 8px 12px; border-radius: 999px;">
                                                Role Default
                                            </span>
                                        @else
                                            <span class="badge badge-light" style="padding: 8px 12px; border-radius: 999px;">
                                                System Default
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.auth-policies.show', $user->id) }}"
                                           class="btn btn-primary btn-sm"
                                           style="border-radius: 10px; font-weight: 600;">
                                            Manage Auth Policy
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">No users found.</td>
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