{{-- x-stat-card.blade.php --}}
{{-- Usage: <x-stat-card title="Total Investment" value="$12.5M" icon="fas fa-chart-line" /> --}}

@props(['title', 'value', 'icon' => null, 'difference' => null])

@php
    $designClasses = config('design.classes');
    $transitionBase = $designClasses['transition_base'];

    // Stat Card uses cardLight, often paired with an ambient neon glow
    $cardClasses = $designClasses['card']; 
@endphp

<div {{ $attributes->merge(['class' => "{$cardClasses} p-6 space-y-3"]) }}>
    <div class="flex items-center justify-between">
        
        {{-- Icon Container (Neon Accent Border) --}}
        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-primary/10 border border-primary/50 text-primary text-lg">
            @if ($icon)
                <i class="{{ $icon }}"></i>
            @else
                <i class="fas fa-star"></i>
            @endif
        </div>

        {{-- Difference/Change (Optional) --}}
        @if ($difference)
            @php
                // Example: green for positive, red for negative
                $isPositive = str_contains($difference, '+');
                $diffClass = $isPositive ? 'text-green-400' : 'text-red-400';
            @endphp
            <span class="text-xs font-semibold {{ $diffClass }}">{{ $difference }}</span>
        @endif
    </div>

    {{-- Value: High-Impact Gradient --}}
    <p class="text-4xl font-extrabold {{ $designClasses['text_gradient'] }} tracking-tight">{{ $value }}</p>

    {{-- Title: Muted Label --}}
    <h4 class="text-sm font-medium text-light/70 uppercase tracking-wider">{{ $title }}</h4>
</div>