<header class="w-full fixed top-0 left-0 z-50 backdrop-blur-md bg-cardDark/90 border-b border-primary/20">
    <div class="{{ config('design.classes.container') }} flex items-center justify-between h-20">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ config('design.brand.logo') }}" alt="{{ config('design.brand.name') }}" class="w-10 h-10">
            <span class="font-extrabold text-2xl {{ config('design.classes.text_accent') }}">{{ config('design.brand.name') }}</span>
        </a>

        {{-- DESKTOP NAV --}}
        <nav class="hidden md:flex items-center gap-8 text-light font-medium">
            @php
                $transitionBase = config('design.classes.transition_base');
                $user = auth('web')->user();

                $navLinks = [
                    ['href' => '#advantage', 'label' => 'The Advantage'],
                    ['href' => route('utility.support'), 'label' => 'Support'],
                ];

                if ($user) {
                    if ($user->role === 'Investor') {
                        array_unshift($navLinks, ['href' => route('frontend.projects.index'), 'label' => 'Marketplace']);
                    } else {
                        array_unshift($navLinks, ['href' => route('project.submit.step1'), 'label' => 'Submit Research']);
                    }
                } else {
                    array_unshift($navLinks, ['href' => route('frontend.projects.index'), 'label' => 'Explore Projects']);
                }
            @endphp

            @foreach($navLinks as $link)
                <a href="{{ $link['href'] }}"
                   class="{{ $transitionBase }} hover:text-primary relative group uppercase text-[11px] tracking-widest font-bold">
                    {{ $link['label'] }}
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary transform scale-x-0 group-hover:scale-x-100 {{ $transitionBase }} ease-out"></span>
                </a>
            @endforeach
        </nav>

        {{-- ACTIONS --}}
        <div class="hidden md:flex items-center gap-4">
            @guest('web')
                <a href="{{ route('login.show') }}" class="text-light/80 hover:text-primary text-xs font-bold uppercase tracking-widest {{ $transitionBase }} mr-4">
                    Login
                </a>
                <a href="{{ route('frontend.projects.index') }}"
                   class="{{ config('design.classes.btn_base') }} {{ config('design.classes.btn_primary') }} text-xs py-3 px-6 shadow-neon_sm">
                    Find Investment
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
                       class="text-primary hover:text-light text-xs font-bold uppercase tracking-widest mr-2 transition-colors">
                        <i class="fas fa-plus-circle mr-1"></i> New Project
                    </a>
                @endif

                {{-- NOTIFICATION BELL --}}
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
                            class="relative flex items-center justify-center w-10 h-10 rounded-full bg-white/5 border border-white/10 text-primary hover:bg-primary/10 transition-all focus:outline-none">
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
                         class="absolute right-0 top-12 w-80 bg-[#0B1218] border border-white/10 rounded-2xl shadow-2xl z-[9999] overflow-hidden">

                        <div class="p-4 border-b border-white/5 bg-white/5 flex justify-between items-center">
                            <h3 class="text-xs font-black uppercase tracking-widest text-primary">Notifications</h3>
                            <span class="text-[10px] text-light/50" x-text="unreadCount + ' unread'"></span>
                        </div>

                        <div class="max-h-80 overflow-y-auto">
                            @forelse($latestNotifications as $n)
                                @php
                                    $title = $n->data['title'] ?? 'Notification';
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
                                class="w-full text-left block p-4 border-b border-white/5 hover:bg-white/5 transition {{ $n->read_at ? 'opacity-50' : '' }}">
                            <div class="flex gap-3">
                                <div class="text-primary mt-1">
                                    <i class="{{ $icon }} text-xs"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-light truncate">{{ $title }}</p>
                                    <p class="text-[10px] text-light/60 mt-0.5 line-clamp-2">
                                        {{ $message }}
                                    </p>
                                    <p class="text-[10px] text-light/30 mt-1">
                                        {{ $n->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </button>
                        
                    </form>
                            @empty
                                <div class="p-8 text-center text-light/30 text-xs italic">
                                    No notifications yet
                                </div>
                            @endforelse
                        </div>

                        <div class="grid grid-cols-2 border-t border-white/5 bg-white/5">
                            <a href="{{ route('frontend.notifications.index') }}"
                               class="p-3 text-center text-[10px] font-black text-light/50 hover:text-primary transition border-r border-white/5">
                                History
                            </a>
                            <form method="POST" action="{{ route('frontend.notifications.markAllRead') }}">
                                @csrf
                                <button type="submit" class="p-3 w-full text-center text-[10px] font-black text-primary hover:text-light transition">
                                    Mark All Read
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <a href="{{ $dashboardRoute }}"
                   class="px-5 py-2.5 bg-white/5 border border-white/10 rounded-xl text-light hover:bg-primary hover:text-dark font-black uppercase text-[10px] tracking-widest transition-all">
                    Dashboard
                </a>

            <div class="flex items-center gap-3 ml-4 pl-4 border-l border-white/10">
                <div title="{{ $user->role }}"
                    class="w-10 h-10 rounded-full bg-primary/20 border border-primary text-primary flex items-center justify-center font-black text-sm">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <form action="{{ route('frontend.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-xl border border-red-400/30 text-red-300 hover:bg-red-500 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest">
                        Logout
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</header>