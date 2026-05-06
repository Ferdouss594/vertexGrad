@extends('frontend.layouts.app')
@section('robots', 'noindex, nofollow')
@section('content')
<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 h-72 w-72 sm:h-96 sm:w-96 rounded-full blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 pt-32 pb-16">
        <div class="w-full max-w-md">
            <div class="theme-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 backdrop-blur-sm text-center">

                <div class="mx-auto mb-4 flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent shadow-brand-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                </div>

                <h2 class="text-2xl sm:text-3xl font-black text-theme-text mb-2 leading-tight">
                    {{ __('frontend.verify_email.verified_title') }}
                </h2>

                <p class="text-sm sm:text-base text-theme-muted leading-relaxed max-w-sm mx-auto mb-6">
                    {{ __('frontend.verify_email.verified_subtitle') }}
                </p>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-500">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('login.show') }}"
                   class="w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-base font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                    {{ __('frontend.verify_email.go_to_login') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection