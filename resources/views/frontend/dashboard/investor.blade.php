@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';
    
    // Placeholder Data for Investor Metrics
    $portfolioValue = '$12.4M';
    $fundedProjects = 8;
    $pipelineProjects = 15;
    $returnRate = '18.5%';
    
    // Placeholder Data for Pipeline
    $pipeline = [
        ['title' => 'Advanced AI Climate Modeling V2', 'amount' => '$900K', 'discipline' => 'AI & ML', 'status' => 'Due Diligence'],
        ['title' => 'Novel Biometric Sensor Array', 'amount' => '$450K', 'discipline' => 'Biotech', 'status' => 'Vetting Complete'],
        ['title' => 'Next-Gen Quantum Random Generator', 'amount' => '$1.2M', 'discipline' => 'Quantum', 'status' => 'New'],
    ];
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-10 border-b border-light/20 pb-4">
            <h1 class="text-4xl font-extrabold text-light">
                🤝 Investor Dashboard
            </h1>
            <p class="text-xl text-light/70 mt-1">Investment Pipeline & Portfolio Overview</p>
        </header>

        {{-- 1. Key Metrics --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            {{-- Total Portfolio Value --}}
            <div class="p-5 rounded-xl border border-primary/20 bg-cardLight/50 text-center">
                <p class="text-sm text-light/80">Active Portfolio Value</p>
                <p class="text-3xl font-bold text-success mt-1">{{ $portfolioValue }}</p>
            </div>
            
            {{-- Funded Projects Count --}}
            <div class="p-5 rounded-xl border border-primary/20 bg-cardLight/50 text-center">
                <p class="text-sm text-light/80">Funded Projects</p>
                <p class="text-3xl font-bold text-primary mt-1">{{ $fundedProjects }}</p>
            </div>

            {{-- New Pipeline Projects --}}
            <div class="p-5 rounded-xl border border-primary/20 bg-cardLight/50 text-center">
                <p class="text-sm text-light/80">Vetted Pipeline</p>
                <p class="text-3xl font-bold text-warning mt-1">{{ $pipelineProjects }}</p>
            </div>
            
            {{-- Projected Return Rate --}}
            <div class="p-5 rounded-xl border border-primary/20 bg-cardLight/50 text-center">
                <p class="text-sm text-light/80">Annualized Return Rate (ARR)</p>
                <p class="text-3xl font-bold text-light mt-1">{{ $returnRate }}</p>
            </div>
        </div>

        {{-- 2. Pipeline & Portfolio --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Investment Pipeline (New Deals) --}}
            <div class="lg:col-span-2 bg-card/50 p-6 rounded-xl border border-primary/30">
                <h3 class="text-2xl font-semibold text-light mb-5 flex justify-between items-center">
                    <span class="flex items-center"><i class="fas fa-search-dollar mr-3 text-warning"></i> Active Deal Pipeline</span>
                    <a href="/pipeline" class="text-sm text-primary hover:text-light">View All ({{ $pipelineProjects }})</a>
                </h3>

                <ul class="space-y-4">
                    @foreach ($pipeline as $item)
                        <li class="p-4 rounded-lg bg-dark/50 border border-light/10 flex justify-between items-center hover:bg-dark/70 transition duration-150">
                            <div>
                                <p class="text-lg font-semibold text-light">{{ $item['title'] }}</p>
                                <p class="text-sm text-primary mt-1">{{ $item['discipline'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-light">{{ $item['amount'] }}</p>
                                <span class="text-xs {{ 
                                    $item['status'] == 'New' ? 'text-success' : 
                                    ($item['status'] == 'Due Diligence' ? 'text-warning' : 'text-primary') 
                                }}">{{ $item['status'] }}</span>
                            </div>
                            <a href="/project/{{ Str::slug($item['title']) }}" class="ml-4 {{ $btnPrimaryClass }} py-2 px-4 !text-sm">
                                Review <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Portfolio Status --}}
            <div class="bg-card/50 p-6 rounded-xl border border-light/20">
                <h3 class="text-2xl font-semibold text-light mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-3 text-success"></i> Portfolio Tracking
                </h3>
                
                <p class="text-light/80 mb-4">
                    Track milestones, fund disbursements, and projected returns for your existing investments.
                </p>
                
                {{-- Example of a visual chart placeholder --}}
                <div class="h-40 bg-dark/70 rounded-lg flex items-center justify-center text-light/50 border border-light/10 mb-4">
                    
                </div>

                <a href="/portfolio" class="{{ $btnSecondaryClass }} w-full text-center">
                    View Full Portfolio Details
                </a>
            </div>
        </div>

    </div>
</div>
@endsection