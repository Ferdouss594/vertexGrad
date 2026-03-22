<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title', 'VertexGrad - Supervisor Panel')</title>

    <link rel="apple-touch-icon" href="{{ asset('vendors/images/apple-touch-icon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --sup-primary: #1b00ff;
            --sup-primary-2: #4338ca;
            --sup-dark: #0f172a;
            --sup-dark-2: #111827;
            --sup-slate: #64748b;
            --sup-border: rgba(255,255,255,.08);
            --sup-card: rgba(255,255,255,.05);
            --sup-glow: 0 16px 40px rgba(27, 0, 255, .18);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
        }

        body.page-transition {
            opacity: 1;
            transition: opacity .2s ease-out;
        }

        body.page-transition.fade-out {
            opacity: 0;
        }

        #flash-messages {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 99999;
            min-width: 290px;
            max-width: 420px;
        }

        .main-container,
        .left-side-bar,
        .right-sidebar,
        .header {
            transition: all .25s ease;
        }

        .main-container {
            opacity: 0;
            transform: translateY(8px);
            padding-top: 90px;
        }

        .main-container.loaded {
            opacity: 1;
            transform: translateY(0);
        }

        /* =========================
           HEADER
        ========================= */
        .header {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 78px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid #e9eef7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 1200;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .04);
        }

        .left-side-bar.closed + .mobile-menu-overlay + .main-container + .header,
        body.sidebar-collapsed .header {
            left: 0;
        }

        .header-left,
        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-icon,
        .search-toggle-icon,
        .dashboard-setting {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f7f9ff;
            color: #334155;
            cursor: pointer;
            transition: all .2s ease;
            border: 1px solid #e6ebf5;
            text-decoration: none;
        }

        .menu-icon:hover,
        .search-toggle-icon:hover,
        .dashboard-setting:hover {
            background: #eef2ff;
            color: var(--sup-primary);
            transform: translateY(-1px);
        }

        .user-info-dropdown .dropdown-toggle {
            background: #fff;
            border: 1px solid #e6ebf5;
            padding: 8px 12px;
            border-radius: 16px;
            text-decoration: none;
            color: #0f172a;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(15,23,42,.04);
        }

        .user-info-dropdown .dropdown-toggle::after {
            margin-left: 10px;
        }

        .user-info-dropdown .dropdown-menu,
        .header-right .dropdown-menu {
            border: 1px solid #edf2f7;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, .12);
            overflow: hidden;
        }

        .header-right .dropdown-menu .dropdown-item {
            transition: .2s ease;
        }

        .header-right .dropdown-menu .dropdown-item:hover {
            background: #f8fbff;
        }

        /* =========================
           NOTIFICATION BELL
        ========================= */
        .notification-trigger {
            position: relative;
            width: 46px;
            height: 46px;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff, #f8fbff);
            border: 1px solid #e6ebf5;
            color: #334155;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .05);
            transition: all .22s ease;
            text-decoration: none;
        }

        .notification-trigger:hover {
            transform: translateY(-1px);
            color: var(--sup-primary);
            background: #eef2ff;
            border-color: #dbe4ff;
            box-shadow: 0 14px 28px rgba(27, 0, 255, .10);
        }

        .notification-trigger i {
            font-size: 20px;
            line-height: 1;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border-radius: 999px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 8px 18px rgba(220, 38, 38, .28);
        }

        .notification-panel {
            width: 360px;
            max-width: 360px;
            border: 1px solid #edf2f7;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, .12);
            overflow: hidden;
        }

        .notification-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid #eef2f7;
            background: #fff;
        }

        .notification-panel-title {
            margin: 0;
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
        }

        .notification-panel-count {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
        }

        .notification-panel-body {
            max-height: 330px;
            overflow-y: auto;
            background: #fff;
        }

        .notification-item-btn {
            display: block;
            width: 100%;
            text-align: left;
            padding: 14px 16px;
            border: 0;
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            transition: .2s ease;
        }

        .notification-item-btn:hover {
            background: #f8fbff;
        }

        .notification-item-btn.unread {
            background: #f8faff;
        }

        .notification-item-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: #eef2ff;
            color: var(--sup-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .notification-item-title {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 3px;
        }

        .notification-item-message {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }

        .notification-item-time {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 6px;
        }

        .notification-panel-footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-top: 1px solid #eef2f7;
            background: #fff;
        }

        .notification-footer-btn {
            border: 0;
            background: #fff;
            padding: 12px;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            text-decoration: none;
            text-align: center;
            transition: .2s ease;
        }

        .notification-footer-btn:hover {
            background: #f8fbff;
            color: var(--sup-primary);
        }

        .notification-footer-btn + .notification-footer-btn {
            border-left: 1px solid #eef2f7;
        }

        /* =========================
           SIDEBAR
        ========================= */
        .left-side-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(67,56,202,.22), transparent 28%),
                linear-gradient(180deg, #0b1120 0%, #0f172a 48%, #111827 100%);
            border-right: 1px solid rgba(255,255,255,.05);
            z-index: 1300;
            overflow: hidden;
            box-shadow: 18px 0 45px rgba(253, 254, 255, 0.28);
        }

        .left-side-bar.closed {
            transform: translateX(-100%);
            opacity: 0;
        }

        .brand-logo {
            height: 84px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        .brand-logo a {
            display: flex;
            align-items: center;
            min-height: 60px;
        }

        .brand-logo img {
            max-height: 42px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 6px 18px rgba(255,255,255,.08));
        }

        .close-sidebar {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.06);
            color: #1c3c65;
            cursor: pointer;
            transition: .2s ease;
        }

        .close-sidebar:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
        }

        .menu-block {
            height: calc(100vh - 84px);
            overflow-y: auto;
            overflow-x: hidden;
            padding: 16px 14px 26px;
        }

        .menu-block::-webkit-scrollbar {
            width: 6px;
        }

        .menu-block::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.12);
            border-radius: 20px;
        }

        .sidebar-menu ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .sidebar-menu .menu-title {
            padding: 16px 14px 8px;
        }

        .sidebar-menu .menu-title .mtext {
            color: rgba(24, 32, 103, 0.42) !important;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: .14em;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu li > a {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 52px;
            padding: 13px 16px;
            border-radius: 16px;
            color: #122236;
            text-decoration: none;
            font-weight: 600;
            transition: all .22s ease;
            background: transparent;
            border: 1px solid transparent;
        }

        .sidebar-menu li > a .micon {
            width: 22px;
            min-width: 22px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: #38498d;
        }

        .sidebar-menu li > a:hover,
        .sidebar-menu li.active > a {
            background: linear-gradient(135deg, rgba(255,255,255,.09), rgba(255,255,255,.04));
            border-color: rgba(255,255,255,.08);
            color: #273e9b;
            transform: translateX(3px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.04), 0 10px 25px rgba(0,0,0,.18);
        }

        .sidebar-menu li > a:hover .micon,
        .sidebar-menu li.active > a .micon {
            color: #332b93;
        }

        .sidebar-menu li > a .menu-arrow {
            margin-left: auto;
            transition: transform .25s ease;
            font-size: 12px;
            opacity: .8;
        }

        .sidebar-menu li.open > a .menu-arrow {
            transform: rotate(180deg);
        }

        .sidebar-menu .dropdown-parent > a {
            background: linear-gradient(135deg, rgba(255,255,255,.04), rgba(255,255,255,.02));
            border: 1px solid rgba(255,255,255,.05);
        }

        .sidebar-menu .submenu {
            display: none;
            margin-top: 8px;
            margin-left: 10px;
            padding: 10px;
            border-radius: 18px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.05);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.03);
        }

        .sidebar-menu .dropdown-parent.open > .submenu {
            display: block;
            animation: fadeSlideDown .22s ease;
        }

        .sidebar-menu .submenu li {
            margin-bottom: 6px;
        }

        .sidebar-menu .submenu li:last-child {
            margin-bottom: 0;
        }

        .sidebar-menu .submenu a {
            min-height: 46px;
            padding: 11px 14px 11px 42px;
            font-size: 14px;
            color: #cbd5e1;
            border-radius: 14px;
            background: transparent;
        }

        .sidebar-menu .submenu a::before {
            content: "";
            position: absolute;
            left: 18px;
            top: 50%;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #60a5fa, #8b5cf6);
            box-shadow: 0 0 0 4px rgba(96,165,250,.12);
        }

        .sidebar-menu .submenu a:hover,
        .sidebar-menu .submenu li.active a {
            background: linear-gradient(135deg, rgba(27,0,255,.18), rgba(67,56,202,.15));
            color: #e6d6d6;
            border-color: transparent;
            transform: translateX(2px);
        }

        .mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,.45);
            backdrop-filter: blur(2px);
            opacity: 0;
            visibility: hidden;
            transition: .25s ease;
            z-index: 1250;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .right-sidebar {
            background: #fff;
            border-left: 1px solid #edf2f7;
            box-shadow: -16px 0 45px rgba(15,23,42,.08);
        }

        .right-sidebar .sidebar-title {
            padding: 24px 20px;
            border-bottom: 1px solid #eef2f7;
        }

        .right-sidebar .close-sidebar {
            background: #f8fafc;
            color: #334155;
        }

        .right-sidebar .close-sidebar:hover {
            background: #eef2ff;
            color: var(--sup-primary);
        }

        @keyframes fadeSlideDown {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 991px) {
            .left-side-bar {
                transform: translateX(-100%);
                opacity: 0;
            }

            .left-side-bar.mobile-open {
                transform: translateX(0);
                opacity: 1;
            }

            .header {
                left: 0 !important;
                padding: 0 16px;
            }

            .main-container {
                padding-top: 86px;
            }
        }
    </style>

    <script>
        function showToast(message, type = 'success') {
            const flashDiv = document.getElementById('flash-messages');
            if (!flashDiv) return;

            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show shadow`;
            toast.style.marginBottom = '10px';
            toast.style.borderRadius = '16px';
            toast.style.border = 'none';
            toast.innerHTML = message + `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
            flashDiv.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 250);
            }, 4000);
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif

            @if(session('error'))
                showToast(@json(session('error')), 'danger');
            @endif
        });
    </script>
