@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                {{ __('frontend.disclosures.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.disclosures.title_highlight') }}</span>
            </h1>
            <p class="text-sm text-theme-muted">
                {{ __('frontend.disclosures.subtitle') }}
            </p>
        </header>

        <div class="theme-panel p-10 rounded-xl space-y-8 text-theme-muted">

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.disclosures.section1_title') }}</h3>
                <p>{{ __('frontend.disclosures.section1_text') }}</p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.disclosures.section2_title') }}</h3>
                <p>{{ __('frontend.disclosures.section2_text') }}</p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.disclosures.section3_title') }}</h3>
                <p>{{ __('frontend.disclosures.section3_text') }}</p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.disclosures.section4_title') }}</h3>
                <p>{{ __('frontend.disclosures.section4_text') }}</p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.disclosures.section5_title') }}</h3>
                <p>{{ __('frontend.disclosures.section5_text') }}</p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">{{ __('frontend.disclosures.section6_title') }}</h3>
                <p>{{ __('frontend.disclosures.section6_text') }}</p>
            </section>

        </div>

    </div>
</div>
@endsection