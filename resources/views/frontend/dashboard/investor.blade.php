@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen pt-28 pb-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="mb-12 flex flex-col md:flex-row md:justify-between md:items-end gap-6">
            <div>
                <h1 class="text-5xl font-black text-theme-text tracking-tighter uppercase">
                    {{ __('frontend.investor_dashboard.investor') }} <span class="text-brand-accent">{{ __('frontend.investor_dashboard.dashboard') }}</span>
                </h1>
                <p class="text-theme-muted text-xs font-bold tracking-[0.3em] mt-2 uppercase">
                    {{ __('frontend.investor_dashboard.subtitle') }}
                </p>
            </div>

            <div class="text-right hidden md:block">
                <p class="text-theme-muted text-[10px] font-black uppercase tracking-widest">
                    {{ __('frontend.investor_dashboard.total_approved_funding') }}
                </p>
                <p class="text-3xl font-black text-green-600 mt-1">
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
                <div class="relative overflow-hidden rounded-[2rem] theme-panel shadow-brand-soft">
                    <div class="relative z-10 p-5 md:p-7">
                        <div class="flex items-start gap-4">
                            <div class="hidden sm:flex w-14 h-14 rounded-2xl border border-brand-accent bg-brand-accent-soft text-brand-accent items-center justify-center shrink-0">
                                <i class="fas fa-bullhorn text-lg"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-theme-surface-2 text-theme-muted border border-theme-border text-[11px] font-black uppercase tracking-[0.16em]">
                                        {{ __('frontend.investor_dashboard.announcement') }}
                                    </span>

                                    @if($featuredAnnouncement->is_pinned)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-400/10 text-amber-500 border border-amber-400/20 text-[11px] font-black uppercase tracking-[0.16em]">
                                            <i class="fas fa-thumbtack text-[10px]"></i>
                                            {{ __('frontend.investor_dashboard.pinned') }}
                                        </span>
                                    @endif

                                    @if($featuredAnnouncement->expires_at)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-red-500/10 text-red-500 border border-red-500/20 text-[11px] font-black uppercase tracking-[0.16em]">
                                            <i class="fas fa-hourglass-half text-[10px]"></i>
                                            {{ __('frontend.investor_dashboard.until') }} {{ $featuredAnnouncement->expires_at->format('M d, Y • h:i A') }}
                                        </span>
                                    @endif
                                </div>

                                <h2 class="text-xl md:text-2xl font-black text-theme-text leading-tight mb-2">
                                    {{ $featuredAnnouncement->title }}
                                </h2>

                                <p class="text-theme-muted text-sm md:text-[15px] leading-7 max-w-4xl">
                                    {{ $featuredAnnouncement->body }}
                                </p>
                            </div>

                            <button type="button"
                                    onclick="dismissAnnouncements()"
                                    class="shrink-0 w-11 h-11 rounded-2xl border border-theme-border bg-theme-surface-2 hover:bg-brand-accent-soft text-theme-muted hover:text-theme-text transition flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        @if($otherAnnouncements->count())
                            <div class="mt-5 pt-5 border-t border-theme-border">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    @foreach($otherAnnouncements as $announcement)
                                        <div class="rounded-[1.5rem] border border-theme-border bg-theme-surface-2 transition p-4">
                                            <div class="flex items-start justify-between gap-3 mb-2">
                                                <h3 class="text-theme-text font-bold text-base leading-snug">
                                                    {{ $announcement->title }}
                                                </h3>

                                                @if($announcement->is_pinned)
                                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-amber-400/10 text-amber-500 border border-amber-400/20 shrink-0">
                                                        <i class="fas fa-thumbtack text-[11px]"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="text-theme-muted text-sm leading-6">
                                                {{ \Illuminate\Support\Str::limit($announcement->body, 160) }}
                                            </p>

                                            @if($announcement->expires_at)
                                                <div class="mt-3 text-[11px] text-red-500 font-semibold">
                                                    {{ __('frontend.investor_dashboard.visible_until') }} {{ $announcement->expires_at->format('M d, Y • h:i A') }}
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
                <section class="theme-panel p-10 rounded-[3rem]">
                    <h3 class="text-xl font-black text-theme-text mb-8 flex items-center uppercase tracking-widest">
                        <i class="fas fa-briefcase mr-4 text-brand-accent"></i> {{ __('frontend.investor_dashboard.my_investment_activity') }}
                    </h3>

                    <div class="space-y-4">
                        @forelse($myInvestments as $investment)
                            @php
                                $image = $investment->getFirstMediaUrl('images');
                                $video = $investment->getFirstMediaUrl('videos');
                                $pivotStatus = $investment->pivot->status ?? 'interested';
                            @endphp

                            <a href="{{ route('frontend.projects.show', $investment) }}"
                               class="p-6 bg-theme-surface-2 rounded-2xl border border-theme-border flex items-center justify-between hover:border-brand-accent/40 transition-all">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-theme-surface flex items-center justify-center shrink-0">
                                        @if($image)
                                            <img src="{{ $image }}" alt="{{ $investment->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-image text-theme-muted text-lg"></i>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <h4 class="text-theme-text font-bold truncate">
                                            {{ $investment->name }}
                                        </h4>

                                        <p class="text-xs text-theme-muted mt-1">
                                            {{ __('frontend.investor_dashboard.lead') }}: {{ $investment->student?->name ?? __('frontend.investor_dashboard.not_available') }}
                                        </p>

                                        <div class="flex items-center gap-3 mt-2 flex-wrap">
                                            @if($video)
                                                <span class="text-xs text-brand-accent flex items-center gap-1">
                                                    <i class="fas fa-video"></i> {{ __('frontend.investor_dashboard.video_available') }}
                                                </span>
                                            @endif

                                            @if($investment->getMedia('images')->count() > 1)
                                                <span class="text-xs text-theme-muted">
                                                    {{ $investment->getMedia('images')->count() }} {{ __('frontend.investor_dashboard.images') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right shrink-0 ml-4">
                                    <span class="text-brand-accent font-bold text-sm">
                                        {{ strtoupper($pivotStatus) }}
                                    </span>

                                    <p class="text-[10px] text-theme-muted uppercase mt-1">
                                        {{ __('frontend.investor_dashboard.budget') }}: ${{ number_format($investment->budget ?? 0) }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-10 text-theme-muted italic text-sm">
                                {{ __('frontend.investor_dashboard.no_interest_yet') }}
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- DEAL FLOW --}}
                <section class="theme-panel p-10 rounded-[3rem]">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-xl font-black text-theme-text uppercase tracking-widest">
                            {{ __('frontend.investor_dashboard.suggested_for_you') }}
                        </h3>

                        <a href="{{ route('frontend.projects.index') }}"
                           class="text-brand-accent text-[10px] font-black hover:underline tracking-widest">
                            {{ __('frontend.investor_dashboard.explore_all') }}
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
                               class="flex items-center justify-between p-6 bg-theme-surface-2 rounded-2xl border border-theme-border hover:border-brand-accent/40 transition-all group">

                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-theme-surface flex items-center justify-center shrink-0">
                                        @if($image)
                                            <img src="{{ $image }}" alt="{{ $deal->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-image text-theme-muted text-lg"></i>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="text-theme-text font-semibold group-hover:text-brand-accent transition-colors truncate">
                                            {{ $deal->name }}
                                        </div>

                                        <div class="flex items-center gap-3 mt-2 flex-wrap">
                                            <span class="text-xs text-theme-muted">
                                                {{ $deal->student?->name ?? __('frontend.investor_dashboard.researcher') }}
                                            </span>

                                            @if($video)
                                                <span class="text-xs text-brand-accent flex items-center gap-1">
                                                    <i class="fas fa-video"></i> {{ __('frontend.investor_dashboard.video') }}
                                                </span>
                                            @endif
                                        </div>

                                        @if($interestedCount > 0)
                                            <div class="flex items-center gap-2 mt-3">
                                                <div class="flex -space-x-2">
                                                    @foreach($interestedUsers as $investor)
                                                        <div class="w-7 h-7 rounded-full bg-brand-accent-soft border border-brand-accent text-brand-accent flex items-center justify-center text-[10px] font-black">
                                                            {{ strtoupper(substr($investor->name ?? 'I', 0, 1)) }}
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <span class="text-xs text-theme-muted">
                                                    {{ $interestedCount }} {{ __('frontend.investor_dashboard.interested_investor_label', ['count' => $interestedCount]) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <span class="text-green-600 font-mono text-sm font-bold shrink-0 ml-4">
                                    ${{ number_format($deal->budget ?? 0) }}
                                </span>
                            </a>
                        @empty
                            <div class="text-center py-10 text-theme-muted italic text-sm">
                                {{ __('frontend.investor_dashboard.no_open_opportunities') }}
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <div class="space-y-8">
                <div class="theme-panel p-10 rounded-[3rem]">
                    <h3 class="text-theme-text font-black uppercase tracking-widest text-sm mb-6">
                        {{ __('frontend.investor_dashboard.marketplace_overview') }}
                    </h3>

                    <div class="space-y-5 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-theme-muted">{{ __('frontend.investor_dashboard.active_projects') }}</span>
                            <span class="text-brand-accent font-bold">{{ $marketplaceStats['active_projects'] }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-theme-muted">{{ __('frontend.investor_dashboard.interested') }}</span>
                            <span class="text-theme-text font-bold">{{ $marketplaceStats['interested_count'] }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-theme-muted">{{ __('frontend.investor_dashboard.funding_requested') }}</span>
                            <span class="text-theme-text font-bold">{{ $marketplaceStats['requested_count'] }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-theme-muted">{{ __('frontend.investor_dashboard.approved_investments') }}</span>
                            <span class="text-green-600 font-bold">{{ $marketplaceStats['approved_count'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="theme-panel p-10 rounded-[3rem]">
                    <h3 class="text-theme-text font-black uppercase tracking-widest text-sm mb-6">
                        {{ __('frontend.investor_dashboard.investor_summary') }}
                    </h3>

                    <div class="space-y-4 text-xs text-theme-muted leading-relaxed">
                        <p>
                            <span class="text-brand-accent">{{ __('frontend.investor_dashboard.focus') }}:</span>
                            {{ __('frontend.investor_dashboard.focus_text') }}
                        </p>

                        <p>
                            <span class="text-brand-accent">{{ __('frontend.investor_dashboard.status') }}:</span>
                            {{ __('frontend.investor_dashboard.status_text') }}
                        </p>

                        <p>
                            <span class="text-brand-accent">{{ __('frontend.investor_dashboard.action') }}:</span>
                            {{ __('frontend.investor_dashboard.action_text') }}
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