<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Flash Messages -->
<div id="flash-messages" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('success') }}', 'success');
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('error') }}', 'danger');
    });
</script>
@endif

@push('scripts')
<script>
function showToast(message, type='success'){
    let flashDiv = document.getElementById('flash-messages');

    let toast = document.createElement('div');
    toast.className = 'alert alert-' + type + ' alert-dismissible fade show';
    toast.style.minWidth = '250px';
    toast.style.marginBottom = '10px';
    toast.innerHTML = message + `<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>`;

    flashDiv.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('show');
        toast.remove();
    }, 4000); // يختفي بعد 4 ثواني
}
</script>
@endpush

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>VertexGrad - Dashboard</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ asset('vendors/images/apple-touch-icon.png') }}?v=2.0" />
                                                                                                                                                                                                                                                        ``````````````````````````````````````````qw 

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Core CSS (keep original order/design) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}" />

    <!-- Bootstrap CSS (kept) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Small custom performance + transitions (does NOT change layout) -->
    <style>
        /* Lightweight, fast transitions — very short durations for snappy feel */
        .main-container,
        .left-side-bar,
        .right-sidebar,
        .header,
        .footer {
            transition: transform 0.20s ease-out, opacity 0.20s ease-out !important;
            will-change: transform, opacity;
        }

        /* Fade-in the main container on load */
        .main-container {
            opacity: 0;
            transform: translateY(8px);
        }
        .main-container.loaded {
            opacity: 1;
            transform: translateY(0);
        }

        /* Sidebar open/close smoother */
        .left-side-bar, .right-sidebar {
            transition: transform 0.18s ease-out, opacity 0.18s ease-out !important;
        }

        /* Sidebar links hover small shift */
        .sidebar-menu li a {
            transition: background-color 0.15s ease, padding-left 0.14s ease !important;
        }
        .sidebar-menu li a:hover {
            padding-right: 5px !important;
        }

        /* Modal animation tweak (keeps bootstrap modal look) */
        .modal.fade .modal-dialog {
            transform: translateY(-6px);
            transition: transform 0.11s ease-out;
        }
        .modal.show .modal-dialog {
            transform: translateY(0);
        }

        /* Page transition fade for links (very quick) */
        body.page-transition {
            opacity: 1;
            transition: opacity 0.20s ease-out;
        }
        body.page-transition.fade-out {
            opacity: 0;
        }

        /* Keep images responsive but lazy */
        img[loading="lazy"] {
            -webkit-user-drag: none;
            user-select: none;
        }

        /* Right-sidebar small visual polish */
        .right-sidebar .sidebar-btn-group .btn {
            transition: transform 0.12s ease, box-shadow 0.12s ease;
        }
        .right-sidebar .sidebar-btn-group .btn:active {
            transform: translateY(1px);
        }
/* رابط القائمة flex أفقي */
/* رابط القائمة flex أفقي */
#accordion-menu li a {
    display: flex;        
    align-items: center;  
    gap: 10px;            
}

/* تأكد من أن الأيقونة لا تتحول لعرض كامل */
#accordion-menu li a .micon {
    display: inline-flex; 
    align-items: center;
    justify-content: center;
    font-size: 18px;  
	    
 
}




		
    </style>

    <!-- Google Analytics & Ads (async, unchanged) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258" crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-GBZ3SGGX85');
    </script>

    <!-- Google Tag Manager -->
    <script>
    (function(w,d,s,l,i){
        w[l]=w[l]||[];
        w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
        var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),
            dl=l!='dataLayer'?'&l='+l:'';
        j.async=true;
        j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
        f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NXZMQSS');
    </script>
    <!-- End head -->
</head>
<body class="page-transition">

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>

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
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="dw dw-user1"></i> Profile</a>
                    <a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Setting</a>
                    <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="dw dw-logout"></i> Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            <img src="vendors/images/VertexGrad_logod.png" alt="" class="dark-logo" style="margin-top:30px;" />
            <img src="vendors/images/VertexGrad_logod.png" alt="" class="light-logo" style="margin-top:30px;" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>

    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow" style="margin-top:30px;">
                        <span class="micon bi bi-house "></span>
                        <span class="mtext">Home</span >
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.pending.users') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-people"></span>
                        <span class="mtext">User managment</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('students.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-people"></span>
                        <span class="mtext">student</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('investors.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-people"></span>
                        <span class="mtext">Investors</span>
                    </a>
                </li>
                <li>
    <a href="{{ route('projects.index') }}" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-briefcase"></span> <!-- أيقونة المشاريع -->
        <span class="mtext">Projects</span>
    </a>
</li>

              <li>
    <a href="{{ route('manager.calendar.index') }}" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-calendar"></span>
        <span class="mtext">Calendar</span>
    </a>
</li>

                <li>
    <a href="{{ route('reports.platform') }}" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-file-earmark-text"></span>
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
