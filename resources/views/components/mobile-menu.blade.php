@php
    $designClasses = config('design.classes');
    $designColors = config('design.colors');
    $transitionBase = $designClasses['transition_base'];
    
    // Ensure the focus styles are available for buttons
    $primaryButtonClasses = $designClasses['btn_base'] . ' ' . $designClasses['btn_primary'];
    $secondaryButtonClasses = $designClasses['btn_base'] . ' ' . $designClasses['btn_secondary'];
@endphp

{{-- ====================================== --}}
{{-- 2. SLIDING MOBILE MENU (RIGHT SIDEBAR) --}}
{{-- ====================================== --}}
<div id="mobileSidebar"
{{-- ENHANCEMENT 1: Replace inline style with bg-cardDark and shadow-xl --}}
class="fixed inset-y-0 right-0 w-80 transform translate-x-full z-50 {{ $transitionBase }} bg-cardDark shadow-xl text-light">


    {{-- Top section of sidebar --}}
    {{-- Use dark-colored border --}}
    <div class="flex items-center justify-between p-4 border-b border-primary/20">
        <a href="/" class="flex items-center gap-2">
            <img src="{{ config('design.brand.logo') }}" alt="{{ config('design.brand.name') }}" class="w-8 h-8">
            {{-- Use accent text color --}}
            <span class="font-extrabold text-xl tracking-wider {{ $designClasses['text_accent'] }}">{{ config('design.brand.name') }}</span>
        </a>


        {{-- Close button: Use primary color for icon and hover --}}
        <button id="mobileSidebarClose" class="p-2 rounded-md text-primary hover:bg-primary/10 focus:ring-2 focus:ring-primary focus:ring-offset-dark">✕</button>
    </div>


    {{-- Navigation links for mobile --}}
    <nav class="p-6">
        <ul class="space-y-4">
            {{-- ENHANCEMENT 2: Apply theme hover/transition styles to links --}}
            <li><a href="#projects" class="block py-2 text-lg hover:text-primary {{ $transitionBase }}">Projects</a></li>
            <li><a href="#students" class="block py-2 text-lg hover:text-primary {{ $transitionBase }}">For Students</a></li>
            <li><a href="#investors" class="block py-2 text-lg hover:text-primary {{ $transitionBase }}">For Investors</a></li>
            <li><a href="#about" class="block py-2 text-lg hover:text-primary {{ $transitionBase }}">About</a></li>
        </ul>


        {{-- Action buttons --}}
        <div class="mt-8 space-y-3">
            {{-- ENHANCEMENT 3: Use configured button classes --}}
            <a href="/login" class="block text-center w-full {{ $primaryButtonClasses }}">
                Login
            </a>


            <a href="/projects/submit" class="block text-center w-full {{ $secondaryButtonClasses }}">
                Submit Project
            </a>
        </div>
    </nav>
</div>


{{-- OVERLAY BACKDROP --}}
{{-- Adjusted opacity for better blending, kept z-40 --}}
<div id="mobileSidebarOverlay" class="fixed inset-0 bg-dark/70 opacity-0 pointer-events-none z-40 {{ $transitionBase }}"></div>