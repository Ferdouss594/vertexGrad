{{-- x-mobile-nav.blade.php (Assumed component name) --}}

@php
    $designClasses = config('design.classes');
    $transitionBase = $designClasses['transition_base'];
    $primaryButtonClasses = $designClasses['btn_base'] . ' ' . $designClasses['btn_primary'];
    $secondaryButtonClasses = $designClasses['btn_base'] . ' ' . $designClasses['btn_secondary'];

    // Define mobile navigation links (consistent with desktop)
    $navLinks = [
        ['href' => '/projects', 'label' => 'Explore Projects'],
        ['href' => '/how-it-works', 'label' => 'How It Works'],
        ['href' => '/partners', 'label' => 'Partnerships'],
        ['href' => '/faq', 'label' => 'FAQs / Support'],
    ];
@endphp

{{-- ====================================== --}}
{{-- 2. SLIDING MOBILE MENU (RIGHT SIDEBAR) --}}
{{--    NOTE: This assumes Alpine.js or custom JS will handle the 'translate-x-full' toggle --}}
{{-- ====================================== --}}
<div id="mobileSidebar"
    class="fixed inset-y-0 right-0 w-80 transform translate-x-full z-[60] {{ $transitionBase }} bg-cardDark shadow-xl text-light">


    {{-- Top section of sidebar: Logo and Close Button --}}
    <div class="flex items-center justify-between p-4 h-20 border-b border-primary/20">
        {{-- Brand Logo/Name --}}
        <a href="/" class="flex items-center gap-2">
            <img src="{{ config('design.brand.logo') }}" alt="{{ config('design.brand.name') }}" class="w-10 h-10">
            <span class="font-extrabold text-xl tracking-wider {{ $designClasses['text_accent'] }}">{{ config('design.brand.name') }}</span>
        </a>


        {{-- Close button (Ensure this button has a JS handler to toggle 'translate-x-full') --}}
        <button id="mobileSidebarClose" class="p-2 rounded-lg text-primary hover:bg-primary/10 {{ $transitionBase }} focus:ring-2 focus:ring-primary focus:ring-offset-dark" aria-label="Close mobile menu">
            {{-- Use a standard X icon for clarity --}}
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>


    {{-- Navigation links for mobile --}}
    <nav class="p-6">
        <ul class="space-y-2">
            @foreach($navLinks as $link)
                <li>
                    <a href="{{ $link['href'] }}" 
                       class="block py-3 text-lg font-medium text-light hover:text-primary border-b border-cardLight {{ $transitionBase }}">
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>


        {{-- Action buttons (Dynamic Auth & Custom Button Classes) --}}
        <div class="mt-8 space-y-4 pt-4 border-t border-primary/10">
            
            @guest
                {{-- Secondary CTA for Graduates: Outline/Ghost Style --}}
                <a href="/submit-project" class="block text-center w-full {{ $secondaryButtonClasses }} text-base py-3">
                    Submit Project
                </a>

                {{-- Primary CTA for Investors: High-Contrast Neon Button --}}
                <a href="/login" class="block text-center w-full {{ $primaryButtonClasses }} text-base py-3">
                    Login / Register
                </a>
            @endguest

            @auth
                {{-- Authenticated User View --}}
                <a href="/dashboard" class="block text-center w-full py-3 font-semibold rounded-lg bg-primary/10 text-primary hover:bg-primary/20 {{ $transitionBase }}">Dashboard</a>
                {{-- You would typically include a Logout button here as well --}}
            @endauth
        </div>
    </nav>
</div>


{{-- OVERLAY BACKDROP --}}
{{-- This must be just below the main content in the DOM and toggled by JS --}}
<div id="mobileSidebarOverlay" class="fixed inset-0 bg-dark/70 opacity-0 pointer-events-none z-50 {{ $transitionBase }}"></div>