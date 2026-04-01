@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                {{ __('frontend.support.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.support.title_highlight') }}</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-2xl mx-auto">
                {{ __('frontend.support.subtitle_before') }}
                <a href="/contact" class="text-brand-accent hover:underline">{{ __('frontend.support.contact_link') }}</a>.
            </p>
        </header>

        <div class="space-y-6">
            <div class="theme-panel p-6 rounded-xl group cursor-pointer">
                <h3 class="text-xl font-semibold text-theme-text mb-2 flex justify-between items-center">
                    {{ __('frontend.support.q1') }}
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300">
                    {{ __('frontend.support.a1') }}
                </p>
            </div>

            <div class="theme-panel p-6 rounded-xl group cursor-pointer">
                <h3 class="text-xl font-semibold text-theme-text mb-2 flex justify-between items-center">
                    {{ __('frontend.support.q2') }}
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300">
                    {{ __('frontend.support.a2') }}
                </p>
            </div>

            <div class="theme-panel p-6 rounded-xl group cursor-pointer">
                <h3 class="text-xl font-semibold text-theme-text mb-2 flex justify-between items-center">
                    {{ __('frontend.support.q3') }}
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300">
                    {{ __('frontend.support.a3') }}
                </p>
            </div>
        </div>

    </div>
</div>
@endsection