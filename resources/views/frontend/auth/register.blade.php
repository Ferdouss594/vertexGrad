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
        <div class="w-full max-w-5xl text-center">

            <div class="register-choice-heading">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-theme-text mb-4 leading-tight">
                    {{ __('frontend.auth.join_the') }}
                    <span class="text-brand-accent">{{ __('frontend.auth.vertexgrad_ecosystem') }}</span>
                </h2>

                <p class="text-base sm:text-lg lg:text-xl text-theme-muted mb-10 sm:mb-14 max-w-3xl mx-auto leading-relaxed">
                    {{ __('frontend.auth.choose_registration_type') }}
                </p>
            </div>

            @if ($errors->any())
                <div class="register-choice-alert max-w-md mx-auto mb-8 p-4 rounded-2xl bg-red-500/10 border border-red-400/40 text-red-500 text-sm">
                    <ul class="list-disc list-inside text-start space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">

                <a href="{{ route('register.investor') }}"
                   class="register-choice-card p-7 sm:p-8 lg:p-10 rounded-3xl theme-panel border border-theme-border/60 hover:bg-theme-surface-2 transition duration-300 shadow-brand-soft block group text-center">
                    <div class="mx-auto mb-5 flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-3xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent shadow-brand-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 17h18M6 17V9m6 8V5m6 12v-6" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 21h16M7 9h-2a2 2 0 010-4h2m10 6h2a2 2 0 100-4h-2" />
                        </svg>
                    </div>

                    <h3 class="text-2xl sm:text-3xl font-black text-theme-text mb-3 leading-tight">
                        {{ __('frontend.auth.investor_fund_manager') }}
                    </h3>

                    <p class="text-sm sm:text-base text-theme-muted mb-7 leading-relaxed">
                        {{ __('frontend.auth.investor_register_text') }}
                    </p>

                    <span class="register-choice-cta inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3 font-bold bg-brand-accent text-white group-hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                        {{ __('frontend.auth.register_as_investor') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M20 12H4" />
                        </svg>
                    </span>
                </a>

                <a href="{{ route('register.academic') }}"
                   class="register-choice-card p-7 sm:p-8 lg:p-10 rounded-3xl theme-panel border border-theme-border/60 hover:bg-theme-surface-2 transition duration-300 shadow-brand-soft block group text-center">
                    <div class="mx-auto mb-5 flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-3xl bg-brand-accent/10 border border-brand-accent/20 text-brand-accent shadow-brand-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 3v6l-5 8a3 3 0 002.6 4.5h8.8A3 3 0 0019 17l-5-8V3" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3h8M8 15h8" />
                        </svg>
                    </div>

                    <h3 class="text-2xl sm:text-3xl font-black text-theme-text mb-3 leading-tight">
                        {{ __('frontend.auth.academic_project_creator') }}
                    </h3>

                    <p class="text-sm sm:text-base text-theme-muted mb-7 leading-relaxed">
                        {{ __('frontend.auth.academic_register_text') }}
                    </p>

                    <span class="register-choice-cta inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3 font-bold border border-brand-accent text-theme-text group-hover:bg-brand-accent group-hover:text-white transition duration-300">
                        {{ __('frontend.auth.register_as_academic') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M20 12H4" />
                        </svg>
                    </span>
                </a>

            </div>

            <p class="register-choice-login mt-10 sm:mt-12 text-center text-theme-muted text-sm">
                {{ __('frontend.auth.already_have_account') }}
                <a href="{{ route('login.show') }}" class="text-brand-accent font-bold underline">
                    {{ __('frontend.auth.log_in') }}
                </a>
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const cards = Array.from(document.querySelectorAll('.register-choice-card'));

    if (!document.getElementById('vg-register-choice-style')) {
        const style = document.createElement('style');
        style.id = 'vg-register-choice-style';
        style.textContent = `
            .vg-reveal {
                opacity: 0;
                transform: translateY(22px);
                transition: opacity .7s ease, transform .7s cubic-bezier(.22,1,.36,1);
            }

            .vg-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .register-choice-card {
                position: relative;
                overflow: hidden;
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease, background-color .28s ease, opacity .28s ease;
            }

            .register-choice-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at 50% 0%, rgba(0,224,255,.10), transparent 48%);
                opacity: 0;
                transition: opacity .28s ease;
                pointer-events: none;
            }

            .register-choice-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 22px 52px rgba(0,0,0,.12);
            }

            .register-choice-card:hover::before {
                opacity: 1;
            }

            .register-choice-cta {
                transition: transform .22s ease, box-shadow .22s ease, background-color .22s ease, color .22s ease, border-color .22s ease;
            }

            .register-choice-card:hover .register-choice-cta {
                transform: translateY(-1px);
            }

            @media (max-width: 767px) {
                .register-choice-card:hover {
                    transform: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal,
                .register-choice-card,
                .register-choice-card::before,
                .register-choice-cta {
                    transition: none !important;
                    animation: none !important;
                    transform: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    [
        document.querySelector('.register-choice-heading'),
        document.querySelector('.register-choice-alert'),
        ...cards,
        document.querySelector('.register-choice-login')
    ].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal');

        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 100 + (index * 110));
    });

    if (!prefersReducedMotion) {
        cards.forEach((card) => {
            card.addEventListener('mouseenter', () => {
                cards.forEach((otherCard) => {
                    if (otherCard !== card) {
                        otherCard.style.opacity = '0.88';
                    }
                });
            });

            card.addEventListener('mouseleave', () => {
                cards.forEach((item) => {
                    item.style.opacity = '';
                });
            });
        });
    }
});
</script>
@endsection