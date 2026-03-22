@extends('layouts.app')

@section('title', 'Investor Reports')

@section('content')
<style>
    .investor-reports-page .page-header-card {
        background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
        border-radius: 22px;
        padding: 30px 32px;
        color: #fff;
        box-shadow: 0 14px 34px rgba(27, 0, 255, 0.18);
        margin-bottom: 24px;
    }

    .investor-reports-page .stats-card,
    .investor-reports-page .section-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        height: 100%;
    }

    .investor-reports-page .stats-card {
        padding: 22px;
    }

    .investor-reports-page .stats-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .investor-reports-page .stats-label {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0;
    }

    .investor-reports-page .section-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eef2f7;
        font-weight: 700;
        color: #0f172a;
    }

    .investor-reports-page .section-body {
        padding: 22px;
    }

    .investor-reports-page .list-clean {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .investor-reports-page .list-clean li {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .investor-reports-page .list-clean li:last-child {
        border-bottom: none;
    }

    .investor-reports-page .record-title {
        font-weight: 700;
        color: #0f172a;
    }

    .investor-reports-page .record-meta {
        font-size: 12px;
        color: #64748b;
        margin-top: 4px;
    }

    .investor-reports-page .btn-export {
        background: #fff;
        border: 1px solid #dbe4f0;
        color: #0f172a;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 700;
        text-decoration: none;
    }

    .investor-reports-page .btn-export:hover {
        text-decoration: none;
        color: #0f172a;
        background: #f8fafc;
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 investor-reports-page">
    <div class="min-height-200px">

        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                <div>
                    <h3 class="mb-1">Investor Reports</h3>
                    <p class="mb-0">Investor analytics, funding activity, request trends, and recent actions.</p>
                </div>

                <a href="{{ route('admin.investor-reports.export') }}" class="btn-export">
                    <i class="fa fa-file-excel mr-1"></i> Export Report
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['total_investors'] }}</div><p class="stats-label">Total Investors</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['active_investors'] }}</div><p class="stats-label">Active Investors</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['inactive_investors'] }}</div><p class="stats-label">Inactive Investors</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['archived_investors'] }}</div><p class="stats-label">Archived Investors</p></div></div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 col-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['total_requests'] }}</div><p class="stats-label">Total Requests</p></div></div>
            <div class="col-xl-2 col-md-4 col-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['interested'] }}</div><p class="stats-label">Interested</p></div></div>
            <div class="col-xl-2 col-md-4 col-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['requested'] }}</div><p class="stats-label">Requested</p></div></div>
            <div class="col-xl-2 col-md-4 col-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['approved'] }}</div><p class="stats-label">Approved</p></div></div>
            <div class="col-xl-2 col-md-4 col-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['rejected'] }}</div><p class="stats-label">Rejected</p></div></div>
            <div class="col-xl-2 col-md-4 col-12 mb-3"><div class="stats-card"><div class="stats-number">${{ number_format($stats['approved_amount'], 2) }}</div><p class="stats-label">Approved Amount</p></div></div>
        </div>

        <div class="row">
            <div class="col-xl-4 mb-4">
                <div class="section-card">
                    <div class="section-header">Top Investors by Approved Amount</div>
                    <div class="section-body">
                        @if($topApprovedInvestors->count())
                            <ul class="list-clean">
                                @foreach($topApprovedInvestors as $row)
                                    <li>
                                        <div class="record-title">{{ optional($row->investor)->name ?? 'Unknown Investor' }}</div>
                                        <div class="record-meta">
                                            Approved Requests: {{ $row->approved_count }} |
                                            Approved Amount: ${{ number_format($row->approved_amount, 2) }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted">No approved investment data yet.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mb-4">
                <div class="section-card">
                    <div class="section-header">Top Investors by Total Requests</div>
                    <div class="section-body">
                        @if($topRequestInvestors->count())
                            <ul class="list-clean">
                                @foreach($topRequestInvestors as $row)
                                    <li>
                                        <div class="record-title">{{ optional($row->investor)->name ?? 'Unknown Investor' }}</div>
                                        <div class="record-meta">
                                            Total Requests: {{ $row->total_requests }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted">No request data yet.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mb-4">
                <div class="section-card">
                    <div class="section-header">Latest Investor Activities</div>
                    <div class="section-body">
                        @if($latestActivities->count())
                            <ul class="list-clean">
                                @foreach($latestActivities as $activity)
                                    <li>
                                        <div class="record-title">
                                            {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                        </div>
                                        <div class="record-meta">
                                            Investor: {{ optional(optional($activity->investor)->user)->name ?? 'Unknown' }} |
                                            By: {{ optional($activity->user)->name ?? 'System' }}
                                        </div>
                                        <div class="record-meta">
                                            {{ optional($activity->created_at)->format('Y-m-d h:i A') }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted">No investor activity found.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection