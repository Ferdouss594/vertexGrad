<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    data-theme="{{ config('design.default_theme', 'brand') }}"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <script>
        (function () {
            const savedTheme = localStorage.getItem('vertexgrad_theme') || '{{ config('design.default_theme', 'brand') }}';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen overflow-x-hidden transition-colors duration-300 bg-theme-bg text-theme-text antialiased">
    <x-header />

    @if (session('success') || session('error'))
        <div class="fixed top-24 inset-x-0 z-50 px-4 pointer-events-none">
            <div class="max-w-4xl mx-auto space-y-3">
                @if (session('success'))
                    <div class="pointer-events-auto p-4 rounded-2xl bg-green-500/20 border border-green-500 text-green-100 shadow-xl backdrop-blur">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="pointer-events-auto p-4 rounded-2xl bg-red-500/20 border border-red-500 text-red-100 shadow-xl backdrop-blur">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <main class="min-h-screen overflow-x-hidden">
        @yield('content')
    </main>

    <x-footer />
</body>
</html>