<header class="w-full fixed top-0 left-0 z-50 backdrop-blur-md bg-cardDark/90 border-b border-primary/20">
    <div class="{{ config('design.classes.container') }} flex items-center justify-between h-20">

        {{-- LOGO --}}
        <a href="/" class="flex items-center gap-2">
            <img src="{{ config('design.brand.logo') }}" alt="{{ config('design.brand.name') }}" class="w-10 h-10">
            <span class="font-extrabold text-2xl {{ config('design.classes.text_accent') }}">{{ config('design.brand.name') }}</span>
        </a>

        {{-- DESKTOP NAV --}}
        <nav class="hidden md:flex items-center gap-8 text-light font-medium">
        @php
            $transitionBase = config('design.classes.transition_base');
            $user = auth()->user();
            $navLinks = [
                ['href' => '#advantage', 'label' => 'The Advantage'],
                ['href' => route('utility.support'), 'label' => 'Support'],
            ];

            if ($user) {
                if ($user->role === 'Investor') {
                    array_unshift($navLinks, ['href' => route('projects.index'), 'label' => 'Marketplace']);
                } else {
                    array_unshift($navLinks, ['href' => route('project.submit.step1'), 'label' => 'Submit Research']);
                }
            } else {
                array_unshift($navLinks, ['href' => route('projects.index'), 'label' => 'Explore Projects']);
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
            @guest
                <a href="{{ route('login.show') }}" class="text-light/80 hover:text-primary text-xs font-bold uppercase tracking-widest {{ $transitionBase }} mr-4">Login</a>
                <a href="{{ route('projects.index') }}" class="{{ config('design.classes.btn_base') }} {{ config('design.classes.btn_primary') }} text-xs py-3 px-6 shadow-neon_sm">Find Investment</a>
            @endguest

            @auth
                @php
                    $isInvestor = auth()->user()->role === 'Investor';
                    $dashboardRoute = $isInvestor ? route('dashboard.investor') : route('dashboard.academic');
                @endphp

                @if(!$isInvestor)
                    <a href="{{ route('project.submit.step1') }}" class="text-primary hover:text-light text-xs font-bold uppercase tracking-widest mr-4 transition-colors">
                       <i class="fas fa-plus-circle mr-1"></i> New Project
                    </a>
                @endif
                
                {{-- NOTIFICATION BELL --}}
                <div class="relative flex items-center" x-data="{ 
                open: false, 
                unreadCount: {{ auth()->user()->unreadNotifications->count() }},
                init() {
                    setInterval(() => {
                        fetch('{{ route('notifications.count') }}')
                            .then(res => res.json())
                            .then(data => { this.unreadCount = data.count; });
                    }, 30000); 
                }
            }">
                <button @click="open = !open" 
                        type="button"
                        class="relative flex items-center justify-center w-10 h-10 rounded-full bg-white/5 border border-white/10 text-primary hover:bg-primary/10 transition-all focus:outline-none">
                    
                    <i class="fas fa-bell text-lg"></i>

                    <template x-if="unreadCount > 0">
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                    </template>
                </button>

                <div x-show="open" 
                    x-cloak
                    @click.away="open = false" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    style="display: none;" 
                    class="absolute right-0 top-12 w-80 bg-[#0B1218] border border-white/10 rounded-xl shadow-2xl z-[9999] overflow-hidden">
                    
                    <div class="p-4 border-b border-white/5 bg-white/5 flex justify-between items-center">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-primary">Notifications</h3>
                        <span class="text-[10px] text-light/50" x-text="unreadCount + ' New'"></span>
                    </div>

                    <div class="max-h-80 overflow-y-auto">
                        @forelse(auth()->user()->notifications->take(5) as $notification)
                            <a href="{{ route('notifications.read', $notification->id) }}?redirect={{ $notification->data['url'] ?? '#' }}" 
                            class="block p-4 border-b border-white/5 hover:bg-white/5 transition {{ $notification->read_at ? 'opacity-50' : '' }}">
                                <div class="flex gap-3">
                                    <div class="text-primary mt-1">
                                        <i class="{{ $notification->data['icon'] ?? 'fas fa-circle' }} text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-light">{{ $notification->data['title'] }}</p>
                                        <p class="text-[10px] text-light/60 mt-0.5 line-clamp-2">{{ $notification->data['message'] }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-light/20 text-xs italic">
                                No notifications yet
                            </div>
                        @endforelse
                    </div>

                    <div class="grid grid-cols-2 border-t border-white/5 bg-white/5">
                        <a href="#" class="p-3 text-center text-[10px] font-bold text-light/40 hover:text-primary transition border-r border-white/5">History</a>
                        <a href="{{ route('notifications.markAllRead') }}" class="p-3 text-center text-[10px] font-bold text-primary hover:text-light transition">Mark All Read</a>
                    </div>
                </div>
                </div>
                <a href="{{ $dashboardRoute }}" class="px-5 py-2.5 bg-white/5 border border-white/10 rounded-xl text-light hover:bg-primary hover:text-dark font-bold uppercase text-[10px] tracking-widest transition-all">Dashboard</a>

                <div class="flex items-center gap-3 ml-4 pl-4 border-l border-white/10">
                    <div title="{{ auth()->user()->role }}" class="w-10 h-10 rounded-full bg-primary/20 border border-primary text-primary flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-light/20 hover:text-error transition-colors"><i class="fas fa-power-off"></i></button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</header>