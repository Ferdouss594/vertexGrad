<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>VertexGrad - Dashboard</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ asset('vendors/images/apple-touch-icon.png') }}" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom lightweight transitions -->
    <style>
        body.page-transition { opacity: 1; transition: opacity 0.2s ease-out; }
        body.page-transition.fade-out { opacity: 0; }

        .main-container,
        .left-side-bar,
        .right-sidebar,
        .header,
        .footer { transition: transform 0.2s ease-out, opacity 0.2s ease-out; will-change: transform, opacity; }
        .main-container { opacity: 0; transform: translateY(8px); }
        .main-container.loaded { opacity: 1; transform: translateY(0); }

        /* Sidebar links */
        #accordion-menu li a { display: flex; align-items: center; gap: 10px; transition: background-color 0.15s, padding 0.15s; }
        #accordion-menu li a:hover { padding-right: 5px; }

        #accordion-menu li a .micon { display: inline-flex; align-items: center; justify-content: center; font-size: 18px; }

        /* Flash messages */
        #flash-messages { position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 250px; }
    </style>

    <!-- Flash Messages Script -->
    <script>
        function showToast(message, type='success'){
            const flashDiv = document.getElementById('flash-messages');
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show`;
            toast.style.marginBottom = '10px';
            toast.innerHTML = message + `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
            flashDiv.appendChild(toast);
            setTimeout(() => { toast.classList.remove('show'); toast.remove(); }, 4000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif
            @if(session('error'))
                showToast('{{ session('error') }}', 'danger');
            @endif
        });
    </script>
</head>
<body class="page-transition">
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.left-side-bar');
    if (!sidebar) return;

    // تأكد من وجود transition سلس
    sidebar.style.transition = 'transform 0.25s ease, opacity 0.25s ease';
    sidebar.classList.remove('closed');
    sidebar.style.transform = 'translateX(0)';
    sidebar.style.opacity = '1';

    // اختيار كل أزرار الـ toggle أو close
    const toggleBtns = document.querySelectorAll('[data-toggle="left-sidebar-toggle"], .close-sidebar');

    toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (sidebar.classList.contains('closed')) {
                sidebar.classList.remove('closed');
                sidebar.style.transform = 'translateX(0)';
                sidebar.style.opacity = '1';
            } else {
                sidebar.classList.add('closed');
                sidebar.style.transform = 'translateX(-260px)';
                sidebar.style.opacity = '0';
            }
        });
    });

    // إجبار sidebar على أن يظل مفتوح عند العودة للصفحة
    window.addEventListener('pageshow', () => {
        sidebar.classList.remove('closed');
        sidebar.style.transform = 'translateX(0)';
        sidebar.style.opacity = '1';
    });
});
</script>
@endpush

<!-- Flash Messages -->
<div id="flash-messages"></div>

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>

<!-- ===================== HEADER ===================== -->
<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list" data-toggle="left-sidebar-toggle"></div>
        <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
    </div>

    <div class="header-right d-flex align-items-center gap-2">
        <!-- Settings -->
        <a href="javascript:;" class="dashboard-setting" data-toggle="right-sidebar"><i class="dw dw-settings2"></i></a>

        <!-- Notifications -->
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="icon-copy dw dw-notification"></i>
                <span class="badge bg-danger rounded-circle notification-active"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-header">Notifications</li>
                <li><a href="#"><i class="bi bi-envelope"></i> New message from John</a></li>
                <li><a href="#"><i class="bi bi-check-circle"></i> Task completed</a></li>
            </ul>
        </div>

        <!-- Profile -->
        <div class="dropdown user-info-dropdown">
            <a class="dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('vendors/images/photo1.jpg') }}" class="rounded-circle" width="32" height="32" alt="User Avatar">
                <span>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="bi bi-person"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Log Out
                </a></li>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
            </ul>
        </div>
    </div>
</div>
<!-- ===================== END HEADER ===================== -->


