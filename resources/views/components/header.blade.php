<header class="w-full fixed top-0 left-0 z-50 backdrop-blur-md bg-cardDark/90 border-b border-primary/20">
    <div class="{{ config('design.classes.container') }} flex items-center justify-between h-20">

        {{-- LOGO --}}
        <a href="/" class="flex items-center gap-2">
            <img src="{{ config('design.brand.logo') }}" alt="{{ config('design.brand.name') }}" class="w-10 h-10">
            <span class="font-extrabold text-2xl {{ config('design.classes.text_accent') }}">{{ config('design.brand.name') }}</span>
        </a>

        {{-- DESKTOP NAV (Now Dynamic!) --}}
        <nav class="hidden md:flex items-center gap-8 text-light font-medium">
        @php
            $transitionBase = config('design.classes.transition_base');
            $user = auth()->user();

            // 1. Start with common links everyone sees
            $navLinks = [
                ['href' => '#advantage', 'label' => 'The Advantage'],
                ['href' => route('utility.support'), 'label' => 'Support'],
            ];

            // 2. Add Role-Specific Links
            if ($user) {
                if ($user->role === 'Investor') {
                    // Investors see the marketplace
                    array_unshift($navLinks, ['href' => route('projects.index'), 'label' => 'Marketplace']);
                } else {
                    // Students see "My Submissions" or "New Research"
                    array_unshift($navLinks, ['href' => route('project.submit.step1'), 'label' => 'Submit Research']);
                }
            } else {
                // Guests see a general "Explore" link
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
                <a href="{{ route('login.show') }}" class="text-light/80 hover:text-primary text-xs font-bold uppercase tracking-widest {{ $transitionBase }} mr-4">
                    Login
                </a>
                
                <a href="{{ route('projects.index') }}" 
                    class="{{ config('design.classes.btn_base') }} {{ config('design.classes.btn_primary') }} text-xs py-3 px-6 shadow-neon_sm">
                    Find Investment
                </a>
            @endguest

            @auth
                @php
                    $isInvestor = auth()->user()->role === 'Investor';
                    $dashboardRoute = $isInvestor ? route('dashboard.investor') : route('dashboard.academic');
                @endphp

                {{-- Action button based on role --}}
                @if(!$isInvestor)
                    <a href="{{ route('project.submit.step1') }}" class="text-primary hover:text-light text-xs font-bold uppercase tracking-widest mr-4 transition-colors">
                       <i class="fas fa-plus-circle mr-1"></i> New Project
                    </a>
                @endif

                <a href="{{ $dashboardRoute }}" class="px-5 py-2.5 bg-white/5 border border-white/10 rounded-xl text-light hover:bg-primary hover:text-dark font-bold uppercase text-[10px] tracking-widest transition-all">
                    Dashboard
                </a>

                {{-- User Avatar & Logout --}}
                <div class="flex items-center gap-3 ml-4 pl-4 border-l border-white/10">
                    <div title="{{ auth()->user()->role }}" class="w-10 h-10 rounded-full bg-primary/20 border border-primary text-primary flex items-center justify-center font-bold text-sm shadow-[0_0_10px_rgba(30,227,247,0.2)]">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-light/20 hover:text-error transition-colors">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </form>
                </div>
            @endauth

        </div>

        {{-- MOBILE MENU BUTTON --}}
        <button class="md:hidden p-2 rounded-lg {{ $transitionBase }} text-primary hover:bg-primary/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>
</header>