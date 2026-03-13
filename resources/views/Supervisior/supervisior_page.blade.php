{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>VertexGrad - Admin Dashboard</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendors/images/apple-touch-icon.png') }}" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}" />

    <style>
        /* تحسينات إضافية */
        .stats-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
        
        .stats-card .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.2);
        }
        
        .stats-card .icon-wrapper i {
            font-size: 28px;
            color: white;
        }
        
        .stats-card .card-title {
            font-size: 14px;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .stats-card .card-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            line-height: 1.2;
        }
        
        .stats-card .card-footer-text {
            font-size: 12px;
            opacity: 0.8;
        }
        
        /* تدرجات ألوان جميلة */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .bg-gradient-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .bg-gradient-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        
        .bg-gradient-info {
            background: linear-gradient(135deg, #3c8ce7 0%, #00eaff 100%);
        }
        
        .bg-gradient-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .bg-gradient-dark {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        }
        
        /* تحسين الجدول */
        .table-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .table thead th {
            background: #f8f9fa;
            color: #1b2c3f;
            font-weight: 600;
            font-size: 13px;
            border-bottom: 2px solid #e9ecef;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr:hover {
            background: #f8f9ff;
        }
        
        .badge-status {
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .badge-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .badge-pending {
            background: #fff3e0;
            color: #f57c00;
        }
        
        .badge-active {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        /* تحسين العنوان */
        .page-header {
            margin-bottom: 25px;
        }
        
        .page-header h4 {
            font-weight: 700;
            color: #1b2c3f;
            margin-bottom: 5px;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
        }
        
        .breadcrumb-item a {
            color: #00b0f0;
        }
        
        /* تحسين الـ loader */
        .pre-loader {
            background: #1b2c3f;
        }
        
        .loader-logo img {
            max-width: 100px;
        }
        
        .loader-progress .bar {
            background: #00b0f0;
        }
        
        /* تحسين الـ header */
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .user-name {
            font-weight: 600;
            color: #1b2c3f;
        }
        
        /* تحسين الـ sidebar */
        .left-side-bar {
            background: #1b2c3f;
        }
        
        .brand-logo {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu li a {
            color: rgba(255,255,255,0.8);
            transition: all 0.3s;
        }
        
        .sidebar-menu li a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 30px;
        }
        
        .sidebar-menu li a.active {
            background: #00b0f0;
            color: white;
        }
        
        .sidebar-menu li a i {
            font-size: 18px;
        }
        
        /* تحسين البطاقات الصغيرة */
        .mini-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            transition: all 0.3s;
        }
        
        .mini-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .mini-card .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .mini-card .icon-circle i {
            font-size: 24px;
        }
        
        .mini-card .value {
            font-size: 24px;
            font-weight: 700;
            color: #1b2c3f;
            margin-bottom: 5px;
        }
        
        .mini-card .label {
            font-size: 13px;
            color: #6c757d;
        }
        
        /* تحسين الرسم البياني */
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .chart-title {
            font-size: 16px;
            font-weight: 600;
            color: #1b2c3f;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Pre-loader -->
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="{{ asset('vendors/images/VertexGrad_logod.png') }}" alt="VertexGrad" style="width: 120px;" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading Dashboard...</div>
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="menu-icon dw dw-menu"></div>
            <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
            <div class="header-search">
                <form>
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Search here..." />
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
                    <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                        <i class="icon-copy dw dw-notification"></i>
                        <span class="badge notification-active"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="notification-list mx-h-350 customscroll">
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('vendors/images/photo1.jpg') }}" alt="" />
                                        <h3>New Project Added</h3>
                                        <p>AI Research project submitted by John</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('vendors/images/photo2.jpg') }}" alt="" />
                                        <h3>Investment Request</h3>
                                        <p>New investment request for FinTech project</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="{{ asset('vendors/images/photo1.jpg') }}" alt="" />
                        </span>
                        <span class="user-name">Admin</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="#"><i class="dw dw-user1"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="dw dw-settings2"></i> Settings</a>
                        <a class="dropdown-item" href="#"><i class="dw dw-help"></i> Help</a>
                        <a class="dropdown-item" href="#"><i class="dw dw-logout"></i> Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="{{ url('/dashboard') }}">
                <img src="{{ asset('vendors/images/VertexGrad_logod.png') }}" alt="VertexGrad" style="width: 150px;" />
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li class="dropdown">
                        <a href="{{ url('/dashboard') }}" class="dropdown-toggle no-arrow active">
                            <span class="micon bi bi-speedometer2"></span>
                            <span class="mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('admin.students.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-mortarboard"></span>
                            <span class="mtext">Students</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">
                            <span class="micon bi bi-wallet2"></span>
                            <span class="mtext">Investors</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">All Investors</a></li>
                            <li><a href="#">Investment Requests</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">
                            <span class="micon bi bi-briefcase"></span>
                            <span class="mtext">Projects</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">All Projects</a></li>
                            <li><a href="#">Pending Review</a></li>
                            <li><a href="#">Approved</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-calendar-check"></span>
                            <span class="mtext">Calendar</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-file-bar-graph"></span>
                            <span class="mtext">Reports</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                Quick Settings
                <span class="btn-block font-12">Customize your view</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-14 pb-10">Theme Colors</h4>
                <div class="sidebar-btn-group pb-20">
                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm">Light</a>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm">Dark</a>
                </div>
                
                <h4 class="weight-600 font-14 pb-10 mt-10">Sidebar</h4>
                <div class="sidebar-btn-group pb-20">
                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm">Mini</a>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm">Full</a>
                </div>
                
                <div class="reset-options pt-20 text-center">
                    <button class="btn btn-danger btn-sm" id="reset-settings">Reset Settings</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4><i class="bi bi-grid-1x2-fill me-2" style="color: #00b0f0;"></i> Dashboard Overview</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="bi bi-calendar-week me-1"></i> Last 30 Days
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Today</a>
                                    <a class="dropdown-item" href="#">Yesterday</a>
                                    <a class="dropdown-item" href="#">Last 7 Days</a>
                                    <a class="dropdown-item" href="#">Last 30 Days</a>
                                    <a class="dropdown-item" href="#">This Month</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-20">
                        <div class="stats-card bg-gradient-primary text-white">
                            <div class="card-body pd-20">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="card-title">Total Users</p>
                                        <h2 class="card-value">1,248</h2>
                                        <p class="card-footer-text"><i class="bi bi-arrow-up me-1"></i> 12% increase</p>
                                    </div>
                                    <div class="icon-wrapper">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-20">
                        <div class="stats-card bg-gradient-success text-white">
                            <div class="card-body pd-20">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="card-title">Active Projects</p>
                                        <h2 class="card-value">342</h2>
                                        <p class="card-footer-text"><i class="bi bi-arrow-up me-1"></i> 8% increase</p>
                                    </div>
                                    <div class="icon-wrapper">
                                        <i class="bi bi-folder-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-20">
                        <div class="stats-card bg-gradient-warning text-white">
                            <div class="card-body pd-20">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="card-title">Total Investors</p>
                                        <h2 class="card-value">89</h2>
                                        <p class="card-footer-text"><i class="bi bi-arrow-up me-1"></i> 5 new this month</p>
                                    </div>
                                    <div class="icon-wrapper">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-20">
                        <div class="stats-card bg-gradient-info text-white">
                            <div class="card-body pd-20">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="card-title">Investment Amount</p>
                                        <h2 class="card-value">$2.4M</h2>
                                        <p class="card-footer-text"><i class="bi bi-arrow-up me-1"></i> 23% increase</p>
                                    </div>
                                    <div class="icon-wrapper">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mini Stats Cards -->
                <div class="row mb-20">
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-20">
                        <div class="mini-card">
                            <div class="icon-circle" style="background: #e8f4ff;">
                                <i class="bi bi-mortarboard" style="color: #00b0f0;"></i>
                            </div>
                            <div class="value">1,024</div>
                            <div class="label">Students</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-20">
                        <div class="mini-card">
                            <div class="icon-circle" style="background: #e8f5e9;">
                                <i class="bi bi-award" style="color: #2e7d32;"></i>
                            </div>
                            <div class="value">342</div>
                            <div class="label">Top Performers</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-20">
                        <div class="mini-card">
                            <div class="icon-circle" style="background: #fff4e8;">
                                <i class="bi bi-building" style="color: #ff9800;"></i>
                            </div>
                            <div class="value">24</div>
                            <div class="label">Universities</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-20">
                        <div class="mini-card">
                            <div class="icon-circle" style="background: #ffebee;">
                                <i class="bi bi-clock-history" style="color: #dc3545;"></i>
                            </div>
                            <div class="value">23</div>
                            <div class="label">Pending Approval</div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-30">
                    <div class="col-lg-8">
                        <div class="chart-container">
                            <div class="chart-title">
                                <i class="bi bi-graph-up me-2" style="color: #00b0f0;"></i>
                                Project Trends
                            </div>
                            <div id="chart1" style="height: 300px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="chart-container">
                            <div class="chart-title">
                                <i class="bi bi-pie-chart me-2" style="color: #00b0f0;"></i>
                                Status Distribution
                            </div>
                            <div id="chart2" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Projects Table -->
                <div class="table-card">
                    <div class="pd-20 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="font-weight: 600; color: #1b2c3f;">
                            <i class="bi bi-clock-history me-2" style="color: #00b0f0;"></i>
                            Recent Projects
                        </h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    <div class="pb-20">
                        <table class="table table-hover nowrap">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Student</th>
                                    <th>University</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>AI-Powered Healthcare System</td>
                                    <td>John Doe</td>
                                    <td>Harvard University</td>
                                    <td><span class="badge-status badge-active">Active</span></td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-success" style="width: 75%;"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light" style="border-radius: 6px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Blockchain for Supply Chain</td>
                                    <td>Sarah Johnson</td>
                                    <td>Stanford University</td>
                                    <td><span class="badge-status badge-completed">Completed</span></td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-success" style="width: 100%;"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light" style="border-radius: 6px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>FinTech Mobile Application</td>
                                    <td>Michael Chen</td>
                                    <td>MIT</td>
                                    <td><span class="badge-status badge-pending">Pending</span></td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-warning" style="width: 30%;"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light" style="border-radius: 6px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Renewable Energy Research</td>
                                    <td>Emily Brown</td>
                                    <td>Oxford University</td>
                                    <td><span class="badge-status badge-active">Active</span></td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-success" style="width: 60%;"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light" style="border-radius: 6px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="footer-wrap mt-30">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted" style="font-size: 13px;">
                            © 2024 VertexGrad. All rights reserved.
                        </div>
                        <div>
                            <span class="text-muted me-3" style="font-size: 13px;">v1.0.0</span>
                            <span class="badge bg-light text-dark">Dashboard</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        // Charts initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Line Chart
            var options1 = {
                series: [{
                    name: 'Projects',
                    data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                colors: ['#00b0f0'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                },
                grid: { borderColor: '#f1f1f1' }
            };

            var chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
            chart1.render();

            // Pie Chart
            var options2 = {
                series: [44, 55, 41, 17],
                chart: { height: 300, type: 'donut' },
                labels: ['Active', 'Pending', 'Completed', 'On Hold'],
                colors: ['#00b0f0', '#ff9800', '#4caf50', '#f44336'],
                legend: { position: 'bottom' },
                responsive: [{
                    breakpoint: 480,
                    options: { chart: { width: 200 } }
                }]
            };

            var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
            chart2.render();
        });

        // Preloader
        setTimeout(function() {
            var bar1 = document.getElementById('bar1');
            var percent1 = document.getElementById('percent1');
            
            var width = 0;
            var interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);
                    document.querySelector('.pre-loader').style.opacity = '0';
                    setTimeout(function() {
                        document.querySelector('.pre-loader').style.display = 'none';
                    }, 300);
                } else {
                    width++;
                    bar1.style.width = width + '%';
                    percent1.innerHTML = width + '%';
                }
            }, 20);
        }, 500);
    </script>
</body>
</html>