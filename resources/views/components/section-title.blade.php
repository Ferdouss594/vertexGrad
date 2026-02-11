{{-- Section Title Component --}}
{{-- Usage: <x-section-title title="Featured Projects" subtitle="Discover the latest student innovations" alignment="left"/> --}}

@props([
    'title',
    'subtitle' => null,
    'alignment' => 'center' // options: center, left, right
])

<div class="mb-12 {{ 
    $alignment === 'center' ? 'text-center' : 
    ($alignment === 'left' ? 'text-left' : 'text-right') 
}}">
    
    {{-- Main Title --}}
    {{-- ENHANCEMENT 1: Apply text_gradient for maximum impact --}}
    <h2 class="{{ config('design.classes.heading_primary') }} {{ config('design.classes.text_gradient') }}">
        {{ $title }}
    </h2>

    {{-- Subtitle (optional) --}}
    @if($subtitle)
        {{-- ENHANCEMENT 2: Use theme-relative muted text --}}
        <p class="mt-4 text-light/70 text-lg md:text-xl font-light max-w-4xl {{ $alignment === 'center' ? 'mx-auto' : '' }}">
            {{ $subtitle }}
        </p>
    @endif
</div>