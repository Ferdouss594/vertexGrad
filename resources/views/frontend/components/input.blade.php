{{-- x-input.blade.php --}}
{{-- Usage: <x-input type="text" name="project_title" placeholder="Project Title" :value="$project->title"/> --}}
{{-- Usage: <x-input type="textarea" name="description" rows="4">Project description...</x-input> --}}

@props(['type' => 'text', 'name', 'rows' => 3, 'value' => null])

@php
    $designClasses = config('design.classes');
    $transitionBase = $designClasses['transition_base'];
    
    // Base classes for all inputs (dark background, light text, custom focus)
    $baseClasses = "w-full p-3 rounded-lg text-light bg-cardLight border border-cardLight focus:border-primary/50 placeholder-light/50 outline-none shadow-inner {$transitionBase}";

    // Handle the input type rendering
    if ($type === 'textarea') {
        $tag = 'textarea';
    } else {
        $tag = 'input';
    }
@endphp

@if ($tag === 'textarea')
    <textarea
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >{{ $slot->isNotEmpty() ? $slot : old($name, $value) }}</textarea>
@else
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    />
@endif