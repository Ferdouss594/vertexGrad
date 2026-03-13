@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-header mb-30">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="title">
                            <h4>VertexGrad Dashboard</h4>
                            <p class="text-muted mb-0">Platform analytics, project pipeline, and activity overview.</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('admin.reports.platform') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-bar-chart me-1"></i> Open Reports
                        </a>
                    </div>
                </div>
            </div>

            {{-- Top KPI cards --}}
            <div class="row pb-10">
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3 dashboard-kpi-card">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $stats['total_projects'] }}</div>
                                <div class="font-14 text-secondary weight-500">Total Projects</div>
                                <div class="font-12 text-muted mt-1">All project records</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#00bcd4">
                                    <i class="icon-copy fa fa-briefcase" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3 dashboard-kpi-card">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $stats['students'] }}</div>
                                <div class="font-14 text-secondary weight-500">Students</div>
                                <div class="font-12 text-muted mt-1">Registered academic users</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#28a745">
                                    <i class="icon-copy fa fa-graduation-cap" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3 dashboard-kpi-card">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $stats['investors'] }}</div>
                                <div class="font-14 text-secondary weight-500">Investors</div>
                                <div class="font-12 text-muted mt-1">Opportunity seekers</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#f39c12">
                                    <i class="icon-copy fa fa-line-chart" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3 dashboard-kpi-card">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">${{ number_format($stats['total_funding']) }}</div>
                                <div class="font-14 text-secondary weight-500">Funding Scope</div>
                                <div class="font-12 text-muted mt-1">Active + completed value</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#34495e">
                                    <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main analytics row --}}
            <div class="row pb-10">
                <div class="col-md-8 mb-20">
                    <div class="card-box height-100-p pd-20 dashboard-main-card">
                        <div class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
                            <div>
                                <div class="h5 mb-md-1">Project Pipeline Analytics</div>
                                <div class="font-13 text-muted">Overview of project movement across all statuses</div>
                            </div>
                            <div class="form-group mb-md-0">
                                <span class="badge badge-pill dashboard-badge-soft">Live Data</span>
                            </div>
                        </div>
                        <div id="activities-chart"></div>
                    </div>
                </div>

                <div class="col-md-4 mb-20">
                    <div class="card-box min-height-200px pd-20 mb-20 dashboard-side-stat" data-bgcolor="#455a64">
                        <div class="d-flex justify-content-between pb-20 text-white">
                            <div class="icon h1 text-white">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                            </div>
                            <div class="font-14 text-right">
                                <div class="font-12">Waiting for review</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="text-white">
                                <div class="font-14">Pending Projects</div>
                                <div class="font-24 weight-500">{{ $stats['pending_projects'] }}</div>
                            </div>
                            <div class="max-width-150">
                                <div id="pending-chart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-box min-height-200px pd-20 mb-20 dashboard-side-stat" data-bgcolor="#265ed7">
                        <div class="d-flex justify-content-between pb-20 text-white">
                            <div class="icon h1 text-white">
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                            </div>
                            <div class="font-14 text-right">
                                <div class="font-12">Currently visible</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="text-white">
                                <div class="font-14">Active Projects</div>
                                <div class="font-24 weight-500">{{ $stats['active_projects'] }}</div>
                            </div>
                            <div class="max-width-150">
                                <div id="active-chart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-box min-height-200px pd-20 dashboard-side-stat" data-bgcolor="#8b1e3f">
                        <div class="d-flex justify-content-between pb-20 text-white">
                            <div class="icon h1 text-white">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </div>
                            <div class="font-14 text-right">
                                <div class="font-12">Declined submissions</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="text-white">
                                <div class="font-14">Rejected Projects</div>
                                <div class="font-24 weight-500">{{ $stats['rejected_projects'] }}</div>
                            </div>
                            <div class="max-width-150">
                                <div id="rejected-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Middle row --}}
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p pd-20 min-height-200px dashboard-middle-card">
                        <div class="d-flex justify-content-between pb-10">
                            <div class="h5 mb-0">Recent Students</div>
                        </div>
                        <div class="user-list">
                            <ul>
                                @forelse($recentStudents as $student)
                                    <li class="d-flex align-items-center justify-content-between dashboard-list-item">
                                        <div class="name-avatar d-flex align-items-center pr-2">
                                            <div class="avatar mr-2 flex-shrink-0">
                                                <img
                                                    src="{{ asset('vendors/images/photo1.jpg') }}"
                                                    class="border-radius-100 box-shadow"
                                                    width="50"
                                                    height="50"
                                                    alt=""
                                                />
                                            </div>
                                            <div class="txt">
                                                <div class="font-14 weight-600">{{ $student->name }}</div>
                                                <div class="font-12 weight-500 text-muted">
                                                    {{ $student->email }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cta flex-shrink-0">
                                            <span class="badge badge-pill badge-sm dashboard-badge-soft">
                                                {{ $student->status }}
                                            </span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-muted">No students found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p pd-20 min-height-200px dashboard-middle-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h5 mb-0">Project Status Breakdown</div>
                                <div class="font-12 text-muted mt-1">Status composition across the platform</div>
                            </div>
                        </div>

                        <div id="project-status-chart" style="min-height: 280px;"></div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 mb-20">
                    <div class="card-box height-100-p pd-20 min-height-200px dashboard-middle-card">
                        <div class="text-center">
                            <div class="h5 mb-1">Platform Summary</div>
                            <div class="font-14 weight-500 max-width-300 mx-auto pb-20 text-muted">
                                VertexGrad currently manages {{ $stats['total_projects'] }} projects across {{ $stats['students'] }} students and {{ $stats['investors'] }} investors.
                            </div>

                            <div class="row text-center mt-2">
                                <div class="col-6 mb-15">
                                    <div class="font-24 weight-700 text-primary">{{ $stats['completed_projects'] }}</div>
                                    <div class="font-12 text-muted">Completed</div>
                                </div>
                                <div class="col-6 mb-15">
                                    <div class="font-24 weight-700 text-danger">{{ $stats['rejected_projects'] }}</div>
                                    <div class="font-12 text-muted">Rejected</div>
                                </div>
                                <div class="col-6">
                                    <div class="font-24 weight-700 text-success">{{ $stats['active_projects'] }}</div>
                                    <div class="font-12 text-muted">Active</div>
                                </div>
                                <div class="col-6">
                                    <div class="font-24 weight-700 text-warning">{{ $stats['pending_projects'] }}</div>
                                    <div class="font-12 text-muted">Pending</div>
                                </div>
                            </div>

                            <a href="{{ route('admin.reports.platform') }}" class="btn btn-primary btn-lg mt-20">Open Reports</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Projects --}}
            <div class="card-box pb-10 dashboard-table-card">
                <div class="h5 pd-20 mb-0">Recent Projects</div>
                <table class="data-table table nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus">Project</th>
                            <th>Student</th>
                            <th>Status</th>
                            <th>Budget</th>
                            <th>Created</th>
                            <th class="datatable-nosort">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentProjects as $project)
                            <tr>
                                <td class="table-plus">
                                    <div class="name-avatar d-flex align-items-center">
                                        <div class="txt">
                                            <div class="weight-600">{{ $project->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $project->student->name ?? '—' }}</td>
                                <td>
                                    @if($project->status === 'pending')
                                        <span class="badge badge-pill dashboard-status dashboard-status-warning">Pending</span>
                                    @elseif($project->status === 'active')
                                        <span class="badge badge-pill dashboard-status dashboard-status-success">Active</span>
                                    @elseif($project->status === 'completed')
                                        <span class="badge badge-pill dashboard-status dashboard-status-primary">Completed</span>
                                    @elseif($project->status === 'rejected')
                                        <span class="badge badge-pill dashboard-status dashboard-status-danger">Rejected</span>
                                    @else
                                        <span class="badge badge-pill dashboard-status dashboard-status-secondary">{{ $project->status }}</span>
                                    @endif
                                </td>
                                <td>${{ number_format($project->budget ?? 0) }}</td>
                                <td>{{ $project->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.projects.show', $project) }}" data-color="#265ed7">
                                            <i class="icon-copy dw dw-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Quick Start --}}
            <div class="title pb-20 pt-20">
                <h2 class="h3 mb-0">Quick Start</h2>
            </div>

            <div class="row">
                <div class="col-md-4 mb-20">
                    <a href="{{ route('admin.projects.index') }}" class="card-box d-block mx-auto pd-20 text-secondary dashboard-quick-card">
                        <div class="img pb-20 text-center">
                            <i class="fa fa-briefcase fa-3x text-primary"></i>
                        </div>
                        <div class="content text-center">
                            <h3 class="h4">Projects</h3>
                            <p class="max-width-200 mx-auto">
                                Review submissions, approvals, and project lifecycle activity.
                            </p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-20">
                    <a href="{{ route('admin.students.index') }}" class="card-box d-block mx-auto pd-20 text-secondary dashboard-quick-card">
                        <div class="img pb-20 text-center">
                            <i class="fa fa-graduation-cap fa-3x text-success"></i>
                        </div>
                        <div class="content text-center">
                            <h3 class="h4">Students</h3>
                            <p class="max-width-200 mx-auto">
                                Monitor registered students and their research activity.
                            </p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-20">
                    <a href="{{ route('admin.investors.index') }}" class="card-box d-block mx-auto pd-20 text-secondary dashboard-quick-card">
                        <div class="img pb-20 text-center">
                            <i class="fa fa-line-chart fa-3x text-warning"></i>
                        </div>
                        <div class="content text-center">
                            <h3 class="h4">Investors</h3>
                            <p class="max-width-200 mx-auto">
                                Track investor accounts, engagement, and opportunity flow.
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.dashboard-kpi-card,
.dashboard-main-card,
.dashboard-middle-card,
.dashboard-table-card,
.dashboard-quick-card,
.dashboard-side-stat {
    border-radius: 14px;
    transition: all 0.22s ease;
}

.dashboard-kpi-card,
.dashboard-main-card,
.dashboard-middle-card,
.dashboard-table-card,
.dashboard-quick-card {
    border: 1px solid #edf1f7;
    box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
}

.dashboard-kpi-card:hover,
.dashboard-main-card:hover,
.dashboard-middle-card:hover,
.dashboard-quick-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
}

.dashboard-side-stat {
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.10);
}