<!-- ===================== HEADER (original markup preserved) ===================== -->
<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list" data-toggle="left-sidebar-toggle"></div>
        <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
        <div class="header-search">
            <form>
                <div class="form-group mb-0">
                    <i class="dw dw-search2 search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="Search Here" />
                    <div class="dropdown">
                        <a class="dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="ion-arrow-down-c"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">From</label>
                                <div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">To</label>
                                <div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Subject</label>
                                <div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" />
                                </div>
                            </div>
                            <div class="text-end me-2">
                                <button class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="header-right">
        <div class="dashboard-setting user-notification">
            <div class="dropdown">
                <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                    <i class="dw dw-settings2"></i>
                </a>
            </div>
        </div>

        <div class="user-notification">
            <div class="dropdown">
                <a class="dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="icon-copy dw dw-notification"></i>
                    <span class="badge notification-active"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="notification-list mx-h-350 customscroll">
                        <ul>
                            <li>
                                <a href="#">
                                    <img loading="lazy" src="vendors/images/img.jpg" alt="" />
                                    <h3>John Doe</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img loading="lazy" src="vendors/images/photo1.jpg" alt="" />
                                    <h3>Lea R. Frith</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img loading="lazy" src="vendors/images/photo2.jpg" alt="" />
                                    <h3>Erik L. Richards</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img loading="lazy" src="vendors/images/photo3.jpg" alt="" />
                                    <h3>John Doe</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img loading="lazy" src="vendors/images/photo4.jpg" alt="" />
                                    <h3>Renee I. Hansen</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img loading="lazy" src="vendors/images/img.jpg" alt="" />
                                    <h3>Vicki M. Coleman</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <span class="user-icon">
                      @if(Auth::check())
    <img loading="lazy" src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('vendors/images/photo1.jpg') }}" alt="" />
    <span class="user-name">{{ Auth::user()->name }}</span>
@else
    <img loading="lazy" src="{{ asset('vendors/images/photo1.jpg') }}" alt="" />
    <span class="user-name">Guest</span>
@endif

                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-icon-list">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="dw dw-user1"></i> Profile</a>
                    <a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Setting</a>
                    <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="dw dw-logout"></i> Log Out
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===================== END HEADER ===================== -->

<!-- ===================== RIGHT SIDEBAR (original content) ===================== -->
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
<!-- ===================== END RIGHT SIDEBAR ===================== -->

<!-- ===================== LEFT SIDEBAR (original left navigation) ===================== -->
<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('dashboard') }}">
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

                <!-- Home -->
                <li>
                    <a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow" style="margin-top:30px;">
                        <span class="micon bi bi-house-door-fill"></span>
                        <span class="mtext">Home</span>
                    </a>
                </li>

                <!-- User Management -->
                <li>
                    <a href="{{ route('manager.pending.users') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person-badge-fill"></span>
                        <span class="mtext">User Management</span>
                    </a>
                </li>
<li>
                    <a href="{{ route('manager.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person-badge-fill"></span>
                        <span class="mtext"> manager</span>
                    </a>
                </li>
                <!-- Students -->
                <li>
                    <a href="{{ route('admin.students.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-mortarboard-fill"></span>
                        <span class="mtext">Students</span>
                    </a>
                </li>

                <!-- Investors -->
                <li>
                    <a href="{{ route('admin.investors.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-wallet2"></span>
                        <span class="mtext">Investors</span>
                    </a>
                </li>

                <!-- Projects -->
                <li>
                    <a href="{{ route('admin.projects.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-briefcase-fill"></span>
                        <span class="mtext">Projects</span>
                    </a>
                </li>

                <!-- Calendar -->
                <li>
                    <a href="{{ route('manager.calendar.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-calendar-check-fill"></span>
                        <span class="mtext">Calendar</span>
                    </a>
                </li>

                <!-- Platform Reports -->
                <li>
                    <a href="{{ route('admin.reports.platform') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-file-earmark-bar-graph-fill"></span>
                        <span class="mtext">Platform Reports</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

<!-- ===================== END LEFT SIDEBAR ===================== -->

<div class="mobile-menu-overlay"></div>

<!-- ===================== MAIN CONTAINER ===================== -->
<div class="main-container">
    @yield('content')
</div>
<!-- ===================== END MAIN CONTAINER ===================== -->

<!-- ===================== WELCOME MODAL (lazy iframe) ===================== -->

<!-- ===================== END WELCOME MODAL ===================== -->

<!-- ===================== SCRIPTS (keep core scripts loaded early so UI toggles work) ===================== -->

<!-- Core (no defer) - these scripts initialize UI behaviors like sidebar toggles, close buttons, layout settings -->
<script src="{{ asset('vendors/scripts/core.js') }}"></script>
<script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
<script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>

