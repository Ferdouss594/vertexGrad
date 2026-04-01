<header class="w-full fixed top-0 left-0 z-50 border-b header-shell transition-colors duration-300">
    <div class="{{ config('design.classes.container') }} flex items-center justify-between h-20">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
            <img src="{{ config('design.brand.logo') }}" alt="{{ config('design.brand.name') }}" class="w-10 h-10 object-contain">
            <span class="font-extrabold text-2xl tracking-tight text-brand-accent">
                {{ config('design.brand.name') }}
            </span>
        </a>

        {{-- DESKTOP NAV --}}
        <nav class="hidden md:flex items-center gap-8">
            @php
                $transitionBase = config('design.classes.transition_base');
                $user = auth('web')->user();

                $navLinks = [
                    ['href' => '#advantage', 'label' => __('frontend.header.why_vertexgrad')],
                    ['href' => route('utility.support'), 'label' => __('frontend.header.help_center')],
                ];

                if ($user) {
                    if ($user->role === 'Investor') {
                        array_unshift($navLinks, ['href' => route('frontend.projects.index'), 'label' => __('frontend.header.marketplace')]);
                    } else {
                        array_unshift($navLinks, ['href' => route('project.submit.step1'), 'label' => __('frontend.header.submit_project')]);
                    }
                } else {
                    array_unshift($navLinks, ['href' => route('frontend.projects.index'), 'label' => __('frontend.header.browse_projects')]);
                }

                $currentLocale = app()->getLocale();
                $nextLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                $languageLabel = $currentLocale === 'ar' ? 'English' : 'العربية';
            @endphp

            @foreach($navLinks as $link)
                <a href="{{ $link['href'] }}"
                   class="{{ $transitionBase }} text-theme-text hover-text-brand-accent relative group uppercase text-[11px] tracking-[0.18em] font-bold">
                    {{ $link['label'] }}
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-brand-accent transform scale-x-0 group-hover:scale-x-100 {{ $transitionBase }}"></span>
                </a>
            @endforeach
        </nav>

        {{-- DESKTOP ACTIONS --}}
        <div class="hidden md:flex items-center gap-3">
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
                    class="h-10 px-4 rounded-xl border border-theme-border bg-theme-surface text-theme-text hover-border-brand-accent hover-text-brand-accent transition-all text-[11px] font-black uppercase tracking-widest shadow-brand-soft"
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
                    style="display:none;"
                    class="absolute right-0 top-12 w-56 rounded-2xl border border-theme-border bg-theme-surface shadow-2xl overflow-hidden"
                >
                    <button
                        type="button"
                        @click="setTheme('brand')"
                        class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-brand-accent-soft transition"
                    >
                        <span class="text-sm font-semibold text-theme-text">{{ __('frontend.header.vertexgrad_theme') }}</span>
                        <span class="w-4 h-4 rounded-full border border-cyan-400 bg-cyan-400"></span>
                    </button>

                    <button
                        type="button"
                        @click="setTheme('dark')"
                        class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-brand-accent-soft transition border-t border-theme-border"
                    >
                        <span class="text-sm font-semibold text-theme-text">{{ __('frontend.header.dark_theme') }}</span>
                        <span class="w-4 h-4 rounded-full border border-slate-500 bg-slate-950"></span>
                    </button>

                    <button
                        type="button"
                        @click="setTheme('light')"
                        class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-brand-accent-soft transition border-t border-theme-border"
                    >
                        <span class="text-sm font-semibold text-theme-text">{{ __('frontend.header.light_theme') }}</span>
                        <span class="w-4 h-4 rounded-full border border-slate-300 bg-white"></span>
                    </button>
                </div>
            </div>

            {{-- LANGUAGE SWITCHER --}}
            <a
                href="{{ route('frontend.language.switch', $nextLocale) }}"
                class="h-10 px-4 rounded-xl border border-theme-border bg-theme-surface text-theme-text hover-border-brand-accent hover-text-brand-accent transition-all text-[11px] font-black uppercase tracking-widest shadow-brand-soft inline-flex items-center justify-center"
            >
                {{ $languageLabel }}
            </a>

            @guest('web')
                <a href="{{ route('login.show') }}"
                   class="text-theme-muted hover-text-brand-accent text-xs font-bold uppercase tracking-widest {{ $transitionBase }}">
                    {{ __('frontend.header.sign_in') }}
                </a>

                <a href="{{ route('frontend.projects.index') }}"
                   class="inline-flex items-center justify-center rounded-xl px-6 py-3 text-xs font-extrabold bg-brand-accent text-white hover-bg-brand-accent-strong transition-all shadow-brand-soft">
                    {{ __('frontend.header.browse_opportunities') }}
                </a>
            @endguest

            @auth('web')
                @php
                    $user = auth('web')->user();
                    $isInvestor = $user->role === 'Investor';
                    $dashboardRoute = $isInvestor ? route('dashboard.investor') : route('dashboard.academic');

                    $initialUnread = $user->unreadNotifications()->count();
                    $latestNotifications = $user->notifications()->latest()->take(5)->get();
                @endphp

                @if(!$isInvestor)
                    <a href="{{ route('project.submit.step1') }}"
                       class="text-brand-accent hover:text-theme-text text-xs font-bold uppercase tracking-widest mr-1 transition-colors">
                        <i class="fas fa-plus-circle mr-1"></i> {{ __('frontend.header.new_submission') }}
                    </a>
                @endif

                {{-- NOTIFICATIONS --}}
                <div class="relative flex items-center"
                     x-data="{
                        open:false,
                        unreadCount: {{ $initialUnread }},
                        init() {
                            setInterval(() => {
                                fetch('{{ route('frontend.notifications.count') }}')
                                    .then(r => r.json())
                                    .then(d => { this.unreadCount = d.count ?? 0; })
                                    .catch(() => {});
                            }, 30000);
                        }
                     }">

                    <button type="button"
                            @click="open = !open"
                            class="relative flex items-center justify-center w-10 h-10 rounded-full bg-brand-accent-soft border border-theme-border text-brand-accent hover:bg-brand-accent hover:text-white transition-all focus:outline-none shadow-brand-soft">
                        <i class="fas fa-bell text-lg"></i>

                        <template x-if="unreadCount > 0">
                            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white shadow">
                                <span x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
                            </span>
                        </template>
                    </button>

                    <div x-show="open"
                         x-cloak
                         @click.away="open=false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         style="display:none;"
                         class="absolute right-0 top-12 w-80 bg-theme-surface border border-theme-border rounded-2xl shadow-2xl z-[9999] overflow-hidden">

                        <div class="p-4 border-b border-theme-border bg-brand-accent-soft flex justify-between items-center">
                            <h3 class="text-xs font-black uppercase tracking-widest text-brand-accent">
                                {{ __('frontend.header.alerts') }}
                            </h3>
                            <span class="text-[10px] text-theme-muted" x-text="unreadCount + ' {{ __('frontend.header.unread') }}'"></span>
                        </div>

                        <div class="max-h-80 overflow-y-auto">
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
                                            class="w-full text-left block p-4 border-b border-theme-border hover:bg-brand-accent-soft transition {{ $n->read_at ? 'opacity-50' : '' }}">
                                        <div class="flex gap-3">
                                            <div class="text-brand-accent mt-1">
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
                               class="p-3 text-center text-[10px] font-black text-theme-muted hover-text-brand-accent transition border-r border-theme-border">
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
                   class="px-5 py-2.5 bg-theme-surface border border-theme-border rounded-xl text-theme-text hover:bg-brand-accent hover:text-white font-black uppercase text-[10px] tracking-widest transition-all shadow-brand-soft">
                    {{ __('frontend.header.dashboard') }}
                </a>

                <div class="flex items-center gap-3 ml-3 pl-3 border-l border-theme-border">
                    <div title="{{ $user->role }}"
                         class="w-10 h-10 rounded-full bg-brand-accent-soft border border-brand-accent text-brand-accent flex items-center justify-center font-black text-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <form action="{{ route('frontend.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 rounded-xl border border-red-400/30 text-red-400 hover:bg-red-500 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest">
                            {{ __('frontend.header.logout') }}
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        {{-- MOBILE ACTIONS --}}
        <div class="md:hidden flex items-center gap-2">
            {{-- MOBILE LANGUAGE SWITCH --}}
            <a
                href="{{ route('frontend.language.switch', $nextLocale) }}"
                class="w-auto min-w-[74px] h-10 px-3 rounded-xl border border-theme-border bg-theme-surface text-theme-text flex items-center justify-center shadow-brand-soft text-[11px] font-black uppercase tracking-widest hover-border-brand-accent hover-text-brand-accent transition-all"
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
                    class="w-10 h-10 rounded-xl border border-theme-border bg-theme-surface text-theme-text flex items-center justify-center shadow-brand-soft"
                >
                    <i class="fas fa-palette text-sm"></i>
                </button>

                <div
                    x-show="open"
                    x-cloak
                    @click.away="open = false"
                    style="display:none;"
                    class="absolute right-0 top-12 w-44 rounded-2xl border border-theme-border bg-theme-surface shadow-2xl overflow-hidden"
                >
                    <button type="button" @click="setTheme('brand')" class="w-full px-4 py-3 text-left text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition">
                        {{ __('frontend.header.vertexgrad_theme') }}
                    </button>
                    <button type="button" @click="setTheme('dark')" class="w-full px-4 py-3 text-left text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition border-t border-theme-border">
                        {{ __('frontend.header.dark_theme') }}
                    </button>
                    <button type="button" @click="setTheme('light')" class="w-full px-4 py-3 text-left text-sm font-semibold text-theme-text hover:bg-brand-accent-soft transition border-t border-theme-border">
                        {{ __('frontend.header.light_theme') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>