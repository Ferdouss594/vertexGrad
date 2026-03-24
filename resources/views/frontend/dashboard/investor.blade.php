@extends('frontend.layouts.app')

@section('content')
@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
@endphp

<div class="min-h-screen pt-28 pb-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="mb-12 flex flex-col md:flex-row md:justify-between md:items-end gap-6">
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

        {{-- Announcements --}}
        @if(isset($announcements) && $announcements->count())
            @php
                $featuredAnnouncement = $announcements->first();
                $otherAnnouncements = $announcements->slice(1);
            @endphp

            <section id="announcementSection" class="mb-8">
                <div class="relative overflow-hidden rounded-[2rem] border border-cyan-400/20 bg-gradient-to-r from-cyan-500/10 via-slate-900/90 to-slate-900/90 backdrop-blur-xl shadow-[0_18px_50px_rgba(0,224,255,0.08)]">
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute -top-12 -right-12 w-44 h-44 bg-cyan-400/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-12 -left-12 w-44 h-44 bg-primary/10 rounded-full blur-3xl"></div>
                    </div>

                    <div class="relative z-10 p-5 md:p-7">
                        <div class="flex items-start gap-4">
                            <div class="hidden sm:flex w-14 h-14 rounded-2xl border border-cyan-400/20 bg-cyan-400/10 text-cyan-300 items-center justify-center shrink-0">
                                <i class="fas fa-bullhorn text-lg"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/5 text-light/70 border border-white/10 text-[11px] font-black uppercase tracking-[0.16em]">
                                        Announcement
                                    </span>

                                    @if($featuredAnnouncement->is_pinned)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-400/10 text-amber-300 border border-amber-400/20 text-[11px] font-black uppercase tracking-[0.16em]">
                                            <i class="fas fa-thumbtack text-[10px]"></i>
                                            Pinned
                                        </span>
                                    @endif

                                    @if($featuredAnnouncement->expires_at)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-red-500/10 text-red-200 border border-red-500/20 text-[11px] font-black uppercase tracking-[0.16em]">
                                            <i class="fas fa-hourglass-half text-[10px]"></i>
                                            Until {{ $featuredAnnouncement->expires_at->format('M d, Y • h:i A') }}
                                        </span>
                                    @endif
                                </div>

                                <h2 class="text-xl md:text-2xl font-black text-light leading-tight mb-2">
                                    {{ $featuredAnnouncement->title }}
                                </h2>

                                <p class="text-light/70 text-sm md:text-[15px] leading-7 max-w-4xl">
                                    {{ $featuredAnnouncement->body }}
                                </p>
                            </div>

                            <button type="button"
                                    onclick="dismissAnnouncements()"
                                    class="shrink-0 w-11 h-11 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 text-light/50 hover:text-light transition flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        @if($otherAnnouncements->count())
                            <div class="mt-5 pt-5 border-t border-white/10">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    @foreach($otherAnnouncements as $announcement)
                                        <div class="rounded-[1.5rem] border border-white/10 bg-white/5 hover:bg-white/[0.07] transition p-4">
                                            <div class="flex items-start justify-between gap-3 mb-2">
                                                <h3 class="text-light font-bold text-base leading-snug">
                                                    {{ $announcement->title }}
                                                </h3>

                                                @if($announcement->is_pinned)
                                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-amber-400/10 text-amber-300 border border-amber-400/20 shrink-0">
                                                        <i class="fas fa-thumbtack text-[11px]"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="text-light/55 text-sm leading-6">
                                                {{ \Illuminate\Support\Str::limit($announcement->body, 160) }}
                                            </p>

                                            @if($announcement->expires_at)
                                                <div class="mt-3 text-[11px] text-red-200/90 font-semibold">
                                                    Visible until {{ $announcement->expires_at->format('M d, Y • h:i A') }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

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

<script>
    function dismissAnnouncements() {
        const section = document.getElementById('announcementSection');
        if (section) {
            section.style.transition = 'all 0.25s ease';
            section.style.opacity = '0';
            section.style.transform = 'translateY(-8px)';
            setTimeout(() => {
                section.remove();
            }, 250);
        }
    }
</script>
@endsection