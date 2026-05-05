@extends('frontend.layouts.app')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-x-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 h-80 w-80 sm:h-96 sm:w-96 blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="login-page-shell relative min-h-[calc(100vh-80px)] flex items-start justify-center px-4 sm:px-6 lg:px-8 pb-24" style="padding-top: 120px;">
        <div class="w-full max-w-2xl">

            <div class="theme-panel login-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 lg:p-10">

                <div class="text-center mb-8 sm:mb-10 login-header">
                    <div class="mx-auto mb-5 flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 16.5 6 19m9.5-2.5L18 19M12 14v7M5 9a7 7 0 0114 0v2a7 7 0 01-14 0V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 10h.01M15 10h.01M10 14h4" />
                        </svg>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-black text-theme-text leading-tight">
                        {{ __('frontend.auth.sign_in_to') }}
                        <span class="text-brand-accent">{{ __('frontend.auth.vertexgrad') }}</span>
                    </h2>

                    <p class="text-theme-muted mt-3 text-sm sm:text-base leading-7 max-w-xl mx-auto">
                        {{ __('frontend.auth.login_subtitle') }}
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-400/40 text-red-500 text-sm">
                        <ul class="list-disc list-inside space-y-1 text-start">
                            @foreach ($errors->all() as $error)
                                <li class="break-words">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6 login-form" id="loginForm">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-theme-muted mb-2">
                            {{ __('frontend.auth.username_or_email') }}
                        </label>

                        <div class="login-field-shell">
                            <span class="login-field-icon">
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
                                class="login-input"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-theme-muted mb-2">
                            {{ __('frontend.auth.password') }}
                        </label>

                        <div class="login-field-shell">
                            <span class="login-field-icon">
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
                                class="login-input login-password-input"
                            >

                            <button
                                type="button"
                                id="passwordToggle"
                                class="login-password-toggle"
                                aria-label="Toggle password visibility"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4 pt-1">
                        <label class="inline-flex items-center gap-3 text-sm sm:text-base text-theme-muted cursor-pointer min-w-0">
                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-theme-border bg-theme-surface-2 text-brand-accent focus:ring-brand-accent shrink-0"
                            >
                            <span class="whitespace-nowrap">{{ __('frontend.auth.remember_me') }}</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="text-sm sm:text-base font-bold text-brand-accent hover:underline text-end whitespace-nowrap">
                            {{ __('frontend.auth.forgot_password_short') }}
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="login-submit w-full min-h-[56px] inline-flex items-center justify-center rounded-2xl px-6 py-4 text-base sm:text-lg font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        {{ __('frontend.auth.log_in') }}
                    </button>
                </form>

                <p class="mt-8 text-center text-theme-muted text-sm sm:text-base leading-7">
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
    const form = document.getElementById('loginForm');
    const passwordInput = document.getElementById('loginPassword');
    const passwordToggle = document.getElementById('passwordToggle');
    const submitButton = form?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-login-page-style')) {
        const style = document.createElement('style');
        style.id = 'vg-login-page-style';
        style.textContent = `
            @keyframes vgLoginSpin {
                to { transform: rotate(360deg); }
            }

            .login-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .login-field-shell {
                position: relative;
                width: 100%;
            }

            .login-field-icon {
                position: absolute;
                top: 50%;
                inset-inline-start: 22px;
                transform: translateY(-50%);
                z-index: 2;
                color: var(--theme-muted);
                pointer-events: none;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 22px;
                height: 22px;
                line-height: 1;
            }

            .login-field-icon svg {
                display: block;
                width: 20px;
                height: 20px;
            }

            .login-input {
                width: 100%;
                min-height: 56px;
                border-radius: 1rem;
                border: 1px solid var(--theme-border);
                background: var(--theme-surface-2);
                color: var(--theme-text);
                padding-top: 1rem;
                padding-bottom: 1rem;
                padding-inline-start: 64px;
                padding-inline-end: 1.25rem;
                font-size: 1rem;
                transition: border-color .3s ease, box-shadow .3s ease, background-color .3s ease;
            }

            .login-password-input {
                padding-inline-end: 64px;
            }

            .login-input:focus {
                outline: none;
                border-color: var(--brand-accent);
                box-shadow: 0 0 0 4px rgba(0,224,255,.10);
            }

            .login-password-toggle {
                position: absolute;
                top: 50%;
                inset-inline-end: 22px;
                transform: translateY(-50%);
                z-index: 3;
                color: var(--theme-muted);
                display: flex;
                align-items: center;
                justify-content: center;
                width: 24px;
                height: 24px;
                transition: color .2s ease;
            }

            .login-password-toggle:hover {
                color: var(--brand-accent);
            }

            .login-submit {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .login-submit.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-login-spinner {
                width: 16px;
                height: 16px;
                border: 2px solid rgba(255,255,255,.45);
                border-top-color: #fff;
                border-radius: 9999px;
                display: inline-block;
                animation: vgLoginSpin .7s linear infinite;
            }
@media (max-width: 640px) {
    .login-page-shell {
        padding-top: 112px !important;
        padding-bottom: 72px !important;
    }
}

@media (min-width: 1024px) {
    .login-page-shell {
        padding-top: 125px !important;
        padding-bottom: 96px !important;
    }
}
}

            @media (hover: hover) and (pointer: fine) {
                .login-panel:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 22px 52px rgba(0,0,0,.10);
                }

                .login-submit:hover {
                    transform: translateY(-1px);
                }
            }

            @media (max-width: 420px) {
                .login-panel {
                    padding-left: 1.125rem !important;
                    padding-right: 1.125rem !important;
                }

                .login-form .flex.items-center.justify-between {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .login-form .flex.items-center.justify-between a {
                    text-align: start;
                }
            }

            @media (max-width: 640px) {
                input,
                button {
                    font-size: 16px;
                }

                .login-field-icon {
                    inset-inline-start: 20px;
                }

                .login-input {
                    padding-inline-start: 60px;
                }

                .login-password-toggle {
                    inset-inline-end: 20px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
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

    passwordToggle?.addEventListener('click', () => {
        if (!passwordInput) return;

        const icon = passwordToggle.querySelector('i');
        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        if (icon) {
            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
        }
    });

    form?.addEventListener('submit', () => {
        if (!submitButton) return;

        submitButton.classList.add('is-loading');
        submitButton.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <span class="vg-login-spinner"></span>
                {{ __('frontend.auth.log_in') }}
            </span>
        `;
    });
});
</script>
@endsection