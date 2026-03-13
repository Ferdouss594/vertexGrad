{{-- Secondary Button Component (Outline/Ghost Style) --}}
{{-- Usage: <x-button-secondary href="/submit" class="text-xl">Submit Project</x-button-secondary> --}}

@props(['href' => null, 'type' => 'button', 'disabled' => false])

@php
    $designClasses = config('design.classes');
    
    // Combine the structural base classes and the secondary color/outline classes
    $combinedClasses = $designClasses['btn_base'] . ' ' . $designClasses['btn_secondary'];

    // Add disabled styling (consistent with x-button-primary)
    $disabledClasses = 'disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none disabled:bg-cardLight disabled:border-light/50 disabled:text-light/50';

    $finalClasses = $combinedClasses . ' ' . $disabledClasses;
@endphp

@if($href)
    <a href="{{ $href }}"
        @if($disabled) aria-disabled="true" @endif
        {{-- Merge ensures any extra classes passed (e.g., text-xl) are appended --}}
        {{ $attributes->merge(['class' => $finalClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => $finalClasses]) }}>
        {{ $slot }}
    </button>
@endif