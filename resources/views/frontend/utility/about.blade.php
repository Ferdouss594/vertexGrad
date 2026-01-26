@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $cardBg = '#1E293B';
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-20" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="text-center mb-12">
            <h1 class="text-6xl font-extrabold text-light mb-4">
                Our <span class="text-primary">Mission</span>
            </h1>
            <p class="text-xl text-light/80 max-w-3xl mx-auto">
                Connecting academic brilliance with institutional capital to accelerate global innovation.
            </p>
        </header>

        {{-- Mission & Vision Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <div class="bg-cardLight/70 p-8 rounded-xl border border-primary/30 shadow-lg">
                <i class="fas fa-rocket text-4xl text-primary mb-3"></i>
                <h3 class="text-3xl font-semibold text-light mb-3">The Vision</h3>
                <p class="text-light/80 leading-relaxed">
                    We envision a world where the most groundbreaking university research—in quantum computing, sustainable energy, and biotech—never stalls due to funding gaps. VertexGrad is the catalyst that transforms research into market reality.
                </p>
            </div>
            <div class="bg-cardLight/70 p-8 rounded-xl border border-primary/30 shadow-lg">
                <i class="fas fa-shield-alt text-4xl text-primary mb-3"></i>
                <h3 class="text-3xl font-semibold text-light mb-3">Our Commitment</h3>
                <p class="text-light/80 leading-relaxed">
                    We commit to rigorous, unbiased vetting. Our platform is built on transparency and security, ensuring that investors receive high-quality, pre-screened deals and academics maintain full IP protection during the process.
                </p>
            </div>
        </div>

        {{-- Team Section (Placeholder) --}}
        <div class="text-center">
            <h2 class="text-5xl font-bold text-light mb-8">Meet the Founders</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                {{-- Placeholder for You --}}
                <div class="bg-dark/70 p-6 rounded-xl border border-light/20">
                    <div class="h-24 w-24 rounded-full bg-primary/30 mx-auto mb-4"></div> 
                    <h4 class="text-2xl font-semibold text-light">A. Front-end Architect</h4>
                    <p class="text-primary/70">Co-Founder, Design & UX</p>
                </div>
                {{-- Placeholder for Your Friend --}}
                <div class="bg-dark/70 p-6 rounded-xl border border-light/20">
                    <div class="h-24 w-24 rounded-full bg-primary/30 mx-auto mb-4"></div>
                    <h4 class="text-2xl font-semibold text-light">B. Back-end Engineer</h4>
                    <p class="text-primary/70">Co-Founder, Core Systems & API</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection