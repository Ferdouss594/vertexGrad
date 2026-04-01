@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="mb-10 border-b border-theme-border pb-4">
            <h1 class="text-4xl font-extrabold text-theme-text">
                {{ __('frontend.investor.settings_title_before') }}
                <span class="text-brand-accent">{{ __('frontend.investor.settings_title_highlight') }}</span>
            </h1>
            <p class="text-xl text-theme-muted mt-1">
                {{ __('frontend.investor.subtitle') }}
            </p>
        </header>

        <form action="/settings/investor/update" method="POST" class="space-y-8">
            @csrf

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">
                    {{ __('frontend.investor.contact_info') }}
                </h2>

                <input type="text" name="contact_name"
                       placeholder="{{ __('frontend.investor.contact_name') }}"
                       class="w-full p-3 mb-4 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">

                <input type="text" name="fund_name"
                       placeholder="{{ __('frontend.investor.fund_name') }}"
                       class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">
                    {{ __('frontend.investor.investment_focus') }}
                </h2>

                <input type="number" name="min_investment"
                       placeholder="{{ __('frontend.investor.min_investment') }}"
                       class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text">
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">
                    {{ __('frontend.investor.compliance') }}
                </h2>

                <p class="text-green-600 font-bold">
                    {{ __('frontend.investor.verified') }}
                </p>
            </div>

            <div class="text-right">
                <button class="px-8 py-3 bg-brand-accent text-white rounded-lg">
                    {{ __('frontend.investor.save_preferences') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection