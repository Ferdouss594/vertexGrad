@extends('layouts.app')

@section('title','Notifications')

@section('content')
<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h2 class="mb-0">Notifications</h2>
    <form method="POST" action="{{ route('admin.notifications.read', $n->id) }}">
      @csrf
      <button class="btn btn-sm btn-primary">Mark read</button>
    </form>
  </div>

  <div class="card">
    <div class="card-body p-0">
      @forelse($notifications as $n)
        <div class="p-3 border-bottom {{ $n->read_at ? 'text-muted' : '' }}">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="fw-bold">{{ $n->data['title'] ?? 'Notification' }}</div>
              <div class="small">
                {{ $n->data['message'] ?? '' }}
              </div>
              <div class="text-muted small mt-1">{{ $n->created_at->diffForHumans() }}</div>
            </div>

            <div class="d-flex gap-2">
              @if(!empty($n->data['url']))
                <a href="{{ $n->data['url'] }}" class="btn btn-sm btn-secondary">Open</a>
              @endif

              @if(!$n->read_at)
              <form method="POST" action="{{ route('admin.notifications.read', $n->id) }}">
                @csrf
                <button class="btn btn-sm btn-primary">Mark read</button>
              </form>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="p-4">No notifications.</div>
      @endforelse
    </div>
  </div>

  <div class="mt-3">
    {{ $notifications->links() }}
  </div>
</div>
@endsection