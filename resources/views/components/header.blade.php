@php
    $transitionBase = config('design.classes.transition_base');
    $user = auth('web')->user();
    $isLoggedIn = auth('web')->check();

    if ($user) {
        if ($user->role === 'Investor') {
            $navLinks = [
                ['href' => route('frontend.projects.index'), 'label' => __('frontend.header.marketplace')],
                ['href' => route('home') . '#advantage', 'label' => __('frontend.header.why_vertexgrad')],
            ];
        } else {
            $navLinks = [
                ['href' => route('project.submit.step1'), 'label' => __('frontend.header.submit_project')],
                ['href' => route('home') . '#advantage', 'label' => __('frontend.header.why_vertexgrad')],
            ];
        }
    } else {
        $navLinks = [
            ['href' => route('frontend.projects.index'), 'label' => __('frontend.header.browse_projects')],
            ['href' => route('home') . '#advantage', 'label' => __('frontend.header.why_vertexgrad')],
            ['href' => route('utility.support'), 'label' => __('frontend.header.help_center')],
        ];
    }

    $currentLocale = app()->getLocale();
    $nextLocale = $currentLocale === 'ar' ? 'en' : 'ar';
    $languageLabel = $currentLocale === 'ar' ? 'English' : 'العربية';
@endphp

<style>
    img.brand-logo {
        width: 2.5rem !important;
        height: 2.5rem !important;
        min-width: 2.5rem !important;
        min-height: 2.5rem !important;
        max-width: 2.5rem !important;
        max-height: 2.5rem !important;
        object-fit: contain !important;
        flex-shrink: 0 !important;
        display: block !important;
        transition: filter 0.3s ease, opacity 0.3s ease, transform 0.3s ease;
    }

    [data-theme="dark"] img.brand-logo,
    [data-theme="brand"] img.brand-logo {
        filter: brightness(0) invert(1) sepia(1) saturate(5) hue-rotate(180deg);
        opacity: 0.9;
        transform: scale(1.02);
    }

    [data-theme="light"] img.brand-logo {
        filter: none;
        opacity: 1;
        transform: scale(1);
    }

    img.brand-logo:hover {
        transform: scale(1.08) !important;
    }

    [x-cloak] {
        display: none !important;
    }
    .vg-mobile-header-actions {
    display: flex;
}
.vg-header-nav-link::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: -8px;
    width: 0;
    height: 2px;
    background: var(--brand-accent);
    transform: translateX(-50%);
    transition: width 0.25s ease;
    border-radius: 999px;
}

@media (hover: hover) and (pointer: fine) {
    .vg-header-nav-link:hover::after {
        width: 100%;
    }
}

@media (hover: none) {
    .vg-header-nav-link::after {
        display: none;
    }
}

@media (min-width: 1024px) {
    .vg-mobile-header-actions {
        display: none !important;
    }
}
    @media (max-width: 640px) {
        img.brand-logo {
            width: 2.25rem !important;
            height: 2.25rem !important;
            min-width: 2.25rem !important;
            min-height: 2.25rem !important;
            max-width: 2.25rem !important;
            max-height: 2.25rem !important;
        }
    }
</style>

<header
    class="w-full fixed top-0 inset-x-0 z-50 border-b header-shell transition-colors duration-300"
    x-data="{ mobileOpen: false }"
>
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-2 sm:gap-3 lg:gap-5">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 shrink-0 min-w-0 max-w-[190px] sm:max-w-[260px] lg:max-w-none">
            <img
                src="{{ config('design.brand.logo') ? asset(config('design.brand.logo')) : asset('images/logo.png') }}"
                alt="{{ config('design.brand.name', 'VertexGrad') }}"
                class="brand-logo"
            >
            <span class="font-extrabold text-lg sm:text-xl lg:text-2xl tracking-tight text-brand-accent whitespace-nowrap truncate">
                {{ config('design.brand.name', 'VertexGrad') }}
            </span>
        </a>

        {{-- DESKTOP NAV --}}
        <nav class="hidden lg:flex items-center justify-center gap-6 xl:gap-8 min-w-0 flex-1">
            @foreach($navLinks as $link)
  <a href="{{ $link['href'] }}"
   class="vg-header-nav-link {{ $transitionBase }} text-theme-text hover-text-brand-accent relative uppercase text-[11px] tracking-[0.16em] font-bold whitespace-nowrap">
    {{ $link['label'] }}
