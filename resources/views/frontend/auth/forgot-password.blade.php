@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-md p-8 rounded-xl theme-panel shadow-brand-soft">

        <i class="fas fa-lock text-4xl text-brand-accent mb-4 block text-center"
           style="filter: drop-shadow(0 0 8px var(--brand-accent-glow));"></i>

        <h2 class="text-3xl font-bold text-center text-theme-text mb-2">
            {{ __('frontend.auth.forgot_password_title') }}
        </h2>

        <p class="text-center text-theme-muted mb-8">
            {{ __('frontend.auth.forgot_password_subtitle') }}
        </p>

        <form action="/forgot-password" method="POST">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-theme-muted mb-2">{{ __('frontend.auth.email') }}</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <button
                type="submit"
                class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
            >
                {{ __('frontend.auth.send_reset_link') }}
            </button>
        </form>

        <p class="mt-8 text-center text-theme-muted text-sm">
            {{ __('frontend.auth.remember_password') }}
            <a href="/login" class="text-brand-accent font-medium ml-1">
                {{ __('frontend.auth.log_in') }}
            </a>
        </p>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const panel = document.querySelector('.theme-panel');
    const topIcon = document.querySelector('.theme-panel > i');
    const heading = document.querySelector('h2');
    const subtitle = document.querySelector('h2 + p');
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const submitButton = form?.querySelector('button[type="submit"]');
    const backLink = document.querySelector('a[href*="login"]');

    if (!document.getElementById('vg-forgot-password-style')) {
        const style = document.createElement('style');
        style.id = 'vg-forgot-password-style';
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
                transition: box-shadow .28s ease, transform .28s ease;
            }

            .vg-auth-panel:hover {
                box-shadow: 0 22px 52px rgba(0,0,0,.10);
            }

            .vg-auth-input {
                transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
            }

            .vg-auth-input:focus {
                box-shadow: 0 0 0 4px rgba(99,102,241,.10);
            }

            .vg-auth-btn {
                transition: transform .22s ease, box-shadow .22s ease, opacity .22s ease;
            }

            .vg-auth-btn:hover {
                transform: translateY(-1px);
            }

            .vg-auth-btn.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(99,102,241,.16);
                border-radius: 12px;
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .vg-auth-panel,
                .vg-auth-input,
                .vg-auth-btn {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [panel, topIcon, heading, subtitle, form].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => el.classList.add('is-visible'), 100 + (index * 110));
    });

    if (panel) panel.classList.add('vg-auth-panel');
    if (emailInput) emailInput.classList.add('vg-auth-input', 'vg-focus-ring');
    if (backLink) backLink.classList.add('vg-focus-ring');

    if (submitButton) {
        submitButton.classList.add('vg-auth-btn', 'vg-focus-ring');

        form?.addEventListener('submit', () => {
            submitButton.classList.add('is-loading');
            submitButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    {{ __('frontend.auth.send_reset_link') }}
                </span>
            `;
        });
    }
});
</script>
@endsection