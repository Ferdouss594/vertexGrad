@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-md p-8 rounded-xl theme-panel shadow-brand-soft">

        <i class="fas fa-key text-4xl text-brand-accent mb-4 block text-center"
           style="filter: drop-shadow(0 0 8px var(--brand-accent-glow));"></i>

        <h2 class="text-3xl font-bold text-center text-theme-text mb-2">
            {{ __('frontend.auth.reset_password_title') }}
        </h2>

        <p class="text-center text-theme-muted mb-8">
            {{ __('frontend.auth.reset_password_subtitle') }}
        </p>

        <form action="/reset-password" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token ?? '' }}">

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.auth.email') }}
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    value="{{ $email ?? old('email') }}"
                    readonly
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted opacity-70 focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.auth.new_password') }}
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div class="mb-8">
                <label for="password_confirmation" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.auth.confirm_new_password') }}
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <button
                type="submit"
                class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
            >
                {{ __('frontend.auth.reset_password_button') }}
            </button>
        </form>

        <p class="mt-8 text-center text-theme-muted text-sm">
            <a href="/login" class="text-brand-accent font-medium ml-1">
                <i class="fas fa-arrow-left mr-1"></i> {{ __('frontend.auth.back_to_login') }}
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
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const submitButton = form?.querySelector('button[type="submit"]');
    const backLink = document.querySelector('a[href*="login"]');

    if (!document.getElementById('vg-reset-password-style')) {
        const style = document.createElement('style');
        style.id = 'vg-reset-password-style';
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

            .vg-readonly-field {
                cursor: not-allowed;
            }

            .vg-field-ok {
                border-color: rgba(34,197,94,.45) !important;
            }

            .vg-field-mismatch {
                border-color: rgba(239,68,68,.45) !important;
                box-shadow: 0 0 0 4px rgba(239,68,68,.08);
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

            .vg-password-wrap {
                position: relative;
            }

            .vg-password-toggle {
                position: absolute;
                right: 14px;
                top: 50%;
                transform: translateY(-50%);
                background: transparent;
                border: 0;
                color: inherit;
                cursor: pointer;
                opacity: .75;
                transition: opacity .2s ease, transform .2s ease;
            }

            .vg-password-toggle:hover {
                opacity: 1;
            }

            .vg-password-input {
                padding-right: 42px !important;
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
                .vg-auth-btn,
                .vg-password-toggle {
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

    [emailInput, passwordInput, confirmPasswordInput].filter(Boolean).forEach(input => {
        input.classList.add('vg-auth-input', 'vg-focus-ring');
    });

    if (emailInput && emailInput.hasAttribute('readonly')) {
        emailInput.classList.add('vg-readonly-field');
    }

    if (backLink) backLink.classList.add('vg-focus-ring');

    function addPasswordToggle(input) {
        if (!input || input.dataset.toggleApplied === 'true') return;

        const wrapper = document.createElement('div');
        wrapper.className = 'vg-password-wrap';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        input.classList.add('vg-password-input');

        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'vg-password-toggle';
        toggle.innerHTML = '<i class="fas fa-eye"></i>';
        wrapper.appendChild(toggle);

        toggle.addEventListener('click', () => {
            const icon = toggle.querySelector('i');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            if (icon) {
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            }
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

    if (submitButton) {
        submitButton.classList.add('vg-auth-btn', 'vg-focus-ring');

        form?.addEventListener('submit', () => {
            submitButton.classList.add('is-loading');
            submitButton.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    {{ __('frontend.auth.reset_password_button') }}
                </span>
            `;
        });
    }
});
</script>
@endsection