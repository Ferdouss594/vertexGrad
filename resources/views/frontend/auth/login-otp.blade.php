@extends('frontend.layouts.app')

@section('content')
@php
    $policy = $policy ?? [
        'trusted_devices_enabled' => true,
        'recovery_codes_enabled' => true,
    ];
@endphp

<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 h-72 w-72 sm:h-96 sm:w-96 rounded-full blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>

        <div class="absolute bottom-0 right-0 h-64 w-64 sm:h-80 sm:w-80 rounded-full blur-3xl opacity-10"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 pt-32 pb-16">
        <div class="w-full max-w-md">
            <div class="otp-panel theme-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 backdrop-blur-sm">

                <div class="otp-header text-center mb-8">
                    <div class="otp-icon mx-auto mb-4 flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent shadow-brand-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/>
                            <path d="M9.5 12l1.8 1.8L15 10"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-theme-text mb-2 leading-tight">
                        {{ __('frontend.auth.verify_login_title') }}
                    </h2>

                    <p class="text-sm sm:text-base text-theme-muted leading-relaxed max-w-sm mx-auto">
                        {{ __('frontend.auth.verify_login_subtitle') }}
                    </p>
                </div>

                @if (session('status'))
                    <div class="otp-alert mb-6 rounded-2xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-500">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="otp-alert mb-6 rounded-2xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-500">
                        <ul class="list-disc list-inside space-y-1 text-start">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.otp.verify') }}" id="otpVerifyForm" class="otp-form space-y-5">
                    @csrf

                    <div>
                        <label for="code" class="mb-2 block text-sm font-bold text-theme-muted">
                            {{ __('frontend.auth.verification_code') }}
                        </label>

                        <input
                            type="text"
                            id="code"
                            name="code"
                            inputmode="numeric"
                            maxlength="6"
                            value="{{ old('code') }}"
                            required
                            autocomplete="one-time-code"
                            placeholder="000000"
                            class="otp-code-input w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-4 px-4 text-center text-xl sm:text-2xl tracking-[0.42em] text-theme-text placeholder:text-theme-muted focus:border-brand-accent focus:ring-0 transition duration-300"
                        >
                    </div>

                    @if(($policy['trusted_devices_enabled'] ?? true) === true)
                        <div class="flex items-center justify-start">
                            <label class="inline-flex items-start gap-3 text-sm text-theme-muted cursor-pointer leading-relaxed">
                                <input
                                    type="checkbox"
                                    name="trust_device"
                                    value="1"
                                    class="mt-0.5 rounded border-theme-border bg-theme-surface-2 text-brand-accent focus:ring-brand-accent"
                                >
                                <span>{{ __('frontend.auth.trust_device_30_days') }}</span>
                            </label>
                        </div>
                    @endif

                    <button
                        type="submit"
                        class="otp-submit-btn w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-base font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/>
                            <path d="M9.5 12l1.8 1.8L15 10"/>
                        </svg>
                        <span>{{ __('frontend.auth.verify_and_continue') }}</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('login.otp.resend') }}" class="otp-resend-form mt-4" id="otpResendForm">
                    @csrf
                    <button
                        type="submit"
                        class="otp-secondary-btn w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3 text-sm font-bold border border-theme-border text-theme-text hover:bg-theme-surface-2 transition duration-300"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-2.64-6.36"/>
                            <path d="M21 3v6h-6"/>
                        </svg>
                        <span>{{ __('frontend.auth.resend_code') }}</span>
                    </button>
                </form>

                @if(($policy['recovery_codes_enabled'] ?? true) === true)
                    <div class="otp-recovery mt-6 pt-6 border-t border-theme-border/60">
                        <p class="text-sm text-theme-muted mb-3 text-center">
                            {{ __('frontend.auth.cant_access_email_code') }}
                        </p>

                        <button
                            type="button"
                            id="toggleRecoveryCode"
                            class="w-full text-brand-accent text-sm font-bold hover:underline"
                        >
                            {{ __('frontend.auth.use_recovery_code_instead') }}
                        </button>

                        <div id="recoveryCodeBox" class="hidden mt-4">
                            <form method="POST" action="{{ route('login.otp.recovery') }}" class="space-y-4">
                                @csrf

                                <input
                                    type="text"
                                    name="recovery_code"
                                    required
                                    placeholder="{{ __('frontend.auth.recovery_code_placeholder') }}"
                                    class="w-full rounded-2xl border border-theme-border bg-theme-surface-2 py-3.5 px-4 text-theme-text placeholder:text-theme-muted focus:border-brand-accent focus:ring-0 transition duration-300"
                                >

                                <button
                                    type="submit"
                                    class="otp-secondary-btn w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3 text-sm font-bold border border-theme-border text-theme-text hover:bg-theme-surface-2 transition duration-300"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 2l-2 2"/>
                                        <path d="M15.5 7.5l3.5-3.5"/>
                                        <circle cx="9" cy="15" r="6"/>
                                        <path d="M9 15h.01"/>
                                    </svg>
                                    <span>{{ __('frontend.auth.use_recovery_code') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <div class="otp-footer mt-8 border-t border-theme-border/60 pt-6 text-center">
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

    const panel = document.querySelector('.otp-panel');
    const codeInput = document.getElementById('code');
    const verifyForm = document.getElementById('otpVerifyForm');
    const resendForm = document.getElementById('otpResendForm');
    const verifyButton = verifyForm?.querySelector('button[type="submit"]');
    const resendButton = resendForm?.querySelector('button[type="submit"]');
    const toggleRecoveryButton = document.getElementById('toggleRecoveryCode');
    const recoveryCodeBox = document.getElementById('recoveryCodeBox');

    if (!document.getElementById('vg-login-otp-style')) {
        const style = document.createElement('style');
        style.id = 'vg-login-otp-style';
        style.textContent = `
            @keyframes vgSpin {
                from { transform: rotate(0deg); }
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

            .otp-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .otp-panel:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 52px rgba(0,0,0,.10);
            }

            .otp-submit-btn,
            .otp-secondary-btn {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease, background-color .22s ease;
            }

            .otp-submit-btn:hover,
            .otp-secondary-btn:hover {
                transform: translateY(-1px);
            }

            .otp-submit-btn.is-loading,
            .otp-secondary-btn.is-loading {
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

            .otp-code-input {
                caret-color: var(--brand-accent);
            }

            @media (max-width: 640px) {
                .otp-panel:hover {
                    transform: none;
                }

                .otp-code-input {
                    letter-spacing: .32em;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .otp-panel,
                .otp-submit-btn,
                .otp-secondary-btn {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    const revealItems = [
        document.querySelector('.otp-icon'),
        document.querySelector('.otp-header h2'),
        document.querySelector('.otp-header p'),
        document.querySelector('.otp-alert'),
        document.querySelector('.otp-form'),
        document.querySelector('.otp-resend-form'),
        document.querySelector('.otp-recovery'),
        document.querySelector('.otp-footer')
    ].filter(Boolean);

    revealItems.forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 100 + (index * 90));
    });

    if (codeInput) {
        codeInput.focus();

        codeInput.addEventListener('input', () => {
            codeInput.value = codeInput.value.replace(/\D/g, '').slice(0, 6);
        });

        codeInput.addEventListener('paste', (event) => {
            event.preventDefault();

            const pasted = (event.clipboardData || window.clipboardData).getData('text');
            codeInput.value = pasted.replace(/\D/g, '').slice(0, 6);
        });
    }

    if (toggleRecoveryButton && recoveryCodeBox) {
        toggleRecoveryButton.addEventListener('click', () => {
            recoveryCodeBox.classList.toggle('hidden');

            if (!recoveryCodeBox.classList.contains('hidden')) {
                const recoveryInput = recoveryCodeBox.querySelector('input[name="recovery_code"]');
                recoveryInput?.focus();
            }
        });
    }

    if (verifyButton) {
        verifyForm?.addEventListener('submit', () => {
            verifyButton.classList.add('is-loading');
            verifyButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <span class="vg-spinner"></span>
                    {{ __('frontend.auth.verify_and_continue') }}
                </span>
            `;
        });
    }

    if (resendButton) {
        resendForm?.addEventListener('submit', () => {
            resendButton.classList.add('is-loading');
            resendButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <span class="vg-spinner"></span>
                    {{ __('frontend.auth.resend_code') }}
                </span>
            `;
        });
    }
});
</script>
@endsection