</head>
<body class="page-transition">

<div id="flash-messages"></div>

@php
    $adminUser = auth('admin')->user();
    $unreadCount = $adminUser ? $adminUser->unreadNotifications()->count() : 0;
    $latestNotifications = $adminUser
        ? $adminUser->notifications()->latest()->take(5)->get()
        : collect();
@endphp

<div class="left-side-bar" id="supervisorSidebar">
    <div class="brand-logo">
        <a href="{{ route('supervisor.dashboard') }}">
            <img src="{{ asset('vendors/images/VertexGrad_logod.png') }}" alt="Logo" class="dark-logo" />
        </a>

        <div class="close-sidebar" id="sidebarCloseBtn">
            <i class="ion-close-round"></i>
        </div>
    </div>

    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">

               @php
    $user = auth('admin')->user();

    $canReviewProjects = $user && $user->hasPermission('review_projects');
    $canViewMeetings = $user && $user->hasPermission('view_meetings');
    $canManageMeetings = $user && $user->hasPermission('manage_meetings');
    $canViewRequests = $user && $user->hasPermission('view_requests');
@endphp

<li class="menu-title">
    <span class="mtext">SUPERVISOR PANEL</span>
</li>

<li>
    <a href="{{ route('supervisor.dashboard') }}">
        <span class="micon bi bi-house-door-fill"></span>
        <span class="mtext">Dashboard</span>
    </a>
