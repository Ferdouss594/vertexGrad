@extends('frontend.layouts.app')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="min-h-screen bg-theme-bg transition-colors duration-300 relative overflow-x-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute bottom-0 right-0 h-80 w-80 blur-3xl opacity-10"
             style="background: radial-gradient(circle, var(--brand-accent) 0%, transparent 70%);"></div>
    </div>

    <div class="register-page-shell relative min-h-[calc(100vh-80px)] flex items-start justify-center px-4 sm:px-6 lg:px-8 pb-24" style="padding-top: 120px;">
        <div class="w-full max-w-2xl">

            <div class="theme-panel register-panel rounded-3xl shadow-brand-soft border border-theme-border/60 p-6 sm:p-8 lg:p-10">

                <div class="text-center mb-8 sm:mb-10 register-header">
                    <div class="mx-auto mb-5 flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/>
                        </svg>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-black text-theme-text leading-tight">
                        {{ __('frontend.auth.academic') }}
                        <span class="text-brand-accent">{{ __('frontend.auth.registration') }}</span>
                    </h2>

                    <p class="text-theme-muted mt-3 text-sm sm:text-base leading-7 max-w-xl mx-auto">
                        {{ __('frontend.auth.academic_register_text') }}
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

                <form method="POST" action="{{ route('register.student.post') }}" class="space-y-6 register-form" id="academicRegisterForm">
                    @csrf

                    @foreach([
                        ['name'=>'name','label'=>__('frontend.auth.full_name')],
                        ['name'=>'username','label'=>__('frontend.auth.username')],
                        ['name'=>'email','label'=>__('frontend.auth.university_email'),'type'=>'email'],
                    ] as $field)
                        <div>
                            <label class="block text-sm font-bold text-theme-muted mb-2">
                                {{ $field['label'] }}
                            </label>

                            <input
                                type="{{ $field['type'] ?? 'text' }}"
                                name="{{ $field['name'] }}"
                                value="{{ old($field['name']) }}"
                                required
                                class="register-input"
                            >
                        </div>
                    @endforeach

                    <div>
                        <label class="block text-sm font-bold text-theme-muted mb-2">
                            {{ __('frontend.auth.password') }}
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            class="register-input"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-theme-muted mb-2">
                            {{ __('frontend.auth.confirm_password') }}
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="register-input"
                        >
                    </div>

                    <button type="submit" class="register-submit w-full min-h-[56px] inline-flex items-center justify-center rounded-2xl px-6 py-4 text-base sm:text-lg font-black bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                        {{ __('frontend.auth.create_academic_account') }}
                    </button>
                </form>

                <p class="mt-8 text-center text-sm sm:text-base text-theme-muted leading-7">
                    {{ __('frontend.auth.already_have_account') }}
                    <a href="{{ route('login.show') }}" class="text-brand-accent font-bold underline">
                        {{ __('frontend.auth.log_in') }}
                    </a>
                </p>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('academicRegisterForm');
    const btn = form?.querySelector('button[type="submit"]');

    if (!document.getElementById('vg-register-page-style')) {
        const style = document.createElement('style');
        style.id = 'vg-register-page-style';
        style.textContent = `
            @keyframes vgRegisterSpin {
                to { transform: rotate(360deg); }
            }

            .register-panel {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .register-input {
                width: 100%;
                min-height: 56px;
                border-radius: 1rem;
                border: 1px solid var(--theme-border);
                background: var(--theme-surface-2);
                color: var(--theme-text);
                padding: 1rem 1.25rem;
                font-size: 1rem;
                transition: border-color .3s ease, box-shadow .3s ease, background-color .3s ease;
            }

            .register-input:focus {
                outline: none;
                border-color: var(--brand-accent);
                box-shadow: 0 0 0 4px rgba(0,224,255,.10);
            }

            .register-submit {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .register-submit.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-register-spinner {
                width: 16px;
                height: 16px;
                border: 2px solid rgba(255,255,255,.45);
                border-top-color: #fff;
                border-radius: 9999px;
                display: inline-block;
                animation: vgRegisterSpin .7s linear infinite;
            }

            @media (hover: hover) and (pointer: fine) {
                .register-panel:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 22px 52px rgba(0,0,0,.10);
                }

                .register-submit:hover {
                    transform: translateY(-1px);
                }
            }

            @media (max-width: 640px) {
                .register-page-shell {
                    padding-top: 112px !important;
                    padding-bottom: 72px !important;
                }

                input,
                button {
                    font-size: 16px;
                }
            }

            @media (min-width: 1024px) {
                .register-page-shell {
                    padding-top: 125px !important;
                    padding-bottom: 96px !important;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .register-panel,
                .register-submit {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    form?.addEventListener('submit', () => {
        if (!btn) return;

        btn.classList.add('is-loading');
        btn.innerHTML = `<span class="inline-flex items-center gap-2">
            <span class="vg-register-spinner"></span>
            {{ __('frontend.auth.create_academic_account') }}
        </span>`;
    });
});
</script>
@endsection