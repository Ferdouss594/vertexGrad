{{-- resources/views/components/feature-box.blade.php --}}
{{-- 
    Usage: <x-feature-box 
        title="Showcase in Minutes" 
        description="Upload your project assets and academic endorsements swiftly with our guided process."
        icon="fas fa-upload" 
    />
--}}

@props(['title', 'description', 'icon' => 'fas fa-cogs'])

@php
    $designClasses = config('design.classes');
    $transitionBase = $designClasses['transition_base'];
    $primaryColor = config('design.colors.primary'); 
    
    // We use a slight variant of the card styling for features for a subtle lift
    $featureClasses = "bg-cardLight rounded-xl p-8 shadow-xl {$transitionBase} hover:shadow-neon_md hover:scale-[1.02]";
@endphp

<div {{ $attributes->merge(['class' => $featureClasses]) }}>
    
    {{-- Icon with Neon Accents --}}
    <div class="mb-4">
        <i 
            class="{{ $icon }} text-4xl {{ $designClasses['text_accent'] }} drop-shadow-neon_sm"
            style="text-shadow: 0 0 5px {{ $primaryColor }};"
        ></i>
    </div>

    {{-- Title (Strong, Light Text) --}}
    <h3 class="text-xl font-bold text-light mb-3">
        {{ $title }}
    </h3>

    {{-- Description (Muted Text) --}}
    <p class="text-light/70 text-base leading-relaxed">
        {{ $description }}
    </p>

    {{-- Optional: Call to Action (Subtle link) --}}
    <div class="mt-4">
        <a href="#" class="text-sm font-semibold text-primary hover:underline {{ $transitionBase }}">
            Learn More <i class="fas fa-arrow-right ml-1 text-xs"></i>
        </a>
    </div>

</div>