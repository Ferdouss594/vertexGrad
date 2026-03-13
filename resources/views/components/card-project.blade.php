{{-- Project Card Component --}}
{{-- Usage: <x-card-project title="My Project" creator="John Doe" category="Tech" image="/path/to/image.jpg"/> --}}

@props(['title', 'creator', 'category' => null, 'image' => null])

@php
    $designClasses = config('design.classes');
    $lightColor = config('design.colors.light');
@endphp

{{-- 
    1. Base classes use config('design.classes.card') for consistency.
    2. Added a consistent border color using the dark background.
--}}
<div {{ $attributes->merge(['class' => $designClasses['card'] . ' border border-darker/50']) }}>
    
    {{-- Project image container --}}
    {{-- Use bg-cardDark for image placeholder/container for maximum contrast --}}
    <div class="h-48 w-full overflow-hidden bg-cardDark">
        @if($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
        @else
            {{-- Placeholder text is light, centered --}}
            <div class="w-full h-full flex items-center justify-center text-light/40 text-sm">
                Project Visual Coming Soon
            </div>
        @endif
    </div>

    {{-- Project info --}}
    <div class="p-5 space-y-3">
        
        {{-- ENHANCEMENT 1: Title now uses the text gradient for a premium look --}}
        <h3 class="text-xl font-semibold truncate {{ $designClasses['text_gradient'] }}">{{ $title }}</h3>
        
        {{-- ENHANCEMENT 2: Creator text uses light/70 for better consistency/muting --}}
        <p class="text-sm text-light/70">By <span class="font-medium text-light/90">{{ $creator }}</span></p>

        @if($category)
            {{-- Category Tag: Uses primary color with a dark background for neon look --}}
            <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full bg-primary/10 {{ $designClasses['text_accent'] }} border border-primary/50 uppercase tracking-wide">
                {{ $category }}
            </span>
        @endif

        {{-- Call to action button --}}
        <div class="pt-4">
            {{-- Using the combined class string for the button/anchor --}}
            <a href="#" class="{{ $designClasses['btn_base'] }} {{ $designClasses['btn_primary'] }} text-sm py-2 px-4 w-full">
                View Project
            </a>
        </div>
    </div>
</div>