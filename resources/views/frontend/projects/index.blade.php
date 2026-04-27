@php
    $authUser = auth('web')->user();
    $isInvestor = $authUser && $authUser->role === 'Investor';
@endphp

@extends('frontend.layouts.app')

@push('styles')
<style>
    .vg-reveal {
        opacity: 0;
        transform: translateY(26px);
        transition:
            opacity 0.75s cubic-bezier(.22, 1, .36, 1),
            transform 0.75s cubic-bezier(.22, 1, .36, 1);
        will-change: opacity, transform;
    }

    .vg-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .vg-project-card {
        position: relative;
        transition:
            transform 0.35s ease,
            border-color 0.35s ease,
            box-shadow 0.35s ease;
    }

    .vg-project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 70px rgba(0, 224, 255, 0.08);
    }

    .vg-project-card::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        border-radius: 2.5rem;
        background: linear-gradient(135deg, rgba(0, 224, 255, 0.12), transparent 42%);
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    .vg-project-card:hover::before {
        opacity: 1;
    }

    .vg-image-wrap {
        position: relative;
    }

    .vg-image-wrap::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(110deg, transparent 20%, rgba(255,255,255,0.08) 45%, transparent 70%);
        transform: translateX(-120%);
        transition: transform 0.9s ease;
    }

    .vg-project-card:hover .vg-image-wrap::after {
        transform: translateX(120%);
    }

    .vg-filter-panel {
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }

    .vg-filter-panel:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 60px rgba(0, 224, 255, 0.06);
    }

    .vg-directory-panel {
        position: relative;
        overflow: hidden;
    }

    .vg-directory-panel::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 999px;
        background: rgba(0, 224, 255, 0.12);
        filter: blur(42px);
        top: -110px;
        inset-inline-end: -80px;
        pointer-events: none;
    }

    .vg-directory-panel::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 999px;
        background: rgba(0, 224, 255, 0.06);
        filter: blur(48px);
        bottom: -150px;
        inset-inline-start: -120px;
        pointer-events: none;
    }

    .vg-chip {
        transition: transform 0.25s ease, background-color 0.25s ease;
    }

    .vg-chip:hover {
        transform: translateY(-2px);
    }

    @media (prefers-reduced-motion: reduce) {
        .vg-reveal,
        .vg-project-card,
        .vg-filter-panel,
        .vg-image-wrap::after,
        .vg-chip {
            transition: none !important;
            transform: none !important;
        }

        .vg-reveal {
            opacity: 1 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen pt-28 pb-12 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="mb-12 vg-reveal">
            <h1 class="text-5xl font-black text-theme-text tracking-tight">
                {{ __('frontend.pipeline.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.pipeline.title_highlight') }}</span>
            </h1>

            <p class="text-theme-muted mt-2 uppercase tracking-[0.3em] text-xs font-bold flex items-center">
                <span class="w-12 h-[1px] bg-brand-accent me-4"></span>
                {{ __('frontend.pipeline.subtitle') }}
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

            <aside class="lg:col-span-1 vg-reveal">
                <div class="theme-panel vg-filter-panel p-8 rounded-[2rem] sticky top-32">
                    <h3 class="text-theme-text font-bold mb-6 flex items-center uppercase tracking-widest text-sm">
                        <i class="fas fa-filter me-3 text-brand-accent text-xs"></i>
                        {{ __('frontend.pipeline.filter') }}
                    </h3>

                    <form action="{{ route('frontend.projects.index') }}" method="GET" class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-theme-muted uppercase tracking-widest block mb-3">
                                {{ __('frontend.pipeline.search') }}
                            </label>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="{{ __('frontend.pipeline.search_placeholder') }}"
                                class="w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all"
                            >
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-theme-muted uppercase tracking-widest block mb-3">
                                {{ __('frontend.pipeline.discipline') }}
                            </label>

                            <select name="category" class="w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all">
                                <option value="">{{ __('frontend.pipeline.all_fields') }}</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[10px] font-black text-theme-muted uppercase tracking-widest block mb-3">
                                    {{ __('frontend.pipeline.min_budget') }}
                                </label>

                                <input
                                    type="number"
                                    name="budget_min"
                                    min="100"
                                    step="100"
                                    value="{{ request('budget_min', 100) }}"
                                    placeholder="100"
                                    class="w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all"
                                >
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-theme-muted uppercase tracking-widest block mb-3">
                                    {{ __('frontend.pipeline.max_budget') }}
                                </label>

                                <input
                                    type="number"
                                    name="budget_max"
                                    min="100"
                                    step="100"
                                    value="{{ request('budget_max') }}"
                                    placeholder="1000000"
                                    class="w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-theme-muted uppercase tracking-widest block mb-3">
                                {{ __('frontend.pipeline.sort_by') }}
                            </label>

                            <select name="sort" class="w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    {{ __('frontend.pipeline.sort_latest') }}
                                </option>

                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    {{ __('frontend.pipeline.sort_oldest') }}
                                </option>

                                <option value="budget_low" {{ request('sort') == 'budget_low' ? 'selected' : '' }}>
                                    {{ __('frontend.pipeline.sort_budget_low') }}
                                </option>

                                <option value="budget_high" {{ request('sort') == 'budget_high' ? 'selected' : '' }}>
                                    {{ __('frontend.pipeline.sort_budget_high') }}
                                </option>

                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                    {{ __('frontend.pipeline.sort_name') }}
                                </option>
                            </select>
                        </div>

                        <div class="pt-4 space-y-3">
                            <button type="submit" class="w-full py-4 bg-brand-accent text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-brand-accent-strong transition-all shadow-brand-soft">
                                {{ __('frontend.pipeline.apply_filters') }}
                            </button>

                            @if(
                                request()->filled('search') ||
                                request()->filled('category') ||
                                request()->filled('budget_min') ||
                                request()->filled('budget_max') ||
                                request()->filled('sort')
                            )
                                <a href="{{ route('frontend.projects.index') }}" class="block text-center text-[10px] font-black text-theme-muted uppercase tracking-widest hover:text-red-500 transition-colors">
                                    {{ __('frontend.pipeline.clear_filters') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </aside>

            <section class="lg:col-span-3">

                <div class="theme-panel vg-directory-panel vg-reveal p-6 rounded-[2rem] mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5 border border-brand-accent/20">
                    <div class="relative z-10 flex items-center gap-4">
                        <span class="w-11 h-11 rounded-2xl bg-brand-accent-soft border border-brand-accent/20 flex items-center justify-center text-brand-accent shrink-0">
                            <i class="fas fa-layer-group"></i>
                        </span>

                        <div>
                            <h2 class="text-theme-text font-black text-xl tracking-tight">
                                {{ __('frontend.projects_directory.title') }}
                            </h2>

                            <p class="text-sm text-theme-muted mt-1">
                                {{ __('frontend.projects_directory.showing_results', [
                                    'from' => $projects->firstItem() ?? 0,
                                    'to' => $projects->lastItem() ?? 0,
                                    'total' => $projects->total(),
                                ]) }}
                            </p>
                        </div>
                    </div>

                    @if(
                        request()->filled('search') ||
                        request()->filled('category') ||
                        request()->filled('budget_min') ||
                        request()->filled('budget_max')
                    )
                        <div class="relative z-10 flex flex-wrap gap-2 md:justify-end">
                            @if(request('search'))
                                <span class="vg-chip px-3 py-1.5 rounded-full bg-brand-accent-soft text-brand-accent text-[10px] font-black uppercase tracking-widest border border-brand-accent/20">
                                    {{ __('frontend.projects_directory.search_chip') }}: {{ request('search') }}
                                </span>
                            @endif

                            @if(request('category'))
                                <span class="vg-chip px-3 py-1.5 rounded-full bg-brand-accent-soft text-brand-accent text-[10px] font-black uppercase tracking-widest border border-brand-accent/20">
                                    {{ request('category') }}
                                </span>
                            @endif

                            @if(request('budget_min'))
                                <span class="vg-chip px-3 py-1.5 rounded-full bg-brand-accent-soft text-brand-accent text-[10px] font-black uppercase tracking-widest border border-brand-accent/20">
                                    {{ __('frontend.projects_directory.min_chip') }} ${{ number_format((float) request('budget_min')) }}
                                </span>
                            @endif

                            @if(request('budget_max'))
                                <span class="vg-chip px-3 py-1.5 rounded-full bg-brand-accent-soft text-brand-accent text-[10px] font-black uppercase tracking-widest border border-brand-accent/20">
                                    {{ __('frontend.projects_directory.max_chip') }} ${{ number_format((float) request('budget_max')) }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($projects as $project)
                        @php
                            $image = $project->getFirstMediaUrl('images');
                            $video = $project->getFirstMediaUrl('videos');
                            $interestedCount = $project->investors->count();
                            $interestedUsers = $project->investors->take(3);
                            $hasInterest = $isInvestor ? $project->investors->contains('id', $authUser->id) : false;
                        @endphp

                        <div class="theme-panel vg-project-card vg-reveal rounded-[2.5rem] overflow-hidden hover:border-brand-accent/40 transition-all group">
                            <div class="vg-image-wrap h-52 bg-theme-surface-2 overflow-hidden flex items-center justify-center">
                                @if($image)
                                    <img src="{{ $image }}" alt="{{ $project->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div class="text-theme-muted text-4xl transition-transform duration-500 group-hover:scale-110">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-8 relative z-10">
                                <div class="flex justify-between items-start mb-6 gap-4">
                                    <span class="px-3 py-1 bg-brand-accent-soft text-brand-accent text-[10px] font-black rounded-lg border border-brand-accent/20 uppercase tracking-widest">
                                        {{ $project->category ?? __('frontend.pipeline.general') }}
                                    </span>

                                    <span class="text-green-600 font-mono font-bold shrink-0">
                                        ${{ number_format($project->budget ?? 0) }}
                                    </span>
                                </div>

                                <h2 class="text-2xl font-bold text-theme-text mb-4 leading-tight group-hover:text-brand-accent transition-colors">
                                    {{ $project->name }}
                                </h2>

                                <p class="text-theme-muted text-sm line-clamp-2 mb-6 italic">
                                    "{{ $project->description }}"
                                </p>

                                <div class="flex items-center gap-3 mb-4 flex-wrap">
                                    <span class="text-xs text-theme-muted font-medium">
                                        {{ $project->student?->name ?? __('frontend.pipeline.researcher') }}
                                    </span>

                                    @if($video)
                                        <span class="text-xs text-brand-accent flex items-center gap-1">
                                            <i class="fas fa-video"></i>
                                            {{ __('frontend.pipeline.video') }}
                                        </span>
                                    @endif
                                </div>

                                @if($interestedCount > 0)
                                    <div class="flex items-center gap-2 mb-6">
                                        <div class="flex -space-x-2">
                                            @foreach($interestedUsers as $investor)
                                                <div class="w-7 h-7 rounded-full bg-brand-accent-soft border border-brand-accent text-brand-accent flex items-center justify-center text-[10px] font-black">
                                                    {{ strtoupper(substr($investor->name ?? 'I', 0, 1)) }}
                                                </div>
                                            @endforeach
                                        </div>

                                        <span class="text-xs text-theme-muted">
                                            {{ $interestedCount }} {{ trans_choice('frontend.pipeline.interested_investors', $interestedCount) }}
                                        </span>
                                    </div>
                                @endif

                                <div class="pt-6 border-t border-theme-border flex items-center justify-between gap-3">
                                    <a href="{{ route('frontend.projects.show', $project) }}" class="text-brand-accent hover:text-theme-text transition-colors text-sm font-bold">
                                        {{ __('frontend.pipeline.view_details') }}
                                    </a>

                                    @if($isInvestor)
                                        @if(!$hasInterest)
                                            <form method="POST" action="{{ route('frontend.projects.invest', $project) }}">
                                                @csrf

                                                <button type="submit" class="px-4 py-2 bg-brand-accent text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-brand-accent-strong transition">
                                                    {{ __('frontend.pipeline.express_interest') }}
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('frontend.projects.interest.remove', $project) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="px-4 py-2 rounded-xl bg-green-500/10 border border-green-500/20 text-green-600 text-xs font-black uppercase tracking-wider hover:bg-red-500/20 hover:text-red-600 transition">
                                                    {{ __('frontend.pipeline.interested') }}
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center theme-panel vg-reveal rounded-[2.5rem] border-dashed">
                            <p class="text-theme-muted italic">
                                {{ __('frontend.pipeline.no_projects_match') }}
                            </p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12 vg-reveal">
                    {{ $projects->links() }}
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const revealItems = document.querySelectorAll('.vg-reveal');

    if (!('IntersectionObserver' in window)) {
        revealItems.forEach(function (item) {
            item.classList.add('is-visible');
        });
        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }

            const item = entry.target;
            const delay = Number(item.dataset.delay || 0);

            window.setTimeout(function () {
                item.classList.add('is-visible');
            }, delay);

            observer.unobserve(item);
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px'
    });

    revealItems.forEach(function (item, index) {
        item.dataset.delay = String(Math.min(index * 70, 420));
        observer.observe(item);
    });
});
</script>
@endpush