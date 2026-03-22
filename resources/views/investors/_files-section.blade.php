<div class="section-card h-100">
    <div class="section-header">
        <i class="fa fa-sticky-note"></i> Notes
    </div>

    <div class="section-body">
        <form action="{{ route('admin.investors.notes.store', $investor->user_id) }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
                <label class="form-label" style="font-weight:700;">Add Note</label>
                <textarea name="note" rows="4" class="form-control" placeholder="Write a note about this investor..." style="border-radius: 12px;">{{ old('note') }}</textarea>
                @error('note')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="border-radius: 12px; font-weight: 700;">
                <i class="fa fa-plus mr-1"></i> Add Note
            </button>
        </form>

        @if($investor->notes->count() > 0)
            <ul class="list-clean">
                @foreach($investor->notes as $note)
                    <li>
                        <div class="d-flex justify-content-between align-items-start" style="gap: 10px;">
                            <div class="flex-grow-1">
                                <div class="record-title">{{ $note->user?->name ?? 'Unknown User' }}</div>
                                <div class="record-meta">{{ $note->created_at?->format('Y-m-d h:i A') }}</div>
                                <div class="record-text">{{ $note->note }}</div>
                            </div>

                            <form action="{{ route('admin.investors.notes.delete', [$investor->user_id, $note->id]) }}" method="POST" onsubmit="return confirm('Delete this note?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light" style="border-radius: 10px; border: 1px solid #e2e8f0;">
                                    <i class="fa fa-trash text-danger"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-state">
                <i class="fa fa-sticky-note"></i>
                <div>No notes available.</div>
            </div>
        @endif
    </div>
</div>