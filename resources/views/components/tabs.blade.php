{{-- resources/views/components/tabs.blade.php --}}
{{-- 
    This component acts as the container for <x-tab-link> components.
    It provides the visual bottom border for the tab navigation area.
--}}
@props(['activeTab' => null])

@php
    // We already pulled classes in the child component, 
    // but pulling them here is clean practice.
    $designClasses = config('design.classes');
@endphp

{{-- Main Tab Container: This wrapper holds the links and provides the visual divider. --}}
<div class="border-b border-primary/20 flex space-x-6 overflow-x-auto mb-6">
    {{ $slot }}
</div>

{{-- 
    Note: The actual content areas (the divs that show/hide) are placed 
    *after* this component in the main page's HTML. 
--}}