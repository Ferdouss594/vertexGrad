<footer class="w-full border-t border-theme-border bg-theme-surface transition-colors duration-300">

    <div class="{{ config('design.classes.container') }} py-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-12 gap-y-10 text-theme-muted">

        {{-- 1. BRAND / LOGO & TAGLINE --}}
        <div class="space-y-4 col-span-1 sm:col-span-2 md:col-span-1">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ asset(config('design.brand.logo')) }}" alt="{{ config('design.brand.name') }} logo" class="w-10 h-10 object-contain transition-transform group-hover:rotate-12">
                <span class="font-extrabold text-2xl tracking-wider text-brand-accent transition-colors group-hover:opacity-90">
                    {{ config('design.brand.name') }}
                </span>
            </a>

            <p class="text-sm max-w-xs text-theme-muted">
                {{ __('frontend.footer.tagline') }}
            </p>
        </div>

        {{-- 2. COMPANY LINKS --}}
        <nav aria-labelledby="footer-company-heading" class="space-y-4">
            <h4 id="footer-company-heading" class="font-bold text-theme-text uppercase tracking-wider mb-4 border-b border-theme-border pb-1">
                {{ __('frontend.footer.company') }}
            </h4>

            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('utility.about') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.about') }}</a></li>
                <li><a href="{{ route('utility.contact') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.contact') }}</a></li>
                <li><a href="{{ route('utility.careers') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.careers') }}</a></li>
                <li><a href="{{ route('utility.partnerships') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.partnerships') }}</a></li>
            </ul>
        </nav>

        {{-- 3. RESOURCES --}}
        <nav aria-labelledby="footer-resources-heading" class="space-y-4">
            <h4 id="footer-resources-heading" class="font-bold text-theme-text uppercase tracking-wider mb-4 border-b border-theme-border pb-1">
                {{ __('frontend.footer.resources') }}
            </h4>

            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('frontend.projects.index') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.explore_projects') }}</a></li>
                <li><a href="{{ route('utility.how-it-works') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.how_it_works') }}</a></li>
                <li><a href="{{ route('project.submit.step1') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.submit_idea') }}</a></li>
                <li><a href="{{ route('utility.support') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.support') }}</a></li>
            </ul>
        </nav>

        {{-- 4. LEGAL & SOCIAL --}}
        <div class="space-y-4">
            <nav aria-labelledby="footer-legal-heading">
                <h4 id="footer-legal-heading" class="font-bold text-theme-text uppercase tracking-wider mb-4 border-b border-theme-border pb-1">
                    {{ __('frontend.footer.legal') }}
                </h4>

                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('utility.terms') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.terms') }}</a></li>
                    <li><a href="{{ route('utility.privacy') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.privacy') }}</a></li>
                    <li><a href="{{ route('utility.disclosures') }}" class="hover-text-brand-accent transition-colors duration-300">{{ __('frontend.footer.disclosures') }}</a></li>
                </ul>
            </nav>

            <div class="space-y-2 pt-2">
                <h4 class="font-bold text-theme-text uppercase tracking-wider">{{ __('frontend.footer.connect') }}</h4>

                <div class="flex gap-4">
                    <a href="#" class="text-xl text-theme-muted hover-text-brand-accent hover:scale-110 transition-transform duration-300" aria-label="{{ __('frontend.footer.linkedin') }}">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-xl text-theme-muted hover-text-brand-accent hover:scale-110 transition-transform duration-300" aria-label="{{ __('frontend.footer.twitter') }}">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-xl text-theme-muted hover-text-brand-accent hover:scale-110 transition-transform duration-300" aria-label="{{ __('frontend.footer.facebook') }}">
                        <i class="fab fa-facebook"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full border-t border-theme-border py-6 text-center text-xs text-theme-muted bg-theme-surface-2 transition-colors duration-300">
        <div class="{{ config('design.classes.container') }}">
            &copy; {{ date('Y') }} {{ config('design.brand.name') }}. {{ __('frontend.footer.rights') }}
        </div>
    </div>
</footer>
<script>
(function () {
    function initVertexFooter() {
        const footer = document.querySelector('footer');
        if (!footer) return;

        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const footerColumns = footer.querySelectorAll('nav, .space-y-4, .space-y-2.pt-2');

        // reveal footer when it appears
        if (!prefersReducedMotion && 'IntersectionObserver' in window) {
            footer.style.opacity = '0';
            footer.style.transform = 'translateY(34px)';
            footer.style.transition = 'opacity 1s ease, transform 1s cubic-bezier(0.22, 1, 0.36, 1)';

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;

                    footer.style.opacity = '1';
                    footer.style.transform = 'translateY(0)';

                    footerColumns.forEach((col, index) => {
                        col.style.opacity = '0';
                        col.style.transform = 'translateY(20px)';
                        col.style.transition = 'opacity 0.85s ease, transform 0.85s ease';

                        setTimeout(() => {
                            col.style.opacity = '1';
                            col.style.transform = 'translateY(0)';
                        }, 140 + (index * 120));
                    });

                    obs.unobserve(footer);
                });
            }, { threshold: 0.15 });

            observer.observe(footer);
        }

        // footer links hover
        const links = footer.querySelectorAll('a');
        links.forEach(link => {
            link.style.transition = 'transform 0.25s ease, color 0.25s ease';

            link.addEventListener('mouseenter', function () {
                if (prefersReducedMotion) return;
                link.style.transform = 'translateX(3px)';
            });

            link.addEventListener('mouseleave', function () {
                link.style.transform = '';
            });
        });

        // social icons
        const socialLinks = footer.querySelectorAll('.fab');
        socialLinks.forEach(icon => {
            const parent = icon.closest('a');
            if (!parent) return;

            parent.style.transition = 'transform 0.28s ease';

            parent.addEventListener('mouseenter', function () {
                if (prefersReducedMotion) return;
                parent.style.transform = 'translateY(-4px) scale(1.06)';
            });

            parent.addEventListener('mouseleave', function () {
                parent.style.transform = '';
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initVertexFooter);
    } else {
        initVertexFooter();
    }
})();
</script>