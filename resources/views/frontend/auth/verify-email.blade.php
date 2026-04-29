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
            <div class="verify-email-panel theme-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 backdrop-blur-sm">

                <div class="verify-email-header text-center mb-8">
                    <div class="verify-email-icon mx-auto mb-4 flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent shadow-brand-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11Z"/>
                            <path d="m4.8 7.2 6.1 5a1.8 1.8 0 0 0 2.2 0l6.1-5"/>
                            <path d="M9 15h6"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-theme-text mb-2 leading-tight">
                        {{ __('frontend.verify_email.title') }}
                    </h2>

                    <p class="text-sm sm:text-base text-theme-muted leading-relaxed max-w-sm mx-auto">
                        {{ __('frontend.verify_email.subtitle') }}
                    </p>
                </div>

                @if (session('success'))
                    <div class="verify-email-alert mb-6 rounded-2xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-500">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="verify-email-alert mb-6 rounded-2xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-500">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16v16H4z"/>
                                <path d="m4 7 8 6 8-6"/>
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" id="verifyEmailForm" class="verify-email-form space-y-4">
                    @csrf
                    <button
                        type="submit"
                        class="verify-email-primary-btn w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-base font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m22 2-7 20-4-9-9-4 20-7Z"/>
                            <path d="M22 2 11 13"/>
                        </svg>
                        <span>{{ __('frontend.verify_email.resend') }}</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('frontend.logout') }}" id="verifyLogoutForm" class="verify-logout-form mt-4">
                    @csrf
                    <button
                        type="submit"
                        class="verify-email-secondary-btn w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3 text-sm font-bold border border-theme-border text-theme-text hover:bg-theme-surface-2 transition duration-300"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <path d="m16 17 5-5-5-5"/>
                            <path d="M21 12H9"/>
                        </svg>
                        <span>{{ __('frontend.verify_email.logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const verifyForm = document.getElementById('verifyEmailForm');
    const logoutForm = document.getElementById('verifyLogoutForm');
    const verifyButton = verifyForm?.querySelector('button[type="submit"]');
    const logoutButton = logoutForm?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-verify-email-style')) {
        const style = document.createElement('style');
        style.id = 'vg-verify-email-style';
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

            .verify-email-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .verify-email-panel:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 52px rgba(0,0,0,.10);
            }

            .verify-email-primary-btn,
            .verify-email-secondary-btn {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease, background-color .22s ease;
            }

            .verify-email-primary-btn:hover,
            .verify-email-secondary-btn:hover {
                transform: translateY(-1px);
            }

            .verify-email-primary-btn.is-loading,
            .verify-email-secondary-btn.is-loading {
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

            .vg-spinner-muted {
                border-color: rgba(148,163,184,.45);
                border-top-color: var(--brand-accent);
            }

            @media (max-width: 640px) {
                .verify-email-panel:hover {
                    transform: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .verify-email-panel,
                .verify-email-primary-btn,
                .verify-email-secondary-btn {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [
        document.querySelector('.verify-email-icon'),
        document.querySelector('.verify-email-header h2'),
        document.querySelector('.verify-email-header p'),
        document.querySelector('.verify-email-alert'),
        document.querySelector('.verify-email-form'),
        document.querySelector('.verify-logout-form')
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

    verifyForm?.addEventListener('submit', () => {
        if (!verifyButton) return;

        verifyButton.classList.add('is-loading');
        verifyButton.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <span class="vg-spinner"></span>
                {{ __('frontend.verify_email.resend') }}
            </span>
        `;
    });

    logoutForm?.addEventListener('submit', () => {
        if (!logoutButton) return;

        logoutButton.classList.add('is-loading');
        logoutButton.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <span class="vg-spinner vg-spinner-muted"></span>
                {{ __('frontend.verify_email.logout') }}
            </span>
        `;
    });
});
</script>
@endsection