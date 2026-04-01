@extends('frontend.layouts.app')

@section('title', __('frontend.notifications_page.title'))

@section('content')
<div class="min-h-screen bg-theme-bg text-theme-text pt-28 pb-10 transition-colors duration-300">
    <div class="{{ config('design.classes.container') }}">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-theme-text">
                    <span class="text-brand-accent">{{ __('frontend.notifications_page.heading') }}</span>
                </h1>
                <p class="text-theme-muted text-sm mt-1">
                    {{ __('frontend.notifications_page.subtitle') }}
                </p>
            </div>

            <form method="POST" action="{{ route('frontend.notifications.markAllRead') }}">
                @csrf
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg px-5 py-3 font-semibold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300">
                    {{ __('frontend.notifications_page.mark_all_read') }}
                </button>
            </form>
        </div>

        <div class="theme-panel rounded-3xl overflow-hidden shadow-brand-soft">
            @forelse($notifications as $n)
                @php
                    $title = $n->data['title'] ?? __('frontend.notifications_page.notification_fallback');
                    $message = $n->data['message'] ?? '';
                    $url = $n->data['url'] ?? null;
                    $icon = $n->data['icon'] ?? 'fas fa-bell';
                    $isRead = !is_null($n->read_at);
                @endphp

                <div class="p-5 border-b border-theme-border last:border-b-0 {{ $isRead ? 'opacity-70' : 'bg-brand-accent-soft/40' }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div class="text-brand-accent mt-1">
                                <i class="{{ $icon }}"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="font-bold text-theme-text">{{ $title }}</p>
                                <p class="text-sm text-theme-muted mt-1">{{ $message }}</p>
                                <p class="text-xs text-theme-muted/80 mt-2">
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
                                            class="px-3 py-2 rounded-lg bg-brand-accent text-white text-xs font-bold hover:bg-brand-accent-strong transition">
                                        {{ __('frontend.notifications_page.open') }}
                                    </button>
                                </form>
                            @endif

                            @if(!$isRead)
                                <form method="POST" action="{{ route('frontend.notifications.read', $n->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-2 rounded-lg bg-theme-surface-2 text-theme-text text-xs font-bold hover:bg-brand-accent-soft transition border border-theme-border">
                                        {{ __('frontend.notifications_page.mark_read') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-theme-muted">
                    {{ __('frontend.notifications_page.empty') }}
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection