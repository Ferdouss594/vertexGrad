<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title', 'VertexGrad - Dashboard')</title>

    <link rel="apple-touch-icon" href="{{ asset('vendors/images/apple-touch-icon.png') }}" />
    <link rel="icon" href="{{ asset('vendors/images/VertexGrad_logod.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --vg-primary: #1b00ff;
            --vg-primary-dark: #1400c8;
            --vg-header-start: #081534;
            --vg-header-end: #1200b8;
            --vg-sidebar-start: #061127;
            --vg-sidebar-end: #0b1d49;
            --vg-bg: #f3f6fb;
            --vg-surface: #ffffff;
            --vg-surface-soft: #f8fafc;
            --vg-text: #18243a;
            --vg-text-muted: #6b7a90;
            --vg-border: #e2e8f0;
            --vg-shadow-sm: 0 10px 24px rgba(15, 23, 42, 0.06);
            --vg-shadow-md: 0 16px 36px rgba(15, 23, 42, 0.10);
            --sidebar-width: 290px;
            --header-height: 76px;
        }

        body.sidebar-closed .header {
    left: 0 !important;
    width: 100% !important;
}

body.sidebar-closed .main-container {
    margin-left: 0 !important;
    width: 100% !important;
}

body.sidebar-closed .left-side-bar {
    transform: translateX(-100%) !important;
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: none !important;
}

.left-side-bar {
    transform: translateX(0);
}

@media (max-width: 991.98px) {
    .header {
        left: 0 !important;
        width: 100% !important;
    }

    .main-container {
        margin-left: 0 !important;
        width: 100% !important;
    }
}
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--vg-bg);
            color: var(--vg-text);
            overflow-x: hidden;
        }

        body {
            position: relative;
        }

        #flash-messages {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            min-width: 280px;
            max-width: 360px;
        }

        /* =========================
           HARD RESET FOR VENDOR LAYOUT
        ========================= */
        .header,
        .left-side-bar,
        .main-container,
        .right-sidebar,
        .footer {
            box-sizing: border-box;
        }

        .header,
        .left-side-bar,
        .main-container {
            margin: 0 !important;
        }

        .header {
            position: fixed !important;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            width: auto !important;
            height: var(--header-height);
            min-height: var(--header-height);
            z-index: 1000;
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            background: linear-gradient(135deg, var(--vg-header-start) 0%, var(--vg-header-end) 100%) !important;
            border: 0 !important;
            box-shadow: 0 10px 28px rgba(9, 16, 45, 0.18);
        }

        body.sidebar-closed .header {
    left: 0 !important;
    width: 100% !important;
}

body.sidebar-closed .main-container {
    margin-left: 0 !important;
    width: 100% !important;
}