<!-- Other scripts can be deferred to avoid blocking initial render -->
<script src="{{ asset('vendors/scripts/process.js') }}" defer></script>
<script src="{{ asset('src/plugins/apexcharts/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}" defer></script>
<script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}" defer></script>
<script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('vendors/scripts/dashboard3.js') }}" defer></script>
<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/jQuery-Knob-master/jquery.knob.min.js"></script>
		<script src="vendors/scripts/knob-chart-setting.js"></script>
		<!-- Google Tag Manager (noscript) -->
		
		<!-- End Google Tag Manager (noscript) -->

<!-- Bootstrap JS (deferred) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<!-- ===================== CUSTOM JS: keep UI intact & add fast transitions ===================== -->
<script>
    
    // Ensure DOM interactions for toggles and close buttons run after core scripts loaded
    (function () {
        // Run when DOMContentLoaded
        function onReady(fn) {
            if (document.readyState !== 'loading') {
                fn();
            } else {
                document.addEventListener('DOMContentLoaded', fn);
            }
        }

        onReady(function () {
            // 1) Fade-in main container (fast)
            var main = document.querySelector('.main-container');
            if (main) {
                // slight delay to allow core styles/scripts to normalize
                requestAnimationFrame(function () {
                    main.classList.add('loaded');
                });
            }

            // 2) Welcome modal close button
            var welcomeClose = document.querySelector('.welcome-modal-close');
            if (welcomeClose) {
                welcomeClose.addEventListener('click', function (e) {
                    var modal = document.querySelector('.welcome-modal');
                    if (modal) {
                        // fast fade-out
                        modal.style.transition = 'opacity 0.18s ease-out, transform 0.18s ease-out';
                        modal.style.opacity = '0';
                        modal.style.transform = 'translateY(-6px)';
                        setTimeout(function () { modal.style.display = 'none'; }, 180);
                    }
                });
            }

            // 3) Ensure sidebar close X works (binding to original data-toggle attributes)
            var leftClose = document.querySelectorAll('[data-toggle="left-sidebar-close"]');
            leftClose.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var left = document.querySelector('.left-side-bar');
                    if (left) {
                        left.classList.toggle('closed');
                        // keep transform smooth
                        if (left.classList.contains('closed')) {
                            left.style.transform = 'translateX(-260px)';
                            left.style.opacity = '0';
                        } else {
                            left.style.transform = '';
                            left.style.opacity = '';
                        }
                    }
                });
            });

            var rightClose = document.querySelectorAll('[data-toggle="right-sidebar-close"]');
            rightClose.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var right = document.querySelector('.right-sidebar');
                    if (right) {
                        right.classList.toggle('closed');
                        if (right.classList.contains('closed')) {
                            right.style.transform = 'translateX(260px)';
                            right.style.opacity = '0';
                        } else {
                            right.style.transform = '';
                            right.style.opacity = '';
                        }
                    }
                });
            });

            // 4) If your template toggles sidebars with other controls, keep bindings
            var leftToggle = document.querySelectorAll('[data-toggle="left-sidebar-toggle"]');
            leftToggle.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var left = document.querySelector('.left-side-bar');
                    if (left) {
                        left.classList.toggle('closed');
                        if (left.classList.contains('closed')) {
                            left.style.transform = 'translateX(-260px)';
                            left.style.opacity = '0';
                        } else {
                            left.style.transform = '';
                            left.style.opacity = '';
                        }
                    }
                });
            });

            // 5) Quick binding for links to add a tiny fade-out (snappy)
            // We exclude external links, anchors, and JS pseudo links
            var anchors = document.querySelectorAll('a[href]');
            anchors.forEach(function(a) {
                var href = a.getAttribute('href');
                if (!href) return;
                if (href.startsWith('#')) return;
                if (href.startsWith('javascript:')) return;
                if (href.startsWith('mailto:')) return;
                if (a.target && a.target !== '_self') return; // open in new tab -> skip

                
            });

            // 6) Improve DataTables performance hint (if using many rows)
            // If DataTables exist, prefer serverSide or delay rendering — just an example, doesn't change config
            if (window.jQuery && $.fn.dataTable) {
                // leave table initialization to dashboard3.js or existing scripts
                // but you can add pageLength small or defer render on heavy tables if desired
            }

            // 7) Accessibility: allow keyboard close for welcome modal
            document.addEventListener('keydown', function (ev) {
                if (ev.key === 'Escape') {
                    var modal = document.querySelector('.welcome-modal');
                    if (modal && modal.style.display !== 'none') {
                        var btn = document.querySelector('.welcome-modal-close');
                        if (btn) btn.click();
                    }
                }
            });
        });
    })();
</script>

</body>
</html>
