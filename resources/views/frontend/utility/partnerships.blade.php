@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-12 sm:py-16 lg:py-20 bg-theme-bg transition-colors duration-300 overflow-x-hidden">
    <div class="w-full max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">

        <header class="text-center mb-10 sm:mb-12 lg:mb-16">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-theme-text mb-3 sm:mb-4 leading-tight break-words">
                {{ __('frontend.partnerships.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.partnerships.title_highlight') }}</span>
            </h1>
            <p class="text-base sm:text-lg lg:text-xl text-theme-muted max-w-3xl mx-auto leading-7">
                {{ __('frontend.partnerships.subtitle') }}
            </p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
            <div class="theme-panel p-5 sm:p-6 rounded-xl text-center min-w-0">
                <i class="fas fa-university text-3xl sm:text-4xl text-brand-accent mb-4"></i>
                <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.partnerships.card1_title') }}</h3>
                <p class="text-theme-muted text-sm leading-6">
                    {{ __('frontend.partnerships.card1_text') }}
                </p>
            </div>

            <div class="theme-panel p-5 sm:p-6 rounded-xl text-center min-w-0">
                <i class="fas fa-lock text-3xl sm:text-4xl text-brand-accent mb-4"></i>
                <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.partnerships.card2_title') }}</h3>
                <p class="text-theme-muted text-sm leading-6">
                    {{ __('frontend.partnerships.card2_text') }}
                </p>
            </div>

            <div class="theme-panel p-5 sm:p-6 rounded-xl text-center min-w-0">
                <i class="fas fa-bullseye text-3xl sm:text-4xl text-brand-accent mb-4"></i>
                <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.partnerships.card3_title') }}</h3>
                <p class="text-theme-muted text-sm leading-6">
                    {{ __('frontend.partnerships.card3_text') }}
                </p>
            </div>
        </div>

        <div class="mt-12 sm:mt-16 text-center">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-theme-text mb-3 sm:mb-4 break-words">{{ __('frontend.partnerships.cta_title') }}</h2>
            <p class="text-base sm:text-lg lg:text-xl text-theme-muted mb-6 sm:mb-8 max-w-2xl mx-auto leading-7">
                {{ __('frontend.partnerships.cta_text') }}
            </p>

            <a href="/contact"
               class="inline-flex w-full sm:w-auto items-center justify-center rounded-lg px-6 sm:px-10 py-3 text-base sm:text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft text-center">
                {{ __('frontend.partnerships.cta_button') }} <i class="fas fa-envelope ml-3"></i>
            </a>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-partnerships-motion-style')) {
        const style = document.createElement('style');
        style.id = 'vg-partnerships-motion-style';
        style.innerHTML = `
            @keyframes vgSpin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .vg-progress-line {
                position: fixed;
                top: 0;
                left: 0;
                height: 3px;
                width: 0%;
                z-index: 9999;
                pointer-events: none;
                background: linear-gradient(90deg, rgba(99,102,241,0.98), rgba(34,197,94,0.98));
                box-shadow: 0 0 18px rgba(99,102,241,0.28);
                transition: width 0.08s linear;
            }

            .vg-reveal-up {
                opacity: 0;
                transform: translateY(24px);
                transition: opacity .7s ease, transform .7s cubic-bezier(0.22, 1, 0.36, 1);
            }

            .vg-visible {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }

            .vg-card-hover {
                transition: transform .28s ease, box-shadow .28s ease;
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(99,102,241,0.18);
                border-radius: 12px;
            }

            @media (hover: hover) and (pointer: fine) {
                .vg-card-hover:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 22px 48px rgba(0,0,0,0.09);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal-up,
                .vg-card-hover {
                    transition: none !important;
                    transform: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    const progress = document.createElement('div');
    progress.className = 'vg-progress-line';
    document.body.appendChild(progress);

    function updateProgress() {
        const scrollTop = window.scrollY || window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const percent = docHeight > 0 ? Math.min((scrollTop / docHeight) * 100, 100) : 0;
        progress.style.width = percent + '%';
    }

    updateProgress();
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);

    const header = document.querySelector('header');
    const cards = Array.from(document.querySelectorAll('.grid.grid-cols-1.md\\:grid-cols-3 > .theme-panel'));
    const ctaSection = document.querySelector('.mt-12.text-center, .mt-16.text-center');
    const ctaButton = ctaSection ? ctaSection.querySelector('a[href]') : null;

    [header, ...cards, ctaSection].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal-up');

        if (prefersReducedMotion) {
            el.classList.add('vg-visible');
            return;
        }

        setTimeout(() => el.classList.add('vg-visible'), 100 + (index * 120));
    });

    cards.forEach(card => {
        card.classList.add('vg-card-hover');
    });

    document.querySelectorAll('a, button').forEach(el => {
        el.classList.add('vg-focus-ring');
    });

    if (ctaButton) {
        const originalHTML = ctaButton.innerHTML;

        ctaButton.addEventListener('click', function () {
            ctaButton.style.pointerEvents = 'none';
            ctaButton.style.opacity = '0.92';
            ctaButton.innerHTML = `
                <span style="display:inline-flex;align-items:center;gap:10px;">
                    <span style="width:16px;height:16px;border:2px solid rgba(255,255,255,0.45);border-top-color:#ffffff;border-radius:50%;display:inline-block;animation: vgSpin .7s linear infinite;"></span>
                    Opening...
                </span>
            `;

            setTimeout(() => {
                ctaButton.style.pointerEvents = '';
                ctaButton.style.opacity = '';
                ctaButton.innerHTML = originalHTML;
            }, 1800);
        });
    }
});
</script>
@endsection