@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 sm:py-14 lg:py-16 bg-theme-bg transition-colors duration-300 overflow-x-hidden">
    <div class="w-full max-w-4xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="w-full p-4 sm:p-6 md:p-8 lg:p-10 rounded-3xl sm:rounded-[2rem] theme-panel shadow-brand-soft">

            <div class="mb-6 sm:mb-8">
                <h3 class="text-base sm:text-lg md:text-xl font-semibold text-theme-text mb-2 break-words">
                    {{ __('frontend.submit_step4.step_title') }}
                </h3>
                <div class="h-2 bg-theme-surface-2 rounded-full overflow-hidden">
                    <div class="h-full bg-brand-accent" style="width: 80%;"></div>
                </div>
            </div>

            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-theme-text mb-2 leading-tight break-words">
                {{ __('frontend.submit_step4.page_title') }}
            </h2>

            <p class="text-sm sm:text-base md:text-lg text-theme-muted mb-6 sm:mb-8 lg:mb-10 leading-6 sm:leading-7">
                {{ __('frontend.submit_step4.page_subtitle') }}
            </p>

            @if ($errors->any())
                <div class="mb-5 sm:mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-600 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="break-words">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('project.submit.step4.post') }}" method="POST" class="space-y-5 sm:space-y-6 lg:space-y-8">
                @csrf

                <div class="border border-theme-border p-4 sm:p-5 md:p-6 rounded-2xl bg-theme-surface-2 min-w-0">
                    <h4 class="text-xl sm:text-2xl font-semibold text-brand-accent mb-4 break-words">
                        {{ __('frontend.submit_step4.account_information') }}
                    </h4>

                    <p class="text-sm text-theme-muted mb-5 sm:mb-6 leading-6 break-words">
                        {{ __('frontend.submit_step4.account_information_text') }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div class="md:col-span-2 min-w-0">
                            <label for="email" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step4.email') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                required
                                value="{{ old('email', session('user_data.email')) }}"
                                placeholder="{{ __('frontend.submit_step4.email_placeholder') }}"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                        </div>

                        <div class="min-w-0">
                            <label for="password" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step4.password') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                minlength="8"
                                autocomplete="new-password"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >

                            <div class="mt-3 rounded-xl border border-theme-border bg-theme-surface p-3">
                                <p class="text-xs font-bold text-theme-text mb-2">
                                    Password must include:
                                </p>
                                <ul class="space-y-1 text-xs text-theme-muted" data-password-rules>
                                    <li data-rule="length">At least 8 characters</li>
                                    <li data-rule="lowercase">One lowercase letter</li>
                                    <li data-rule="uppercase">One uppercase letter</li>
                                    <li data-rule="number">One number</li>
                                    <li data-rule="special">One special character</li>
                                    <li data-rule="spaces">No spaces</li>
                                </ul>
                                <p class="mt-3 text-xs font-semibold text-red-600 hidden" data-password-warning>
                                    Please complete the password requirements above.
                                </p>
                            </div>
                        </div>

                        <div class="min-w-0">
                            <label for="password_confirmation" class="block text-sm font-medium text-theme-muted mb-2">
                                {{ __('frontend.submit_step4.confirm_password') }} <span class="text-brand-accent">*</span>
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                minlength="8"
                                autocomplete="new-password"
                                class="w-full min-w-0 p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent text-sm sm:text-base"
                            >
                            <p class="mt-2 text-xs text-theme-muted" data-password-match>
                                Password confirmation must match.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border border-theme-border p-4 sm:p-5 md:p-6 rounded-2xl bg-theme-surface-2 min-w-0">
                    <h4 class="text-xl sm:text-2xl font-semibold text-brand-accent mb-4 break-words">
                        {{ __('frontend.submit_step4.submission_confirmation') }}
                    </h4>

                    <div class="space-y-4">
                        <label class="flex items-start text-theme-text">
                            <input
                                type="checkbox"
                                name="data_confirmation"
                                value="1"
                                required
                                class="form-checkbox h-5 w-5 mt-1 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent shrink-0"
                            >
                            <span class="ml-3 text-sm leading-6 break-words">
                                {{ __('frontend.submit_step4.data_confirmation_text') }}
                            </span>
                        </label>

                        <label class="flex items-start text-theme-text">
                            <input
                                type="checkbox"
                                name="terms_agreement"
                                value="1"
                                required
                                class="form-checkbox h-5 w-5 mt-1 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent shrink-0"
                            >
                            <span class="ml-3 text-sm leading-6 break-words">
                                {!! __('frontend.submit_step4.terms_agreement_text') !!}
                            </span>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-4 pt-2 sm:pt-4">
                    <a
                        href="{{ route('project.submit.step3') }}"
                        class="inline-flex w-full sm:w-auto items-center justify-center rounded-lg px-6 sm:px-8 py-3 text-base sm:text-lg font-semibold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300 text-center"
                    >
                        <i class="fas fa-arrow-left mr-2"></i> {{ __('frontend.common.back') }}
                    </a>

                    <button
                        type="submit"
                        class="inline-flex w-full sm:w-auto items-center justify-center rounded-lg px-6 sm:px-8 py-3 text-base sm:text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft text-center"
                    >
                        {{ __('frontend.common.save_continue') }} <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const pagePanel = document.querySelector('.theme-panel');
    const progressLabel = document.querySelector('.mb-6 h3, .mb-8 h3');
    const progressBar = document.querySelector('.mb-6 .bg-brand-accent, .mb-8 .bg-brand-accent');
    const heading = document.querySelector('h2');
    const subtitle = document.querySelector('h2 + p');
    const errorBox = document.querySelector('.bg-red-500\\/10');
    const form = document.querySelector('form');
    const cards = Array.from(document.querySelectorAll('form .border.border-theme-border'));
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const passwordRules = Array.from(document.querySelectorAll('[data-password-rules] [data-rule]'));
    const passwordWarning = document.querySelector('[data-password-warning]');
    const passwordMatchText = document.querySelector('[data-password-match]');
    const checkboxes = Array.from(document.querySelectorAll('input[type="checkbox"]'));
    const backLink = form?.querySelector('a[href*="step3"]');
    const submitButton = form?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-submit-step4-style')) {
        const style = document.createElement('style');
        style.id = 'vg-submit-step4-style';
        style.textContent = `
            .vg-reveal {
                opacity: 0;
                transform: translateY(16px);
                transition: opacity .6s ease, transform .6s cubic-bezier(.22,1,.36,1);
            }

            .vg-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .vg-card {
                transition: box-shadow .22s ease, border-color .22s ease;
            }

            @media (hover: hover) and (pointer: fine) {
                .vg-card:hover {
                    box-shadow: 0 16px 36px rgba(0,0,0,.05);
                    border-color: rgba(99,102,241,.14);
                }

                .vg-btn:hover,
                .vg-back-link:hover {
                    transform: translateY(-1px);
                }
            }

            .vg-field {
                max-width: 100%;
                transition: border-color .2s ease, box-shadow .2s ease;
            }

            .vg-field:focus {
                box-shadow: 0 0 0 4px rgba(99,102,241,.10);
            }

            .vg-field.is-ok {
                border-color: rgba(34,197,94,.42);
            }

            .vg-field.is-warning {
                border-color: rgba(245,158,11,.55);
                box-shadow: 0 0 0 4px rgba(245,158,11,.10);
            }

            .vg-field.is-error {
                border-color: rgba(239,68,68,.50);
                box-shadow: 0 0 0 4px rgba(239,68,68,.10);
            }

            .vg-rule {
                display: flex;
                align-items: flex-start;
                gap: 8px;
                line-height: 1.45;
                transition: color .2s ease;
            }

            .vg-rule::before {
                content: "•";
                font-weight: 900;
                line-height: 1.45;
            }

            .vg-rule.is-valid {
                color: rgb(22,163,74);
            }

            .vg-rule.is-invalid {
                color: rgb(220,38,38);
            }

            .vg-check-row {
                padding: 8px;
                margin: -8px;
                transition: background-color .2s ease, box-shadow .2s ease, border-radius .2s ease;
            }

            .vg-check-row.is-checked {
                background-color: rgba(99,102,241,.05);
                box-shadow: inset 0 0 0 1px rgba(99,102,241,.16);
                border-radius: 14px;
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
                transition: opacity .2s ease;
            }

            .vg-password-toggle:hover {
                opacity: 1;
            }

            .vg-password-input {
                padding-right: 42px !important;
            }

            .vg-btn,
            .vg-back-link {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .vg-btn.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(99,102,241,.16);
                border-radius: 12px;
            }

            @media (max-width: 640px) {
                .vg-reveal {
                    transform: translateY(12px);
                }

                input,
                button,
                select,
                textarea {
                    font-size: 16px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .vg-card,
                .vg-field,
                .vg-check-row,
                .vg-password-toggle,
                .vg-btn,
                .vg-back-link {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [pagePanel, progressLabel, heading, subtitle, errorBox, ...cards].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (cards.includes(el)) {
            el.classList.add('vg-card');
        }

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => el.classList.add('is-visible'), 70 + (index * 85));
    });

    if (progressBar && !prefersReducedMotion) {
        progressBar.style.width = '0%';
        progressBar.style.transition = 'width .9s cubic-bezier(.22,1,.36,1)';

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                progressBar.style.width = '80%';
            });
        });
    }

    [emailInput, passwordInput, confirmPasswordInput].filter(Boolean).forEach(field => {
        field.classList.add('vg-field', 'vg-focus-ring');
    });

    passwordRules.forEach(rule => {
        rule.classList.add('vg-rule');
    });

    function addPasswordToggle(input) {
        if (!input || input.dataset.toggleApplied === 'true') return;

        const wrapper = document.createElement('div');
        wrapper.className = 'vg-password-wrap';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        input.classList.add('vg-password-input');

        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'vg-password-toggle vg-focus-ring';
        toggle.setAttribute('aria-label', 'Show or hide password');
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

    function getPasswordChecks(value) {
        return {
            length: value.length >= 8,
            lowercase: /[a-z]/.test(value),
            uppercase: /[A-Z]/.test(value),
            number: /\d/.test(value),
            special: /[^A-Za-z0-9\s]/.test(value),
            spaces: !/\s/.test(value) && value.length > 0
        };
    }

    function getMissingPasswordRules(checks) {
        const missing = [];

        if (!checks.length) missing.push('at least 8 characters');
        if (!checks.lowercase) missing.push('one lowercase letter');
        if (!checks.uppercase) missing.push('one uppercase letter');
        if (!checks.number) missing.push('one number');
        if (!checks.special) missing.push('one special character');
        if (!checks.spaces) missing.push('no spaces');

        return missing;
    }

    function validatePasswords(showWarnings = false) {
        if (!passwordInput || !confirmPasswordInput) return true;

        const password = passwordInput.value || '';
        const confirmation = confirmPasswordInput.value || '';
        const checks = getPasswordChecks(password);
        const missing = getMissingPasswordRules(checks);
        const passwordIsValid = missing.length === 0;
        const confirmationMatches = passwordIsValid && confirmation.length > 0 && password === confirmation;

        passwordRules.forEach(rule => {
            const key = rule.dataset.rule;
            const valid = Boolean(checks[key]);

            rule.classList.toggle('is-valid', valid);
            rule.classList.toggle('is-invalid', showWarnings && !valid);
        });

        passwordInput.classList.remove('is-ok', 'is-warning', 'is-error');
        confirmPasswordInput.classList.remove('is-ok', 'is-warning', 'is-error');

        if (password.length > 0 && passwordIsValid) {
            passwordInput.classList.add('is-ok');
            passwordInput.setCustomValidity('');
        } else if (password.length > 0 || showWarnings) {
            passwordInput.classList.add(showWarnings ? 'is-error' : 'is-warning');
            passwordInput.setCustomValidity('Password must include ' + missing.join(', ') + '.');
        } else {
            passwordInput.setCustomValidity('');
        }

        if (confirmation.length > 0 && confirmationMatches) {
            confirmPasswordInput.classList.add('is-ok');
            confirmPasswordInput.setCustomValidity('');
            if (passwordMatchText) {
                passwordMatchText.textContent = 'Passwords match.';
                passwordMatchText.classList.remove('text-red-600');
                passwordMatchText.classList.add('text-green-600');
            }
        } else if (confirmation.length > 0 || showWarnings) {
            confirmPasswordInput.classList.add(showWarnings ? 'is-error' : 'is-warning');
            confirmPasswordInput.setCustomValidity('Password confirmation must match.');
            if (passwordMatchText) {
                passwordMatchText.textContent = 'Password confirmation must match.';
                passwordMatchText.classList.remove('text-green-600');
                passwordMatchText.classList.add('text-red-600');
            }
        } else {
            confirmPasswordInput.setCustomValidity('');
            if (passwordMatchText) {
                passwordMatchText.textContent = 'Password confirmation must match.';
                passwordMatchText.classList.remove('text-green-600', 'text-red-600');
            }
        }

        if (passwordWarning) {
            passwordWarning.classList.toggle('hidden', passwordIsValid || (!showWarnings && password.length === 0));
            passwordWarning.textContent = passwordIsValid
                ? ''
                : 'Password needs: ' + missing.join(', ') + '.';
        }

        return passwordIsValid && confirmationMatches;
    }

    passwordInput?.addEventListener('input', () => validatePasswords(false));
    confirmPasswordInput?.addEventListener('input', () => validatePasswords(false));
    passwordInput?.addEventListener('blur', () => validatePasswords(true));
    confirmPasswordInput?.addEventListener('blur', () => validatePasswords(true));

    validatePasswords(false);

    checkboxes.forEach(checkbox => {
        const label = checkbox.closest('label');
        if (!label) return;

        label.classList.add('vg-check-row', 'vg-focus-ring');

        const syncState = () => {
            label.classList.toggle('is-checked', checkbox.checked);
        };

        syncState();
        checkbox.addEventListener('change', syncState);
    });

    if (backLink) {
        backLink.classList.add('vg-back-link', 'vg-focus-ring');
    }

    if (submitButton) {
        submitButton.classList.add('vg-btn', 'vg-focus-ring');

        form?.addEventListener('submit', event => {
            const validPassword = validatePasswords(true);

            if (!validPassword) {
                event.preventDefault();
                passwordInput?.reportValidity();
                passwordInput?.focus();
                return;
            }

            submitButton.classList.add('is-loading');
            submitButton.innerHTML = `
                <span class="inline-flex items-center justify-center gap-2">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    {{ __('frontend.common.save_continue') }}
                </span>
            `;
        });
    }
});
</script>
@endsection