.dashboard-badge-soft {
    background: #eef4ff;
    color: #265ed7;
    font-weight: 700;
}

.dashboard-list-item {
    border-bottom: 1px solid #f1f4f8;
    padding: 10px 0;
}

.dashboard-list-item:last-child {
    border-bottom: none;
}

.dashboard-status {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .04em;
    text-transform: uppercase;
    padding: 7px 12px;
}

.dashboard-status-warning { background: #fff4db; color: #946200; }
.dashboard-status-success { background: #e8f7ee; color: #1d7f49; }
.dashboard-status-primary { background: #eaf2ff; color: #265ed7; }
.dashboard-status-danger { background: #fdecef; color: #b42318; }
.dashboard-status-secondary { background: #eff2f6; color: #475467; }

.dashboard-quick-card .content h3 {
    margin-bottom: 8px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined') return;

const pipelineEl = document.querySelector("#activities-chart");
if (pipelineEl) {
    new ApexCharts(pipelineEl, {
        series: [
            {
                name: 'submitted',
                data: @json($submittedByMonth)
            },
            {
                name: 'active',
                data: @json($activeByMonth)
            },
            {
                name: 'rejected',
                data: @json($rejectedByMonth)
            },
            {
                name: 'completed',
                data: @json($completedByMonth)
            }
        ],
        chart: {
            type: 'bar',
            height: 320,
            toolbar: { show: false }
        },
        colors: ['#17a2b8', '#28a745', '#dc3545', '#265ed7'],
        dataLabels: { enabled: false },
        stroke: { show: true, width: 0 },
        grid: { borderColor: '#eef2f6' },
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '48%'
            }
        },
        xaxis: {
            categories: @json($months),
            labels: {
                style: {
                    colors: ['#98a2b3', '#98a2b3', '#98a2b3', '#98a2b3', '#98a2b3', '#98a2b3']
                }
            }
        },
        yaxis: {
            labels: {
                style: { colors: ['#98a2b3'] }
            }
        },
        legend: {
            position: 'top'
        }
    }).render();
}


const statusEl = document.querySelector("#project-status-chart");
    if (statusEl) {
        new ApexCharts(statusEl, {
            series: [
                {{ $stats['pending_projects'] }},
                {{ $stats['active_projects'] }},
                {{ $stats['completed_projects'] }},
                {{ $stats['rejected_projects'] }}
            ],
            chart: {
                type: 'donut',
                height: 280
            },
            labels: ['Pending', 'Active', 'Completed', 'Rejected'],
            colors: ['#f0ad4e', '#28a745', '#265ed7', '#dc3545'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: false
            }
        }).render();
    }

    const pendingEl = document.querySelector("#pending-chart");
    if (pendingEl) {
        new ApexCharts(pendingEl, {
            series: [{{ max($stats['pending_projects'], 1) }}],
            chart: { type: 'radialBar', height: 120, sparkline: { enabled: true } },
            plotOptions: {
                radialBar: {
                    hollow: { size: '62%' },
                    track: { background: 'rgba(255,255,255,0.12)' },
                    dataLabels: { show: false }
                }
            },
            colors: ['#f8c35c']
        }).render();
    }

    const activeEl = document.querySelector("#active-chart");
    if (activeEl) {
        new ApexCharts(activeEl, {
            series: [{{ max($stats['active_projects'], 1) }}],
            chart: { type: 'radialBar', height: 120, sparkline: { enabled: true } },
            plotOptions: {
                radialBar: {
                    hollow: { size: '62%' },
                    track: { background: 'rgba(255,255,255,0.12)' },
                    dataLabels: { show: false }
                }
            },
            colors: ['#57d68d']
        }).render();
    }

    const rejectedEl = document.querySelector("#rejected-chart");
    if (rejectedEl) {
        new ApexCharts(rejectedEl, {
            series: [{{ max($stats['rejected_projects'], 1) }}],
            chart: { type: 'radialBar', height: 120, sparkline: { enabled: true } },
            plotOptions: {
                radialBar: {
                    hollow: { size: '62%' },
                    track: { background: 'rgba(255,255,255,0.12)' },
                    dataLabels: { show: false }
                }
            },
            colors: ['#ff6b81']
        }).render();
    }
});
</script>
@endpush
@endsection