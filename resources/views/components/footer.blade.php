<footer class="w-full border-t border-primary/20" style="background-color: {{ config('design.colors.dark') }};">

    {{-- Main Footer Content Grid --}}
    {{-- Using sm:col-span-2 for better branding area on small tablets --}}
    <div class="{{ config('design.classes.container') }} py-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-12 gap-y-10 text-light/80">

        {{-- 1. BRAND / LOGO & TAGLINE --}}
        <div class="space-y-4 col-span-1 sm:col-span-2 md:col-span-1">
            {{-- Use route('home') if defined, or '/' otherwise --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <img src="{{ config('design.brand.logo') }}" alt="{{ config('design.brand.name') }} logo" class="w-10 h-10 transition-transform group-hover:rotate-12">
                <span class="font-extrabold text-2xl tracking-wider text-light {{ config('design.classes.text_accent') }} transition-colors group-hover:text-primary">{{ config('design.brand.name') }}</span>
            </a>
            <p class="text-sm max-w-xs text-light/60">
                {{ config('design.brand.tagline') }}
            </p>
        </div>

        {{-- 2. VERTEXGRAD (COMPANY) LINKS --}}
        <nav aria-labelledby="footer-company-heading" class="space-y-4">
            <h4 id="footer-company-heading" class="font-bold text-light uppercase tracking-wider mb-4 border-b border-primary/20 pb-1">VertexGrad</h4>
            <ul class="space-y-2 text-sm">
                {{-- Utility Links --}}
                <li><a href="{{ route('utility.about') }}" class="hover:text-primary transition-colors duration-300">About Us</a></li>
                <li><a href="{{ route('utility.contact') }}" class="hover:text-primary transition-colors duration-300">Contact Us</a></li>
                <li><a href="{{ route('utility.careers') }}" class="hover:text-primary transition-colors duration-300">Careers</a></li>
                <li><a href="{{ route('utility.partnerships') }}" class="hover:text-primary transition-colors duration-300">Partnerships</a></li>
            </ul>
        </nav>

        {{-- 3. ACADEMIC & INVESTOR RESOURCES --}}
        <nav aria-labelledby="footer-resources-heading" class="space-y-4">
            <h4 id="footer-resources-heading" class="font-bold text-light uppercase tracking-wider mb-4 border-b border-primary/20 pb-1">Resources</h4>
            <ul class="space-y-2 text-sm">
                {{-- Resource Links --}}
                <li><a href="{{ route('projects.index') }}" class="hover:text-primary transition-colors duration-300">Explore Projects</a></li>
                <li><a href="{{ route('utility.how-it-works') }}" class="hover:text-primary transition-colors duration-300">How It Works</a></li>
                <li><a href="{{ route('project.submit.step1') }}" class="hover:text-primary transition-colors duration-300">Submit Your Idea</a></li>
                <li><a href="{{ route('utility.support') }}" class="hover:text-primary transition-colors duration-300">Support / FAQ</a></li>
            </ul>
        </nav>

        {{-- 4. LEGAL & SOCIAL CONNECT --}}
        <div class="space-y-4">
            <nav aria-labelledby="footer-legal-heading">
                <h4 id="footer-legal-heading" class="font-bold text-light uppercase tracking-wider mb-4 border-b border-primary/20 pb-1">Legal</h4>
                <ul class="space-y-2 text-sm">
                    {{-- Legal Links --}}
                    <li><a href="{{ route('utility.terms') }}" class="hover:text-primary transition-colors duration-300">Terms & Conditions</a></li>
                    <li><a href="{{ route('utility.privacy') }}" class="hover:text-primary transition-colors duration-300">Privacy Policy</a></li>
                    <li><a href="{{ route('utility.disclosures') }}" class="hover:text-primary transition-colors duration-300">Disclosures</a></li>
                </ul>
            </nav>
            
            {{-- Social Icons --}}
            <div class="space-y-2 pt-2">
                <h4 class="font-bold text-light uppercase tracking-wider">Connect</h4>
                <div class="flex gap-4">
                    <a href="#" class="text-xl text-light/70 hover:text-primary hover:scale-110 transition-transform duration-300" aria-label="Connect on LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-xl text-light/70 hover:text-primary hover:scale-110 transition-transform duration-300" aria-label="Follow on Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-xl text-light/70 hover:text-primary hover:scale-110 transition-transform duration-300" aria-label="Join us on Facebook"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </div>

    {{-- COPYRIGHT BAR --}}
    <div class="w-full border-t border-primary/10 py-6 text-center text-xs text-light/50" style="background-color: {{ config('design.colors.darker') }};">
        <div class="{{ config('design.classes.container') }}">
            &copy; {{ date('Y') }} {{ config('design.brand.name') }}. All rights reserved.
        </div>
    </div>
</footer>