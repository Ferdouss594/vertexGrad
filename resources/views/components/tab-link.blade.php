{{-- resources/views/components/tab-link.blade.php --}}

@props(['target', 'label', 'active' => false])

@php
    $designClasses = config('design.classes');
    $transitionBase = $designClasses['transition_base'];
    
    // Determine the styling based on whether the link is the currently active tab
    $activeClasses = $active 
        ? 'border-primary text-primary shadow-neon_md' 
        : 'border-transparent text-light/70 hover:text-primary hover:border-primary/50';
@endphp

<a 
    href="#{{ $target }}" 
    class="py-3 px-1 border-b-2 font-semibold text-lg whitespace-nowrap {{ $activeClasses }} {{ $transitionBase }}"
    data-tab-target="{{ $target }}"
    role="tab"
    aria-controls="{{ $target }}"
    aria-selected="{{ $active ? 'true' : 'false' }}"
>
    {{ $label }}
</a>