@extends('layouts.app')

@section('title', 'Investor Details')

@section('content')
<h1>Investor Details</h1>

<div class="card mb-3">
    <div class="card-header">
        Investor Overview
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="investorTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                    Basic Info
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">
                    Notes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">
                    Files
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities" type="button" role="tab">
                    Activities
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="investorTabsContent">
            <!-- ================= Basic Info ================= -->
            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                <p><strong>Name:</strong> {{ $investor->user?->name ?? '—' }}</p>
                <p><strong>Email:</strong> {{ $investor->user?->email ?? '—' }}</p>
                <p><strong>Status:</strong> {{ $investor->user?->status ?? '—' }}</p>
                <p><strong>Company:</strong> {{ $investor->company ?? '—' }}</p>
                <p><strong>Position:</strong> {{ $investor->position ?? '—' }}</p>
                <p><strong>Investment Type:</strong> {{ $investor->investment_type ?? '—' }}</p>
                <p><strong>Budget:</strong> {{ $investor->budget ?? '—' }}</p>
                <p><strong>Source:</strong> {{ $investor->source ?? '—' }}</p>
                <p><strong>Phone:</strong> {{ $investor->phone ?? '—' }}</p>
            </div>

            <!-- ================= Notes ================= -->
            <div class="tab-pane fade" id="notes" role="tabpanel">
                @if($investor->notes->count() > 0)
                    <ul class="list-group">
                        @foreach($investor->notes as $note)
                            <li class="list-group-item">
                                <strong>{{ $note->user?->name ?? 'Unknown' }}:</strong>
                                {{ $note->note }}
                                <small class="text-muted float-end">{{ $note->created_at->format('Y-m-d H:i') }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No notes available.</p>
                @endif
            </div>

            <!-- ================= Files ================= -->
            <div class="tab-pane fade" id="files" role="tabpanel">
                @if($investor->files->count() > 0)
                    <ul class="list-group">
                        @foreach($investor->files as $file)
                            <li class="list-group-item">
                                <a href="{{ asset('storage/' . $file->path) }}" target="_blank">{{ $file->filename }}</a>
                                <small class="text-muted float-end">{{ $file->created_at->format('Y-m-d H:i') }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No files uploaded.</p>
                @endif
            </div>

            <!-- ================= Activities ================= -->
            <div class="tab-pane fade" id="activities" role="tabpanel">
                @if($investor->activities->count() > 0)
                    <ul class="list-group">
                        @foreach($investor->activities as $activity)
                            <li class="list-group-item">
                                <strong>{{ $activity->user?->name ?? 'System' }}</strong> 
                                {{ $activity->action }}
                                <small class="text-muted float-end">{{ $activity->created_at->format('Y-m-d H:i') }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No activities recorded.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<a href="{{ route('investors.index') }}" class="btn btn-secondary">Back</a>
@endsection
