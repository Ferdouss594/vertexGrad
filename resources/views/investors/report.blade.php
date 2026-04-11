@extends('layouts.app')

@section('title', 'Investor Report')

@section('content')
<style>
    .single-investor-report-page {
        --text-main: #172033;
        --text-soft: #7b8497;
        --border-color: #e8ecf4;
        --primary-color: #4e73df;
        --shadow-sm: 0 8px 20px rgba(18, 38, 63, 0.06);
    }

    .single-investor-report-page .page-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
        border-radius: 24px;
        padding: 26px 28px;
        color: var(--text-main);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        margin-bottom: 24px;
    }

    .single-investor-report-page .stats-card,
    .single-investor-report-page .section-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        height: 100%;
    }

    .single-investor-report-page .stats-card {
        padding: 22px;
    }

    .single-investor-report-page .stats-number {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .single-investor-report-page .stats-label {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0;
    }

    .single-investor-report-page .section-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eef2f7;
        font-weight: 700;
        color: #0f172a;
    }

    .single-investor-report-page .section-body {
        padding: 22px;
    }

    .single-investor-report-page .modern-table {
        margin-bottom: 0;
        width: 100%;
        table-layout: auto;
    }

    .single-investor-report-page .modern-table thead th {
        background: #f8fafc;
        color: #334155;
        font-weight: 700;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 10px;
        font-size: 13px;
        white-space: nowrap;
    }

    .single-investor-report-page .modern-table tbody td {
        padding: 12px 10px;
        border-color: #f1f5f9;
        font-size: 13px;
        vertical-align: middle;
    }

    .single-investor-report-page .btn-export,
    .single-investor-report-page .btn-back {
        background: #eef2f8;
        border: none;
        color: #0f172a;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 700;
        text-decoration: none;
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 single-investor-report-page">
    <div class="min-height-200px">

        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                <div>
                    <h3 class="mb-1">{{ $investor->user?->name ?? 'Investor Report' }}</h3>
                    <p class="mb-0" style="color:#7b8497;">Detailed investor report including requests, funding activity, notes, files, and actions.</p>
                </div>

                <div class="d-flex flex-wrap" style="gap: 10px;">
                    <a href="{{ route('admin.investors.show', $investor->user_id) }}" class="btn-back">
                        <i class="fa fa-arrow-left mr-1"></i> Back to Investor
                    </a>

                    <a href="{{ route('admin.investors.report.export', $investor->user_id) }}" class="btn-export">
                        <i class="fa fa-file-excel mr-1"></i> Export Report
                    </a>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['total_requests'] }}</div><p class="stats-label">Total Requests</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['approved'] }}</div><p class="stats-label">Approved</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['rejected'] }}</div><p class="stats-label">Rejected</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">${{ number_format($stats['approved_amount'], 2) }}</div><p class="stats-label">Approved Amount</p></div></div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['interested'] }}</div><p class="stats-label">Interested</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['requested'] }}</div><p class="stats-label">Requested</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['notes_count'] }}</div><p class="stats-label">Notes</p></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="stats-card"><div class="stats-number">{{ $stats['files_count'] }}</div><p class="stats-label">Files</p></div></div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="section-card">
                    <div class="section-header">Funding Request History</div>
                    <div class="section-body p-0">
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Project</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($investmentRequests as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ optional($item->project)->name ?? '—' }}</td>
                                            <td>{{ ucfirst($item->status) }}</td>
                                            <td>{{ $item->amount !== null ? '$' . number_format($item->amount, 2) : '—' }}</td>
                                            <td>{{ $item->message ?: '—' }}</td>
                                            <td>{{ optional($item->created_at)->format('Y-m-d h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No funding requests found for this investor.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.stats-card, .section-card').forEach((el, i) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(10px)';
        setTimeout(() => {
            el.style.transition = 'all .35s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, i * 60);
    });
});
</script>
@endsection