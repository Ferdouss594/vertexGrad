<div class="section-card h-100 investor-notes-card">
    <div class="section-header">
        <div class="title-wrap">
            <i class="fa fa-sticky-note"></i>
            <span>Notes</span>
        </div>
    </div>

    <div class="section-body">
        <form action="{{ route('admin.investors.notes.store', $investor->user_id) }}"
              method="POST"
              class="mb-4 investor-note-form"
              data-submit-text="Add Note"
              data-loading-text="Saving...">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Add Note</label>
                <textarea name="note"
                          rows="4"
                          class="form-control auto-resize"
                          placeholder="Write a note about this investor...">{{ old('note') }}</textarea>

                @error('note')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary-custom submit-btn">
                <i class="fa fa-plus mr-1"></i> Add Note
            </button>
        </form>

        @if($investor->notes->count() > 0)
            <ul class="list-clean">
                @foreach($investor->notes as $note)
                    <li class="record-item">
                        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 12px;">
                            <div class="flex-grow-1">
                                <div class="record-title">{{ $note->user?->name ?? 'Unknown User' }}</div>
                                <div class="record-meta">{{ $note->created_at?->format('Y-m-d h:i A') }}</div>
                                <div class="record-text">{{ $note->note }}</div>
                            </div>

                            <form action="{{ route('admin.investors.notes.delete', [$investor->user_id, $note->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this note?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="icon-delete-btn" title="Delete Note">
                                    <i class="fa fa-trash"></i>
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