</li>

@if($canReviewProjects)
<li class="dropdown-parent">
    <a href="javascript:void(0);" class="menu-dropdown-trigger">
        <span class="micon bi bi-folder-fill"></span>
        <span class="mtext">Projects</span>
        <span class="menu-arrow"><i class="fa fa-chevron-down"></i></span>
    </a>
    <ul class="submenu">
        <li><a href="{{ route('supervisor.projects.index') }}">All Projects</a></li>
        <li><a href="{{ route('supervisor.projects.pending') }}">Pending Reviews</a></li>
        <li><a href="{{ route('supervisor.projects.approved') }}">Approved Projects</a></li>
        <li><a href="{{ route('supervisor.projects.revisions') }}">Revision Requests</a></li>
    </ul>
</li>
@endif

@if($canViewMeetings)
<li class="dropdown-parent">
    <a href="javascript:void(0);" class="menu-dropdown-trigger">
        <span class="micon bi bi-calendar-event"></span>
        <span class="mtext">Meetings</span>
        <span class="menu-arrow"><i class="fa fa-chevron-down"></i></span>
    </a>
    <ul class="submenu">
        <li><a href="{{ route('supervisor.meetings.index') }}">All Meetings</a></li>
        <li><a href="{{ route('supervisor.meetings.upcoming') }}">Upcoming Meetings</a></li>
        <li><a href="{{ route('supervisor.meetings.completed') }}">Completed Meetings</a></li>

        @if($canManageMeetings)
        <li><a href="{{ route('supervisor.meetings.create') }}">Create Meeting</a></li>
        @endif
    </ul>
