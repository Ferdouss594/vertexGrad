@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 h-72 w-72 rounded-full blur-3xl opacity-20"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
        <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full blur-3xl opacity-10"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="theme-panel rounded-2xl shadow-brand-soft border border-theme-border/60 p-8 backdrop-blur-sm">

                <div class="text-center mb-8">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20">
                        <i class="fas fa-envelope-open-text text-3xl text-brand-accent"></i>
                    </div>

                    <h2 class="text-3xl font-bold text-theme-text mb-2">
                        {{ __('Verify Your Email') }}
                    </h2>

                    <p class="text-theme-muted leading-relaxed">
                        {{ __('We sent a verification link to your email address. Please verify your account before continuing.') }}
                    </p>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-500">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-circle-check mt-0.5"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-500">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-envelope mt-0.5"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" id="verifyEmailForm" class="space-y-4">
                    @csrf
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-base font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        <i class="fas fa-paper-plane"></i>
                        <span>{{ __('Resend Verification Email') }}</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('frontend.logout') }}" id="verifyLogoutForm" class="mt-4">
                    @csrf
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold border border-theme-border text-theme-text hover:bg-theme-surface-2 transition duration-300"
                    >
                        <i class="fas fa-arrow-right-from-bracket"></i>
                        <span>{{ __('Log Out') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const panel = document.querySelector('.theme-panel');
    const verifyForm = document.getElementById('verifyEmailForm');
    const logoutForm = document.getElementById('verifyLogoutForm');
    const verifyButton = verifyForm?.querySelector('button[type="submit"]');
    const logoutButton = logoutForm?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-verify-email-style')) {
        const style = document.createElement('style');
        style.id = 'vg-verify-email-style';
        style.textContent = `
            .vg-reveal {
                opacity: 0;
                transform: translateY(18px);
                transition: opacity .65s ease, transform .65s cubic-bezier(.22,1,.36,1);
            }

            .vg-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .vg-auth-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .vg-auth-panel:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 52px rgba(0,0,0,.10);
            }

            .vg-auth-btn {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .vg-auth-btn:hover {
                transform: translateY(-1px);
            }

            .vg-auth-btn.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .vg-auth-panel,
                .vg-auth-btn {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    const revealItems = [
        document.querySelector('.theme-panel .mx-auto'),
        document.querySelector('h2'),
        document.querySelector('h2 + p'),
        document.getElementById('verifyEmailForm'),
        document.getElementById('verifyLogoutForm')
    ].filter(Boolean);

    if (panel) panel.classList.add('vg-auth-panel');

    revealItems.forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => el.classList.add('is-visible'), 100 + (index * 100));
    });

    if (verifyButton) {
        verifyButton.classList.add('vg-auth-btn');

        verifyForm?.addEventListener('submit', () => {
            verifyButton.classList.add('is-loading');
            verifyButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    {{ __('Resend Verification Email') }}
                </span>
            `;
        });
    }

    if (logoutButton) {
        logoutButton.classList.add('vg-auth-btn');

        logoutForm?.addEventListener('submit', () => {
            logoutButton.classList.add('is-loading');
            logoutButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    {{ __('Log Out') }}
                </span>
            `;
        });
    }
});
</script>
@endsection