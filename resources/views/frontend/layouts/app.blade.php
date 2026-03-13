<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    
    @php
        $design = config('design');
    @endphp

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <!-- Vite Assets -->
    @vite([
        'resources/css/app.css',
        'resources/css/chat-bot.css',  // ملف CSS الخاص بالشات
        'resources/js/app.js',
        'resources/js/chat-bot.js'      // ملف JS الخاص بالشات
    ])
    
    <!-- ستايلات إضافية من components -->
    @stack('styles')
</head>
<body class="text-light" style="background-color: {{ $design['colors']['dark'] ?? '#0f172a' }};">
    <!-- Header -->
    <x-header />
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <x-footer />
    
    <!-- Chat Bot Component - يظهر في كل الصفحات -->
    <x-chat-bot />
    
    <!-- سكريبتات إضافية من components -->
    @stack('scripts')
</body>
</html>