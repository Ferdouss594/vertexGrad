@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-12 sm:py-16 lg:py-20 bg-theme-bg transition-colors duration-300 overflow-x-hidden">
    <div class="w-full max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">

        <header class="text-center mb-10 sm:mb-12 lg:mb-16">
            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold text-theme-text mb-3 sm:mb-4 leading-tight break-words">
                {{ __('frontend.process.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.process.title_highlight') }}</span>
            </h1>
            <p class="text-base sm:text-lg lg:text-xl text-theme-muted max-w-3xl mx-auto leading-7">
                {{ __('frontend.process.subtitle') }}
            </p>
        </header>

        <div class="space-y-6 sm:space-y-8 lg:space-y-12 relative">
            <div class="absolute left-4 md:left-1/2 w-0.5 bg-brand-accent h-full transform md:-translate-x-1/2 opacity-30"></div>

            <div class="relative flex justify-start md:justify-around items-stretch md:items-center pl-10 md:pl-0">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute w-8 h-8 rounded-full bg-brand-accent border-4 border-theme-bg z-10 left-4 md:left-1/2 transform -translate-x-1/2 flex items-center justify-center text-white font-bold">1</div>
                <div class="w-full md:w-5/12 bg-theme-surface-2/70 p-5 sm:p-6 rounded-xl border border-brand-accent/30 shadow-lg md:mr-10 min-w-0">
                    <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.process.step1_title') }}</h3>
                    <p class="text-theme-muted text-sm sm:text-base leading-7">
                        {{ __('frontend.process.step1_text') }}
                    </p>
                </div>
            </div>

            <div class="relative flex justify-start md:justify-around items-stretch md:items-center pl-10 md:pl-0">
                <div class="absolute w-8 h-8 rounded-full bg-brand-accent border-4 border-theme-bg z-10 left-4 md:left-1/2 transform -translate-x-1/2 flex items-center justify-center text-white font-bold">2</div>
                <div class="w-full md:w-5/12 bg-theme-surface-2/70 p-5 sm:p-6 rounded-xl border border-brand-accent/30 shadow-lg md:ml-10 order-2 md:order-1 min-w-0">
                    <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.process.step2_title') }}</h3>
                    <p class="text-theme-muted text-sm sm:text-base leading-7">
                        {{ __('frontend.process.step2_text') }}
                    </p>
                </div>
                <div class="hidden md:block w-5/12 order-1 md:order-2"></div>
            </div>

            <div class="relative flex justify-start md:justify-around items-stretch md:items-center pl-10 md:pl-0">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute w-8 h-8 rounded-full bg-brand-accent border-4 border-theme-bg z-10 left-4 md:left-1/2 transform -translate-x-1/2 flex items-center justify-center text-white font-bold">3</div>
                <div class="w-full md:w-5/12 bg-theme-surface-2/70 p-5 sm:p-6 rounded-xl border border-brand-accent/30 shadow-lg md:mr-10 min-w-0">
                    <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.process.step3_title') }}</h3>
                    <p class="text-theme-muted text-sm sm:text-base leading-7">
                        {{ __('frontend.process.step3_text') }}
                    </p>
                </div>
            </div>

            <div class="relative flex justify-start md:justify-around items-stretch md:items-center pl-10 md:pl-0">
                <div class="absolute w-8 h-8 rounded-full bg-brand-accent border-4 border-theme-bg z-10 left-4 md:left-1/2 transform -translate-x-1/2 flex items-center justify-center text-white font-bold">4</div>
                <div class="w-full md:w-5/12 bg-theme-surface-2/70 p-5 sm:p-6 rounded-xl border border-brand-accent/30 shadow-lg md:ml-10 order-2 md:order-1 min-w-0">
                    <h3 class="text-xl sm:text-2xl font-semibold text-theme-text mb-2 break-words">{{ __('frontend.process.step4_title') }}</h3>
                    <p class="text-theme-muted text-sm sm:text-base leading-7">
                        {{ __('frontend.process.step4_text') }}
                    </p>
                </div>
                <div class="hidden md:block w-5/12 order-1 md:order-2"></div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-process-motion-style')) {
        const style = document.createElement('style');
        style.id = 'vg-process-motion-style';
        style.innerHTML = `
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

            @keyframes vgPulseStep {
                0%, 100% { transform: translateX(-50%) scale(1); }
                50% { transform: translateX(-50%) scale(1.08); }
            }

            .vg-reveal-up {
                opacity: 0;
                transform: translateY(24px);
                transition: opacity .75s ease, transform .75s cubic-bezier(0.22, 1, 0.36, 1);
            }

            .vg-visible {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }

            .vg-step-card {
                transition: transform .28s ease, box-shadow .28s ease;
            }

            @media (hover: hover) and (pointer: fine) {
                .vg-step-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 22px 48px rgba(0,0,0,0.12);
                }
            }

            @media (max-width: 767px) {
                @keyframes vgPulseStep {
                    0%, 100% { transform: translateX(-50%) scale(1); }
                    50% { transform: translateX(-50%) scale(1.06); }
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal-up,
                .vg-step-card {
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
    const timelineLine = document.querySelector('.absolute.left-4.w-0\\.5, .absolute.md\\:left-1\\/2.w-0\\.5');
    const stepRows = Array.from(document.querySelectorAll('.space-y-6 > .relative.flex, .space-y-8 > .relative.flex, .space-y-12 > .relative.flex'));
    const stepDots = Array.from(document.querySelectorAll('.absolute.w-8.h-8.rounded-full.bg-brand-accent'));
    const stepCards = stepRows.map(row => row.querySelector('.w-full.md\\:w-5\\/12'));

    [header, ...stepCards].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal-up');

        if (prefersReducedMotion) {
            el.classList.add('vg-visible');
            return;
        }

        setTimeout(() => el.classList.add('vg-visible'), 120 + (index * 160));
    });

    if (timelineLine && !prefersReducedMotion) {
        timelineLine.style.transformOrigin = 'top';
        timelineLine.style.transition = 'transform 1.1s cubic-bezier(0.22, 1, 0.36, 1)';
        timelineLine.style.transform = window.innerWidth >= 768 ? 'translateX(-50%) scaleY(0)' : 'scaleY(0)';

        setTimeout(() => {
            timelineLine.style.transform = window.innerWidth >= 768 ? 'translateX(-50%) scaleY(1)' : 'scaleY(1)';
        }, 350);
    }

    stepDots.forEach((dot, index) => {
        if (prefersReducedMotion) return;

        dot.style.opacity = '0';
        dot.style.transition = 'opacity .55s ease';

        setTimeout(() => {
            dot.style.opacity = '1';
            dot.style.animation = 'vgPulseStep 2.2s ease-in-out infinite';
        }, 520 + (index * 180));
    });

    stepCards.forEach(card => {
        if (!card) return;
        card.classList.add('vg-step-card');
    });
});
</script>
@endsection