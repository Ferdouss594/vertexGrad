<div class="main-panel mb-4">
    <div class="panel-head">
        <h2 class="panel-title">
            <i class="fa fa-hand-holding-usd mr-2"></i> Funding / Project Investments
        </h2>
        <div class="panel-subtitle">Track investor funding activity, project interest, and investment statuses.</div>
    </div>

    <div class="table-wrap">
        @if($projectInvestments->count() > 0)
            <div class="table-responsive students-table-card">
                <table class="table students-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Project</th>
                            <th>Student</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Amount</th>
                            <th>Message</th>
                            <th class="text-center">Date</th>
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
                                <td class="text-center">{{ $loop->iteration }}</td>

                                <td>
                                    <div class="student-name-cell">{{ $project->name ?? 'Untitled Project' }}</div>
                                    <div class="student-muted-cell">Project ID: {{ $project->project_id ?? '—' }}</div>
                                </td>

                                <td>
                                    <div class="student-muted-cell">{{ $project->student->name ?? '—' }}</div>
                                </td>

                                <td class="text-center">
                                    <span class="badge-soft {{ $fundingClass }}">
                                        {{ ucfirst($project->pivot->status ?? '—') }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="student-muted-cell">
                                        {{ $project->pivot->amount !== null ? '$' . number_format($project->pivot->amount, 2) : '—' }}
                                    </div>
                                </td>

                                <td style="max-width: 260px;">
                                    <div class="student-muted-cell" style="white-space: normal; line-height: 1.6;">
                                        {{ $project->pivot->message ?? '—' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="student-muted-cell">
                                        {{ optional($project->pivot->created_at)->format('Y-m-d h:i A') ?? '—' }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="students-table-card">
                <div class="empty-state">
                    <i class="fa fa-hand-holding-usd mb-2"></i>
                    <div>No funding activity found for this investor.</div>
                </div>
            </div>
        @endif
    </div>
</div>