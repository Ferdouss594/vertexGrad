<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @php
        $design = config('design');
    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
{{-- IMPROVEMENT: Use the dark background from your config for the entire page body --}}
<body class="text-light" style="background-color: {{ $design['colors']['dark'] }};">
    <x-header />
    <main>
        @yield('content')
    </main>
    <x-footer />
</body>
</html>