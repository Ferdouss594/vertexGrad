<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title', 'VertexGrad - Supervisor Panel')</title>

    <link rel="apple-touch-icon" href="{{ asset('vendors/images/apple-touch-icon.png') }}" />
    <link rel="icon" href="{{ asset('vendors/images/VertexGrad_logod.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    @php
        use App\Models\Announcement;

        $adminUser = auth('admin')->user();

        $layoutAnnouncements = Announcement::published()
            ->where(function ($query) {
                $query->where('audience', 'all')
                      ->orWhere('audience', 'supervisors');
            })
            ->ordered()
            ->take(3)
            ->get();

        $unreadCount = $adminUser ? $adminUser->unreadNotifications()->count() : 0;
        $latestNotifications = $adminUser
            ? $adminUser->notifications()->latest()->take(5)->get()
            : collect();
    @endphp

    <style>
        :root {
            --bg: #f5f7fb;
            --bg-soft: #eef2f8;
            --surface: #ffffff;
            --surface-2: #f8fafc;
            --text: #0f172a;
            --text-soft: #64748b;
            --border: #dbe3ef;
            --primary: #1b00ff;
            --primary-2: #4338ca;
            --accent: #06b6d4;
            --success: #16a34a;
            --warning: #f59e0b;
            --danger: #ef4444;
            --sidebar: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            --sidebar-text: #1e293b;
            --sidebar-muted: #64748b;
            --sidebar-hover: rgba(27, 0, 255, 0.08);
            --header-bg: rgba(255, 255, 255, 0.9);
            --header-border: #e9eef7;
            --card-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
            --soft-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            --announcement-bg: linear-gradient(135deg, rgba(27, 0, 255, 0.08), rgba(6, 182, 212, 0.06));
            --announcement-border: rgba(27, 0, 255, 0.14);
            --announcement-text: #0f172a;
        }

        html[data-theme="dark"] {
            --bg: #0b1220;
            --bg-soft: #111827;
            --surface: #111827;
            --surface-2: #0f172a;
            --text: #e5eefc;
            --text-soft: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
            --primary: #6d5dfc;
            --primary-2: #8b5cf6;
            --accent: #22d3ee;
            --success: #22c55e;
            --warning: #fbbf24;
            --danger: #f87171;
            --sidebar: radial-gradient(circle at top left, rgba(109,93,252,.20), transparent 28%), linear-gradient(180deg, #0b1120 0%, #0f172a 48%, #111827 100%);
            --sidebar-text: #dbe7ff;
            --sidebar-muted: #94a3b8;
            --sidebar-hover: rgba(255, 255, 255, 0.08);
            --header-bg: rgba(15, 23, 42, 0.85);
            --header-border: rgba(255, 255, 255, 0.08);
            --card-shadow: 0 18px 45px rgba(0, 0, 0, 0.22);
            --soft-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
            --announcement-bg: linear-gradient(135deg, rgba(109, 93, 252, 0.14), rgba(34, 211, 238, 0.09));
            --announcement-border: rgba(109, 93, 252, 0.22);
            --announcement-text: #e5eefc;
        }

        * {
            transition: background-color .22s ease, border-color .22s ease, color .22s ease, box-shadow .22s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        body.page-transition {
            opacity: 1;
            transition: opacity .2s ease-out;
        }

        body.page-transition.fade-out {
            opacity: 0;
        }

        a {
            text-decoration: none;
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
            padding-top: 96px;
            min-height: 100vh;
            background: var(--bg);
        }

        .main-container.loaded {
            opacity: 1;
            transform: translateY(0);
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 78px;
            background: var(--header-bg);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--header-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 1200;
            box-shadow: var(--soft-shadow);
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
        .dashboard-setting,
        .theme-toggle-btn {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--surface);
            color: var(--text);
            cursor: pointer;
            transition: all .2s ease;
            border: 1px solid var(--border);
            text-decoration: none;
            box-shadow: var(--soft-shadow);
        }

        .menu-icon:hover,
        .search-toggle-icon:hover,
        .dashboard-setting:hover,
        .theme-toggle-btn:hover {
            background: var(--bg-soft);
            color: var(--primary);
            transform: translateY(-1px);
        }

        .theme-toggle-btn i {
            font-size: 18px;
        }

        .theme-toggle-btn .theme-icon-dark {
            display: none;
        }

        html[data-theme="dark"] .theme-toggle-btn .theme-icon-light {
            display: none;
        }

        html[data-theme="dark"] .theme-toggle-btn .theme-icon-dark {
            display: inline-block;
        }

        .user-info-dropdown .dropdown-toggle {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 8px 12px;
            border-radius: 16px;
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
            box-shadow: var(--soft-shadow);
        }

        .user-info-dropdown .dropdown-toggle::after {
            margin-left: 10px;
        }

        .user-info-dropdown .dropdown-menu,
        .header-right .dropdown-menu {
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            background: var(--surface);
        }

        .header-right .dropdown-menu .dropdown-item,
        .user-info-dropdown .dropdown-menu .dropdown-item {
            color: var(--text);
            transition: .2s ease;
        }

        .header-right .dropdown-menu .dropdown-item:hover,
        .user-info-dropdown .dropdown-menu .dropdown-item:hover {
            background: var(--bg-soft);
            color: var(--primary);
        }

        /* Notification bell */
        .notification-trigger {
            position: relative;
            width: 46px;
            height: 46px;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
            box-shadow: var(--soft-shadow);
            transition: all .22s ease;
            text-decoration: none;
        }

        .notification-trigger:hover {
            transform: translateY(-1px);
            color: var(--primary);
            background: var(--bg-soft);
            border-color: var(--border);
            box-shadow: var(--card-shadow);
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
            border: 2px solid var(--surface);
            box-shadow: 0 8px 18px rgba(220, 38, 38, .28);
        }

        .notification-panel {
            width: 360px;
            max-width: 360px;
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            background: var(--surface);
        }

        .notification-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }

        .notification-panel-title {
            margin: 0;
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
        }

        .notification-panel-count {
            font-size: 12px;
            color: var(--text-soft);
            font-weight: 600;
        }

        .notification-panel-body {
            max-height: 330px;
            overflow-y: auto;
            background: var(--surface);
        }

        .notification-item-btn {
            display: block;
            width: 100%;
            text-align: left;
            padding: 14px 16px;
            border: 0;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            transition: .2s ease;
        }

        .notification-item-btn:hover {
            background: var(--bg-soft);
        }

        .notification-item-btn.unread {
            background: color-mix(in srgb, var(--surface) 88%, var(--primary) 12%);
        }

        .notification-item-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: color-mix(in srgb, var(--primary) 12%, transparent);
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .notification-item-title {
            font-size: 13px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 3px;
        }

        .notification-item-message {
            font-size: 12px;
            color: var(--text-soft);
            line-height: 1.5;
        }

        .notification-item-time {
            font-size: 11px;
            color: var(--text-soft);
            margin-top: 6px;
        }

        .notification-panel-footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-top: 1px solid var(--border);
            background: var(--surface);
        }

        .notification-footer-btn {
            border: 0;
            background: var(--surface);
            padding: 12px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            text-decoration: none;
            text-align: center;
            transition: .2s ease;
        }

        .notification-footer-btn:hover {
            background: var(--bg-soft);
            color: var(--primary);
        }

        .notification-footer-btn + .notification-footer-btn {
            border-left: 1px solid var(--border);
        }

        /* Sidebar */
        .left-side-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            z-index: 1300;
            overflow: hidden;
            box-shadow: 18px 0 45px rgba(15, 23, 42, 0.10);
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
            border-bottom: 1px solid var(--border);
        }

        .brand-logo-link {
            display: flex;
            align-items: center;
            min-height: 60px;
        }

        .brand-main-logo {
            display: block !important;
            max-height: 46px !important;
            width: auto !important;
            object-fit: contain;
            opacity: 1 !important;
            visibility: visible !important;
            filter: none !important;
        }

        .close-sidebar {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--surface) 88%, var(--primary) 12%);
            color: var(--text);
            cursor: pointer;
            transition: .2s ease;
            border: 1px solid var(--border);
        }

        .close-sidebar:hover {
            background: var(--bg-soft);
            color: var(--primary);
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
            background: color-mix(in srgb, var(--text-soft) 30%, transparent);
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
            color: var(--sidebar-muted) !important;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
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
            color: var(--sidebar-text);
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
            color: var(--sidebar-text);
            opacity: .85;
        }

        .sidebar-menu li > a:hover,
        .sidebar-menu li.active > a {
            background: var(--sidebar-hover);
            border-color: var(--border);
            color: var(--primary);
            transform: translateX(3px);
            box-shadow: var(--soft-shadow);
        }

        .sidebar-menu li > a:hover .micon,
        .sidebar-menu li.active > a .micon {
            color: var(--primary);
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
            border: 1px solid transparent;
        }

        .sidebar-menu .submenu {
            display: none;
            margin-top: 8px;
            margin-left: 10px;
            padding: 10px;
            border-radius: 18px;
            background: color-mix(in srgb, var(--surface) 94%, var(--primary) 6%);
            border: 1px solid var(--border);
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
            color: var(--sidebar-text);
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
            background: linear-gradient(135deg, var(--primary), var(--accent));
            box-shadow: 0 0 0 4px rgba(96,165,250,.12);
        }

        .sidebar-menu .submenu a:hover,
        .sidebar-menu .submenu li.active a {
            background: color-mix(in srgb, var(--primary) 12%, transparent);
            color: var(--primary);
            border-color: transparent;
            transform: translateX(2px);
        }

        html[data-theme="light"] .sidebar-menu .submenu,
        html[data-theme="light"] .sidebar-menu .submenu li,
        html[data-theme="light"] .sidebar-menu .submenu li a,
        html[data-theme="light"] .sidebar-menu .submenu li a .mtext {
            color: #0f172a !important;
        }

        html[data-theme="light"] .sidebar-menu .submenu li a {
            background: transparent !important;
        }

        html[data-theme="light"] .sidebar-menu .submenu li a:hover,
        html[data-theme="light"] .sidebar-menu .submenu li.active a {
            color: var(--primary) !important;
            background: rgba(27, 0, 255, 0.08) !important;
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

        /* Right sidebar */
        .right-sidebar {
            position: fixed;
            top: 0;
            right: -340px;
            width: 320px;
            height: 100vh;
            z-index: 1400;
            background: var(--surface);
            border-left: 1px solid var(--border);
            box-shadow: -16px 0 45px rgba(15,23,42,.08);
            transition: right 0.25s ease;
        }

        .right-sidebar.open {
            right: 0;
        }

        .right-sidebar .sidebar-title {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .right-sidebar .sidebar-title h3 {
            color: var(--text);
        }

        .right-sidebar .sidebar-title span {
            color: var(--text-soft);
        }

        .right-sidebar .close-sidebar {
            background: var(--bg-soft);
            color: var(--text);
        }

        .right-sidebar .close-sidebar:hover {
            background: color-mix(in srgb, var(--primary) 10%, var(--surface));
            color: var(--primary);
        }

        .theme-setting-card {
            border: 1px solid var(--border);
            background: var(--surface-2);
            border-radius: 22px;
            padding: 18px;
            margin-bottom: 18px;
        }

        .theme-setting-title {
            font-size: 13px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .theme-btn-group {
            display: flex;
            gap: 10px;
        }

        .theme-choice-btn {
            flex: 1;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            padding: 12px 14px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .theme-choice-btn.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            border-color: transparent;
            box-shadow: 0 14px 30px rgba(27, 0, 255, .18);
        }

        /* Announcement helpers */
        .announcement-banner {
            background: var(--announcement-bg);
            border: 1px solid var(--announcement-border);
            border-radius: 28px;
            padding: 22px 24px;
            color: var(--announcement-text);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .announcement-banner::before {
            content: "";
            position: absolute;
            top: -35px;
            right: -35px;
            width: 130px;
            height: 130px;
            background: rgba(255,255,255,.08);
            border-radius: 999px;
            pointer-events: none;
        }

        .announcement-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            border: 1px solid var(--border);
            background: color-mix(in srgb, var(--surface) 90%, var(--primary) 10%);
            color: var(--text);
        }

        .announcement-badge.pinned {
            background: rgba(245, 158, 11, 0.10);
            border-color: rgba(245, 158, 11, 0.22);
            color: #f59e0b;
        }

        .announcement-title {
            font-size: 22px;
            font-weight: 900;
            margin-top: 12px;
            margin-bottom: 8px;
            color: var(--text);
        }

        .announcement-text {
            font-size: 14px;
            line-height: 1.8;
            color: var(--text-soft);
            margin-bottom: 0;
        }

        .announcement-meta {
            margin-top: 12px;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-soft);
        }

        .announcement-card {
            border: 1px solid var(--border);
            background: var(--surface);
            border-radius: 22px;
            padding: 18px;
            box-shadow: var(--soft-shadow);
            height: 100%;
        }

        .announcement-card-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .announcement-card-text {
            font-size: 13px;
            line-height: 1.7;
            color: var(--text-soft);
            margin-bottom: 0;
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
        (function () {
            const savedTheme = localStorage.getItem('supervisor-theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();

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
    </script>
</head>
<body class="page-transition">

<div id="flash-messages"></div>

<div class="left-side-bar" id="supervisorSidebar">
    <div class="brand-logo">
        <a href="{{ route('supervisor.dashboard') }}" class="brand-logo-link">
            <img src="{{ asset('vendors/images/VertexGrad_logod.png') }}" alt="VertexGrad Logo" class="brand-main-logo" />
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
@if($user && $user->hasPermission('view_contact_messages'))
<li class="{{ request()->routeIs('supervisor.contact-messages.*') ? 'active' : '' }}">
    <a href="{{ route('supervisor.contact-messages.index') }}">
        <span class="micon bi bi-envelope-paper-fill"></span>
        <span class="mtext">Contact Messages</span>
    </a>
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

        <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Toggle theme">
            <i class="fas fa-moon theme-icon-light"></i>
            <i class="fas fa-sun theme-icon-dark"></i>
        </button>

        <a href="javascript:void(0);" class="dashboard-setting" id="rightSidebarToggleBtn" title="Layout settings">
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
                    <a class="dropdown-item" href="javascript:void(0);">
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

<div class="right-sidebar" id="rightSidebarPanel">
    <div class="sidebar-title">
        <h3 class="weight-600 font-16">
            Layout Settings
            <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
        </h3>
        <div class="close-sidebar" id="rightSidebarCloseBtn">
            <i class="icon-copy ion-close-round"></i>
        </div>
    </div>

    <div class="right-sidebar-body customscroll">
        <div class="right-sidebar-body-content p-3">

            <div class="theme-setting-card">
                <div class="theme-setting-title">Theme Mode</div>
                <div class="theme-btn-group">
                    <button type="button" class="theme-choice-btn" id="themeLightBtn">Light</button>
                    <button type="button" class="theme-choice-btn" id="themeDarkBtn">Dark</button>
                </div>
            </div>

            <div class="theme-setting-card">
                <div class="theme-setting-title">Announcements</div>

                @if($layoutAnnouncements->count())
                    <div class="d-flex flex-column gap-3">
                        @foreach($layoutAnnouncements as $announcement)
                            <div class="announcement-card">
                                <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                    <div class="announcement-card-title">
                                        {{ $announcement->title }}
                                    </div>

                                    @if($announcement->is_pinned)
                                        <span class="announcement-badge pinned" style="padding:6px 10px; font-size:10px;">
                                            <i class="fas fa-thumbtack"></i>
                                            Pinned
                                        </span>
                                    @endif
                                </div>

                                <p class="announcement-card-text">
                                    {{ \Illuminate\Support\Str::limit($announcement->body, 120) }}
                                </p>

                                @if($announcement->expires_at)
                                    <div class="announcement-meta">
                                        Until {{ $announcement->expires_at->format('M d, Y • h:i A') }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="announcement-card">
                        <div class="announcement-card-title">No announcements</div>
                        <p class="announcement-card-text mb-0">
                            There are no active announcements right now.
                        </p>
                    </div>
                @endif
            </div>

            <div class="reset-options pt-2 text-center">
                <button class="btn btn-danger" id="reset-settings" type="button">Reset Theme</button>
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
    @if(session('success'))
        showToast(@json(session('success')), 'success');
    @endif

    @if(session('error'))
        showToast(@json(session('error')), 'danger');
    @endif

    const html = document.documentElement;
    const body = document.body;

    const sidebar = document.getElementById('supervisorSidebar');
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    const closeBtn = document.getElementById('sidebarCloseBtn');
    const overlay = document.getElementById('mobileMenuOverlay');
    const main = document.querySelector('.main-container');

    const rightSidebar = document.getElementById('rightSidebarPanel');
    const rightSidebarToggleBtn = document.getElementById('rightSidebarToggleBtn');
    const rightSidebarCloseBtn = document.getElementById('rightSidebarCloseBtn');

    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeLightBtn = document.getElementById('themeLightBtn');
    const themeDarkBtn = document.getElementById('themeDarkBtn');
    const resetBtn = document.getElementById('reset-settings');

    if (main) {
        requestAnimationFrame(() => {
            main.classList.add('loaded');
        });
    }

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('supervisor-theme', theme);
        syncThemeButtons();
    }

    function syncThemeButtons() {
        const currentTheme = html.getAttribute('data-theme') || 'light';

        if (themeLightBtn && themeDarkBtn) {
            themeLightBtn.classList.toggle('active', currentTheme === 'light');
            themeDarkBtn.classList.toggle('active', currentTheme === 'dark');
        }
    }

    function openRightSidebarPanel() {
        if (!rightSidebar) return;
        rightSidebar.classList.add('open');
    }

    function closeRightSidebarPanel() {
        if (!rightSidebar) return;
        rightSidebar.classList.remove('open');
    }

    function toggleRightSidebarPanel() {
        if (!rightSidebar) return;
        rightSidebar.classList.toggle('open');
    }

    function openSidebarMobile() {
        if (!sidebar || !overlay) return;
        sidebar.classList.add('mobile-open');
        overlay.classList.add('active');
    }

    function closeSidebarMobile() {
        if (!sidebar || !overlay) return;
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    }

    function toggleSidebarDesktop() {
        if (!sidebar) return;
        sidebar.classList.toggle('closed');
        body.classList.toggle('sidebar-collapsed');
    }

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function () {
            const currentTheme = html.getAttribute('data-theme') || 'light';
            applyTheme(currentTheme === 'light' ? 'dark' : 'light');
        });
    }

    if (themeLightBtn) {
        themeLightBtn.addEventListener('click', function () {
            applyTheme('light');
            closeRightSidebarPanel();
        });
    }

    if (themeDarkBtn) {
        themeDarkBtn.addEventListener('click', function () {
            applyTheme('dark');
            closeRightSidebarPanel();
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            applyTheme('light');
            closeRightSidebarPanel();
        });
    }

    syncThemeButtons();

    if (rightSidebarToggleBtn) {
        rightSidebarToggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            toggleRightSidebarPanel();
        });
    }

    if (rightSidebarCloseBtn) {
        rightSidebarCloseBtn.addEventListener('click', function () {
            closeRightSidebarPanel();
        });
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            if (window.innerWidth <= 991) {
                if (sidebar && sidebar.classList.contains('mobile-open')) {
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
        overlay.addEventListener('click', function () {
            closeSidebarMobile();
            closeRightSidebarPanel();
        });
    }

    document.querySelectorAll('.dropdown-parent').forEach(function (parent) {
        const link = parent.querySelector('a');
        let closeTimer = null;

        if (!link) return;

        link.addEventListener('click', function (e) {
            e.preventDefault();

            const isOpen = parent.classList.contains('open');

            document.querySelectorAll('.dropdown-parent').forEach(function (item) {
                if (item !== parent) {
                    item.classList.remove('open');
                }
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
            if (closeTimer) clearTimeout(closeTimer);
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

                if (unreadText) {
                    unreadText.textContent = count;
                }

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