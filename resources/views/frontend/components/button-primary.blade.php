{{-- Primary Button Component --}}
{{-- Usage: <x-button-primary href="/signup" class="text-xl">Sign Up</x-button-primary> --}}
{{-- Usage: <x-button-primary type="submit" disabled>Submitting...</x-button-primary> --}}

@props(['href' => null, 'type' => 'button', 'disabled' => false])

@php
    $designClasses = config('design.classes');
    
    // Combine the structural base classes and the primary color/shadow classes
    $baseClasses = $designClasses['btn_base'] . ' ' . $designClasses['btn_primary'];

    // NEW: Add disabled styling to the class string
    $disabledClasses = 'disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none disabled:bg-cardLight disabled:text-light/50';

    $combinedClasses = $baseClasses . ' ' . $disabledClasses;
@endphp

@if($href)
    {{-- Anchor Tag (Used for Navigation) --}}
    <a href="{{ $href }}"
        {{-- If disabled prop is passed, we check for its presence and prevent navigation/interaction --}}
        @if($disabled) aria-disabled="true" @endif
        {{ $attributes->merge(['class' => $combinedClasses]) }}>
        {{ $slot }}
    </a>
@else
    {{-- Standard Button (Used for Form Submission/Action) --}}
    <button type="{{ $type }}"
        {{-- Apply the native disabled attribute to the button element --}}
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => $combinedClasses]) }}>
        {{ $slot }}
    </button>
@endif