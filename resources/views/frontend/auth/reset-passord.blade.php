@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 h-72 w-72 sm:h-96 sm:w-96 rounded-full blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>

        <div class="absolute bottom-0 left-0 h-64 w-64 sm:h-80 sm:w-80 rounded-full blur-3xl opacity-10"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 pt-32 pb-16">
        <div class="w-full max-w-md">
            <div class="reset-password-panel theme-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 backdrop-blur-sm">

                <div class="reset-password-header text-center mb-8">
                    <div class="reset-password-icon mx-auto mb-4 flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent shadow-brand-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 2l-2 2"/>
                            <path d="M15.5 7.5 19 4"/>
                            <circle cx="9" cy="15" r="6"/>
                            <path d="M9 15h.01"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-theme-text mb-2 leading-tight">
                        {{ __('frontend.auth.reset_password_title') }}
                    </h2>

                    <p class="text-sm sm:text-base text-theme-muted leading-relaxed max-w-sm mx-auto">
                        {{ __('frontend.auth.reset_password_subtitle') }}
                    </p>
                </div>

                @if ($errors->any())
                    <div class="reset-password-alert mb-6 rounded-2xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-500">
                        <ul class="list-disc list-inside space-y-1 text-start">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" id="resetPasswordForm" class="reset-password-form space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token ?? '' }}">

                    <div>
                        <label for="email" class="mb-2 block text-sm font-bold text-theme-muted">
                            {{ __('frontend.auth.email') }}
                        </label>

                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4 text-theme-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16v16H4z"/>
                                    <path d="m4 7 8 6 8-6"/>
                                </svg>
                            </span>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                required
                                value="{{ $email ?? old('email') }}"
                                readonly
                                class="reset-password-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3.5 ps-12 pe-4 text-theme-text opacity-70 focus:border-brand-accent focus:ring-0 transition duration-300"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-bold text-theme-muted">
                            {{ __('frontend.auth.new_password') }}
                        </label>

                        <div class="relative password-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                class="reset-password-input password-toggle-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3.5 ps-4 pe-12 text-theme-text focus:border-brand-accent focus:ring-0 transition duration-300"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-bold text-theme-muted">
                            {{ __('frontend.auth.confirm_new_password') }}
                        </label>

                        <div class="relative password-wrapper">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="reset-password-input password-toggle-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3.5 ps-4 pe-12 text-theme-text focus:border-brand-accent focus:ring-0 transition duration-300"
                            >
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="reset-password-submit w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-base font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-2.64-6.36"/>
                            <path d="M21 3v6h-6"/>
                        </svg>
                        <span>{{ __('frontend.auth.reset_password_button') }}</span>
                    </button>
                </form>

                <div class="reset-password-footer mt-8 border-t border-theme-border/60 pt-6 text-center">
                    <a href="{{ route('login.show') }}" class="inline-flex items-center gap-2 text-sm font-bold text-brand-accent hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                        <span>{{ __('frontend.auth.back_to_login') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const form = document.getElementById('resetPasswordForm');
    const submitButton = form?.querySelector('button[type="submit"]');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');

    if (!document.getElementById('vg-reset-password-style')) {
        const style = document.createElement('style');
        style.id = 'vg-reset-password-style';
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

            .reset-password-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .reset-password-panel:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 52px rgba(0,0,0,.10);
            }

            .reset-password-input:focus {
                box-shadow: 0 0 0 4px rgba(0,224,255,.10);
            }

            .reset-password-submit {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .reset-password-submit:hover {
                transform: translateY(-1px);
            }

            .reset-password-submit.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-field-ok {
                border-color: rgba(34,197,94,.45) !important;
            }

            .vg-field-mismatch {
                border-color: rgba(239,68,68,.45) !important;
                box-shadow: 0 0 0 4px rgba(239,68,68,.08) !important;
            }

            .vg-password-toggle {
                position: absolute;
                inset-inline-end: 14px;
                top: 50%;
                transform: translateY(-50%);
                background: transparent;
                border: 0;
                color: var(--theme-muted, currentColor);
                cursor: pointer;
                opacity: .75;
                transition: opacity .2s ease, color .2s ease;
            }

            .vg-password-toggle:hover {
                opacity: 1;
                color: var(--brand-accent);
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
                .reset-password-panel:hover {
                    transform: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .reset-password-panel,
                .reset-password-submit,
                .vg-password-toggle {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [
        document.querySelector('.reset-password-icon'),
        document.querySelector('.reset-password-header h2'),
        document.querySelector('.reset-password-header p'),
        document.querySelector('.reset-password-alert'),
        document.querySelector('.reset-password-form'),
        document.querySelector('.reset-password-footer')
    ].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 100 + (index * 90));
    });

    function addPasswordToggle(input) {
        if (!input || input.dataset.toggleApplied === 'true') return;

        const wrapper = input.closest('.password-wrapper');
        if (!wrapper) return;

        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'vg-password-toggle';
        toggle.setAttribute('aria-label', 'Toggle password visibility');
        toggle.innerHTML = `
            <svg class="eye-open h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z" />
                <circle cx="12" cy="12" r="3" />
            </svg>

            <svg class="eye-closed hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6A2 2 0 0012 14a2 2 0 001.4-.6M7.1 7.1C4.2 8.7 2.5 12 2.5 12s3.5 6 9.5 6c1.7 0 3.2-.5 4.4-1.2M13.8 6.2C18.7 7 21.5 12 21.5 12s-.8 1.4-2.2 2.8" />
            </svg>
        `;

        wrapper.appendChild(toggle);

        toggle.addEventListener('click', () => {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            toggle.querySelector('.eye-open')?.classList.toggle('hidden', isPassword);
            toggle.querySelector('.eye-closed')?.classList.toggle('hidden', !isPassword);
        });

        input.dataset.toggleApplied = 'true';
    }

    addPasswordToggle(passwordInput);
    addPasswordToggle(confirmPasswordInput);

    function validatePasswords() {
        if (!passwordInput || !confirmPasswordInput) return;

        confirmPasswordInput.classList.remove('vg-field-ok', 'vg-field-mismatch');

        if (!confirmPasswordInput.value) return;

        if (passwordInput.value === confirmPasswordInput.value) {
            confirmPasswordInput.classList.add('vg-field-ok');
        } else {
            confirmPasswordInput.classList.add('vg-field-mismatch');
        }
    }

    passwordInput?.addEventListener('input', validatePasswords);
    confirmPasswordInput?.addEventListener('input', validatePasswords);

    form?.addEventListener('submit', () => {
        if (!submitButton) return;

        submitButton.classList.add('is-loading');
        submitButton.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <span class="vg-spinner"></span>
                {{ __('frontend.auth.reset_password_button') }}
            </span>
        `;
    });
});
</script>
@endsection