</li>
@endif

@if($canViewRequests)
<li class="dropdown-parent">
    <a href="javascript:void(0);" class="menu-dropdown-trigger">
        <span class="micon fa fa-send"></span>
        <span class="mtext">Requests</span>
        <span class="menu-arrow"><i class="fa fa-chevron-down"></i></span>
    </a>
    <ul class="submenu">
        <li><a href="{{ route('supervisor.requests.index') }}">All Requests</a></li>
        <li><a href="{{ route('supervisor.requests.pending') }}">Pending Requests</a></li>
        <li><a href="{{ route('supervisor.requests.completed') }}">Completed Requests</a></li>
    </ul>
</li>
@endif

<li class="menu-title">
    <span class="mtext">ACCOUNT</span>
</li>

<li>
    <a href="{{ route('supervisor.profile.index') }}">
        <span class="micon bi bi-person-lines-fill"></span>
        <span class="mtext">Profile Settings</span>
    </a>
</li>

</ul>
</div>
</div>
</div>

<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list" id="sidebarToggleBtn"></div>
        <div class="search-toggle-icon bi bi-grid"></div>
    </div>

    <div class="header-right d-flex align-items-center gap-2">
        <a href="javascript:;" class="dashboard-setting" data-toggle="right-sidebar">
            <i class="dw dw-settings2"></i>
        </a>

        <div class="dropdown" id="admin-notification-bell" data-count-url="{{ route('admin.notifications.count') }}">
            <a class="dropdown-toggle notification-trigger p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="dw dw-notification"></i>

                <span id="adminUnreadBadge"
                      class="notification-badge {{ $unreadCount > 0 ? '' : 'd-none' }}">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end p-0 notification-panel">
                <div class="notification-panel-header">
                    <h6 class="notification-panel-title">Notifications</h6>
                    <span class="notification-panel-count">
                        <span id="adminUnreadText">{{ $unreadCount }}</span> unread
                    </span>
                </div>

                <div class="notification-panel-body">
                    @forelse($latestNotifications as $notification)
                        @php
                            $title = $notification->data['title'] ?? 'Notification';
                            $message = $notification->data['message'] ?? '';
                            $url = $notification->data['url'] ?? route('admin.notifications.index');
                            $icon = $notification->data['icon'] ?? 'fas fa-bell';
                            $isRead = !is_null($notification->read_at);
                        @endphp

                        <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}" class="m-0">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ $url }}">

                            <button type="submit" class="notification-item-btn {{ $isRead ? '' : 'unread' }}">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="notification-item-icon">
                                        <i class="{{ $icon }}"></i>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="notification-item-title">{{ $title }}</div>
                                        <div class="notification-item-message">{{ $message }}</div>
                                        <div class="notification-item-time">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </button>
                        </form>
                    @empty
                        <div class="px-3 py-4 text-center text-muted small">
                            No notifications yet
                        </div>
                    @endforelse
                </div>

                <div class="notification-panel-footer">
                    <a href="{{ route('admin.notifications.index') }}" class="notification-footer-btn">
                        History
                    </a>

                    <form method="POST" action="{{ route('admin.notifications.markAllRead') }}" class="m-0">
                        @csrf
                        <button type="submit" class="notification-footer-btn w-100">
                            Mark All Read
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="dropdown user-info-dropdown">
            <a class="dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ $adminUser && $adminUser->avatar ? asset('storage/' . $adminUser->avatar) : asset('vendors/images/photo1.jpg') }}"
                     class="rounded-circle"
                     width="36"
                     height="36"
                     alt="User Avatar">
                <span>{{ $adminUser ? $adminUser->name : 'Guest' }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="bi bi-person"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Log Out
                    </a>
                </li>
            </ul>

            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>

<div class="right-sidebar">
    <div class="sidebar-title">
        <h3 class="weight-600 font-16 text-blue">
            Layout Settings
            <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
        </h3>
        <div class="close-sidebar" data-toggle="right-sidebar-close">
            <i class="icon-copy ion-close-round"></i>
        </div>
    </div>

    <div class="right-sidebar-body customscroll">
        <div class="right-sidebar-body-content">
            <h4 class="weight-600 font-18 pb-10">Header Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
            </div>

            <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
            </div>

            <div class="reset-options pt-30 text-center">
                <button class="btn btn-danger" id="reset-settings">Reset Settings</button>
            </div>
        </div>
    </div>
</div>

<div class="main-container">
    @yield('content')
</div>

<script src="{{ asset('vendors/scripts/core.js') }}"></script>
<script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
<script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
<script src="{{ asset('vendors/scripts/process.js') }}" defer></script>
<script src="{{ asset('src/plugins/apexcharts/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}" defer></script>
<script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}" defer></script>
<script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('supervisorSidebar');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const closeBtn = document.getElementById('sidebarCloseBtn');
        const overlay = document.getElementById('mobileMenuOverlay');
        const main = document.querySelector('.main-container');

        if (main) {
            requestAnimationFrame(() => {
                main.classList.add('loaded');
            });
        }

        function openSidebarMobile() {
            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');
        }

        function closeSidebarMobile() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        }

        function toggleSidebarDesktop() {
            sidebar.classList.toggle('closed');
            document.body.classList.toggle('sidebar-collapsed');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                if (window.innerWidth <= 991) {
                    if (sidebar.classList.contains('mobile-open')) {
                        closeSidebarMobile();
                    } else {
                        openSidebarMobile();
                    }
                } else {
                    toggleSidebarDesktop();
                }
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                if (window.innerWidth <= 991) {
                    closeSidebarMobile();
                } else {
                    toggleSidebarDesktop();
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebarMobile);
        }

        document.querySelectorAll('.dropdown-parent').forEach(function (parent) {
            const link = parent.querySelector('a');
            let closeTimer = null;

            link.addEventListener('click', function (e) {
                e.preventDefault();

                const isOpen = parent.classList.contains('open');

                document.querySelectorAll('.dropdown-parent').forEach(function (item) {
                    item.classList.remove('open');
                });

                if (!isOpen) {
                    parent.classList.add('open');

                    closeTimer = setTimeout(function () {
                        parent.classList.remove('open');
                    }, 10000);
                } else {
                    parent.classList.remove('open');
                }
            });

            parent.addEventListener('mouseenter', function () {
                if (closeTimer) {
                    clearTimeout(closeTimer);
                }
            });

            parent.addEventListener('mouseleave', function () {
                if (parent.classList.contains('open')) {
                    closeTimer = setTimeout(function () {
                        parent.classList.remove('open');
                    }, 10000);
                }
            });
        });

        const bell = document.getElementById('admin-notification-bell');
        if (bell) {
            const countUrl = bell.dataset.countUrl;
            const badge = document.getElementById('adminUnreadBadge');
            const unreadText = document.getElementById('adminUnreadText');

            function refreshUnreadCount() {
                fetch(countUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const count = data.count ?? 0;

                    if (unreadText) unreadText.textContent = count;

                    if (badge) {
                        if (count > 0) {
                            badge.classList.remove('d-none');
                            badge.textContent = count > 9 ? '9+' : count;
                        } else {
                            badge.classList.add('d-none');
                        }
                    }
                })
                .catch(() => {});
            }

            setInterval(refreshUnreadCount, 30000);
        }
    });
</script>

@stack('scripts')

</body>
</html>