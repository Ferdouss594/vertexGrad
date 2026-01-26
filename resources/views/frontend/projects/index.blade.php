@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';
    
    // Placeholder Data for Project Listings
    $projects = [
        ['title' => 'Quantum ML Drug Discovery', 'lead' => 'Dr. L. Chen', 'institution' => 'Stanford University', 'discipline' => 'AI & Quantum', 'funding' => '$1.5M', 'status' => 'Vetted', 'slug' => 'quantum-ml-drug-discovery'],
        ['title' => 'Sustainable Bio-Plastic Synthesis', 'lead' => 'Prof. S. Khan', 'institution' => 'ETH Zurich', 'discipline' => 'Materials', 'funding' => '$400K', 'status' => 'Due Diligence', 'slug' => 'sustainable-bio-plastic'],
        ['title' => 'Autonomous Crop Management System', 'lead' => 'Dr. K. Patel', 'institution' => 'UC Davis', 'discipline' => 'Robotics & AI', 'funding' => '$950K', 'status' => 'Hot Deal', 'slug' => 'autonomous-crop-management'],
        ['title' => 'Advanced Fusion Reactor Modeling', 'lead' => 'Dr. M. Lee', 'institution' => 'Princeton Plasma Physics Lab', 'discipline' => 'Energy', 'funding' => '$3.0M', 'status' => 'Vetted', 'slug' => 'advanced-fusion-reactor'],
    ];
    $totalProjects = count($projects) + 12; // Example total
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-8">
            <h1 class="text-4xl font-extrabold text-light">
                🔬 Investment Pipeline
            </h1>
            <p class="text-xl text-primary mt-1">
                Explore Vetted Academic Research Opportunities ({{ $totalProjects }} Available)
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- 1. Sidebar Filters (1/4 width) --}}
            <aside class="lg:col-span-1 bg-card/50 p-6 rounded-xl border border-light/20 h-fit">
                <h3 class="text-2xl font-semibold text-light mb-4">Filter Projects</h3>
                
                <form>
                    <div class="mb-5">
                        <label for="discipline" class="block text-sm font-medium text-light/80 mb-2">Discipline</label>
                        <select id="discipline" name="discipline" class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                            <option value="">All Disciplines</option>
                            <option value="AI">AI & ML</option>
                            <option value="Biotech">Biotech</option>
                            <option value="Energy">Energy</option>
                            <option value="Quantum">Quantum</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="funding_range" class="block text-sm font-medium text-light/80 mb-2">Funding Range (Max)</label>
                        <input type="range" id="funding_range" name="funding_range" min="100000" max="5000000" step="100000" class="w-full h-2 bg-primary/20 rounded-lg appearance-none cursor-pointer">
                        <span class="text-sm text-light/70 mt-1 block">Up to $5,000,000</span>
                    </div>

                    <div class="mb-6">
                        <label for="sort" class="block text-sm font-medium text-light/80 mb-2">Sort By</label>
                        <select id="sort" name="sort" class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                            <option value="newest">Newest First</option>
                            <option value="highest_funding">Highest Funding</option>
                            <option value="lowest_funding">Lowest Funding</option>
                        </select>
                    </div>

                    <button type="submit" class="{{ $btnPrimaryClass }} w-full py-2">
                        Apply Filters
                    </button>
                </form>
            </aside>

            {{-- 2. Project List (3/4 width) --}}
            <section class="lg:col-span-3 space-y-6">
                
                @foreach ($projects as $project)
                <div class="bg-cardLight/70 p-6 rounded-xl shadow-lg border border-primary/30 hover:shadow-neon_sm transition duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-light hover:text-primary transition duration-150">
                                <a href="/projects/{{ $project['slug'] }}">{{ $project['title'] }}</a>
                            </h2>
                            <p class="text-light/70 mt-1">
                                <i class="fas fa-university text-primary/70 mr-1"></i> {{ $project['institution'] }} | Lead: {{ $project['lead'] }}
                            </p>
                        </div>
                        <span class="text-sm font-semibold py-1 px-3 rounded-full 
                            @if($project['status'] == 'Hot Deal') bg-error text-light @else bg-success/20 text-success @endif">
                            {{ $project['status'] }}
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mt-4 items-center">
                        <div>
                            <p class="text-sm text-light/70">Discipline</p>
                            <p class="text-lg font-medium text-light">{{ $project['discipline'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-light/70">Funding Request</p>
                            <p class="text-lg font-bold text-success">{{ $project['funding'] }}</p>
                        </div>
                        <div class="text-right">
                            <a href="/projects/{{ $project['slug'] }}" class="{{ $btnPrimaryClass }} py-2 px-6">
                                View Due Diligence <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                
                {{-- Pagination Placeholder --}}
                <div class="text-center pt-8">
                    <p class="text-light/60">Showing 1-10 of {{ $totalProjects }} projects.</p>
                </div>

            </section>
        </div>

    </div>
</div>
@endsection