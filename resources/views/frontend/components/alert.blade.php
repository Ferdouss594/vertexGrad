{{-- x-alert.blade.php --}}
{{-- Usage: <x-alert type="success" message="Project successfully submitted for review."/> --}}
{{-- Usage: <x-alert type="error">Could not process investment request.</x-alert> --}}

@props(['type' => 'info', 'message' => null])

@php
    $designClasses = config('design.classes');
    $transitionBase = $designClasses['transition_base'];
    
    // Define color schemes based on alert type
    $schemes = [
        'success' => ['bg' => 'bg-green-600/10', 'border' => 'border-green-400', 'text' => 'text-green-400', 'icon' => 'fas fa-check-circle'],
        'error'   => ['bg' => 'bg-red-600/10', 'border' => 'border-red-400', 'text' => 'text-red-400', 'icon' => 'fas fa-times-circle'],
        // Use primary theme color for info
        'info'    => ['bg' => 'bg-primary/10', 'border' => 'border-primary', 'text' => 'text-primary', 'icon' => 'fas fa-info-circle'],
        'warning' => ['bg' => 'bg-yellow-600/10', 'border' => 'border-yellow-400', 'text' => 'text-yellow-400', 'icon' => 'fas fa-exclamation-triangle'],
    ];

    $scheme = $schemes[$type] ?? $schemes['info'];
    $icon = $scheme['icon'];
@endphp

<div 
    {{ $attributes->merge(['class' => "p-4 rounded-lg border-l-4 {$scheme['bg']} {$scheme['border']} shadow-lg {$transitionBase}"]) }} 
    role="alert"
>
    <div class="flex items-start">
        {{-- Icon --}}
        <div class="flex-shrink-0 mr-3 text-xl {$scheme['text']}">
            <i class="{{ $icon }}"></i>
        </div>
        
        {{-- Content --}}
        <div class="text-light text-sm font-medium">
            {{ $message ?? $slot }}
        </div>

        {{-- Optional: Close button --}}
        {{-- You would integrate Alpine/JS here to hide the alert --}}
    </div>
</div>