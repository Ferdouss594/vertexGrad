<div class="section-card h-100">
    <div class="section-header">
        <i class="fa fa-history"></i> Activities
    </div>

    <div class="section-body">
        @if($investor->activities->count() > 0)
            <ul class="list-clean">
                @foreach($investor->activities as $activity)
                    <li>
                        <div class="record-title">{{ $activity->user?->name ?? 'System' }}</div>
                        <div class="record-meta">{{ $activity->created_at?->format('Y-m-d h:i A') }}</div>
                        <div class="record-text">{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</div>

                        @if(!empty($activity->meta))
                            <div class="record-meta mt-1">
                                {{ is_array($activity->meta) ? json_encode($activity->meta) : $activity->meta }}
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-state">
                <i class="fa fa-history"></i>
                <div>No activities recorded.</div>
            </div>
        @endif
    </div>
</div>