</a>
            @endforeach
        </nav>

        {{-- DESKTOP ACTIONS --}}
        <div class="hidden lg:flex items-center gap-2 xl:gap-3 shrink-0">

            {{-- THEME SWITCHER --}}
            <div
                class="relative"
                x-data="{
                    open: false,
                    currentTheme: localStorage.getItem('vertexgrad_theme') || '{{ config('design.default_theme', 'brand') }}',
                    setTheme(theme) {
                        this.currentTheme = theme;
                        window.VertexGradUI.applyTheme(theme);
                        this.open = false;
                    }
                }"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="h-10 px-3 xl:px-4 rounded-xl border border-theme-border bg-theme-surface text-theme-text hover-border-brand-accent hover-text-brand-accent transition-all text-[11px] font-black uppercase tracking-widest shadow-brand-soft whitespace-nowrap"
                >
                    {{ __('frontend.header.theme') }}
                </button>

                <div
                    x-show="open"
                    x-cloak
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute end-0 top-12 w-56 rounded-2xl border border-theme-border bg-theme-surface shadow-2xl overflow-hidden z-[9999]"
                >
                    <button
                        type="button"
                        @click="setTheme('brand')"
                        class="w-full flex items-center justify-between gap-3 px-4 py-3 text-start hover:bg-brand-accent-soft transition"
                    >
                        <span class="text-sm font-semibold text-theme-text">{{ __('frontend.header.vertexgrad_theme') }}</span>
                        <span class="w-4 h-4 rounded-full border border-cyan-400 bg-cyan-400 shrink-0"></span>
                    </button>

                    <button
                        type="button"
                        @click="setTheme('dark')"
                        class="w-full flex items-center justify-between gap-3 px-4 py-3 text-start hover:bg-brand-accent-soft transition border-t border-theme-border"
                    >
                        <span class="text-sm font-semibold text-theme-text">{{ __('frontend.header.dark_theme') }}</span>
                        <span class="w-4 h-4 rounded-full border border-slate-500 bg-slate-950 shrink-0"></span>
                    </button>

                    <button
                        type="button"
                        @click="setTheme('light')"
                        class="w-full flex items-center justify-between gap-3 px-4 py-3 text-start hover:bg-brand-accent-soft transition border-t border-theme-border"
                    >
                        <span class="text-sm font-semibold text-theme-text">{{ __('frontend.header.light_theme') }}</span>
                        <span class="w-4 h-4 rounded-full border border-slate-300 bg-white shrink-0"></span>
                    </button>
                </div>
            </div>

            {{-- LANGUAGE SWITCHER --}}
            <a
                href="{{ route('frontend.language.switch', $nextLocale) }}"
                class="h-10 px-3 xl:px-4 rounded-xl border border-theme-border bg-theme-surface text-theme-text hover-border-brand-accent hover-text-brand-accent transition-all text-[11px] font-black uppercase tracking-widest shadow-brand-soft inline-flex items-center justify-center whitespace-nowrap"
            >
                {{ $languageLabel }}
            </a>

            @guest('web')
                <a href="{{ route('login.show') }}"
                   class="text-theme-muted hover-text-brand-accent text-xs font-bold uppercase tracking-widest {{ $transitionBase }} whitespace-nowrap">
                    {{ __('frontend.header.sign_in') }}
                </a>

                <a href="{{ route('frontend.projects.index') }}"
                   class="inline-flex items-center justify-center rounded-xl px-4 xl:px-6 py-3 text-xs font-extrabold bg-brand-accent text-white hover-bg-brand-accent-strong transition-all shadow-brand-soft whitespace-nowrap">
                    {{ __('frontend.header.browse_opportunities') }}
                </a>
            @endguest

            @auth('web')
                @php
                    $isInvestor = $user->role === 'Investor';
                    $dashboardRoute = $isInvestor ? route('dashboard.investor') : route('dashboard.academic');

                    $initialUnread = $user->unreadNotifications()->count();
                    $latestNotifications = $user->notifications()->latest()->take(5)->get();
                @endphp

                {{-- NOTIFICATIONS --}}
                <div
                    id="frontend-notification-bell"
                    class="relative flex items-center"
                    x-data="{ open:false }"
                    data-latest-url="{{ route('frontend.notifications.latest') }}"
                >
                    <button type="button"
                            @click="open = !open"
                            class="relative flex items-center justify-center w-10 h-10 rounded-full bg-brand-accent-soft border border-theme-border text-brand-accent hover:bg-brand-accent hover:text-white transition-all focus:outline-none shadow-brand-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[17px] h-[17px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />
                        </svg>

                        <span
                            id="frontendUnreadBadge"
                            class="absolute -top-1 -end-1 {{ $initialUnread > 0 ? 'flex' : 'hidden' }} h-4 min-w-[16px] px-1 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white shadow"
                        >
                            {{ $initialUnread > 9 ? '9+' : $initialUnread }}
                        </span>
                    </button>

                    <div x-show="open"
                         x-cloak
                         @click.away="open=false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute end-0 top-12 w-[calc(100vw-2rem)] max-w-80 bg-theme-surface border border-theme-border rounded-2xl shadow-2xl z-[9999] overflow-hidden">

                        <div class="p-4 border-b border-theme-border bg-brand-accent-soft flex justify-between items-center gap-3">
                            <h3 class="text-xs font-black uppercase tracking-widest text-brand-accent">
                                {{ __('frontend.header.alerts') }}
                            </h3>
                            <span class="text-[10px] text-theme-muted whitespace-nowrap">
                                <span id="frontendUnreadText">{{ $initialUnread }}</span> {{ __('frontend.header.unread') }}
                            </span>
                        </div>

                        <div id="frontendNotificationList" class="max-h-80 overflow-y-auto">
                            @forelse($latestNotifications as $n)
                                @php
                                    $title = $n->data['title'] ?? __('frontend.header.notification');
                                    $message = $n->data['message'] ?? '';
                                    $url = $n->data['url'] ?? null;
                                    $icon = $n->data['icon'] ?? 'fas fa-circle';
                                @endphp

                                <form method="POST"
                                      action="{{ route('frontend.notifications.read', $n->id) }}"
                                      class="block">
                                    @csrf
                                    <input type="hidden" name="redirect" value="{{ $url }}">

                                    <button type="submit"
                                            class="w-full text-start block p-4 border-b border-theme-border hover:bg-brand-accent-soft transition {{ $n->read_at ? 'opacity-50' : '' }}">
                                        <div class="flex gap-3">
                                            <div class="text-brand-accent mt-1 shrink-0">
                                                <i class="{{ $icon }} text-xs"></i>
                                            </div>

                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-theme-text truncate">{{ $title }}</p>
                                                <p class="text-[10px] text-theme-muted mt-0.5 line-clamp-2">
                                                    {{ $message }}
                                                </p>
                                                <p class="text-[10px] text-theme-muted/80 mt-1">
                                                    {{ $n->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @empty
                                <div class="p-8 text-center text-theme-muted text-xs italic">
                                    {{ __('frontend.header.no_alerts') }}
                                </div>
                            @endforelse
                        </div>

                        <div class="grid grid-cols-2 border-t border-theme-border bg-brand-accent-soft">
                            <a href="{{ route('frontend.notifications.index') }}"
                               class="p-3 text-center text-[10px] font-black text-theme-muted hover-text-brand-accent transition border-e border-theme-border">
                                {{ __('frontend.header.view_all') }}
                            </a>
                            <form method="POST" action="{{ route('frontend.notifications.markAllRead') }}">
                                @csrf
                                <button type="submit" class="p-3 w-full text-center text-[10px] font-black text-brand-accent hover:text-theme-text transition">
                                    {{ __('frontend.header.mark_all_read') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <a href="{{ $dashboardRoute }}"
                   class="px-4 xl:px-5 py-2.5 bg-theme-surface border border-theme-border rounded-xl text-theme-text hover:bg-brand-accent hover:text-white font-black uppercase text-[10px] tracking-widest transition-all shadow-brand-soft whitespace-nowrap">
                    {{ __('frontend.header.dashboard') }}
                </a>

                <div class="flex items-center gap-2 xl:gap-3 ms-2 xl:ms-3 ps-2 xl:ps-3 border-s border-theme-border">
                    <div title="{{ $user->role }}" class="shrink-0">
                        @if(!empty($user->profile_image))
                            <img
                                src="{{ asset('storage/' . $user->profile_image) }}"
                                alt="{{ $user->name }}"
                                class="w-10 h-10 rounded-full object-cover border border-brand-accent/30 shadow-brand-soft"
                            >
                        @else
                            <div class="w-10 h-10 rounded-full bg-brand-accent-soft border border-brand-accent text-brand-accent flex items-center justify-center font-black text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('frontend.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-3 xl:px-4 py-2 rounded-xl border border-red-400/30 text-red-400 hover:bg-red-500 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest whitespace-nowrap">
                            {{ __('frontend.header.logout') }}
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        {{-- TABLET / MOBILE ACTIONS --}}
        <div class="vg-mobile-header-actions flex items-center gap-2 shrink-0">
            <a
                href="{{ route('frontend.language.switch', $nextLocale) }}"
                class="hidden sm:inline-flex min-w-[74px] h-10 px-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text items-center justify-center shadow-brand-soft text-[11px] font-black uppercase tracking-widest hover-border-brand-accent hover-text-brand-accent transition-all"
            >
                {{ $languageLabel }}
            </a>

            <div
                class="relative hidden sm:block"
                x-data="{
                    open: false,
                    setTheme(theme) {
                        window.VertexGradUI.applyTheme(theme);
                        this.open = false;
                    }
                }"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="w-10 h-10 rounded-xl border border-theme-border bg-theme-surface text-theme-text flex items-center justify-center shadow-brand-soft"
                    aria-label="{{ __('frontend.header.theme') }}"
                >
                    <i class="fas fa-palette text-sm"></i>
                </button>

                <div
                    x-show="open"
                    x-cloak
                    @click.away="open = false"
                    x-transition
                    class="absolute end-0 top-12 w-44 rounded-2xl border border-theme-border bg-theme-surface shadow-2xl overflow-hidden z-[9999]"
                >
                    <button type="button" @click="setTheme('brand')" class="w-full px-4 py-3 text-start text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition">
                        {{ __('frontend.header.vertexgrad_theme') }}
                    </button>
                    <button type="button" @click="setTheme('dark')" class="w-full px-4 py-3 text-start text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition border-t border-theme-border">
                        {{ __('frontend.header.dark_theme') }}
                    </button>
                    <button type="button" @click="setTheme('light')" class="w-full px-4 py-3 text-start text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition border-t border-theme-border">
                        {{ __('frontend.header.light_theme') }}
                    </button>
                </div>
            </div>

            <button
                type="button"
                @click="mobileOpen = !mobileOpen"
                class="w-10 h-10 rounded-xl border border-theme-border bg-theme-surface text-theme-text flex items-center justify-center shadow-brand-soft hover-border-brand-accent hover-text-brand-accent transition-all"
                :aria-expanded="mobileOpen.toString()"
                aria-label="Toggle navigation"
            >
                <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-theme-text" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>

                <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-theme-text" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div
        x-show="mobileOpen"
        x-cloak
        x-transition
        @click.away="mobileOpen = false"
        class="lg:hidden border-t border-theme-border bg-theme-surface/95 backdrop-blur-xl shadow-2xl"
    >
        <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 py-4 space-y-4 max-h-[calc(100vh-5rem)] overflow-y-auto">

            <nav class="grid gap-2">
                @foreach($navLinks as $link)
                    <a
                        href="{{ $link['href'] }}"
                        @click="mobileOpen = false"
                        class="px-4 py-3 rounded-2xl border border-theme-border bg-theme-bg/40 text-theme-text hover:bg-brand-accent hover:text-white transition-all text-xs font-black uppercase tracking-widest break-words"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="grid grid-cols-2 gap-2">
                <a
                    href="{{ route('frontend.language.switch', $nextLocale) }}"
                    class="h-11 px-4 rounded-2xl border border-theme-border bg-theme-bg/40 text-theme-text flex items-center justify-center shadow-brand-soft text-[11px] font-black uppercase tracking-widest hover-border-brand-accent hover-text-brand-accent transition-all"
                >
                    {{ $languageLabel }}
                </a>

                <div
                    class="relative"
                    x-data="{
                        open: false,
                        setTheme(theme) {
                            window.VertexGradUI.applyTheme(theme);
                            this.open = false;
                        }
                    }"
                >
                    <button
                        type="button"
                        @click="open = !open"
                        class="w-full h-11 rounded-2xl border border-theme-border bg-theme-bg/40 text-theme-text flex items-center justify-center gap-2 shadow-brand-soft text-[11px] font-black uppercase tracking-widest"
                    >
                        <i class="fas fa-palette text-sm"></i>
                        <span>{{ __('frontend.header.theme') }}</span>
                    </button>

                    <div
                        x-show="open"
                        x-cloak
                        @click.away="open = false"
                        x-transition
                        class="absolute end-0 top-12 w-52 rounded-2xl border border-theme-border bg-theme-surface shadow-2xl overflow-hidden z-[9999]"
                    >
                        <button type="button" @click="setTheme('brand')" class="w-full px-4 py-3 text-start text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition">
                            {{ __('frontend.header.vertexgrad_theme') }}
                        </button>
                        <button type="button" @click="setTheme('dark')" class="w-full px-4 py-3 text-start text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition border-t border-theme-border">
                            {{ __('frontend.header.dark_theme') }}
                        </button>
                        <button type="button" @click="setTheme('light')" class="w-full px-4 py-3 text-start text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition border-t border-theme-border">
                            {{ __('frontend.header.light_theme') }}
                        </button>
                    </div>
                </div>
            </div>

            @guest('web')
                <div class="grid gap-2">
                    <a
                        href="{{ route('login.show') }}"
                        class="h-11 rounded-2xl border border-theme-border bg-theme-bg/40 text-theme-text flex items-center justify-center text-xs font-black uppercase tracking-widest hover-border-brand-accent hover-text-brand-accent transition-all"
                    >
                        {{ __('frontend.header.sign_in') }}
                    </a>

                    <a
                        href="{{ route('frontend.projects.index') }}"
                        class="h-12 rounded-2xl bg-brand-accent text-white flex items-center justify-center text-xs font-black uppercase tracking-widest hover-bg-brand-accent-strong transition-all shadow-brand-soft text-center px-4"
                    >
                        {{ __('frontend.header.browse_opportunities') }}
                    </a>
                </div>
            @endguest

            @auth('web')
                <div class="grid gap-2">
                    <a
                        href="{{ $dashboardRoute }}"
                        class="h-11 rounded-2xl border border-theme-border bg-theme-bg/40 text-theme-text flex items-center justify-center text-xs font-black uppercase tracking-widest hover:bg-brand-accent hover:text-white transition-all"
                    >
                        {{ __('frontend.header.dashboard') }}
                    </a>

                    <a
                        href="{{ route('frontend.notifications.index') }}"
                        class="h-11 rounded-2xl border border-theme-border bg-theme-bg/40 text-theme-text flex items-center justify-center text-xs font-black uppercase tracking-widest hover-border-brand-accent hover-text-brand-accent transition-all"
                    >
                        {{ __('frontend.header.alerts') }}
                        @if($initialUnread > 0)
                            <span class="ms-2 inline-flex h-5 min-w-[20px] px-1 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white">
                                {{ $initialUnread > 9 ? '9+' : $initialUnread }}
                            </span>
                        @endif
                    </a>

                    <form action="{{ route('frontend.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full h-11 rounded-2xl border border-red-400/30 text-red-400 hover:bg-red-500 hover:text-white transition-all text-xs font-black uppercase tracking-widest">
                            {{ __('frontend.header.logout') }}
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</header>

<script>
(function () {
    function initVertexHeader() {
        const header = document.querySelector('header.header-shell');
        if (!header) return;

        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (!document.getElementById('vg-shell-motion-style')) {
            const style = document.createElement('style');
            style.id = 'vg-shell-motion-style';
            style.innerHTML = `
                .vg-header-ready {
                    opacity: 1 !important;
                    transform: translateY(0) !important;
                }

                .vg-footer-ready {
                    opacity: 1 !important;
                    transform: translateY(0) !important;
                }

                .vg-header-focus:focus-visible {
                    outline: none;
                    box-shadow: 0 0 0 3px rgba(0,224,255,.16);
                    border-radius: 12px;
                }
            `;
            document.head.appendChild(style);
        }

        if (!prefersReducedMotion) {
            header.style.opacity = '0';
            header.style.transform = 'translateY(-22px)';
            header.style.transition = 'opacity 1s ease, transform 1s cubic-bezier(0.22, 1, 0.36, 1)';

            requestAnimationFrame(() => {
                setTimeout(() => {
                    header.classList.add('vg-header-ready');
                }, 120);
            });
        }

        function updateHeaderState() {
            const y = window.scrollY || window.pageYOffset;

            if (y > 12) {
                header.style.backdropFilter = 'blur(14px)';
                header.style.webkitBackdropFilter = 'blur(14px)';
                header.style.boxShadow = '0 14px 32px rgba(0,0,0,0.10)';
            } else {
                header.style.backdropFilter = '';
                header.style.webkitBackdropFilter = '';
                header.style.boxShadow = '';
            }
        }

        updateHeaderState();
        window.addEventListener('scroll', updateHeaderState, { passive: true });

        const navLinks = header.querySelectorAll('nav a');
        navLinks.forEach(link => {
            link.classList.add('vg-header-focus');
            link.style.transition = 'transform 0.28s ease, color 0.28s ease';

            link.addEventListener('mouseenter', function () {
                if (prefersReducedMotion) return;
                link.style.transform = 'translateY(-2px)';
            });

            link.addEventListener('mouseleave', function () {
                link.style.transform = '';
            });
        });

        const actionButtons = header.querySelectorAll('a, button');
        actionButtons.forEach(el => {
            el.classList.add('vg-header-focus');

            if (el.closest('nav')) return;

            el.style.transition = 'transform 0.28s ease, box-shadow 0.28s ease';

            el.addEventListener('mouseenter', function () {
                if (prefersReducedMotion) return;
                el.style.transform = 'translateY(-2px)';
            });

            el.addEventListener('mouseleave', function () {
                el.style.transform = '';
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initVertexHeader);
    } else {
        initVertexHeader();
    }
})();
</script>