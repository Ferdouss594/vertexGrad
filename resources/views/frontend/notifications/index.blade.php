@extends('frontend.layouts.app')

@section('title', __('frontend.notifications_page.title'))

@section('content')
<div class="min-h-screen bg-theme-bg text-theme-text pt-28 pb-10 transition-colors duration-300 overflow-hidden">
    <div class="{{ config('design.classes.container') }}">
        <div class="notifications-top flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-theme-text leading-tight">
                    <span class="text-brand-accent">{{ __('frontend.notifications_page.heading') }}</span>
                </h1>
                <p class="text-theme-muted text-sm mt-1">
                    {{ __('frontend.notifications_page.subtitle') }}
                </p>
            </div>

            <form method="POST" action="{{ route('frontend.notifications.markAllRead') }}">
                @csrf
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl px-5 py-3 font-bold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300">
                    {{ __('frontend.notifications_page.mark_all_read') }}
                </button>
            </form>
        </div>

        <div class="notifications-panel theme-panel rounded-3xl overflow-hidden shadow-brand-soft">
            @forelse($notifications as $n)
                @php
                    $title = $n->data['title'] ?? __('frontend.notifications_page.notification_fallback');
                    $message = $n->data['message'] ?? '';
                    $url = $n->data['url'] ?? null;
                    $icon = $n->data['icon'] ?? 'fas fa-bell';
                    $isRead = !is_null($n->read_at);
                @endphp

                <div class="notification-item p-4 sm:p-5 border-b border-theme-border last:border-b-0 {{ $isRead ? 'opacity-70' : 'bg-brand-accent-soft/40' }}">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div class="text-brand-accent mt-1 shrink-0">
                                <i class="{{ $icon }}"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="font-bold text-theme-text break-words">{{ $title }}</p>
                                <p class="text-sm text-theme-muted mt-1 break-words">{{ $message }}</p>
                                <p class="text-xs text-theme-muted/80 mt-2">
                                    {{ $n->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col xs:flex-row sm:flex-row items-stretch sm:items-center gap-2 shrink-0">
                            @if($url)
                                <form method="POST" action="{{ route('frontend.notifications.read', $n->id) }}">
                                    @csrf
                                    <input type="hidden" name="redirect" value="{{ $url }}">
                                    <button type="submit"
                                            class="w-full sm:w-auto px-3 py-2 rounded-xl bg-brand-accent text-white text-xs font-bold hover:bg-brand-accent-strong transition">
                                        {{ __('frontend.notifications_page.open') }}
                                    </button>
                                </form>
                            @endif

                            @if(!$isRead)
                                <form method="POST" action="{{ route('frontend.notifications.read', $n->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full sm:w-auto px-3 py-2 rounded-xl bg-theme-surface-2 text-theme-text text-xs font-bold hover:bg-brand-accent-soft transition border border-theme-border">
                                        {{ __('frontend.notifications_page.mark_read') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="notifications-empty p-10 text-center text-theme-muted">
                    {{ __('frontend.notifications_page.empty') }}
                </div>
            @endforelse
        </div>

        <div class="notifications-pagination mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-notifications-style')) {
        const style = document.createElement('style');
        style.id = 'vg-notifications-style';
        style.innerHTML = `
            @keyframes vgSpin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .vg-progress-line {
                position: fixed;
                top: 0;
                inset-inline-start: 0;
                height: 3px;
                width: 0%;
                z-index: 9999;
                pointer-events: none;
                background: linear-gradient(90deg, rgba(0,224,255,0.98), rgba(34,197,94,0.98));
                box-shadow: 0 0 18px rgba(0,224,255,0.28);
                transition: width 0.08s linear;
            }

            .vg-notification-reveal {
                opacity: 0;
                transform: translateY(22px);
                transition: opacity .75s ease, transform .75s cubic-bezier(.22,1,.36,1);
            }

            .vg-notification-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .notification-item {
                transition: transform .28s ease, background-color .28s ease, box-shadow .28s ease;
            }

            .notification-item:hover {
                transform: translateX(4px);
                box-shadow: 0 14px 32px rgba(0,0,0,0.06);
            }

            html[dir="rtl"] .notification-item:hover {
                transform: translateX(-4px);
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(0,224,255,.16);
                border-radius: 12px;
            }

            @media (max-width: 640px) {
                .notification-item:hover,
                html[dir="rtl"] .notification-item:hover {
                    transform: none;
                    box-shadow: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-progress-line,
                .vg-notification-reveal,
                .notification-item {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    const progress = document.createElement('div');
    progress.className = 'vg-progress-line';
    document.body.appendChild(progress);

    function updateProgress() {
        const scrollTop = window.scrollY || window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const percent = docHeight > 0 ? Math.min((scrollTop / docHeight) * 100, 100) : 0;
        progress.style.width = percent + '%';
    }

    updateProgress();
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);

    [
        document.querySelector('.notifications-top'),
        document.querySelector('.notifications-panel'),
        document.querySelector('.notifications-empty'),
        document.querySelector('.notifications-pagination')
    ].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-notification-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 100 + (index * 120));
    });

    document.querySelectorAll('.notification-item').forEach((item, index) => {
        item.classList.add('vg-notification-reveal');

        if (prefersReducedMotion) {
            item.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            item.classList.add('is-visible');
        }, 340 + (index * 75));
    });

    if (!prefersReducedMotion) {
        document.querySelectorAll('.bg-brand-accent-soft\\/40').forEach((item, index) => {
            setTimeout(() => {
                item.animate(
                    [
                        { boxShadow: '0 0 0 rgba(0,224,255,0)' },
                        { boxShadow: '0 0 0 10px rgba(0,224,255,0.06)' },
                        { boxShadow: '0 0 0 rgba(0,224,255,0)' }
                    ],
                    {
                        duration: 1400,
                        easing: 'ease-out',
                        iterations: 1
                    }
                );
            }, 900 + (index * 120));
        });
    }

    document.querySelectorAll('form').forEach(form => {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        submitBtn.classList.add('vg-focus-ring');

        if (!submitBtn.dataset.originalHtml) {
            submitBtn.dataset.originalHtml = submitBtn.innerHTML;
        }

        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.style.pointerEvents = 'none';
            submitBtn.style.opacity = '0.92';

            const isMarkAll = form.action.includes('markAllRead');
            const label = isMarkAll ? 'Processing...' : 'Opening...';

            submitBtn.innerHTML = `
                <span style="display:inline-flex;align-items:center;gap:10px;">
                    <span style="
                        width:16px;
                        height:16px;
                        border:2px solid rgba(255,255,255,0.45);
                        border-top-color:${isMarkAll ? 'currentColor' : '#ffffff'};
                        border-radius:50%;
                        display:inline-block;
                        animation: vgSpin .7s linear infinite;
                    "></span>
                    ${label}
                </span>
            `;
        });
    });

    window.addEventListener('pageshow', function () {
        document.querySelectorAll('form button[type="submit"]').forEach(btn => {
            if (btn.dataset.originalHtml) {
                btn.disabled = false;
                btn.style.pointerEvents = '';
                btn.style.opacity = '';
                btn.innerHTML = btn.dataset.originalHtml;
            }
        });
    });

    document.querySelectorAll('a, button').forEach(el => {
        el.classList.add('vg-focus-ring');
    });
});
</script>
@endsection