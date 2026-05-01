@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-12 sm:py-16 lg:py-20 bg-theme-bg transition-colors duration-300 overflow-x-hidden">
    <div class="w-full max-w-5xl mx-auto px-3 sm:px-6 lg:px-8">

        <header class="text-center mb-8 sm:mb-10 lg:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-theme-text mb-3 sm:mb-4 leading-tight break-words">
                {{ __('frontend.disclosures.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.disclosures.title_highlight') }}</span>
            </h1>
            <p class="text-sm sm:text-base text-theme-muted leading-6">
                {{ __('frontend.disclosures.subtitle') }}
            </p>
        </header>

        <div class="theme-panel p-4 sm:p-6 lg:p-10 rounded-xl space-y-6 sm:space-y-8 text-theme-muted">

            <section>
                <h3 class="text-2xl sm:text-3xl font-semibold text-brand-accent mb-3 sm:mb-4 break-words">{{ __('frontend.disclosures.section1_title') }}</h3>
                <p class="text-sm sm:text-base leading-7 sm:leading-8">{{ __('frontend.disclosures.section1_text') }}</p>
            </section>

            <section>
                <h3 class="text-2xl sm:text-3xl font-semibold text-brand-accent mb-3 sm:mb-4 break-words">{{ __('frontend.disclosures.section2_title') }}</h3>
                <p class="text-sm sm:text-base leading-7 sm:leading-8">{{ __('frontend.disclosures.section2_text') }}</p>
            </section>

            <section>
                <h3 class="text-2xl sm:text-3xl font-semibold text-brand-accent mb-3 sm:mb-4 break-words">{{ __('frontend.disclosures.section3_title') }}</h3>
                <p class="text-sm sm:text-base leading-7 sm:leading-8">{{ __('frontend.disclosures.section3_text') }}</p>
            </section>

            <section>
                <h3 class="text-2xl sm:text-3xl font-semibold text-brand-accent mb-3 sm:mb-4 break-words">{{ __('frontend.disclosures.section4_title') }}</h3>
                <p class="text-sm sm:text-base leading-7 sm:leading-8">{{ __('frontend.disclosures.section4_text') }}</p>
            </section>

            <section>
                <h3 class="text-2xl sm:text-3xl font-semibold text-brand-accent mb-3 sm:mb-4 break-words">{{ __('frontend.disclosures.section5_title') }}</h3>
                <p class="text-sm sm:text-base leading-7 sm:leading-8">{{ __('frontend.disclosures.section5_text') }}</p>
            </section>

            <section>
                <h3 class="text-2xl sm:text-3xl font-semibold text-brand-accent mb-3 sm:mb-4 break-words">{{ __('frontend.disclosures.section6_title') }}</h3>
                <p class="text-sm sm:text-base leading-7 sm:leading-8">{{ __('frontend.disclosures.section6_text') }}</p>
            </section>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-disclosures-motion-style')) {
        const style = document.createElement('style');
        style.id = 'vg-disclosures-motion-style';
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

            .vg-reveal-up {
                opacity: 0;
                transform: translateY(24px);
                transition: opacity .7s ease, transform .7s cubic-bezier(0.22, 1, 0.36, 1);
            }

            .vg-visible {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }

            .vg-panel-hover {
                transition: transform .28s ease, box-shadow .28s ease;
            }

            .vg-section {
                transition: border-color .24s ease, background-color .24s ease;
                border-radius: 16px;
            }

            @media (hover: hover) and (pointer: fine) {
                .vg-panel-hover:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 22px 48px rgba(0,0,0,0.09);
                }

                .vg-section:hover {
                    background-color: rgba(99,102,241,0.035);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal-up,
                .vg-panel-hover,
                .vg-section {
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
    const panel = document.querySelector('.theme-panel');
    const sections = Array.from(document.querySelectorAll('.theme-panel section'));

    [header, panel, ...sections].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal-up');

        if (prefersReducedMotion) {
            el.classList.add('vg-visible');
            return;
        }

        setTimeout(() => el.classList.add('vg-visible'), 100 + (index * 110));
    });

    if (panel) {
        panel.classList.add('vg-panel-hover');
    }

    sections.forEach(section => {
        section.classList.add('vg-section');
    });
});
</script>
@endsection