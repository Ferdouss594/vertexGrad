@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-12 sm:py-16 lg:py-20 bg-theme-bg transition-colors duration-300 overflow-x-hidden">
    <div class="w-full max-w-4xl mx-auto px-3 sm:px-6 lg:px-8">

        <header class="text-center mb-8 sm:mb-10 lg:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-theme-text mb-3 sm:mb-4 leading-tight break-words">
                {{ __('frontend.support.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.support.title_highlight') }}</span>
            </h1>
            <p class="text-base sm:text-lg lg:text-xl text-theme-muted max-w-2xl mx-auto leading-7">
                {{ __('frontend.support.subtitle_before') }}
                <a href="/contact" class="text-brand-accent hover:underline">{{ __('frontend.support.contact_link') }}</a>.
            </p>
        </header>

        <div class="space-y-4 sm:space-y-6">
            <div class="theme-panel p-4 sm:p-6 rounded-xl group cursor-pointer min-w-0">
                <h3 class="text-lg sm:text-xl font-semibold text-theme-text mb-2 flex justify-between items-start gap-4">
                    <span class="break-words">{{ __('frontend.support.q1') }}</span>
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform shrink-0 mt-1"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300 text-sm sm:text-base leading-7">
                    {{ __('frontend.support.a1') }}
                </p>
            </div>

            <div class="theme-panel p-4 sm:p-6 rounded-xl group cursor-pointer min-w-0">
                <h3 class="text-lg sm:text-xl font-semibold text-theme-text mb-2 flex justify-between items-start gap-4">
                    <span class="break-words">{{ __('frontend.support.q2') }}</span>
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform shrink-0 mt-1"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300 text-sm sm:text-base leading-7">
                    {{ __('frontend.support.a2') }}
                </p>
            </div>

            <div class="theme-panel p-4 sm:p-6 rounded-xl group cursor-pointer min-w-0">
                <h3 class="text-lg sm:text-xl font-semibold text-theme-text mb-2 flex justify-between items-start gap-4">
                    <span class="break-words">{{ __('frontend.support.q3') }}</span>
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform shrink-0 mt-1"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300 text-sm sm:text-base leading-7">
                    {{ __('frontend.support.a3') }}
                </p>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-support-motion-style')) {
        const style = document.createElement('style');
        style.id = 'vg-support-motion-style';
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

            .vg-faq-card {
                transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(99,102,241,0.18);
                border-radius: 12px;
            }

            @media (hover: hover) and (pointer: fine) {
                .vg-faq-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 22px 48px rgba(0,0,0,0.09);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .vg-reveal-up,
                .vg-faq-card {
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
    const faqCards = Array.from(document.querySelectorAll('.space-y-4 > .theme-panel, .space-y-6 > .theme-panel'));

    [header, ...faqCards].filter(Boolean).forEach((el, index) => {
        el.classList.add('vg-reveal-up');

        if (prefersReducedMotion) {
            el.classList.add('vg-visible');
            return;
        }

        setTimeout(() => el.classList.add('vg-visible'), 100 + (index * 120));
    });

    faqCards.forEach((card, index) => {
        const title = card.querySelector('h3');
        const icon = card.querySelector('i');
        const answer = card.querySelector('p');

        if (!title || !icon || !answer) return;

        card.classList.add('vg-faq-card', 'vg-focus-ring');
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'button');
        card.setAttribute('aria-expanded', index === 0 ? 'true' : 'false');

        answer.classList.remove('hidden', 'group-hover:block');
        answer.style.overflow = 'hidden';
        answer.style.transition = 'max-height 0.34s ease, opacity 0.28s ease, margin-top 0.28s ease';
        answer.style.maxHeight = index === 0 ? answer.scrollHeight + 'px' : '0px';
        answer.style.opacity = index === 0 ? '1' : '0';
        answer.style.marginTop = index === 0 ? '0.5rem' : '0';

        if (index === 0) {
            icon.style.transform = 'rotate(180deg)';
        }

        function closeAll() {
            faqCards.forEach(otherCard => {
                const otherAnswer = otherCard.querySelector('p');
                const otherIcon = otherCard.querySelector('i');

                if (!otherAnswer || !otherIcon) return;

                otherAnswer.style.maxHeight = '0px';
                otherAnswer.style.opacity = '0';
                otherAnswer.style.marginTop = '0';
                otherIcon.style.transform = 'rotate(0deg)';
                otherIcon.style.transition = 'transform 0.28s ease';
                otherCard.setAttribute('aria-expanded', 'false');
            });
        }

        function toggleCard() {
            const isOpen = card.getAttribute('aria-expanded') === 'true';

            if (isOpen) {
                answer.style.maxHeight = '0px';
                answer.style.opacity = '0';
                answer.style.marginTop = '0';
                icon.style.transform = 'rotate(0deg)';
                card.setAttribute('aria-expanded', 'false');
                return;
            }

            closeAll();
            answer.style.maxHeight = answer.scrollHeight + 'px';
            answer.style.opacity = '1';
            answer.style.marginTop = '0.5rem';
            icon.style.transform = 'rotate(180deg)';
            icon.style.transition = 'transform 0.28s ease';
            card.setAttribute('aria-expanded', 'true');
        }

        card.addEventListener('click', toggleCard);

        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleCard();
            }
        });

        window.addEventListener('resize', function () {
            if (card.getAttribute('aria-expanded') === 'true') {
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });
});
</script>
@endsection