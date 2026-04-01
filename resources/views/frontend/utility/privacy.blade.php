@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                {{ __('frontend.privacy.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.privacy.title_highlight') }}</span>
            </h1>
            <p class="text-sm text-theme-muted">
                {{ __('frontend.privacy.effective_date') }}
            </p>
        </header>

        <div class="theme-panel p-10 rounded-xl space-y-8 text-theme-muted">
            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.privacy.section1_title') }}</h3>
                <p>{{ __('frontend.privacy.section1_text') }}</p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.privacy.section2_title') }}</h3>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>{{ __('frontend.privacy.section2_point1') }}</li>
                    <li>{{ __('frontend.privacy.section2_point2') }}</li>
                    <li>{{ __('frontend.privacy.section2_point3') }}</li>
                    <li>{{ __('frontend.privacy.section2_point4') }}</li>
                </ul>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.privacy.section3_title') }}</h3>
                <p>{{ __('frontend.privacy.section3_text') }}</p>
            </section>
        </div>

    </div>
</div>
@endsection