@media (max-width: 991.98px) {
    .header {
        left: 0 !important;
        width: 100% !important;
    }

    .main-container {
        margin-left: 0 !important;
        width: 100% !important;
    }
}
        .left-side-bar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: var(--sidebar-width) !important;
            min-width: var(--sidebar-width) !important;
            max-width: var(--sidebar-width) !important;
            height: 100vh !important;
            z-index: 1001;
            display: flex !important;
            flex-direction: column;
            background: linear-gradient(180deg, var(--vg-sidebar-start) 0%, var(--vg-sidebar-end) 100%) !important;
            box-shadow: 8px 0 26px rgba(10, 16, 39, 0.18);
            overflow: hidden;
            transition: transform 0.25s ease, opacity 0.25s ease !important;
        }

        .main-container {
            margin-left: var(--sidebar-width) !important;
            margin-top: var(--header-height) !important;
            width: calc(100% - var(--sidebar-width)) !important;
            min-height: calc(100vh - var(--header-height));
            background: var(--vg-bg);
            padding: 28px 0 24px;
        }

        .app-content-wrap {
            padding: 0 22px;
        }

        .right-sidebar {
            position: fixed !important;
            top: 0;
            right: 0;
            width: 320px;
            max-width: 100%;
            height: 100vh;
            background: #fff;
            border-left: 1px solid var(--vg-border);
            box-shadow: -10px 0 24px rgba(15, 23, 42, 0.06);
            z-index: 1200;
            transform: translateX(320px);
            opacity: 0;
            transition: transform 0.25s ease, opacity 0.25s ease !important;
        }

        .right-sidebar.open {
            transform: translateX(0);
            opacity: 1;
        }

        /* =========================
           HEADER
        ========================= */
        .header-left,
        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-left .menu-icon,
        .header-left .search-toggle-icon,
        .header-right .dashboard-setting,
        .header-right .header-circle-btn {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.10);
            color: #fff;
            cursor: pointer;
            transition: all 0.18s ease;
            flex-shrink: 0;
        }

        .header-left .menu-icon:hover,
        .header-left .search-toggle-icon:hover,
        .header-right .dashboard-setting:hover,
        .header-right .header-circle-btn:hover {
            background: rgba(255,255,255,0.18);
            transform: translateY(-1px);
        }

        .user-info-dropdown .dropdown-toggle {
            padding: 6px 10px 6px 8px;
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.10);
            background: rgba(255,255,255,0.12);
            color: #fff !important;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .user-info-dropdown .dropdown-toggle::after {
            margin-left: 10px;
            color: #fff;
        }

        /* =========================
           SIDEBAR
        ========================= */
        .left-side-bar .brand-logo {
            min-height: 82px;
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .sidebar-logo-link {
            display: flex !important;
            align-items: center;
            text-decoration: none;
            max-width: calc(100% - 44px);
        }

        .sidebar-logo-img {
            max-height: 42px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            display: block;
        }

        .left-side-bar .close-sidebar {
            width: 34px;
            height: 34px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: rgba(255,255,255,0.82);
            cursor: pointer;
            transition: all 0.18s ease;
            flex-shrink: 0;
        }

        .left-side-bar .close-sidebar:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .menu-block {
            flex: 1;
            min-height: 0;
            padding-top: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
        }

        .sidebar-section-label {
            padding: 0 18px;
            margin: 8px 0 12px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.44);
        }

        #accordion-menu {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 12px 18px !important;
        }

        #accordion-menu li {
            list-style: none !important;
            margin: 0 0 8px 0 !important;
            padding: 0 !important;
        }

        #accordion-menu li a,
        #accordion-menu li a.dropdown-toggle,
        #accordion-menu li a.no-arrow {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 12px !important;
            width: 100% !important;
            min-height: 52px !important;
            padding: 14px 14px !important;
            border-radius: 14px !important;
            color: rgba(255,255,255,0.84) !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            line-height: 1.2 !important;
            transition: all 0.18s ease !important;
            overflow: hidden !important;
        }

        #accordion-menu li a.dropdown-toggle::before,
        #accordion-menu li a.dropdown-toggle::after,
        #accordion-menu li a.no-arrow::before,
        #accordion-menu li a.no-arrow::after {
            display: none !important;
            content: none !important;
        }

        #accordion-menu li a:hover {
            background: rgba(255,255,255,0.10) !important;
            color: #fff !important;
            transform: translateX(2px);
        }

        #accordion-menu li a .micon {
            position: static !important;
            left: auto !important;
            top: auto !important;
            transform: none !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 20px !important;
            min-width: 20px !important;
            height: 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 17px !important;
            color: inherit !important;
            flex-shrink: 0 !important;
        }

        #accordion-menu li a .mtext {
            position: static !important;
            left: auto !important;
            top: auto !important;
            transform: none !important;
            margin: 0 !important;
            padding: 0 !important;
            flex: 1 !important;
            min-width: 0 !important;
            color: inherit !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        #accordion-menu li a.active,
        #accordion-menu li a.current,
        #accordion-menu li a[aria-expanded="true"] {
            background: linear-gradient(90deg, rgba(27,0,255,0.36) 0%, rgba(79,70,229,0.18) 100%) !important;
            color: #fff !important;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.05);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 14px 12px 16px;
            border-top: 1px solid rgba(255,255,255,0.07);
            background: rgba(255,255,255,0.02);
            flex-shrink: 0;
        }

        .sidebar-bottom-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.46);
            margin-bottom: 10px;
            padding: 0 6px;
        }

        .sidebar-account-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            padding: 12px;
        }

        .sidebar-account-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .sidebar-account-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.14);
            flex-shrink: 0;
        }

        .sidebar-account-name {
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-account-role {
            margin-top: 2px;
            font-size: 11px;
            color: rgba(255,255,255,0.60);
        }

        .sidebar-account-links {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-account-links a {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 42px;
            padding: 10px 12px;
            border-radius: 12px;
            color: rgba(255,255,255,0.84);
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.18s ease;
        }

        .sidebar-account-links a:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        /* =========================
           FORMS / DROPDOWNS / FOOTER
        ========================= */
        .dropdown-menu {
            border: 1px solid var(--vg-border);
            box-shadow: var(--vg-shadow-md);
            padding: 10px;
            border-radius: 16px;
        }

        .dropdown-item {
            min-height: 42px;
            display: flex;
            align-items: center;
            border-radius: 10px;
            font-weight: 500;
            color: var(--vg-text);
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: #f8fafc;
            color: var(--vg-text);
        }

        .btn,
        .form-control,
        .form-select,
        .dropdown-menu {
            border-radius: 12px;
        }

        .btn {
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--vg-primary);
            border-color: var(--vg-primary);
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: var(--vg-primary-dark) !important;
            border-color: var(--vg-primary-dark) !important;
        }

        .app-footer {
            margin: 18px 22px 0;
            padding: 14px 18px;
            background: #fff;
            border: 1px solid var(--vg-border);
            border-radius: 16px;
            box-shadow: var(--vg-shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: var(--vg-text-muted);
            font-size: 13px;
        }

        .app-footer strong {
            color: var(--vg-text);
        }

        .mobile-menu-overlay {
            background: rgba(15, 23, 42, 0.35);
        }

        @media (max-width: 991.98px) {
            .header {
                left: 0 !important;
                width: 100% !important;
            }

            .left-side-bar {
                transform: translateX(-100%);
                opacity: 0;
            }

            .main-container {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .app-content-wrap {
                padding: 0 14px;
            }

            .app-footer {
                margin: 18px 14px 0;
                padding: 12px 14px;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <script>
        function showToast(message, type = 'success') {
            const flashDiv = document.getElementById('flash-messages');
            if (!flashDiv) return;

            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show shadow-sm`;
            toast.style.marginBottom = '10px';
            toast.style.borderRadius = '14px';
            toast.innerHTML = message + `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
            flashDiv.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 200);
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
<body>

<div id="flash-messages"></div>

<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list" data-toggle="left-sidebar-toggle" title="Toggle sidebar"></div>
        <div class="search-toggle-icon bi bi-search" title="Search"></div>
    </div>

    @php
        $adminUser = auth('admin')->user();
        $unreadCount = $adminUser ? $adminUser->unreadNotifications()->count() : 0;
        $latestNotifications = $adminUser ? $adminUser->notifications()->latest()->take(5)->get() : collect();
    @endphp

    <div class="header-right">
        <a href="javascript:;" class="dashboard-setting" data-toggle="right-sidebar" title="Layout settings">
            <i class="dw dw-settings2"></i>
        </a>

        <div class="dropdown" id="admin-notification-bell" data-count-url="{{ route('admin.notifications.count') }}">
            <a class="dropdown-toggle position-relative d-inline-flex align-items-center justify-content-center text-decoration-none header-circle-btn"
               href="#"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">
                <i class="icon-copy dw dw-notification" style="font-size: 18px;"></i>
                <span id="adminUnreadBadge"
                      class="badge bg-danger rounded-circle d-flex align-items-center justify-content-center {{ $unreadCount > 0 ? '' : 'd-none' }}"
                      style="position:absolute; top:-5px; right:-7px; min-width:18px; height:18px; font-size:10px; padding:0;">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end p-0 border-0"
                 style="width: 360px; max-width: 360px; border-radius: 18px; overflow: hidden;">
                <div class="d-flex justify-content-between align-items-center px-3 py-3"
                     style="border-bottom: 1px solid var(--vg-border); background: #fff;">
                    <div>
                        <h6 class="mb-0 fw-bold" style="color: var(--vg-text);">Notifications</h6>
                        <small style="color: var(--vg-text-muted);">
                            <span id="adminUnreadText">{{ $unreadCount }}</span> unread
                        </small>
                    </div>
                </div>

                <div style="max-height: 340px; overflow-y: auto; background: #fff;">
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
                            <button type="submit"
                                    class="dropdown-item px-3 py-3 border-0 border-bottom text-wrap w-100 text-start"
                                    style="background: {{ $isRead ? '#ffffff' : '#f8fbff' }}; border-radius: 0; border-color: var(--vg-border) !important;">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-inline-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 36px; height: 36px; border-radius: 12px; background: rgba(27,0,255,0.08); color: var(--vg-primary);">
                                        <i class="{{ $icon }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small" style="color: var(--vg-text);">{{ $title }}</div>
                                        <div class="small mt-1" style="color: var(--vg-text-muted); line-height: 1.45;">{{ $message }}</div>
                                        <div class="small mt-2" style="color: #94a3b8;">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </form>
                    @empty
                        <div class="px-3 py-4 text-center small" style="color: var(--vg-text-muted); background: #fff;">
                            No notifications yet
                        </div>
                    @endforelse
                </div>

                <div class="d-grid" style="grid-template-columns: 1fr 1fr; background: #fff;">
                    <a href="{{ route('admin.notifications.index') }}"
                       class="btn btn-light rounded-0 border-0 py-2"
                       style="border-top: 1px solid var(--vg-border); border-right: 1px solid var(--vg-border);">
                        History
                    </a>
                    <form method="POST" action="{{ route('admin.notifications.markAllRead') }}" class="m-0">
                        @csrf
                        <button type="submit"
                                class="btn btn-light rounded-0 border-0 py-2"
                                style="border-top: 1px solid var(--vg-border);">
                            Mark All Read
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="dropdown user-info-dropdown">
            <a class="dropdown-toggle d-flex align-items-center gap-2"
               href="#"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">
                <img src="{{ $adminUser && $adminUser->avatar ? asset('storage/' . $adminUser->avatar) : asset('vendors/images/photo1.jpg') }}"
                     class="rounded-circle"
                     width="34"
                     height="34"
                     alt="User Avatar"
                     style="object-fit: cover; border: 2px solid rgba(255,255,255,0.15);">

                <div class="d-none d-md-block text-start">
                    <div style="font-size: 13px; font-weight: 700; color: #fff; line-height: 1.2;">
                        {{ $adminUser ? $adminUser->name : 'Guest' }}
                    </div>
                    <div style="font-size: 11px; color: rgba(255,255,255,0.72); line-height: 1.2;">
                        Administrator
                    </div>
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end border-0" style="min-width: 230px;">
                <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.profile') }}"><i class="bi bi-person"></i><span>Profile</span></a></li>
                <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i class="bi bi-gear"></i><span>Settings</span></a></li>
                <li><hr class="dropdown-divider my-2"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                       href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Log Out</span>
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
    <div class="sidebar-title px-4 py-3" style="border-bottom: 1px solid var(--vg-border);">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <h3 class="mb-1 fw-bold" style="font-size: 16px; color: var(--vg-primary);">Layout Settings</h3>
                <div class="small" style="color: var(--vg-text-muted);">User interface preferences</div>
            </div>
            <div class="close-sidebar" data-toggle="right-sidebar-close" style="cursor: pointer;">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
    </div>

    <div class="right-sidebar-body customscroll">
        <div class="right-sidebar-body-content p-4">
            <h4 class="fw-bold mb-3" style="font-size: 15px; color: var(--vg-text);">Header</h4>
            <div class="sidebar-btn-group d-flex gap-2 pb-4 mb-2">
                <a href="javascript:void(0);" class="btn btn-outline-primary active">Dark Blue</a>
            </div>

            <h4 class="fw-bold mb-3" style="font-size: 15px; color: var(--vg-text);">Sidebar</h4>
            <div class="sidebar-btn-group d-flex gap-2 pb-4 mb-2">
                <a href="javascript:void(0);" class="btn btn-outline-primary active">Deep Blue</a>
            </div>

            <div class="pt-3 text-center">
                <button class="btn btn-danger px-4" id="reset-settings">Reset Settings</button>
            </div>
        </div>
    </div>
</div>

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('manager.dashboard') }}" class="sidebar-logo-link">
            <img src="{{ asset('vendors/images/VertexGrad_logod.png') }}" alt="VertexGrad Logo" class="sidebar-logo-img" />
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
        <a href="{{ route('manager.dashboard') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
            <span class="micon bi bi-house-door-fill"></span>
            <span class="mtext">Dashboard</span>
        </a>
    </li>

    <li>
        <a href="{{ route('manager.pending.users') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('manager.pending.users') ? 'active' : '' }}">
            <span class="micon bi bi-people-fill"></span>
            <span class="mtext">User Management</span>
        </a>
    </li>

    <li>
        <a href="{{ route('manager.index') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('manager.index') ? 'active' : '' }}">
            <span class="micon bi bi-person-workspace"></span>
            <span class="mtext">Managers</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.students.index') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
            <span class="micon bi bi-mortarboard-fill"></span>
            <span class="mtext">Students</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.investors.index') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('admin.investors.*') ? 'active' : '' }}">
            <span class="micon bi bi-wallet2"></span>
            <span class="mtext">Investors</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.investment-requests.index') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('admin.investment-requests.*') ? 'active' : '' }}">
            <span class="micon bi bi-cash-coin"></span>
            <span class="mtext">Investment Requests</span>
        </a>
    </li>
    <li>
    <a href="{{ route('admin.investor-reports.index') }}"
       class="dropdown-toggle no-arrow {{ request()->routeIs('admin.investor-reports.*') ? 'active' : '' }}">
        <span class="micon bi bi-graph-up-arrow"></span>
        <span class="mtext">Investor Reports</span>
    </a>
    <li>
    <a href="{{ route('admin.investor-calendar.index') }}"
       class="dropdown-toggle no-arrow {{ request()->routeIs('admin.investor-calendar.*') ? 'active' : '' }}">
        <span class="micon bi bi-calendar-event"></span>
        <span class="mtext">Investor Calendar</span>
    </a>
</li>
</li>

    <li>
        <a href="{{ route('admin.projects.index') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <span class="micon bi bi-briefcase-fill"></span>
            <span class="mtext">Projects</span>
        </a>
    </li>

    <li>
        <a href="{{ route('manager.calendar.index') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('manager.calendar.*') ? 'active' : '' }}">
            <span class="micon bi bi-calendar-check-fill"></span>
            <span class="mtext">Calendar</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.reports.platform') }}"
           class="dropdown-toggle no-arrow {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <span class="micon bi bi-bar-chart-line-fill"></span>
            <span class="mtext">Platform Reports</span>
        </a>
    </li>
</ul>

            <div class="sidebar-bottom">
                <div class="sidebar-bottom-title">Account</div>

                <div class="sidebar-account-card">
                    <div class="sidebar-account-top">
                        <img src="{{ $adminUser && $adminUser->avatar ? asset('storage/' . $adminUser->avatar) : asset('vendors/images/photo1.jpg') }}"
                             alt="User Avatar"
                             class="sidebar-account-avatar">
                        <div>
                            <div class="sidebar-account-name">{{ $adminUser ? $adminUser->name : 'Guest' }}</div>
                            <div class="sidebar-account-role">Administrator</div>
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

<div class="main-container">
    <div class="app-content-wrap">
        @yield('content')
    </div>

    <div class="app-footer">
        <div><strong>VertexGrad</strong> Manager Panel</div>
        <div>Professional management for students, projects, investors, and requests.</div>
    </div>
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
    const bell = document.getElementById('admin-notification-bell');
    if (!bell) return;

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
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const sidebar = document.querySelector('.left-side-bar');
    const rightSidebar = document.querySelector('.right-sidebar');

    function openLeftSidebar() {
        if (!sidebar) return;
        body.classList.remove('sidebar-closed');
        sidebar.classList.remove('closed');
    }

    function closeLeftSidebar() {
        if (!sidebar) return;
        body.classList.add('sidebar-closed');
        sidebar.classList.add('closed');
    }

    function toggleLeftSidebar() {
        if (!sidebar) return;

        if (body.classList.contains('sidebar-closed')) {
            openLeftSidebar();
        } else {
            closeLeftSidebar();
        }
    }

    document.querySelectorAll('[data-toggle="left-sidebar-toggle"]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            toggleLeftSidebar();
        });
    });

    document.querySelectorAll('[data-toggle="left-sidebar-close"]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            closeLeftSidebar();
        });
    });

    document.querySelectorAll('[data-toggle="right-sidebar"]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (!rightSidebar) return;
            rightSidebar.classList.add('open');
        });
    });

    document.querySelectorAll('[data-toggle="right-sidebar-close"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!rightSidebar) return;
            rightSidebar.classList.remove('open');
        });
    });

    if (window.innerWidth <= 991) {
        closeLeftSidebar();
    } else {
        openLeftSidebar();
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth <= 991) {
            closeLeftSidebar();
        }
    });
});
</script>

@stack('scripts')
</body>
</html>