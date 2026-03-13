@php
    // --- Configuration Access ---
    $design = config('design');
    $containerClass = $design['classes']['container'];
    $headingClass = $design['classes']['heading_primary'];
    $textAccentClass = $design['classes']['text_accent'];

    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];

    $primaryColor = $design['colors']['primary'];
    $darkBg = $design['colors']['dark'];
    $darkestBg = $design['colors']['darkest'] ?? '#030712';
    $cardLight = $design['colors']['cardLight'];

    $sectionYClass = $design['classes']['section_y'] ?? 'py-20 lg:py-32';

    $user = auth('web')->user();
    $isLoggedIn = auth('web')->check();
    $isInvestor = $isLoggedIn && $user->role === 'Investor';
    $isStudent = $isLoggedIn && $user->role === 'Student';

    // Fallback if controller sends fewer projects
    $featuredProjects = $featuredProjects ?? collect();
@endphp

@extends('frontend.layouts.app')

@section('content')

{{-- ---------------------------------------------------------------- --}}
{{-- START OF SECTION 1: HERO SECTION --}}
{{-- ---------------------------------------------------------------- --}}

{{-- Hero Section: Background color is now synchronized with navbar's base color --}}
<section class="relative w-full h-[700px] lg:h-[850px] overflow-hidden flex items-center justify-center border-b border-primary/20" style="background-color: {{ $darkBg }};">

    {{-- Subtle dark overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-dark/50 to-transparent"></div>
    
    {{-- START OF CIRCUIT-BOARD SVG BACKGROUND (REMAINS UNCHANGED) --}}
    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1920 850" preserveAspectRatio="xMidYMid slice" style="opacity: 0.25;"> 
        <defs>
            <filter id="neon-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="2.5" result="coloredBlur"/> 
                <feMerge>
                    <feMergeNode in="coloredBlur"/> 
                    <feMergeNode in="SourceGraphic"/> 
                </feMerge>
            </filter>
        </defs>

        <g transform="translate(0, 175)">
            <circle cx="720" cy="300" r="4" fill="{{ $primaryColor }}" filter="url(#neon-glow)" class="circuit-node central-node node-pulse-1"/>
            <circle cx="1200" cy="300" r="4" fill="{{ $primaryColor }}" filter="url(#neon-glow)" class="circuit-node central-node node-pulse-2"/>

            {{-- Simplified path representation to save space, original SVG paths are here --}}
            <g id="left-paths">
                <path d="M 0 100 H 180 V 200 H 350 V 260 H 550 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="1.5" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-1" /><path d="M 0 350 L 120 350 L 120 250 L 320 250 L 320 330 L 520 330 L 520 300 L 720 300" stroke="{{ $primaryColor }}" stroke-width="1.0" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-2 opacity-60" />
                <path d="M 0 200 H 200 V 140 H 380 V 220 H 600 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="1.5" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-3" /><path d="M 0 420 H 150 V 460 H 350 V 380 H 500 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="1.0" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-4 opacity-40" />
                <path d="M 0 60 H 100 V 160 H 250 V 220 H 450 V 290 H 720" stroke="{{ $primaryColor }}" stroke-width="0.8" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-5 opacity-30" /><path d="M 0 280 H 150 V 180 H 300 V 290 H 500 V 310 H 720" stroke="{{ $primaryColor }}" stroke-width="1.2" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-6 opacity-50" />
                <path d="M 0 470 H 220 V 400 H 450 V 360 H 650 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="0.7" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-7 opacity-30" /><path d="M 0 150 H 50 V 250 H 300 V 190 H 550 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="1.0" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-8 opacity-40" />
                <path d="M 0 30 H 250 V 90 H 400 V 180 H 620 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="0.6" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-9 opacity-25" /><path d="M 0 510 H 100 V 380 H 280 V 440 H 480 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="0.7" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-10 opacity-35" />
                <path d="M 0 250 H 180 V 330 H 420 V 240 H 680 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="0.9" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-11 opacity-45" /><path d="M 0 490 H 50 V 420 H 150 V 350 H 350 V 300 H 720" stroke="{{ $primaryColor }}" stroke-width="0.5" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-12 opacity-20" />
            </g>
            <g id="right-paths">
                <path d="M 1920 100 H 1740 V 200 H 1570 V 260 H 1370 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="1.5" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-1" /><path d="M 1920 350 L 1800 350 L 1800 250 L 1600 250 L 1600 330 L 1400 330 L 1400 300 L 1200 300" stroke="{{ $primaryColor }}" stroke-width="1.0" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-2 opacity-60" />
                <path d="M 1920 200 H 1720 V 140 H 1540 V 220 H 1320 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="1.5" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-3" /><path d="M 1920 420 H 1770 V 460 H 1570 V 380 H 1420 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="1.0" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-4 opacity-40" />
                <path d="M 1920 60 H 1820 V 160 H 1670 V 220 H 1470 V 290 H 1200" stroke="{{ $primaryColor }}" stroke-width="0.8" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-5 opacity-30" /><path d="M 1920 280 H 1770 V 180 H 1620 V 290 H 1420 V 310 H 1200" stroke="{{ $primaryColor }}" stroke-width="1.2" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-6 opacity-50" />
                <path d="M 1920 470 H 1700 V 400 H 1470 V 360 H 1270 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="0.7" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-7 opacity-30" /><path d="M 1920 150 H 1870 V 250 H 1620 V 190 H 1370 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="1.0" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-8 opacity-40" />
                <path d="M 1920 30 H 1670 V 90 H 1520 V 180 H 1300 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="0.6" fill="none" filter='url(#neon-glow)' class="circuit-path animate-flow-9 opacity-25" /><path d="M 1920 510 H 1820 V 380 H 1640 V 440 H 1440 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="0.7" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-10 opacity-35" />
                <path d="M 1920 250 H 1740 V 330 H 1500 V 240 H 1240 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="0.9" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-11 opacity-45" /><path d="M 1920 490 H 1870 V 420 H 1770 V 350 H 1570 V 300 H 1200" stroke="{{ $primaryColor }}" stroke-width="0.5" fill="none" filter="url(#neon-glow)" class="circuit-path animate-flow-12 opacity-20" />
            </g>
        </g>
    </svg>

    <style>
        @keyframes draw-flow { 0% { stroke-dashoffset: 1200; opacity: 0; } 5% { opacity: 1; } 40% { stroke-dashoffset: 0; opacity: 1; } 70% { opacity: 0.2; } 100% { stroke-dashoffset: 1200; opacity: 0; } } .circuit-path { stroke-dasharray: 1200; stroke-dashoffset: 1200; animation: draw-flow 16s linear infinite; } .central-node { opacity: 0.7; transform-origin: center; animation: pulse-neon 2s infinite; } .node-pulse-1 { animation-delay: 0s; } .node-pulse-2 { animation-delay: 1s; } .animate-flow-1 { animation-delay: 0s; } .animate-flow-2 { animation-delay: 0.5s; } .animate-flow-3 { animation-delay: 1s; } .animate-flow-4 { animation-delay: 1.5s; } .animate-flow-5 { animation-delay: 2.0s; } .animate-flow-6 { animation-delay: 2.5s; } .animate-flow-7 { animation-delay: 3.0s; } .animate-flow-8 { animation-delay: 3.5s; } .animate-flow-8 { animation-delay: 3.5s; } .animate-flow-9 { animation-delay: 4.0s; } .animate-flow-10 { animation-delay: 4.5s; } .animate-flow-11 { animation-delay: 5.0s; } .animate-flow-12 { animation-delay: 5.5s; }
    </style>
    {{-- END OF CIRCUIT-BOARD SVG BACKGROUND --}}


    <div class="{{ $containerClass }} relative z-10 text-center pt-24 pb-16">
        
        {{-- Tagline --}}
        <p class="text-md uppercase font-bold tracking-[0.2em] mb-4 text-primary opacity-90">
            A **VertexGrad** Platform
        </p>
        
        {{-- Headline: Emphasizing VertexGrad with NEON GLOW --}}
        <h1 class="{{ $headingClass }} max-w-6xl mx-auto leading-tight">
            Connect with the Future of
            
            <span class="block mt-6 text-7xl lg:text-8xl font-black uppercase {{ $textAccentClass }} tracking-wider 
                drop-shadow-neon_sm" 
                style="text-shadow: 0 0 10px {{ $primaryColor }};">
                VertexGrad
            </span>
        </h1>
        
        {{-- Subtitle: Clear and Professional --}}
        <p class="mt-8 text-xl lg:text-2xl text-light/80 max-w-4xl mx-auto font-light">
            The exclusive marketplace for institutional investors and industry leaders to fund high-potential, faculty-vetted university projects globally.
        </p>
        {{-- Main CTAs: Search Focus (Investors) & Submission Link (Graduates) --}}
        <div class="mt-14 max-w-4xl mx-auto">
            
            {{-- Search Box (Investor Focus) --}}
            <div class="flex flex-col sm:flex-row items-stretch rounded-xl p-2 bg-cardLight shadow-lg border border-primary/20">
                <input 
                    type="search" 
                    placeholder="Search Projects by Industry, University, or Keyword (e.g., AI, Fintech)"
                    class="flex-grow p-4 text-lg bg-transparent text-light placeholder-light/50 focus:outline-none focus:ring-0"
                >
                {{-- FIX: Changed to an <a> tag pointing to the functional projects page --}}
                <a href="/projects" class="{{ $btnPrimaryClass }} mt-4 sm:mt-0 sm:ml-2 flex-shrink-0 text-lg 
                    !bg-primary/20 text-primary border border-primary hover:bg-primary/40">
                    <i class="fas fa-search mr-2"></i> Find Projects
                </a>
            </div>
            
            {{-- Secondary CTA Link for Graduates/Faculty --}}
            <div class="mt-8">
                <p class="text-light/70 text-sm font-semibold uppercase tracking-widest mb-4">
                    Are you a Project Creator or Faculty Partner?
                </p>
                {{-- FIX: Link is already correct: /submit-project --}}
                <a href="/submit-project" class="{{ $btnSecondaryClass }} text-base px-6 py-3 
                    !border-primary/50 text-light hover:text-primary hover:border-primary">
                    <i class="fas fa-rocket mr-2"></i> Submit Your Project for Vetting
                </a>
            </div>
        </div>
    </div>

</section>
{{-- ---------------------------------------------------------------- --}}
{{-- START OF SECTION 2: FEATURED PROJECTS (Pasted directly after Hero) --}}
{{-- ---------------------------------------------------------------- --}}

@php
    $design = config('design');
    $c = $design['classes'];

    $container = $c['container'];
    $sectionY = $c['section_y'];
    $btnSecondary = "{$c['btn_base']} {$c['btn_secondary']}";
@endphp

<section class="{{ $sectionY }} bg-darker border-y border-primary/10 overflow-hidden">
    <div class="{{ $container }}">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">

            <div class="lg:col-span-1 opacity-0 translate-y-8 section-anim">
                <h2 class="text-4xl lg:text-5xl font-extrabold text-light leading-tight">
                    Featured <span class="text-primary">Projects</span>
                </h2>
                <p class="mt-4 text-light/70 text-lg leading-relaxed">
                    Explore high-impact innovations selected by academic partners.
                </p>
                <a href="{{ route('frontend.projects.index') }}"
                   class="mt-8 inline-block {{ $btnSecondary }} px-8 py-3 border-primary/50 text-light hover:text-primary hover:border-primary">
                    View All Projects
                </a>
            </div>

            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-8">
                @forelse ($featuredProjects as $project)
                    <div class="opacity-0 translate-y-8 section-anim">
                        <div class="group bg-cardDark border border-white/5 hover:border-primary/40 rounded-xl overflow-hidden shadow-lg hover:shadow-neon_sm transition duration-300">
                            <div class="relative h-48 w-full bg-dark overflow-hidden">
                                @if(method_exists($project, 'hasMedia') && $project->hasMedia('images'))
                                    <img src="{{ $project->getFirstMediaUrl('images') }}"
                                         alt="{{ $project->name }}"
                                         class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-primary/10">
                                        <i class="fas fa-project-diagram text-primary text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <p class="text-primary text-sm font-semibold mb-2">
                                    {{ $project->category ?? 'General' }}
                                </p>

                                <h3 class="text-xl font-bold text-light leading-tight mb-3">
                                    {{ $project->name }}
                                </h3>

                                <p class="text-light/60 text-sm mb-4 line-clamp-2">
                                    {{ $project->description ?? '' }}
                                </p>

                                <div class="flex justify-between items-center mt-auto">
                                    <p class="text-light/40 text-xs">
                                        By {{ $project->student->name ?? 'Student' }}
                                    </p>
                                    <a href="{{ route('frontend.projects.show', $project) }}" class="text-primary text-sm font-bold hover:underline">
                                        Details →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 p-10 rounded-2xl border border-dashed border-white/10 text-center text-light/40">
                        No featured projects available yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        gsap.fromTo(".section-anim",
            { opacity: 0, y: 30 },
            {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.15,
                ease: "power3.out",
                scrollTrigger: { trigger: ".section-anim", start: "top 85%", once: true }
            }
        );
    }
});
</script>

{{-- ---------------------------------------------------------------- --}}
{{-- END OF SECTION 2 --}}
{{-- ---------------------------------------------------------------- --}}

{{-- ---------------------------------------------------------------- --}}
{{-- START OF SECTION 3: EXPLORE BY CATEGORY --}}
{{-- ---------------------------------------------------------------- --}}

@php
    $categories = [
        ['name' => 'Artificial Intelligence', 'icon' => 'fas fa-brain', 'query' => 'Artificial Intelligence'],
        ['name' => 'Fintech & Blockchain', 'icon' => 'fas fa-money-bill-wave', 'query' => 'Fintech'],
        ['name' => 'Biotechnology & Health', 'icon' => 'fas fa-dna', 'query' => 'Healthcare'],
        ['name' => 'Sustainable Energy', 'icon' => 'fas fa-leaf', 'query' => 'Energy'],
        ['name' => 'Aerospace & Defense', 'icon' => 'fas fa-rocket', 'query' => 'Aerospace'],
        ['name' => 'Quantum Computing', 'icon' => 'fas fa-cube', 'query' => 'Quantum'],
    ];
@endphp

<section class="{{ $sectionYClass }} bg-dark relative border-b border-primary/10"> 
    <div class="{{ $containerClass }} text-center">
        <x-section-title 
            title="Explore by Vetting Category" 
            subtitle="Find the innovations that align perfectly with your investment thesis." 
        />
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mt-12">
            @foreach($categories as $category)
                <a href="{{ route('frontend.projects.index', ['category' => $category['query']]) }}" 
                   class="block p-4 rounded-xl border border-primary/20 bg-cardLight/50 
                              hover:bg-cardLight/70 transition duration-300 group 
                              shadow-neon_sm hover:shadow-neon_md" 
                   style="box-shadow: 0 0 5px {{ $primaryColor }}33;">
                    <div class="mb-3">
                        <i class="{{ $category['icon'] }} text-4xl group-hover:text-primary transition duration-300" 
                           style="color: {{ $primaryColor }}; text-shadow: 0 0 8px {{ $primaryColor }}80;">
                        </i>
                    </div>

                    <p class="font-semibold text-light text-sm mt-2 group-hover:text-primary transition duration-300">
                        {{ $category['name'] }}
                    </p>
                </a>
            @endforeach
        </div>
        
        <div class="mt-12">
            <a href="{{ route('frontend.projects.index') }}" class="text-sm text-primary/80 hover:text-primary font-medium transition">
                <i class="fas fa-arrow-right mr-1"></i> View All Categories
            </a>
        </div>
    </div>
</section>

{{-- ---------------------------------------------------------------- --}}
{{-- END OF SECTION 3 --}}
{{-- ---------------------------------------------------------------- --}}

{{-- ---------------------------------------------------------------- --}}
{{-- START OF SECTION 4: THE VERTEXGRAD ADVANTAGE (VALUE PROPOSITION) --}}
{{-- ---------------------------------------------------------------- --}}

@php
    $valueProps = [
        [
            'title' => 'Faculty-Vetted Exclusivity',
            'icon' => 'fas fa-graduation-cap',
            'description' => 'Every project is rigorously pre-vetted by a panel of leading university faculty partners, ensuring only validated, high-potential research reaches our marketplace.',
        ],
        [
            'title' => 'Institutional-Grade Security',
            'icon' => 'fas fa-lock',
            'description' => 'We utilize structured platform workflows and secure data handling to preserve trust, clarity, and controlled visibility throughout the research lifecycle.',
        ],
        [
            'title' => 'Global Funding Access',
            'icon' => 'fas fa-globe',
            'description' => 'Connect groundbreaking projects with a curated network of global investors and institutions, accelerating development and real-world impact.',
        ],
    ];
@endphp

<section id="advantage" class="{{ $sectionYClass }} bg-darker relative"> 
    <div class="{{ $containerClass }} text-center">
        <x-section-title 
            title="The VertexGrad Advantage" 
            subtitle="Why the world's leading investors and institutions trust our pipeline." 
        />
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 text-left">
            @foreach($valueProps as $prop)
                <div class="p-6 lg:p-8 rounded-2xl bg-cardLight/30 border border-primary/20 
                             transition duration-500 hover:bg-cardLight/50 hover:shadow-neon_xl"
                             style="box-shadow: 0 0 10px {{ $primaryColor }}15;">
                    <div class="mb-4">
                        <i class="{{ $prop['icon'] }} text-5xl text-primary" 
                           style="filter: drop-shadow(0 0 6px {{ $primaryColor }});">
                        </i>
                    </div>

                    <h3 class="text-2xl font-bold text-light mb-3 tracking-wide">
                        {{ $prop['title'] }}
                    </h3>

                    <p class="text-light/70 text-base">
                        {{ $prop['description'] }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-16">
            @guest('web')
                <p class="text-light/50 text-md">
                    Ready to explore the future of investment?
                    <a href="{{ route('register.investor') }}" class="text-primary font-bold hover:text-light transition">
                        Create your Investor Account <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </p>
            @else
                <p class="text-light/50 text-md">
                    Welcome back.
                    <a href="{{ $isInvestor ? route('dashboard.investor') : route('dashboard.academic') }}" class="text-primary font-bold hover:text-light transition">
                        Go to your dashboard <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </p>
            @endguest
        </div>
    </div>
</section>

{{-- ---------------------------------------------------------------- --}}
{{-- END OF SECTION 4 --}}
{{-- ---------------------------------------------------------------- --}}

@php
    $partnerLogos = [
        'stanford-logo.svg', 'mit-logo.svg', 'cambridge-logo.svg',
        'harvard-logo.svg', 'caltech-logo.svg', 'oxford-logo.svg',
    ];
@endphp

{{-- ---------------------------------------------------------------- --}}
{{-- START OF SECTION 5: TRUSTED PARTNERS & UNIVERSITIES --}}
{{-- ---------------------------------------------------------------- --}}

<section id="partners" class="{{ $sectionYClass }} bg-cardLight relative border-b border-primary/10"> 
    <div class="{{ $containerClass }} text-center">
        <h2 class="text-xl font-semibold uppercase tracking-widest text-light/70 mb-12">
            Trusted by Leading Global Research Institutions
        </h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-12 items-center justify-center">
            @foreach($partnerLogos as $logo)
                <div class="flex items-center justify-center h-16 opacity-40 hover:opacity-100 transition duration-500">
                    <img src="/img/logos/{{ $logo }}" 
                         alt="{{ pathinfo($logo, PATHINFO_FILENAME) }} logo" 
                         class="max-h-full w-auto filter grayscale transition duration-300 group-hover:filter-none"
                         style="filter: grayscale(100%); mix-blend-mode: luminosity;">
                </div>
            @endforeach
        </div>
        
        <div class="mt-12">
            <p class="text-light/50 text-sm">
                Interested in becoming a VertexGrad Vetting Partner? 
                <a href="{{ route('utility.partnerships') }}" class="text-primary font-bold hover:text-light transition">
                    Learn More <i class="fas fa-external-link-alt ml-1"></i>
                </a>
            </p>
        </div>
    </div>
</section>

{{-- ---------------------------------------------------------------- --}}
{{-- END OF SECTION 5 --}}
{{-- ---------------------------------------------------------------- --}}

{{-- ---------------------------------------------------------------- --}}
{{-- START OF SECTION 6: DEEP CONTRAST THEME --}}
{{-- ---------------------------------------------------------------- --}}

@guest('web')
<section class="{{ $sectionYClass }} relative overflow-hidden" style="background-color: {{ $darkestBg }};">
    <div class="{{ $containerClass }} text-center">

        <x-section-title 
            title="Access The VertexGrad Network" 
            subtitle="The secure, verified gateway to the future of academic investment." 
        />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-20 max-w-6xl mx-auto">

            <div class="p-10 lg:p-16 text-center rounded-2xl 
                         bg-cardLight/10 border border-primary/20 
                         shadow-neon_xl transition duration-500 hover:bg-cardLight/20"
                 style="box-shadow: 0 0 25px {{ $primaryColor }}40;">
                
                <i class="fas fa-hand-holding-usd text-7xl text-primary mb-6" 
                   style="filter: drop-shadow(0 0 12px {{ $primaryColor }});">
                </i>
                <h3 class="text-4xl font-black text-light mb-3 uppercase tracking-wide">
                    Investor Portal
                </h3>
                <p class="text-light/60 mb-10 max-w-sm mx-auto text-lg">
                    Secure exclusive access to verified, institutional-grade project pipelines and funding opportunities.
                </p>
                
                <a href="{{ route('register.investor') }}" 
                   class="{{ $btnPrimaryClass }} text-xl px-12 py-4 !bg-primary/90 text-darkest font-extrabold border-2 border-primary hover:!bg-primary">
                    <i class="fas fa-eye mr-2"></i> REVIEW PROJECTS NOW
                </a>
            </div>

            <div class="p-10 lg:p-16 text-center rounded-2xl 
                         bg-cardLight/10 border border-primary/20 
                         shadow-neon_xl transition duration-500 hover:bg-cardLight/20"
                 style="box-shadow: 0 0 25px {{ $primaryColor }}40;">
                
                <i class="fas fa-flask text-7xl text-light/80 mb-6"></i>
                <h3 class="text-4xl font-black text-light mb-3 uppercase tracking-wide">
                    Academic Submission
                </h3>
                <p class="text-light/60 mb-10 max-w-sm mx-auto text-lg">
                    Submit your research for faculty vetting and gain direct exposure to global institutional funding.
                </p>

                <a href="{{ route('project.submit.step1') }}" 
                   class="{{ $btnSecondaryClass }} text-xl px-12 py-4 !border-primary/50 text-light hover:text-primary hover:border-primary">
                    <i class="fas fa-rocket mr-2"></i> START VETTING PROCESS
                </a>
            </div>

        </div>

    </div>
</section>
@endguest

{{-- ---------------------------------------------------------------- --}}
{{-- END OF SECTION 6 --}}
{{-- ---------------------------------------------------------------- --}}
@endsection