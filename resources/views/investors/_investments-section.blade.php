<div class="section-card mb-4">
    <div class="section-header">
        <i class="fa fa-hand-holding-usd"></i> Funding / Project Investments
    </div>

    <div class="section-body p-0">
        @if($projectInvestments->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Student</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projectInvestments as $project)
                            @php
                                $fundingClass = match($project->pivot->status) {
                                    'approved' => 'badge-funding-approved',
                                    'rejected' => 'badge-funding-rejected',
                                    'requested' => 'badge-funding-requested',
                                    'interested' => 'badge-funding-interested',
                                    default => 'badge-default',
                                };
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $project->name ?? 'Untitled Project' }}</strong>
                                    <div class="record-meta">Project ID: {{ $project->project_id ?? '—' }}</div>
                                </td>
                                <td>{{ $project->student->name ?? '—' }}</td>
                                <td>
                                    <span class="badge-soft {{ $fundingClass }}">
                                        {{ ucfirst($project->pivot->status ?? '—') }}
                                    </span>
                                </td>
                                <td>
                                    {{ $project->pivot->amount !== null ? '$' . number_format($project->pivot->amount, 2) : '—' }}
                                </td>
                                <td style="max-width: 260px;">
                                    {{ $project->pivot->message ?? '—' }}
                                </td>
                                <td>
                                    {{ optional($project->pivot->created_at)->format('Y-m-d h:i A') ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fa fa-hand-holding-usd"></i>
                <div>No funding activity found for this investor.</div>
            </div>
        @endif
    </div>
</div>