<header
    {{-- Use fixed for sticky behavior, z-index, and backdrop blur for modern effect --}}
    {{-- Background set to dark/90 for strong contrast against the dark page background --}}
    class="w-full fixed top-0 left-0 z-50 backdrop-blur-md bg-cardDark/90 border-b border-primary/20"
>
    {{-- Height changed to h-20 for more space --}}
    <div class="{{ config('design.classes.container') }} flex items-center justify-between h-20">

        {{-- LOGO (Updated to Neon Style) --}}
        <a href="/" class="flex items-center gap-2">
            <img src="{{ config('design.brand.logo') }}" alt="{{ config('design.brand.name') }}" class="w-10 h-10">
            {{-- Use accent color for text, larger size for impact --}}
            <span class="font-extrabold text-2xl {{ config('design.classes.text_accent') }}">{{ config('design.brand.name') }}</span>
        </a>

        {{-- DESKTOP NAV (Updated Links and Classes) --}}
        <nav class="hidden md:flex items-center gap-8 text-light font-medium">
            @php
                // Get transition base class
                $transitionBase = config('design.classes.transition_base');
                
                // UPDATED LINKS TO REFLECT HOMEPAGE SECTIONS
                $navLinks = [
                    ['href' => '/projects', 'label' => 'Explore Projects'], // Functional Link
                    ['href' => '#advantage', 'label' => 'The Advantage'], // Jump Link to Section 4
                    ['href' => '#partners', 'label' => 'Partners & Vetting'], // Jump Link to Section 5
                    ['href' => '/faq', 'label' => 'Support'], 
                ];
            @endphp
            
            @foreach($navLinks as $link)
                <a href="{{ $link['href'] }}"
                    class="{{ $transitionBase }} hover:text-primary relative group">
                    {{ $link['label'] }}
                    {{-- Underline effect on hover --}}
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary transform scale-x-0 group-hover:scale-x-100 {{ $transitionBase }} ease-out"></span>
                </a>
            @endforeach
        </nav>

        {{-- DESKTOP ACTION BUTTONS (Dynamic Auth & Custom Button Classes) --}}
        <div class="hidden md:flex items-center gap-4">
            
            @guest
                {{-- Secondary CTA for Graduates: Functional Link --}}
                <a href="/submit-project" 
                    class="{{ config('design.classes.btn_base') }} {{ config('design.classes.btn_secondary') }} text-sm py-2 px-4">
                    <i class="fas fa-rocket mr-1"></i> Submit Project
                </a>

                {{-- Login/Register Link: Functional Link --}}
                <a href="/login" class="text-light/80 hover:text-primary text-sm font-medium {{ $transitionBase }}">
                    Login
                </a>
                
                {{-- Primary CTA for Investors: Functional Link --}}
                <a href="/projects" 
                    class="{{ config('design.classes.btn_base') }} {{ config('design.classes.btn_primary') }} text-sm py-2 px-4 shadow-neon_sm">
                    Find Investment
                </a>
            @endguest

            @auth
                {{-- Authenticated User View --}}
                <a href="/dashboard" class="text-light hover:text-primary font-medium {{ $transitionBase }}">Dashboard</a>
                <button class="w-10 h-10 rounded-full bg-primary/20 border border-primary text-primary flex items-center justify-center font-bold text-sm">
                    A
                </button>
            @endauth

        </div>

        {{-- MOBILE MENU BUTTON --}}
        <button class="md:hidden p-2 rounded-lg {{ $transitionBase }} text-primary hover:bg-primary/10 focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-dark">
            {{-- Hamburger Icon --}}
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>
</header>