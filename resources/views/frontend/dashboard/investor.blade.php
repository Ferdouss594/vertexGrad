@extends('frontend.layouts.app')

@section('content')
@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
@endphp

<div class="min-h-screen pt-28 pb-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<header class="mb-12 flex justify-between items-end">
    <div>
        <h1 class="text-5xl font-black text-light tracking-tighter uppercase">
            Investor <span class="text-primary">Dashboard</span>
        </h1>
        <p class="text-light/40 text-xs font-bold tracking-[0.3em] mt-2 uppercase">
            Review opportunities, track activity, and explore active research projects
        </p>
    </div>

    <div class="text-right hidden md:block">
        <p class="text-light/40 text-[10px] font-black uppercase tracking-widest">
            Total Approved Funding
        </p>
        <p class="text-3xl font-black text-success mt-1">
            ${{ number_format($totalDeployed) }}
        </p>
    </div>
</header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2 space-y-8">

                {{-- MY INTERESTED / APPROVED PROJECTS --}}
                <section class="bg-slate-900/60 p-10 rounded-[3rem] border border-white/5">
                    <h3 class="text-xl font-black text-light mb-8 flex items-center uppercase tracking-widest">
                        <i class="fas fa-briefcase mr-4 text-primary"></i> My Investment Activity
                    </h3>

                    <div class="space-y-4">
                        @forelse($myInvestments as $investment)
                            @php
                                $image = $investment->getFirstMediaUrl('images');
                                $video = $investment->getFirstMediaUrl('videos');
                                $pivotStatus = $investment->pivot->status ?? 'interested';
                            @endphp

                            <a href="{{ route('frontend.projects.show', $investment) }}"
                               class="p-6 bg-white/5 rounded-2xl border border-white/5 flex items-center justify-between hover:border-primary/30 transition-all">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-black/30 flex items-center justify-center shrink-0">
                                        @if($image)
                                            <img src="{{ $image }}" alt="{{ $investment->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-image text-light/30 text-lg"></i>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <h4 class="text-light font-bold truncate">
                                            {{ $investment->name }}
                                        </h4>

                                        <p class="text-xs text-light/40 mt-1">
                                            Lead: {{ $investment->student?->name ?? 'N/A' }}
                                        </p>

                                        <div class="flex items-center gap-3 mt-2 flex-wrap">
                                            @if($video)
                                                <span class="text-xs text-primary flex items-center gap-1">
                                                    <i class="fas fa-video"></i> Video available
                                                </span>
                                            @endif

                                            @if($investment->getMedia('images')->count() > 1)
                                                <span class="text-xs text-light/40">
                                                    {{ $investment->getMedia('images')->count() }} images
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right shrink-0 ml-4">
                                    <span class="text-primary font-bold text-sm">
                                        {{ strtoupper($pivotStatus) }}
                                    </span>

                                    <p class="text-[10px] text-light/30 uppercase mt-1">
                                        Budget: ${{ number_format($investment->budget ?? 0) }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-10 opacity-30 italic text-sm">
                                You haven't expressed interest in any projects yet.
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- DEAL FLOW --}}
                <section class="bg-slate-900/60 p-10 rounded-[3rem] border border-white/5">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-xl font-black text-light uppercase tracking-widest">
                            Suggested for You
                        </h3>

                        <a href="{{ route('frontend.projects.index') }}"
                           class="text-primary text-[10px] font-black hover:underline tracking-widest">
                            EXPLORE ALL
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($suggestedProjects as $deal)
                            @php
                                $image = $deal->getFirstMediaUrl('images');
                                $video = $deal->getFirstMediaUrl('videos');
                                $interestedCount = $deal->investors->count();
                                $interestedUsers = $deal->investors->take(3);
                            @endphp

                            <a href="{{ route('frontend.projects.show', $deal) }}"
                               class="flex items-center justify-between p-6 bg-dark rounded-2xl border border-white/5 hover:border-primary/40 transition-all group">

                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-black/30 flex items-center justify-center shrink-0">
                                        @if($image)
                                            <img src="{{ $image }}" alt="{{ $deal->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-image text-light/30 text-lg"></i>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="text-light font-semibold group-hover:text-primary transition-colors truncate">
                                            {{ $deal->name }}
                                        </div>

                                        <div class="flex items-center gap-3 mt-2 flex-wrap">
                                            <span class="text-xs text-light/40">
                                                {{ $deal->student?->name ?? 'Researcher' }}
                                            </span>

                                            @if($video)
                                                <span class="text-xs text-primary flex items-center gap-1">
                                                    <i class="fas fa-video"></i> Video
                                                </span>
                                            @endif
                                        </div>

                                        @if($interestedCount > 0)
                                            <div class="flex items-center gap-2 mt-3">
                                                <div class="flex -space-x-2">
                                                    @foreach($interestedUsers as $investor)
                                                        <div class="w-7 h-7 rounded-full bg-primary/20 border border-primary text-primary flex items-center justify-center text-[10px] font-black">
                                                            {{ strtoupper(substr($investor->name ?? 'I', 0, 1)) }}
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <span class="text-xs text-light/40">
                                                    {{ $interestedCount }} interested investor{{ $interestedCount > 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <span class="text-success font-mono text-sm font-bold shrink-0 ml-4">
                                    ${{ number_format($deal->budget ?? 0) }}
                                </span>
                            </a>
                        @empty
                            <div class="text-center py-10 opacity-30 italic text-sm">
                                No open investment opportunities right now.
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <div class="space-y-8">
<div class="bg-gradient-to-br from-primary/20 to-transparent p-10 rounded-[3rem] border border-primary/20">
    <h3 class="text-light font-black uppercase tracking-widest text-sm mb-6">
        Marketplace Overview
    </h3>

    <div class="space-y-5 text-sm">
        <div class="flex justify-between items-center">
            <span class="text-light/50">Active Projects</span>
            <span class="text-primary font-bold">{{ $marketplaceStats['active_projects'] }}</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-light/50">Interested</span>
            <span class="text-light font-bold">{{ $marketplaceStats['interested_count'] }}</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-light/50">Funding Requested</span>
            <span class="text-light font-bold">{{ $marketplaceStats['requested_count'] }}</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-light/50">Approved Investments</span>
            <span class="text-success font-bold">{{ $marketplaceStats['approved_count'] }}</span>
        </div>
    </div>
</div>

                <div class="bg-slate-900/60 p-10 rounded-[3rem] border border-white/5">
                    <h3 class="text-light font-black uppercase tracking-widest text-sm mb-6">
                        Investor Summary
                    </h3>

                    <div class="space-y-4 text-xs text-light/50 leading-relaxed">
                        <p>
                            <span class="text-primary">Focus:</span>
                            Review active research projects and track your investment activity from one place.
                        </p>

                        <p>
                            <span class="text-primary">Status:</span>
                            Suggested opportunities are based on your previous project interactions when available.
                        </p>

                        <p>
                            <span class="text-primary">Action:</span>
                            You can express interest first, then submit a funding request when ready.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection