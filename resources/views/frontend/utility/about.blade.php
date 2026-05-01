@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-12 sm:py-16 lg:py-20 bg-theme-bg transition-colors duration-300 overflow-x-hidden">
    <div class="w-full max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">

        <header class="text-center mb-10 sm:mb-12 lg:mb-16">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-theme-text mb-3 sm:mb-4 leading-tight break-words">
                {{ __('frontend.about.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.about.title_highlight') }}</span>
            </h1>
            <p class="text-base sm:text-lg lg:text-xl text-theme-muted max-w-3xl mx-auto leading-7">
                {{ __('frontend.about.subtitle') }}
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6 lg:gap-8 items-stretch">
            <div class="theme-panel p-5 sm:p-6 lg:p-8 rounded-2xl min-w-0">
                <h2 class="text-2xl sm:text-3xl font-bold text-theme-text mb-3 sm:mb-4 break-words">{{ __('frontend.about.mission_title') }}</h2>
                <p class="text-theme-muted leading-7 sm:leading-8 text-sm sm:text-base">
                    {{ __('frontend.about.mission_text') }}
                </p>
            </div>

            <div class="theme-panel p-5 sm:p-6 lg:p-8 rounded-2xl min-w-0">
                <h2 class="text-2xl sm:text-3xl font-bold text-theme-text mb-3 sm:mb-4 break-words">{{ __('frontend.about.vision_title') }}</h2>
                <p class="text-theme-muted leading-7 sm:leading-8 text-sm sm:text-base">
                    {{ __('frontend.about.vision_text') }}
                </p>
            </div>
        </div>

        <div class="mt-8 sm:mt-10 grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
            <div class="theme-panel p-5 sm:p-6 rounded-xl text-center min-w-0">
                <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-4 rounded-full bg-brand-accent-soft flex items-center justify-center text-brand-accent text-xl sm:text-2xl">
                    <i class="fas fa-microscope"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.about.card1_title') }}</h3>
                <p class="text-theme-muted text-sm leading-6">
                    {{ __('frontend.about.card1_text') }}
                </p>
            </div>

            <div class="theme-panel p-5 sm:p-6 rounded-xl text-center min-w-0">
                <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-4 rounded-full bg-brand-accent-soft flex items-center justify-center text-brand-accent text-xl sm:text-2xl">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.about.card2_title') }}</h3>
                <p class="text-theme-muted text-sm leading-6">
                    {{ __('frontend.about.card2_text') }}
                </p>
            </div>

            <div class="theme-panel p-5 sm:p-6 rounded-xl text-center min-w-0">
                <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-4 rounded-full bg-brand-accent-soft flex items-center justify-center text-brand-accent text-xl sm:text-2xl">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.about.card3_title') }}</h3>
                <p class="text-theme-muted text-sm leading-6">
                    {{ __('frontend.about.card3_text') }}
                </p>
            </div>
        </div>

        <div class="mt-12 sm:mt-16 text-center">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-theme-text mb-3 sm:mb-4 break-words">{{ __('frontend.about.cta_title') }}</h2>
            <p class="text-base sm:text-lg lg:text-xl text-theme-muted mb-6 sm:mb-8 max-w-2xl mx-auto leading-7">
                {{ __('frontend.about.cta_text') }}
            </p>

            <a href="/contact"
               class="inline-flex w-full sm:w-auto items-center justify-center rounded-lg px-6 sm:px-10 py-3 text-base sm:text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft text-center">
                {{ __('frontend.about.cta_button') }} <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-about-motion-style')) {
        const style = document.createElement('style');
        style.id = 'vg-about-motion-style';
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
                transform: translateY(26px);
                transition: opacity .75s ease, transform .75s cubic-bezier(0.22, 1, 0.36, 1);
            }

            .vg-visible {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }

            .vg-panel-hover {
                transition: transform .28s ease, box-shadow .28s ease;
            }

            .vg-icon-hover {
                transition: transform .28s ease, box-shadow .28s ease;
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(99,102,241,0.18);
                border-radius: 12px;
            }

            @media (hover: hover) and (pointer: fine) {
                .vg-panel-hover:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 22px 48px rgba(0,0,0,0.09);
                }

                .vg-icon-hover:hover {
                    transform: translateY(-4px) scale(1.05);
                    box-shadow: 0 12px 28px rgba(99,102,241,0.18);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal-up,
                .vg-panel-hover,
                .vg-icon-hover {
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

    const revealItems = [
        document.querySelector('header'),
        ...Array.from(document.querySelectorAll('.theme-panel')),
        document.querySelector('.mt-12, .mt-16')
    ].filter(Boolean);

    revealItems.forEach((item, index) => {
        item.classList.add('vg-reveal-up');

        if (prefersReducedMotion) {
            item.classList.add('vg-visible');
            return;
        }

        setTimeout(() => item.classList.add('vg-visible'), 100 + (index * 120));
    });

    document.querySelectorAll('.theme-panel').forEach(panel => {
        panel.classList.add('vg-panel-hover');
    });

    document.querySelectorAll('.w-12.h-12, .w-14.h-14').forEach(circle => {
        circle.classList.add('vg-icon-hover');
    });

    document.querySelectorAll('a, button').forEach(el => {
        el.classList.add('vg-focus-ring');
    });

    const ctaButton = document.querySelector('a[href="/contact"]');

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