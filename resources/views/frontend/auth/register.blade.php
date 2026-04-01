@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-5xl p-4 lg:p-8 text-center">

        <h2 class="text-5xl font-extrabold text-theme-text mb-4">
            {{ __('frontend.auth.join_the') }} <span class="text-brand-accent">{{ __('frontend.auth.vertexgrad_ecosystem') }}</span>
        </h2>

        <p class="text-xl text-theme-muted mb-16 max-w-3xl mx-auto">
            {{ __('frontend.auth.choose_registration_type') }}
        </p>

        @if ($errors->any())
            <div class="max-w-md mx-auto mb-8 p-4 rounded-lg bg-red-500/10 border border-red-400/40 text-red-500 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <a href="{{ route('register.investor') }}"
               class="p-10 rounded-2xl theme-panel hover:bg-theme-surface-2 transition duration-300 shadow-brand-soft block group">
                <i class="fas fa-hand-holding-usd text-6xl text-brand-accent mb-4"
                   style="filter: drop-shadow(0 0 8px var(--brand-accent-glow));"></i>

                <h3 class="text-3xl font-bold text-theme-text mb-3">
                    {{ __('frontend.auth.investor_fund_manager') }}
                </h3>

                <p class="text-theme-muted mb-6">
                    {{ __('frontend.auth.investor_register_text') }}
                </p>

                <span class="inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold bg-brand-accent text-white group-hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                    {{ __('frontend.auth.register_as_investor') }} <i class="fas fa-arrow-right ml-2"></i>
                </span>
            </a>

            <a href="{{ route('register.academic') }}"
               class="p-10 rounded-2xl theme-panel hover:bg-theme-surface-2 transition duration-300 shadow-brand-soft block group">
                <i class="fas fa-flask text-6xl text-brand-accent mb-4"
                   style="filter: drop-shadow(0 0 8px var(--brand-accent-glow));"></i>

                <h3 class="text-3xl font-bold text-theme-text mb-3">
                    {{ __('frontend.auth.academic_project_creator') }}
                </h3>

                <p class="text-theme-muted mb-6">
                    {{ __('frontend.auth.academic_register_text') }}
                </p>

                <span class="inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold border border-brand-accent text-theme-text group-hover:bg-brand-accent group-hover:text-white transition duration-300">
                    {{ __('frontend.auth.register_as_academic') }} <i class="fas fa-rocket ml-2"></i>
                </span>
            </a>

        </div>

        <p class="mt-12 text-center text-theme-muted text-sm">
            {{ __('frontend.auth.already_have_account') }}
            <a href="{{ route('login.show') }}" class="text-brand-accent font-medium ml-1">
                {{ __('frontend.auth.log_in') }}
            </a>
        </p>
    </div>
</div>
@endsection