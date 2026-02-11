@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $user = auth()->user();
    
    // REAL DATA: Projects this specific investor is funding
    $myInvestments = \App\Models\Project::where('investor_id', $user->id)->with('student')->get();
    $totalDeployed = $myInvestments->sum('budget');

    // REAL DATA: Latest 3 projects in the system that NEED funding
    $newDeals = \App\Models\Project::whereNull('investor_id')->latest()->take(3)->get();
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen pt-28 pb-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-12 flex justify-between items-end">
            <div>
                <h1 class="text-5xl font-black text-light tracking-tighter uppercase">Portfolio <span class="text-primary">Master</span></h1>
                <p class="text-light/30 text-xs font-bold tracking-[0.4em] mt-2 italic">Global Investment Authority Level 04</p>
            </div>
            <div class="text-right hidden md:block">
                <p class="text-light/40 text-[10px] font-black uppercase tracking-widest">Total Capital Deployed</p>
                <p class="text-3xl font-black text-success mt-1">${{ number_format($totalDeployed) }}</p>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- My Funded Projects --}}
            <div class="lg:col-span-2 space-y-8">
                <section class="bg-slate-900/60 p-10 rounded-[3rem] border border-white/5">
                    <h3 class="text-xl font-black text-light mb-8 flex items-center uppercase tracking-widest">
                        <i class="fas fa-briefcase mr-4 text-primary"></i> Current Assets
                    </h3>
                    
                    <div class="space-y-4">
                        @forelse($myInvestments as $investment)
                            <div class="p-6 bg-white/5 rounded-2xl border border-white/5 flex items-center justify-between">
                                <div>
                                    <h4 class="text-light font-bold">{{ $investment->name }}</h4>
                                    <p class="text-xs text-light/40 mt-1">Lead: {{ $investment->student->name ?? 'N/A' }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-primary font-bold text-sm">ACTIVE</span>
                                    <p class="text-[10px] text-light/30 uppercase mt-1">ROI Tracking: 12.4%</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 opacity-30 italic text-sm">
                                You haven't funded any projects yet.
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Deal Pipeline --}}
                <section class="bg-slate-900/60 p-10 rounded-[3rem] border border-white/5">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-xl font-black text-light uppercase tracking-widest">Incoming Deal Flow</h3>
                        <a href="{{ route('projects.index') }}" class="text-primary text-[10px] font-black hover:underline tracking-widest">EXPLORE ALL</a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($newDeals as $deal)
                            <a href="{{ route('project.details', $deal->project_id) }}" class="flex items-center justify-between p-6 bg-dark rounded-2xl border border-white/5 hover:border-primary/40 transition-all group">
                                <span class="text-light font-semibold group-hover:text-primary transition-colors">{{ $deal->name }}</span>
                                <span class="text-success font-mono text-sm font-bold">${{ number_format($deal->budget) }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- Sidebar Stats --}}
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-primary/20 to-transparent p-10 rounded-[3rem] border border-primary/20">
                    <h3 class="text-light font-black uppercase tracking-widest text-sm mb-6">Market Sentiment</h3>
                    <div class="space-y-6">
                        <div class="flex justify-between items-end">
                            <span class="text-light/40 text-[10px] font-black uppercase">Vetting Speed</span>
                            <span class="text-primary font-bold">Fast</span>
                        </div>
                        <div class="h-1 bg-white/10 rounded-full">
                            <div class="h-full bg-primary" style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/60 p-10 rounded-[3rem] border border-white/5">
                    <h3 class="text-light font-black uppercase tracking-widest text-sm mb-6">Recent Activity</h3>
                    <div class="space-y-4">
                        <p class="text-xs text-light/40 leading-relaxed">
                            <span class="text-primary">System:</span> New research in <span class="text-light">AI & ML</span> has just been verified.
                        </p>
                        <p class="text-xs text-light/40 leading-relaxed">
                            <span class="text-primary">System:</span> You received 1 new file update for an active investment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection