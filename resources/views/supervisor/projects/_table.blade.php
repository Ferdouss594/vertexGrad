<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($projects->count())
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Student</th>
                            <th>Status</th>
                            <th>Scanner</th>
                            <th>Score</th>
                            <th>Supervisor Review</th>
                            <th>Updated</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $project->project_id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $project->name }}</div>
                                    <small class="text-muted">{{ $project->category ?? '—' }}</small>
                                </td>
                                <td>{{ $project->student->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $project->status ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $project->scanner_status ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ $project->scan_score ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $project->supervisor_status ?? 'Not reviewed' }}
                                    </span>
                                </td>
                                <td>{{ optional($project->updated_at)->format('Y-m-d h:i A') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('supervisor.projects.show', $project->project_id) }}" class="btn btn-sm btn-primary">
                                        Open
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $projects->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa fa-folder-open-o fa-3x text-muted mb-3"></i>
                <h6 class="mb-1">No projects found</h6>
                <p class="text-muted mb-0">Projects will appear here when available.</p>
            </div>
        @endif
    </div>
</div>