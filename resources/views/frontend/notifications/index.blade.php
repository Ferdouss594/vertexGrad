@extends('frontend.layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="min-h-screen bg-cardDark text-light pt-28 pb-10">
    <div class="{{ config('design.classes.container') }}">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-primary">Notifications</h1>
                <p class="text-light/60 text-sm mt-1">View all your recent updates and project alerts.</p>
            </div>

            <form method="POST" action="{{ route('frontend.notifications.markAllRead') }}">
                @csrf
                <button type="submit"
                        class="{{ config('design.classes.btn_base') }} {{ config('design.classes.btn_secondary') }}">
                    Mark All Read
                </button>
            </form>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            @forelse($notifications as $n)
                @php
                    $title = $n->data['title'] ?? 'Notification';
                    $message = $n->data['message'] ?? '';
                    $url = $n->data['url'] ?? null;
                    $icon = $n->data['icon'] ?? 'fas fa-bell';
                    $isRead = !is_null($n->read_at);
                @endphp

                <div class="p-4 border-b border-white/10 {{ $isRead ? 'opacity-60' : 'bg-white/5' }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div class="text-primary mt-1">
                                <i class="{{ $icon }}"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="font-bold text-light">{{ $title }}</p>
                                <p class="text-sm text-light/70 mt-1">{{ $message }}</p>
                                <p class="text-xs text-light/40 mt-2">
                                    {{ $n->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            @if($url)
                                <form method="POST" action="{{ route('frontend.notifications.read', $n->id) }}">
                                    @csrf
                                    <input type="hidden" name="redirect" value="{{ $url }}">
                                    <button type="submit"
                                            class="px-3 py-2 rounded-lg bg-primary text-dark text-xs font-bold hover:opacity-90 transition">
                                        Open
                                    </button>
                                </form>
                            @endif

                            @if(!$isRead)
                                <form method="POST" action="{{ route('frontend.notifications.read', $n->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-2 rounded-lg bg-white/10 text-light text-xs font-bold hover:bg-white/20 transition">
                                        Mark Read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-light/40">
                    No notifications yet.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection