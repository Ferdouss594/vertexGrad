@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen pt-28 pb-12" style="background:#0F172A;">
  <div class="max-w-5xl mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-white">Notifications</h1>
        <form method="POST" action="{{ route('frontend.notifications.markAllRead') }}">
        @csrf
<button type="submit"
        class="w-full text-left block p-4 border-b border-white/5 hover:bg-white/5 transition {{ $n->read_at ? 'opacity-50' : '' }}">
  <div class="flex gap-3">
    <div class="text-primary mt-1">
      <i class="{{ $icon }} text-xs"></i>
    </div>
    <div class="min-w-0">
      <p class="text-xs font-bold text-light truncate">{{ $title }}</p>
      <p class="text-[10px] text-light/60 mt-0.5 line-clamp-2">{{ $message }}</p>
      <p class="text-[10px] text-light/30 mt-1">{{ $n->created_at->diffForHumans() }}</p>
    </div>
  </div>
</button>
        </form>
    </div>

    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
      @forelse($notifications as $n)
        <div class="p-5 border-b border-white/10 {{ $n->read_at ? 'opacity-60' : '' }}">
          <div class="flex items-start justify-between gap-4">
            <div>
              <p class="text-white font-semibold">
                {{ $n->data['message'] ?? 'Notification' }}
              </p>
              <p class="text-white/60 text-sm mt-1">
                Project: {{ $n->data['project_name'] ?? '—' }}
                <span class="mx-2">•</span>
                {{ $n->created_at->diffForHumans() }}
              </p>
            </div>

            @if(!$n->read_at)
            <form method="POST" action="{{ route('frontend.notifications.read', $n->id) }}">
            @csrf
<button type="submit"
        class="w-full text-left block p-4 border-b border-white/5 hover:bg-white/5 transition {{ $n->read_at ? 'opacity-50' : '' }}">
  <div class="flex gap-3">
    <div class="text-primary mt-1">
      <i class="{{ $icon }} text-xs"></i>
    </div>
    <div class="min-w-0">
      <p class="text-xs font-bold text-light truncate">{{ $title }}</p>
      <p class="text-[10px] text-light/60 mt-0.5 line-clamp-2">{{ $message }}</p>
      <p class="text-[10px] text-light/30 mt-1">{{ $n->created_at->diffForHumans() }}</p>
    </div>
  </div>
</button>
            </form>
            @endif
          </div>
        </div>
      @empty
        <div class="p-8 text-white/60">No notifications.</div>
      @endforelse
    </div>

    <div class="mt-6">
      {{ $notifications->links() }}
    </div>
  </div>
</div>
@endsection