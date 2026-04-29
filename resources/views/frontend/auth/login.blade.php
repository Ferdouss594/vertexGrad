@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 h-72 w-72 sm:h-96 sm:w-96 rounded-full blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>

        <div class="absolute bottom-0 right-0 h-64 w-64 sm:h-80 sm:w-80 rounded-full blur-3xl opacity-10"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 pt-32 pb-16">
        <div class="w-full max-w-lg">
            <div class="login-panel theme-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 lg:p-10 backdrop-blur-sm">

                <div class="login-header text-center mb-8">
                    <div class="login-icon mx-auto mb-4 flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent shadow-brand-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 16.5 6 19m9.5-2.5L18 19M12 14v7M5 9a7 7 0 0114 0v2a7 7 0 01-14 0V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 10h.01M15 10h.01M10 14h4" />
                        </svg>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-black text-center text-theme-text mb-2 leading-tight">
                        {{ __('frontend.auth.sign_in_to') }}
                        <span class="text-brand-accent">{{ __('frontend.auth.vertexgrad') }}</span>
                    </h2>

                    <p class="text-sm sm:text-base text-center text-theme-muted leading-relaxed max-w-sm mx-auto">
                        {{ __('frontend.auth.login_subtitle') }}
                    </p>
                </div>

                @if ($errors->any())
                    <div class="login-alert mb-6 rounded-2xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-500">
                        <ul class="list-disc list-inside space-y-1 text-start">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="login-form space-y-5" id="loginForm">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-theme-muted mb-2">
                            {{ __('frontend.auth.username_or_email') }}
                        </label>

                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4 text-theme-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 21a8 8 0 0116 0" />
                                </svg>
                            </span>

                            <input
                                type="text"
                                name="login_id"
                                value="{{ old('login_id') }}"
                                required
                                autocomplete="username"
                                class="login-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3.5 ps-12 pe-4 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent transition duration-300"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-theme-muted mb-2">
                            {{ __('frontend.auth.password') }}
                        </label>

                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4 text-theme-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V8a4 4 0 10-8 0v3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 11h12v9H6z" />
                                </svg>
                            </span>

                            <input
                                type="password"
                                id="loginPassword"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="login-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3.5 ps-12 pe-12 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent transition duration-300"
                            >

                            <button
                                type="button"
                                id="passwordToggle"
                                class="absolute inset-y-0 end-0 flex items-center pe-4 text-theme-muted hover:text-brand-accent transition"
                                aria-label="Toggle password visibility"
                            >
                                <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <svg class="eye-closed hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6A2 2 0 0012 14a2 2 0 001.4-.6M7.1 7.1C4.2 8.7 2.5 12 2.5 12s3.5 6 9.5 6c1.7 0 3.2-.5 4.4-1.2M13.8 6.2C18.7 7 21.5 12 21.5 12s-.8 1.4-2.2 2.8" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <label class="inline-flex items-center gap-2 text-sm text-theme-muted cursor-pointer">
                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-theme-border bg-theme-surface-2 text-brand-accent focus:ring-brand-accent"
                            >
                            <span>{{ __('frontend.auth.remember_me') }}</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="text-sm font-bold text-brand-accent hover:underline">
                            {{ __('frontend.auth.forgot_password_short') }}
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="login-submit w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-base font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        <span>{{ __('frontend.auth.log_in') }}</span>
                    </button>
                </form>

                <p class="login-footer mt-8 text-center text-theme-muted text-sm leading-relaxed">
                    {{ __('frontend.auth.no_account') }}
                    <a href="{{ route('register.show') }}" class="text-brand-accent font-bold underline">
                        {{ __('frontend.auth.register_here') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const form = document.getElementById('loginForm');
    const passwordInput = document.getElementById('loginPassword');
    const passwordToggle = document.getElementById('passwordToggle');
    const submitButton = form?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-login-page-style')) {
        const style = document.createElement('style');
        style.id = 'vg-login-page-style';
        style.textContent = `
            @keyframes vgSpin {
                to { transform: rotate(360deg); }
            }

            .vg-reveal {
                opacity: 0;
                transform: translateY(18px);
                transition: opacity .65s ease, transform .65s cubic-bezier(.22,1,.36,1);
            }

            .vg-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .login-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .login-panel:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 52px rgba(0,0,0,.10);
            }

            .login-input:focus {
                box-shadow: 0 0 0 4px rgba(0,224,255,.10);
            }

            .login-submit {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .login-submit:hover {
                transform: translateY(-1px);
            }

            .login-submit.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-spinner {
                width: 16px;
                height: 16px;
                border: 2px solid rgba(255,255,255,.45);
                border-top-color: #fff;
                border-radius: 9999px;
                display: inline-block;
                animation: vgSpin .7s linear infinite;
            }

            @media (max-width: 640px) {
                .login-panel:hover {
                    transform: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .login-panel,
                .login-submit {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [
        document.querySelector('.login-icon'),
        document.querySelector('.login-header h2'),
        document.querySelector('.login-header p'),
        document.querySelector('.login-alert'),
        document.querySelector('.login-form'),
        document.querySelector('.login-footer')
    ].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => el.classList.add('is-visible'), 100 + (index * 90));
    });

    passwordToggle?.addEventListener('click', () => {
        if (!passwordInput) return;

        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';

        passwordToggle.querySelector('.eye-open')?.classList.toggle('hidden', isPassword);
        passwordToggle.querySelector('.eye-closed')?.classList.toggle('hidden', !isPassword);
    });

    form?.addEventListener('submit', () => {
        if (!submitButton) return;

        submitButton.classList.add('is-loading');
        submitButton.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <span class="vg-spinner"></span>
                {{ __('frontend.auth.log_in') }}
            </span>
        `;
    });
});
</script>
@endsection