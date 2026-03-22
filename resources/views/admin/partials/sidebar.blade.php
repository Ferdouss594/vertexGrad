@php
    $adminUser = auth('admin')->user();
@endphp

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('manager.dashboard') }}" class="sidebar-logo-link">
            <img
                src="{{ asset('vendors/images/VertexGrad_logod.png') }}"
                alt="VertexGrad Logo"
                class="sidebar-logo-img"
            />
        </a>

        <div class="close-sidebar" data-toggle="left-sidebar-close" title="Close sidebar">
            <i class="ion-close-round"></i>
        </div>
    </div>

    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <div class="sidebar-section-label">Main Navigation</div>

            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('manager.dashboard') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-house-door-fill"></span>
                        <span class="mtext">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('manager.pending.users') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-people-fill"></span>
                        <span class="mtext">User Management</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('manager.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person-workspace"></span>
                        <span class="mtext">Managers</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.students.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-mortarboard-fill"></span>
                        <span class="mtext">Students</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.investors.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-wallet2"></span>
                        <span class="mtext">Investors</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.projects.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-briefcase-fill"></span>
                        <span class="mtext">Projects</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('manager.calendar.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-calendar-check-fill"></span>
                        <span class="mtext">Calendar</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.platform') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-bar-chart-line-fill"></span>
                        <span class="mtext">Platform Reports</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-bottom">
                <div class="sidebar-bottom-title">Account</div>

                <div class="sidebar-account-card">
                    <div class="sidebar-account-top">
                        <img
                            src="{{ $adminUser && $adminUser->avatar ? asset('storage/' . $adminUser->avatar) : asset('vendors/images/photo1.jpg') }}"
                            alt="User Avatar"
                            class="sidebar-account-avatar"
                        >

                        <div class="sidebar-account-info">
                            <div class="sidebar-account-name">
                                {{ $adminUser ? $adminUser->name : 'Guest' }}
                            </div>
                            <div class="sidebar-account-role">
                                Administrator
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-account-links">
                        <a href="{{ route('admin.profile') }}">
                            <span class="micon bi bi-person-circle"></span>
                            <span class="mtext">Profile</span>
                        </a>

                        <a href="#">
                            <span class="micon bi bi-gear"></span>
                            <span class="mtext">Settings</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>