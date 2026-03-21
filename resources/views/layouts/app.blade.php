<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title', 'VertexGrad - Dashboard')</title>

    <link rel="apple-touch-icon" href="{{ asset('vendors/images/apple-touch-icon.png') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body.page-transition {
            opacity: 1;
            transition: opacity 0.2s ease-out;
        }

        body.page-transition.fade-out {
            opacity: 0;
        }

        .main-container,
        .left-side-bar,
        .right-sidebar,
        .header,
        .footer {
            transition: transform 0.2s ease-out, opacity 0.2s ease-out;
            will-change: transform, opacity;
        }

        .main-container {
            opacity: 0;
            transform: translateY(8px);
        }

        .main-container.loaded {
            opacity: 1;
            transform: translateY(0);
        }

        #accordion-menu li a {
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.15s, padding 0.15s;
        }

        #accordion-menu li a:hover {
            padding-right: 5px;
        }

        #accordion-menu li a .micon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        #flash-messages {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 250px;
        }
    </style>

    <script>
        function showToast(message, type = 'success') {
            const flashDiv = document.getElementById('flash-messages');
            if (!flashDiv) return;

            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show`;
            toast.style.marginBottom = '10px';
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
<body class="page-transition">

<div id="flash-messages"></div>

<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>

@php
    $adminUser = auth('admin')->user();
    $unreadCount = $adminUser ? $adminUser->unreadNotifications()->count() : 0;
    $latestNotifications = $adminUser
        ? $adminUser->notifications()->latest()->take(5)->get()
        : collect();
@endphp

<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list" data-toggle="left-sidebar-toggle"></div>
        <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
    </div>

    <div class="header-right d-flex align-items-center gap-2">
        <a href="javascript:;" class="dashboard-setting" data-toggle="right-sidebar">
            <i class="dw dw-settings2"></i>
        </a>

        <div class="dropdown"
             id="admin-notification-bell"
             data-count-url="{{ route('admin.notifications.count') }}">
            <a class="dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon-copy dw dw-notification"></i>

                <span id="adminUnreadBadge"
                      class="badge bg-danger rounded-circle notification-active d-flex align-items-center justify-content-center {{ $unreadCount > 0 ? '' : 'd-none' }}"
                      style="position:absolute; top:-6px; right:-10px; min-width:18px; height:18px; font-size:10px;">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end p-0" style="width: 340px; max-width: 340px;">
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                    <h6 class="mb-0 fw-bold">Notifications</h6>
                    <small class="text-muted">
                        <span id="adminUnreadText">{{ $unreadCount }}</span> unread
                    </small>
                </div>

                <div style="max-height: 320px; overflow-y: auto;">
                    @forelse($latestNotifications as $notification)
                        @php
                            $title = $notification->data['title'] ?? 'Notification';
                            $message = $notification->data['message'] ?? '';
                            $url = $notification->data['url'] ?? route('admin.notifications.index');
                            $icon = $notification->data['icon'] ?? 'fas fa-bell';
                            $isRead = !is_null($notification->read_at);
                        @endphp

                        <form method="POST"
                              action="{{ route('admin.notifications.read', $notification->id) }}"
                              class="m-0">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ $url }}">

                            <button type="submit"
                                    class="dropdown-item px-3 py-3 border-bottom text-wrap w-100 text-start {{ $isRead ? 'opacity-75' : 'bg-light' }}">
                                <div class="d-flex align-items-start gap-2">
                                    <div class="text-primary pt-1">
                                        <i class="{{ $icon }}"></i>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small text-dark">{{ $title }}</div>
                                        <div class="small text-muted">{{ $message }}</div>
                                        <div class="small text-secondary mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
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

                <div class="d-grid" style="grid-template-columns: 1fr 1fr;">
                    <a href="{{ route('admin.notifications.index') }}"
                       class="btn btn-light rounded-0 border-0 border-top border-end py-2">
                        History
                    </a>

                    <form method="POST" action="{{ route('admin.notifications.markAllRead') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-light rounded-0 border-0 border-top py-2">
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
                     width="32"
                     height="32"
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

@push('scripts')
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
});
</script>
@endpush

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

            <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
            <div class="sidebar-radio-group pb-10 mb-10">
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="form-check-input" value="icon-style-1" checked />
                    <label class="form-check-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="form-check-input" value="icon-style-2" />
                    <label class="form-check-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="form-check-input" value="icon-style-3" />
                    <label class="form-check-label" for="sidebaricon-3"><i class="fa fa-angle-double-right"></i></label>
                </div>
            </div>

            <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
            <div class="sidebar-radio-group pb-30 mb-10">
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="form-check-input" value="icon-list-style-1" checked />
                    <label class="form-check-label" for="sidebariconlist-1"><i class="ion-minus-round"></i></label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="form-check-input" value="icon-list-style-2" />
                    <label class="form-check-label" for="sidebariconlist-2"><i class="fa fa-circle-o" aria-hidden="true"></i></label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="form-check-input" value="icon-list-style-3" />
                    <label class="form-check-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="form-check-input" value="icon-list-style-4" checked />
                    <label class="form-check-label" for="sidebariconlist-4"><i class="icon-copy dw dw-next-2"></i></label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="form-check-input" value="icon-list-style-5" />
                    <label class="form-check-label" for="sidebariconlist-5"><i class="dw dw-fast-forward-1"></i></label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="form-check-input" value="icon-list-style-6" />
                    <label class="form-check-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
                </div>
            </div>

            <div class="reset-options pt-30 text-center">
                <button class="btn btn-danger" id="reset-settings">Reset Settings</button>
            </div>
        </div>
    </div>
</div>

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('manager.dashboard') }}">
            <img src="{{ asset('vendors/images/VertexGrad_logod.png') }}" alt="Logo" class="dark-logo" style="margin-top:30px;" />
            <img src="{{ asset('vendors/images/VertexGrad_logod.png') }}" alt="Logo" class="light-logo" style="margin-top:30px;" />
        </a>

        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>

    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('manager.dashboard') }}" class="dropdown-toggle no-arrow" style="margin-top:30px;">
                        <span class="micon bi bi-house-door-fill"></span>
                        <span class="mtext">Home</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('manager.pending.users') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person-badge-fill"></span>
                        <span class="mtext">User Management</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('manager.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person-badge-fill"></span>
                        <span class="mtext">Manager</span>
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
                        <span class="micon bi bi-file-earmark-bar-graph-fill"></span>
                        <span class="mtext">Platform Reports</span>
                    </a>
                </li>
                <li>
    <a href="{{ route('admin.projects.final-decisions.index') }}" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-check2-square"></span>
        <span class="mtext">Final Decisions</span>
    </a>
</li>
            </ul>
        </div>
    </div>
</div>

<div class="mobile-menu-overlay"></div>

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
    (function () {
        function onReady(fn) {
            if (document.readyState !== 'loading') {
                fn();
            } else {
                document.addEventListener('DOMContentLoaded', fn);
            }
        }

        onReady(function () {
            const sidebar = document.querySelector('.left-side-bar');
            const main = document.querySelector('.main-container');

            if (main) {
                requestAnimationFrame(function () {
                    main.classList.add('loaded');
                });
            }

            if (sidebar) {
                sidebar.style.transition = 'transform 0.25s ease, opacity 0.25s ease';
                sidebar.classList.remove('closed');
                sidebar.style.transform = 'translateX(0)';
                sidebar.style.opacity = '1';
            }

            const leftClose = document.querySelectorAll('[data-toggle="left-sidebar-close"]');
            leftClose.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const left = document.querySelector('.left-side-bar');
                    if (!left) return;

                    left.classList.toggle('closed');
                    if (left.classList.contains('closed')) {
                        left.style.transform = 'translateX(-260px)';
                        left.style.opacity = '0';
                    } else {
                        left.style.transform = 'translateX(0)';
                        left.style.opacity = '1';
                    }
                });
            });

            const leftToggle = document.querySelectorAll('[data-toggle="left-sidebar-toggle"], .close-sidebar');
            leftToggle.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const left = document.querySelector('.left-side-bar');
                    if (!left) return;

                    left.classList.toggle('closed');
                    if (left.classList.contains('closed')) {
                        left.style.transform = 'translateX(-260px)';
                        left.style.opacity = '0';
                    } else {
                        left.style.transform = 'translateX(0)';
                        left.style.opacity = '1';
                    }
                });
            });

            const rightClose = document.querySelectorAll('[data-toggle="right-sidebar-close"]');
            rightClose.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const right = document.querySelector('.right-sidebar');
                    if (!right) return;

                    right.classList.toggle('closed');
                    if (right.classList.contains('closed')) {
                        right.style.transform = 'translateX(260px)';
                        right.style.opacity = '0';
                    } else {
                        right.style.transform = '';
                        right.style.opacity = '';
                    }
                });
            });

            window.addEventListener('pageshow', function () {
                const left = document.querySelector('.left-side-bar');
                if (!left) return;

                left.classList.remove('closed');
                left.style.transform = 'translateX(0)';
                left.style.opacity = '1';
            });

            document.addEventListener('keydown', function (ev) {
                if (ev.key === 'Escape') {
                    const modal = document.querySelector('.welcome-modal');
                    if (modal && modal.style.display !== 'none') {
                        const btn = document.querySelector('.welcome-modal-close');
                        if (btn) btn.click();
                    }
                }
            });
        });
    })();
</script>

@stack('scripts')

</body>
</html>