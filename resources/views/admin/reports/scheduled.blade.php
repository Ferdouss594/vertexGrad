@extends('layouts.app')

@section('title', 'Scheduled Reports')

@section('content')
<style>
    .scheduled-reports-page .hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #2563eb 100%);
        border-radius: 24px;
        padding: 30px 32px;
        color: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.16);
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .scheduled-reports-page .hero-card::before {
        content: "";
        position: absolute;
        top: -45px;
        right: -45px;
        width: 170px;
        height: 170px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
    }

    .scheduled-reports-page .hero-card::after {
        content: "";
        position: absolute;
        bottom: -70px;
        left: -70px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }

    .scheduled-reports-page .hero-content {
        position: relative;
        z-index: 2;
    }

    .scheduled-reports-page .hero-title {
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.4px;
    }

    .scheduled-reports-page .hero-text {
        color: rgba(255,255,255,0.90);
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 0;
        max-width: 780px;
    }

    .scheduled-reports-page .section-card {
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .scheduled-reports-page .section-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .scheduled-reports-page .section-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .scheduled-reports-page .section-header p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .scheduled-reports-page .section-body {
        padding: 24px;
    }

    .scheduled-reports-page .config-card {
        background: #f8fbff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px;
        height: 100%;
    }

    .scheduled-reports-page .config-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
    }

    .scheduled-reports-page .form-label-custom {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
        display: block;
    }

    .scheduled-reports-page .form-control,
    .scheduled-reports-page .form-select-custom {
        border-radius: 14px;
        min-height: 46px;
        border: 1px solid #dbe4ee;
        box-shadow: none;
        font-size: 14px;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    .scheduled-reports-page .form-control:focus,
    .scheduled-reports-page .form-select-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
    }

    .scheduled-reports-page .days-grid {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 10px;
    }

    .scheduled-reports-page .day-option {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #dbe4ee;
        background: #fff;
        border-radius: 14px;
        min-height: 50px;
        padding: 10px 12px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }

    .scheduled-reports-page .day-option:hover {
        border-color: #93c5fd;
        background: #f8fbff;
        box-shadow: 0 8px 18px rgba(37, 99, 235, 0.06);
    }

    .scheduled-reports-page .day-option input {
        accent-color: #2563eb;
    }

    .scheduled-reports-page .action-btn {
        border-radius: 14px;
        padding: 11px 18px;
        font-weight: 700;
    }

    .scheduled-reports-page .schedule-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
        transition: all 0.2s ease;
    }

    .scheduled-reports-page .schedule-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 34px rgba(15, 23, 42, 0.08);
    }

    .scheduled-reports-page .schedule-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .scheduled-reports-page .schedule-meta {
        font-size: 13px;
        color: #64748b;
        line-height: 1.9;
        margin-bottom: 16px;
    }

    .scheduled-reports-page .badge-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .scheduled-reports-page .badge-active {
        background: #dcfce7;
        color: #166534;
    }

    .scheduled-reports-page .badge-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .scheduled-reports-page .badge-frequency {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .scheduled-reports-page .schedule-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .scheduled-reports-page .helper-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e3a8a;
        border-radius: 16px;
        padding: 14px 16px;
        font-size: 13px;
        line-height: 1.8;
        margin-bottom: 18px;
    }

    @media (max-width: 991px) {
        .scheduled-reports-page .days-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .scheduled-reports-page .hero-card {
            padding: 24px 20px;
        }

        .scheduled-reports-page .hero-title {
            font-size: 24px;
        }

        .scheduled-reports-page .days-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .scheduled-reports-page .section-header,
        .scheduled-reports-page .section-body {
            padding-left: 16px;
            padding-right: 16px;
        }
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 scheduled-reports-page">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm" style="border-radius: 16px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 16px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 16px;">
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="hero-card">
        <div class="hero-content">
            <div class="hero-title">Scheduled Reports</div>
            <p class="hero-text">
                Create enterprise-grade automated reports with exact delivery time, recurrence rules,
                selected weekdays, monthly execution settings, and direct email delivery.
            </p>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <h4>Create Advanced Schedule</h4>
            <p>Define exactly when the system should generate and deliver the report.</p>
        </div>

        <div class="section-body">
            <div class="helper-box">
                Use this form to control the report like enterprise systems:
                choose the template, recurrence type, exact send time, email destination,
                working days, monthly day, and activation state.
            </div>

            <form method="POST" action="{{ route('admin.reports.scheduled.store') }}">
                @csrf

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="config-card">
                            <div class="config-title">Core Schedule Settings</div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Report Template</label>
                                    <select name="report_template_id" class="form-control form-select-custom" required>
                                        <option value="">Select template</option>
                                        @foreach($templates as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Recurrence Type</label>
                                    <select name="frequency" id="frequency-select" class="form-control form-select-custom" required>
                                        <option value="">Select frequency</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Send Time</label>
                                    <input type="time" name="run_time" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <label class="form-label-custom">Send To Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="manager@example.com" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="config-card">
                            <div class="config-title">Advanced Recurrence Rules</div>

                            <div id="weekly-options" style="display: none;">
                                <label class="form-label-custom">Send On These Days</label>
                                <div class="days-grid mb-3">
                                    <label class="day-option"><input type="checkbox" name="days_of_week[]" value="monday"> Monday</label>
                                    <label class="day-option"><input type="checkbox" name="days_of_week[]" value="tuesday"> Tuesday</label>
                                    <label class="day-option"><input type="checkbox" name="days_of_week[]" value="wednesday"> Wednesday</label>
                                    <label class="day-option"><input type="checkbox" name="days_of_week[]" value="thursday"> Thursday</label>
                                    <label class="day-option"><input type="checkbox" name="days_of_week[]" value="friday"> Friday</label>
                                    <label class="day-option"><input type="checkbox" name="days_of_week[]" value="saturday"> Saturday</label>
                                    <label class="day-option"><input type="checkbox" name="days_of_week[]" value="sunday"> Sunday</label>
                                </div>
                            </div>

                            <div id="monthly-options" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">Day Of Month</label>
                                        <input type="number" min="1" max="31" name="day_of_month" class="form-control" placeholder="e.g. 15">
                                    </div>
                                </div>
                            </div>

                            <div id="yearly-options" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">Month Of Year</label>
                                        <select name="month_of_year" class="form-control form-select-custom">
                                            <option value="">Select month</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">Day Of Month</label>
                                        <input type="number" min="1" max="31" name="yearly_day" class="form-control" placeholder="e.g. 1">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Schedule Status</label>
                                    <select name="is_active" class="form-control form-select-custom">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label-custom">Delivery Channel</label>
                                    <select name="delivery_type" class="form-control form-select-custom">
                                        <option value="email" selected>Email PDF</option>
                                        <option value="email_excel">Email Excel</option>
                                        <option value="both">PDF + Excel</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label-custom">Notes (Optional)</label>
                                <textarea name="notes" rows="4" class="form-control" placeholder="Internal scheduling notes for management..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap" style="gap: 12px;">
                    <button type="submit" class="btn btn-primary action-btn">
                        Create Advanced Schedule
                    </button>

                    <a href="{{ route('admin.reports.templates') }}" class="btn btn-light action-btn">
                        Back to Templates
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($scheduledReports as $scheduled)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="schedule-card">
                    <div class="d-flex justify-content-between align-items-start mb-3" style="gap: 10px;">
                        <div>
                            <div class="schedule-title">{{ $scheduled->template?->name ?? 'Template' }}</div>
                            <span class="badge-soft badge-frequency">{{ ucfirst($scheduled->frequency) }}</span>
                        </div>

                        <span class="badge-soft {{ $scheduled->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $scheduled->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="schedule-meta">
                        <div><strong>Email:</strong> {{ $scheduled->email ?? '-' }}</div>

                        <div>
                            <strong>Send Time:</strong>
                            {{ $scheduled->run_time
                                ? \Carbon\Carbon::createFromFormat('H:i:s', $scheduled->run_time)->format('h:i A')
                                : '-' }}
                        </div>

                        <div>
                            <strong>Start Date:</strong>
                            {{ $scheduled->start_date
                                ? \Carbon\Carbon::parse($scheduled->start_date)->format('Y-m-d')
                                : '-' }}
                        </div>

                        <div>
                            <strong>Next Run:</strong>
                            {{ $scheduled->next_run_at
                                ? $scheduled->next_run_at->timezone(config('app.timezone'))->format('Y-m-d h:i A')
                                : '-' }}
                        </div>

                        <div>
                            <strong>Last Run:</strong>
                            {{ $scheduled->last_run_at
                                ? $scheduled->last_run_at->timezone(config('app.timezone'))->format('Y-m-d h:i A')
                                : '-' }}
                        </div>

                        @if(!empty($scheduled->days_of_week))
                            <div>
                                <strong>Days:</strong>
                                {{ is_array($scheduled->days_of_week) ? implode(', ', $scheduled->days_of_week) : $scheduled->days_of_week }}
                            </div>
                        @endif

                        @if(!empty($scheduled->day_of_month))
                            <div><strong>Monthly Day:</strong> {{ $scheduled->day_of_month }}</div>
                        @endif

                        @if(!empty($scheduled->month_of_year))
                            <div><strong>Yearly Month:</strong> {{ $scheduled->month_of_year }}</div>
                        @endif
                    </div>

                    <div class="schedule-actions">
                        <form method="POST" action="{{ route('admin.reports.scheduled.run-now', $scheduled->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                ⚡ Send Now
                            </button>
                        </form>

                        <form action="{{ route('admin.reports.scheduled.toggle', $scheduled->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning btn-sm">
                                {{ $scheduled->is_active ? 'Disable' : 'Enable' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.reports.scheduled.delete', $scheduled->id) }}" method="POST" onsubmit="return confirm('Delete this scheduled report?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-box p-5 text-center" style="border-radius: 20px;">
                    <h5 class="mb-2">No Scheduled Reports Yet</h5>
                    <p class="text-muted mb-3">Create your first enterprise-grade recurring report from the form above.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $scheduledReports->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const frequencySelect = document.getElementById('frequency-select');
    const weeklyOptions = document.getElementById('weekly-options');
    const monthlyOptions = document.getElementById('monthly-options');
    const yearlyOptions = document.getElementById('yearly-options');

    function toggleAdvancedOptions() {
        const value = frequencySelect.value;

        weeklyOptions.style.display = value === 'weekly' ? 'block' : 'none';
        monthlyOptions.style.display = value === 'monthly' ? 'block' : 'none';
        yearlyOptions.style.display = value === 'yearly' ? 'block' : 'none';
    }

    frequencySelect.addEventListener('change', toggleAdvancedOptions);
    toggleAdvancedOptions();
});
</script>
@endsection