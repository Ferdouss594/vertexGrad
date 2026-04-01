@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                {{ __('frontend.about.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.about.title_highlight') }}</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-3xl mx-auto">
                {{ __('frontend.about.subtitle') }}
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
            <div class="theme-panel p-8 rounded-2xl">
                <h2 class="text-3xl font-bold text-theme-text mb-4">{{ __('frontend.about.mission_title') }}</h2>
                <p class="text-theme-muted leading-8">
                    {{ __('frontend.about.mission_text') }}
                </p>
            </div>

            <div class="theme-panel p-8 rounded-2xl">
                <h2 class="text-3xl font-bold text-theme-text mb-4">{{ __('frontend.about.vision_title') }}</h2>
                <p class="text-theme-muted leading-8">
                    {{ __('frontend.about.vision_text') }}
                </p>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="theme-panel p-6 rounded-xl text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-brand-accent-soft flex items-center justify-center text-brand-accent text-2xl">
                    <i class="fas fa-microscope"></i>
                </div>
                <h3 class="text-2xl font-semibold text-theme-text mb-2">{{ __('frontend.about.card1_title') }}</h3>
                <p class="text-theme-muted text-sm">
                    {{ __('frontend.about.card1_text') }}
                </p>
            </div>

            <div class="theme-panel p-6 rounded-xl text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-brand-accent-soft flex items-center justify-center text-brand-accent text-2xl">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="text-2xl font-semibold text-theme-text mb-2">{{ __('frontend.about.card2_title') }}</h3>
                <p class="text-theme-muted text-sm">
                    {{ __('frontend.about.card2_text') }}
                </p>
            </div>

            <div class="theme-panel p-6 rounded-xl text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-brand-accent-soft flex items-center justify-center text-brand-accent text-2xl">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-2xl font-semibold text-theme-text mb-2">{{ __('frontend.about.card3_title') }}</h3>
                <p class="text-theme-muted text-sm">
                    {{ __('frontend.about.card3_text') }}
                </p>
            </div>
        </div>

        <div class="mt-16 text-center">
            <h2 class="text-4xl font-bold text-theme-text mb-4">{{ __('frontend.about.cta_title') }}</h2>
            <p class="text-xl text-theme-muted mb-8 max-w-2xl mx-auto">
                {{ __('frontend.about.cta_text') }}
            </p>

            <a href="/contact"
               class="inline-flex items-center justify-center rounded-lg px-10 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                {{ __('frontend.about.cta_button') }} <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>

    </div>
</div>
@endsection