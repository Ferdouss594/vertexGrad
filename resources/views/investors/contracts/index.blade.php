@extends('layouts.app')

@section('title', 'Investor Contracts')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="gap:12px;">
            <div>
                <h4 class="mb-1">{{ $investor->user?->name ?? 'Investor Contracts' }}</h4>
                <p class="text-muted mb-0">Manage legal and commercial contracts for this investor.</p>
            </div>

            <div class="d-flex" style="gap:10px;">
                <a href="{{ route('admin.investors.show', $investor->user_id) }}" class="btn btn-light border">Back</a>
                <a href="{{ route('admin.investors.contracts.create', $investor->user_id) }}" class="btn btn-primary">New Contract</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Dates</th>
                        <th>File</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contracts as $contract)
                        <tr>
                            <td>{{ $loop->iteration + ($contracts->currentPage() - 1) * $contracts->perPage() }}</td>
                            <td>{{ $contract->title }}</td>
                            <td>{{ $contract->type ?? '—' }}</td>
                            <td>{{ ucfirst($contract->status) }}</td>
                            <td>
                                {{ optional($contract->start_date)->format('Y-m-d') ?? '—' }}
                                —
                                {{ optional($contract->end_date)->format('Y-m-d') ?? '—' }}
                            </td>
                            <td>
                                @if($contract->file_path)
                                    <a href="{{ asset('storage/' . $contract->file_path) }}" target="_blank">
                                        {{ $contract->file_name ?? 'Open File' }}
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ optional($contract->creator)->name ?? 'System' }}</td>
                            <td>
                                <div class="d-flex" style="gap:8px;">
                                    <a href="{{ route('admin.investors.contracts.edit', [$investor->user_id, $contract->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                                    <form action="{{ route('admin.investors.contracts.destroy', [$investor->user_id, $contract->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this contract?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No contracts found for this investor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $contracts->links() }}
        </div>
    </div>
</div>
@endsection