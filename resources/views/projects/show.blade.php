@extends('layouts.app')
@section('title','Project Details')

@section('content')
<div class="container">

    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title mb-2">{{ $project->name }}</h1>
            <p class="card-text text-muted">{{ $project->description ?? '-' }}</p>

            <div class="row g-3 mt-2">
                <div class="col-md-3"><strong>Status:</strong> {{ $project->status }}</div>
                <div class="col-md-3"><strong>Progress:</strong> {{ $project->progress ?? 0 }}%</div>
                <div class="col-md-3"><strong>Category:</strong> {{ $project->category ?? '-' }}</div>
                <div class="col-md-3"><strong>Budget:</strong> {{ $project->budget ?? '-' }}</div>
                <div class="col-md-3"><strong>Priority:</strong> {{ $project->priority ?? '-' }}</div>
                <div class="col-md-3"><strong>Start:</strong> {{ optional($project->start_date)->format('d/m/Y') ?? '-' }}</div>
                <div class="col-md-3"><strong>End:</strong> {{ optional($project->end_date)->format('d/m/Y') ?? '-' }}</div>
            </div>

            <hr class="my-3">

            <div class="row g-3">
                <div class="col-md-3"><strong>Supervisor:</strong> {{ $project->supervisor?->name ?? '-' }}</div>
                <div class="col-md-3"><strong>Student:</strong> {{ $project->student?->name ?? '-' }}</div>
                <div class="col-md-3"><strong>Manager:</strong> {{ $project->manager?->name ?? '-' }}</div>
                <div class="col-md-3"><strong>Total Investors:</strong> {{ $project->investors->count() }}</div>
            </div>

            @if($project->status === 'pending')
                <hr class="my-3">
                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('admin.projects.approve', $project) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Approve Project</button>
                    </form>

                    <form method="POST" action="{{ route('admin.projects.reject', $project) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Reject Project</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Interested Investors</h3>
        </div>
        <div class="card-body">
            @php
                $interested = $project->investors->where('pivot.status', 'interested');
            @endphp

            @if($interested->count())
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Investor</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Expressed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interested as $investor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $investor->name }}</td>
                                <td>{{ $investor->email }}</td>
                                <td><span class="badge bg-warning text-dark">Interested</span></td>
                                <td>{{ $investor->pivot->amount ?? '-' }}</td>
                                <td>{{ optional($investor->pivot->created_at)->format('d M Y H:i') ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mb-0">No interest yet.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Funding Requests</h3>
        </div>
        <div class="card-body">
            @php
                $requests = $project->investors->where('pivot.status', 'requested');
            @endphp

            @if($requests->count())
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Investor</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Message</th>
                            <th>Requested</th>
                            <th width="220">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $investor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $investor->name }}</td>
                                <td>{{ $investor->email }}</td>
                                <td>${{ number_format($investor->pivot->amount ?? 0, 2) }}</td>
                                <td>{{ $investor->pivot->message ?? '-' }}</td>
                                <td>{{ optional($investor->pivot->created_at)->format('d M Y H:i') ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
<form method="POST" action="{{ route('admin.projects.investors.approve', ['project' => $project->project_id, 'user' => $investor->id]) }}">
    @csrf
    <button type="submit" class="btn btn-success btn-sm">
        Approve
    </button>
</form>

<form method="POST" action="{{ route('admin.projects.investors.reject', ['project' => $project->project_id, 'user' => $investor->id]) }}">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm">
        Reject
    </button>
</form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mb-0">No funding requests yet.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Project Media</h3>
        </div>
        <div class="card-body">
            @php
                $images = $project->getMedia('images');
                $videoUrl = $project->getFirstMediaUrl('videos');
            @endphp

            <h5 class="mb-3">Images ({{ $images->count() }})</h5>

            @if($images->count())
                <div class="row">
                    @foreach($images as $img)
                        <div class="col-md-3 mb-3">
                            <a href="{{ $img->getUrl() }}" target="_blank" class="d-block">
                                <img src="{{ $img->getUrl() }}" class="img-fluid rounded border" alt="Project image">
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No images uploaded.</p>
            @endif

            <hr>

            <h5 class="mb-3">Video</h5>

            @if($videoUrl)
                <video class="w-100 rounded border" controls style="max-height:420px;">
                    <source src="{{ $videoUrl }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <p class="text-muted">No video uploaded.</p>
            @endif
        </div>
    </div>

</div>
@endsection
