<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    data-theme="{{ config('design.default_theme', 'brand') }}"
>
<head>
    @php
        $siteName = config('app.name', 'VertexGrad');
        $defaultTitle = __('frontend.seo.default_title') !== 'frontend.seo.default_title'
            ? __('frontend.seo.default_title')
            : $siteName . ' | Academic Innovation & Investment Platform';

        $defaultDescription = __('frontend.seo.default_description') !== 'frontend.seo.default_description'
            ? __('frontend.seo.default_description')
            : 'VertexGrad connects academic projects, students, universities, and investors through a professional innovation and funding platform.';

        $pageTitle = trim($__env->yieldContent('title', $defaultTitle));
        $pageDescription = trim($__env->yieldContent('meta_description', $defaultDescription));
        $pageKeywords = trim($__env->yieldContent('meta_keywords', 'academic projects, graduation projects, innovation, investors, startups, research, Yemen, universities'));
        $canonicalUrl = trim($__env->yieldContent('canonical', url()->current()));
        $robots = trim($__env->yieldContent('robots', 'index, follow'));
        $ogType = trim($__env->yieldContent('og_type', 'website'));
        $ogImage = trim($__env->yieldContent('og_image', asset('images/logo.png')));
        $locale = str_replace('_', '-', app()->getLocale());
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>

    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="{{ $pageKeywords }}">
    <meta name="robots" content="{{ $robots }}">
    <meta name="author" content="{{ $siteName }}">
    <meta name="theme-color" content="#0F172A">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="{{ $locale }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    @if(app()->getLocale() === 'ar')
        <link rel="alternate" hreflang="ar" href="{{ $canonicalUrl }}">
    @else
        <link rel="alternate" hreflang="en" href="{{ $canonicalUrl }}">
    @endif
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}">

    @yield('structured_data')

    <script>
        (function () {
            const savedTheme = localStorage.getItem('vertexgrad_theme') || '{{ config('design.default_theme', 'brand') }}';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        img.brand-logo {
            width: 2.5rem !important;
            height: 2.5rem !important;
            min-width: 2.5rem !important;
            min-height: 2.5rem !important;
            max-width: 2.5rem !important;
            max-height: 2.5rem !important;
            object-fit: contain !important;
            flex-shrink: 0 !important;
            display: block !important;
        }

        img.brand-logo:hover {
            transform: scale(1.08) !important;
        }

        @media (max-width: 640px) {
            img.brand-logo {
                width: 2.25rem !important;
                height: 2.25rem !important;
                min-width: 2.25rem !important;
                min-height: 2.25rem !important;
                max-width: 2.25rem !important;
                max-height: 2.25rem !important;
            }
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden transition-colors duration-300 bg-theme-bg text-theme-text antialiased">
    <x-header />

@if (session('success') || session('error'))
    <div class="fixed top-24 inset-x-0 z-50 px-4 pointer-events-none">
        <div class="max-w-5xl mx-auto space-y-3">

            @if (session('success'))
                <div
                    class="relative pointer-events-auto rounded-2xl alert-success-theme shadow-xl backdrop-blur overflow-hidden">

                    <button
                        type="button"
                        onclick="this.closest('.relative').remove()"
                        class="absolute z-20 top-1/2 -translate-y-1/2 ltr:right-4 rtl:left-4
                               w-9 h-9 rounded-full
                               flex items-center justify-center
                               bg-white/10 hover:bg-white/20
                               text-white transition"
                        aria-label="Close"
                    >
                        <i class="fas fa-times text-sm"></i>
                    </button>

                    <div class="px-6 py-5 ltr:pr-16 rtl:pl-16 text-start text-white text-base leading-relaxed">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="relative pointer-events-auto rounded-2xl alert-error-theme shadow-xl backdrop-blur overflow-hidden">

                    <button
                        type="button"
                        onclick="this.closest('.relative').remove()"
                        class="absolute z-20 top-1/2 -translate-y-1/2 ltr:right-4 rtl:left-4
                               w-9 h-9 rounded-full
                               flex items-center justify-center
                               bg-white/10 hover:bg-white/20
                               text-white transition"
                        aria-label="Close"
                    >
                        <i class="fas fa-times text-sm"></i>
                    </button>

                    <div class="px-6 py-5 ltr:pr-16 rtl:pl-16 text-start text-white text-base leading-relaxed">
                        {{ session('error') }}
                    </div>
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