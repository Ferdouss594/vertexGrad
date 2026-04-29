@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 start-1/2 -translate-x-1/2 h-72 w-72 sm:h-96 sm:w-96 rounded-full blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>

        <div class="absolute bottom-0 end-0 h-64 w-64 sm:h-80 sm:w-80 rounded-full blur-3xl opacity-10"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 pt-32 pb-16">
        <div class="w-full max-w-md">
            <div class="forgot-password-panel theme-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 backdrop-blur-sm">

                <div class="text-center mb-8">
                    <div class="forgot-password-icon mx-auto mb-4 flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 shadow-brand-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 sm:w-8 sm:h-8 text-brand-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V8a4 4 0 10-8 0v3m-1 0h10a1 1 0 011 1v7a1 1 0 01-1 1H7a1 1 0 01-1-1v-7a1 1 0 011-1z" />
                        </svg>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-theme-text mb-2 leading-tight">
                        {{ __('frontend.auth.forgot_password_title') }}
                    </h2>

                    <p class="text-sm sm:text-base text-theme-muted leading-relaxed max-w-sm mx-auto">
                        {{ __('frontend.auth.forgot_password_subtitle') }}
                    </p>
                </div>

                @if (session('status'))
                    <div class="forgot-password-alert mb-6 rounded-2xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-500">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                @error('email')
                    <div class="forgot-password-alert mb-6 rounded-2xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-500">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 4h.01M10.29 3.86L1.82 18a1.5 1.5 0 001.29 2.25h17.78A1.5 1.5 0 0022.18 18L13.71 3.86a1.5 1.5 0 00-2.42 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    </div>
                @enderror

                <form action="{{ route('password.email') }}" method="POST" id="forgotPasswordForm" class="forgot-password-form space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-bold text-theme-muted">
                            {{ __('frontend.auth.email') }}
                        </label>

                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4 text-theme-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                </svg>
                            </span>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                class="w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3.5 ps-12 pe-4 text-theme-text placeholder:text-theme-muted focus:border-brand-accent focus:ring-0 transition duration-300"
                                placeholder="{{ __('frontend.auth.email') }}"
                            >
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="forgot-password-submit w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-base font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l18-7-7 18-2.5-7.5L3 10z" />
                        </svg>
                        <span>{{ __('frontend.auth.send_reset_link') }}</span>
                    </button>
                </form>

                <div class="forgot-password-footer mt-8 border-t border-theme-border/60 pt-6 text-center">
                    <p class="text-sm text-theme-muted leading-relaxed">
                        {{ __('frontend.auth.remember_password') }}
                        <a href="{{ route('login.show') }}" class="font-bold text-brand-accent hover:underline">
                            {{ __('frontend.auth.log_in') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const panel = document.querySelector('.forgot-password-panel');
    const form = document.getElementById('forgotPasswordForm');
    const submitButton = form?.querySelector('button[type="submit"]');

    const revealItems = [
        document.querySelector('.forgot-password-icon'),
        document.querySelector('.forgot-password-panel h2'),
        document.querySelector('.forgot-password-panel h2 + p'),
        document.querySelector('.forgot-password-alert'),
        document.querySelector('.forgot-password-form'),
        document.querySelector('.forgot-password-footer')
    ].filter(Boolean);

    if (!document.getElementById('vg-forgot-password-style')) {
        const style = document.createElement('style');
        style.id = 'vg-forgot-password-style';
        style.textContent = `
            .vg-auth-reveal {
                opacity: 0;
                transform: translateY(18px);
                transition: opacity .65s ease, transform .65s cubic-bezier(.22,1,.36,1);
            }

            .vg-auth-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .forgot-password-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .forgot-password-panel:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 52px rgba(0,0,0,.10);
            }

            .forgot-password-submit {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .forgot-password-submit:hover {
                transform: translateY(-1px);
            }

            .forgot-password-submit.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            @media (max-width: 640px) {
                .forgot-password-panel:hover {
                    transform: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-auth-reveal,
                .forgot-password-panel,
                .forgot-password-submit {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    revealItems.forEach((el, index) => {
        el.classList.add('vg-auth-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 100 + (index * 95));
    });

    if (submitButton) {
        form?.addEventListener('submit', () => {
            submitButton.classList.add('is-loading');
            submitButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    {{ __('frontend.auth.send_reset_link') }}
                </span>
            `;
        });
    }
});
</script>
@endsection