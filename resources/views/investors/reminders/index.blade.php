@extends('layouts.app')

@section('title', 'Investor Reminders')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="gap:12px;">
            <div>
                <h4 class="mb-1">{{ $investor->user?->name ?? 'Investor Reminders' }}</h4>
                <p class="text-muted mb-0">Manage reminders, follow-ups, and contract alerts for this investor.</p>
            </div>

            <div class="d-flex" style="gap:10px;">
                <a href="{{ route('admin.investors.show', $investor->user_id) }}" class="btn btn-light border">Back</a>
                <a href="{{ route('admin.investors.reminders.create', $investor->id) }}" class="btn btn-primary">New Reminder</a>
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
                        <th>Remind At</th>
                        <th>Delivery</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reminders as $reminder)
                        <tr>
                            <td>{{ $loop->iteration + ($reminders->currentPage() - 1) * $reminders->perPage() }}</td>
                            <td>{{ $reminder->title }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $reminder->type)) }}</td>
                            <td>{{ ucfirst($reminder->status) }}</td>
                            <td>{{ optional($reminder->remind_at)->format('Y-m-d h:i A') }}</td>
                            <td>
                                In-App: {{ $reminder->send_in_app ? 'Yes' : 'No' }}<br>
                                Email: {{ $reminder->send_email ? 'Yes' : 'No' }}
                            </td>
                            <td>{{ optional($reminder->creator)->name ?? 'System' }}</td>
                            <td>
                                <div class="d-flex" style="gap:8px;">
                                    <a href="{{ route('admin.investors.reminders.edit', [$investor->id, $reminder->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                                    <form action="{{ route('admin.investors.reminders.destroy', [$investor->id, $reminder->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this reminder?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No reminders found for this investor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reminders->links() }}
        </div>
    </div>
</div>
@endsection