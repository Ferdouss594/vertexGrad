@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';
    
    // Placeholder Data for a Single Project
    $project = [
        'title' => 'Quantum ML Drug Discovery',
        'slug' => 'quantum-ml-drug-discovery',
        'abstract' => 'Utilizing high-performance quantum algorithms to drastically reduce the simulation time required for identifying promising drug candidates, specifically targeting novel anti-viral compounds. The model predicts molecular stability and efficacy with 98% accuracy in preliminary trials.',
        'lead_name' => 'Dr. L. Chen (Principal Investigator)',
        'institution' => 'Stanford University, Quantum Physics Lab',
        'funding' => '1,500,000',
        'duration' => 24, // months
        'status' => 'Vetted: Ready for Investment',
        'milestones' => [
            ['month' => 6, 'description' => 'Algorithm optimization complete; successful simulation of 1,000 compounds.'],
            ['month' => 15, 'description' => 'Prototype code deployed on hybrid quantum-classical computing cluster.'],
            ['month' => 24, 'description' => 'Successful publication of results in Nature journal; patent filing initiated.'],
        ]
    ];
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header and Title --}}
        <header class="mb-8 border-b border-primary/30 pb-4">
            <a href="/projects" class="text-sm text-primary hover:text-light/80"><i class="fas fa-arrow-left mr-2"></i> Back to Pipeline</a>
            <h1 class="text-5xl font-extrabold text-light mt-2">{{ $project['title'] }}</h1>
            <p class="text-xl text-success mt-1 font-semibold">{{ $project['status'] }}</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Main Content Column (2/3) --}}
            <section class="lg:col-span-2 space-y-8">
                
                {{-- Abstract/Summary Card --}}
                <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                    <h3 class="text-3xl font-semibold text-primary mb-4 flex items-center">
                        <i class="fas fa-book-open mr-3"></i> Project Summary
                    </h3>
                    <p class="text-light/80 leading-relaxed">{{ $project['abstract'] }}</p>
                </div>
                
                {{-- Team and Institution --}}
                <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                    <h3 class="text-3xl font-semibold text-primary mb-4 flex items-center">
                        <i class="fas fa-users mr-3"></i> Academic Team
                    </h3>
                    <div class="text-light/80 space-y-2">
                        <p class="text-lg"><strong class="text-light">Lead PI:</strong> {{ $project['lead_name'] }}</p>
                        <p class="text-lg"><strong class="text-light">Institution:</strong> {{ $project['institution'] }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="/due-diligence/{{ $project['slug'] }}/cv" class="{{ $btnSecondaryClass }} !bg-dark/50 text-light py-2 px-4 !text-sm">
                            Download PI's CV <i class="fas fa-download ml-2"></i>
                        </a>
                    </div>
                </div>

                {{-- Milestones Timeline --}}
                <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                    <h3 class="text-3xl font-semibold text-primary mb-6 flex items-center">
                        <i class="fas fa-calendar-alt mr-3"></i> Key Milestones & Timeline
                    </h3>
                    
                    <ol class="relative border-l border-primary/50 space-y-8 ml-3 pl-6">
                        @foreach ($project['milestones'] as $milestone)
                        <li>
                            <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -left-1.5 border border-dark"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-light/70">Month {{ $milestone['month'] }}</time>
                            <h4 class="text-xl font-semibold text-light">{{ $milestone['description'] }}</h4>
                        </li>
                        @endforeach
                        <li>
                            <time class="mb-1 text-sm font-normal leading-none text-light/70">Month {{ $project['duration'] }}: Project Completion</time>
                            <h4 class="text-xl font-semibold text-success">Final Report & Exit Strategy Discussion</h4>
                        </li>
                    </ol>
                </div>

            </section>
            
            {{-- Financial Sidebar (1/3) --}}
            <aside class="lg:col-span-1 space-y-6">
                
                {{-- Funding Metrics --}}
                <div class="bg-dark/70 p-6 rounded-xl border-t-4 border-success shadow-xl">
                    <p class="text-lg text-light/70">Total Funding Required</p>
                    <h3 class="text-5xl font-extrabold text-success mt-1">${{ number_format($project['funding']) }}</h3>
                    <div class="mt-4 pt-4 border-t border-light/10 text-light/80">
                        <p class="flex justify-between">Duration: <span>{{ $project['duration'] }} Months</span></p>
                    </div>
                </div>

                {{-- Action Panel --}}
                <div class="bg-dark/70 p-6 rounded-xl border border-primary/50 shadow-xl">
                    <h3 class="text-2xl font-semibold text-light mb-4">Investor Actions</h3>
                    <button class="{{ $btnPrimaryClass }} w-full py-3 mb-3">
                        <i class="fas fa-handshake mr-2"></i> Start Due Diligence
                    </button>
                    <button class="{{ $btnSecondaryClass }} w-full py-3 !bg-dark/50 border border-light/30 text-light/80">
                        <i class="fas fa-heart mr-2"></i> Add to Watchlist
                    </button>
                </div>

                {{-- Document Links --}}
                <div class="bg-dark/70 p-6 rounded-xl border border-light/20 shadow-lg">
                    <h3 class="text-2xl font-semibold text-light mb-4">Supporting Documents</h3>
                    <ul class="space-y-3 text-primary">
                        <li><i class="fas fa-file-pdf mr-2"></i> <a href="#">Detailed Budget Breakdown (PDF)</a></li>
                        <li><i class="fas fa-file-alt mr-2"></i> <a href="#">Technical Whitepaper</a></li>
                        <li><i class="fas fa-video mr-2"></i> <a href="#">Video Pitch (Private Link)</a></li>
                    </ul>
                </div>
                
            </aside>
            
        </div>

    </div>
</div>
@endsection