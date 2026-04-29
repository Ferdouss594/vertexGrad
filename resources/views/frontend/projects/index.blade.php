@php
    $authUser = auth('web')->user();
    $isInvestor = $authUser && $authUser->role === 'Investor';

    $translateProjectMeta = function ($value, $group = 'discipline') {
        $raw = trim((string) $value);

        if ($raw === '') {
            return $raw;
        }

        $key = strtolower($raw);
        $key = str_replace(['&', '/', '-', ' '], ['and', '_', '_', '_'], $key);
        $key = preg_replace('/[^a-z0-9_]/', '', $key);
        $key = preg_replace('/_+/', '_', $key);
        $key = trim($key, '_');

        $translationKey = "frontend.project_meta.{$group}.{$key}";

        return __($translationKey) !== $translationKey ? __($translationKey) : $raw;
    };
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen pt-28 pb-12 bg-theme-bg transition-colors duration-300 overflow-hidden">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="pipeline-reveal mb-10 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-theme-text tracking-tight leading-tight">
                {{ __('frontend.pipeline.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.pipeline.title_highlight') }}</span>
            </h1>

            <p class="text-theme-muted mt-2 uppercase tracking-[0.16em] sm:tracking-[0.3em] text-[10px] sm:text-xs font-bold flex items-center">
                <span class="w-8 sm:w-12 h-[1px] bg-brand-accent me-4 shrink-0"></span>
                {{ __('frontend.pipeline.subtitle') }}
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-10">

            <aside class="pipeline-reveal lg:col-span-1">
                <div class="theme-panel p-5 sm:p-6 lg:p-8 rounded-[2rem] lg:sticky lg:top-32">
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
                                class="pipeline-input w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all"
                            >
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-theme-muted uppercase tracking-widest block mb-3">
                                {{ __('frontend.pipeline.discipline') }}
                            </label>

                            <select name="category" class="pipeline-input w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all">
                                <option value="">{{ __('frontend.pipeline.all_fields') }}</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $translateProjectMeta($category, 'discipline') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
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
                                    class="pipeline-input w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all"
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
                                    class="pipeline-input w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-theme-muted uppercase tracking-widest block mb-3">
                                {{ __('frontend.pipeline.sort_by') }}
                            </label>

                            <select name="sort" class="pipeline-input w-full bg-theme-surface-2 border border-theme-border rounded-xl p-3 text-theme-text text-sm focus:border-brand-accent outline-none transition-all">
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
                            <button type="submit" class="pipeline-submit w-full py-4 bg-brand-accent text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-brand-accent-strong transition-all shadow-brand-soft">
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
                <div class="pipeline-reveal theme-panel p-5 rounded-[1.5rem] mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-theme-text font-black text-xl">
                            {{ __('frontend.projects_directory.title') }}
                        </h2>

                        <p class="text-theme-muted text-sm mt-1">
                            {{ __('frontend.projects_directory.showing_results', [
                                'from' => $projects->firstItem() ?? 0,
                                'to' => $projects->lastItem() ?? 0,
                                'total' => $projects->total(),
                            ]) }}
                        </p>
                    </div>

                    @if(
                        request()->filled('search') ||
                        request()->filled('category') ||
                        request()->filled('budget_min') ||
                        request()->filled('budget_max')
                    )
                        <div class="flex flex-wrap gap-2">
                            @if(request('search'))
                                <span class="px-3 py-1 rounded-full bg-brand-accent-soft text-brand-accent text-xs font-bold">
                                    {{ __('frontend.projects_directory.search_chip') }}: {{ request('search') }}
                                </span>
                            @endif

                            @if(request('category'))
                                <span class="px-3 py-1 rounded-full bg-brand-accent-soft text-brand-accent text-xs font-bold">
                                    {{ $translateProjectMeta(request('category'), 'discipline') }}
                                </span>
                            @endif

                            @if(request('budget_min'))
                                <span class="px-3 py-1 rounded-full bg-brand-accent-soft text-brand-accent text-xs font-bold">
                                    {{ __('frontend.projects_directory.min_chip') }} ${{ number_format((float) request('budget_min')) }}
                                </span>
                            @endif

                            @if(request('budget_max'))
                                <span class="px-3 py-1 rounded-full bg-brand-accent-soft text-brand-accent text-xs font-bold">
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

                        <div class="pipeline-card theme-panel rounded-[2rem] sm:rounded-[2.5rem] overflow-hidden hover:border-brand-accent/40 transition-all group">
                            <div class="h-48 sm:h-52 bg-theme-surface-2 overflow-hidden flex items-center justify-center">
                                @if($image)
                                    <img src="{{ $image }}" alt="{{ $project->name }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="text-theme-muted text-4xl">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-5 sm:p-8">
                                <div class="flex justify-between items-start mb-6 gap-4">
                                    <span class="px-3 py-1 bg-brand-accent-soft text-brand-accent text-[10px] font-black rounded-lg border border-brand-accent/20 uppercase tracking-widest">
                                        {{ $project->category ? $translateProjectMeta($project->category, 'discipline') : __('frontend.pipeline.general') }}
                                    </span>

                                    <span class="text-green-600 font-mono font-bold shrink-0">
                                        ${{ number_format($project->budget ?? 0) }}
                                    </span>
                                </div>

                                <h2 class="text-xl sm:text-2xl font-bold text-theme-text mb-4 leading-tight group-hover:text-brand-accent transition-colors">
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
                                        <div class="flex -space-x-2 rtl:space-x-reverse">
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

                                <div class="pt-6 border-t border-theme-border flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <a href="{{ route('frontend.projects.show', $project) }}" class="text-brand-accent hover:text-theme-text transition-colors text-sm font-bold">
                                        {{ __('frontend.pipeline.view_details') }}
                                    </a>

                                    @if($isInvestor)
                                        @if(!$hasInterest)
                                            <form method="POST" action="{{ route('frontend.projects.invest', $project) }}">
                                                @csrf

                                                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-brand-accent text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-brand-accent-strong transition">
                                                    {{ __('frontend.pipeline.express_interest') }}
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('frontend.projects.interest.remove', $project) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-green-500/10 border border-green-500/20 text-green-600 text-xs font-black uppercase tracking-wider hover:bg-red-500/20 hover:text-red-600 transition">
                                                    {{ __('frontend.pipeline.interested') }}
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="pipeline-reveal col-span-full py-16 sm:py-20 text-center theme-panel rounded-[2.5rem] border-dashed">
                            <p class="text-theme-muted italic">
                                {{ __('frontend.pipeline.no_projects_match') }}
                            </p>
                        </div>
                    @endforelse
                </div>

                <div class="pipeline-reveal mt-12">
                    {{ $projects->links() }}
                </div>
            </section>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.getElementById('vg-pipeline-style')) {
        const style = document.createElement('style');
        style.id = 'vg-pipeline-style';
        style.textContent = `
            .pipeline-reveal,
            .pipeline-card {
                opacity: 0;
                transform: translateY(24px);
                transition: opacity .75s ease, transform .75s cubic-bezier(.22,1,.36,1);
            }

            .pipeline-reveal.is-visible,
            .pipeline-card.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .pipeline-card {
                transition: opacity .75s ease, transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            }

            .pipeline-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 44px rgba(0,0,0,.09);
            }

            .pipeline-input:focus {
                box-shadow: 0 0 0 4px rgba(0,224,255,.10);
            }

            .pipeline-submit {
                transition: transform .22s ease, opacity .22s ease, box-shadow .22s ease;
            }

            .pipeline-submit:hover {
                transform: translateY(-1px);
            }

            .pipeline-submit.is-loading {
                pointer-events: none;
                opacity: .92;
            }

            .vg-focus-ring:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px rgba(0,224,255,.16);
                border-radius: 12px;
            }

            @media (max-width: 767px) {
                .pipeline-card:hover {
                    transform: none;
                    box-shadow: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .pipeline-reveal,
                .pipeline-card,
                .pipeline-submit {
                    opacity: 1 !important;
                    transform: none !important;
                    transition: none !important;
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    document.querySelectorAll('.pipeline-reveal').forEach((el, index) => {
        if (prefersReducedMotion) {
            el.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            el.classList.add('is-visible');
        }, 100 + (index * 110));
    });

    document.querySelectorAll('.pipeline-card').forEach((card, index) => {
        if (prefersReducedMotion) {
            card.classList.add('is-visible');
            return;
        }

        setTimeout(() => {
            card.classList.add('is-visible');
        }, 360 + (index * 90));
    });

    document.querySelectorAll('a, button, input, select').forEach((el) => {
        el.classList.add('vg-focus-ring');
    });

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');

            if (!button || button.dataset.loadingApplied === 'true') {
                return;
            }

            button.dataset.loadingApplied = 'true';
            button.style.opacity = '0.9';
            button.style.pointerEvents = 'none';

            if (button.classList.contains('pipeline-submit')) {
                button.classList.add('is-loading');
                button.innerHTML = '{{ __('frontend.pipeline.apply_filters') }}';
            }
        });
    });
});
</script>
@endsection