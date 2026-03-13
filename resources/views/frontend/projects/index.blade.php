@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $authUser = auth('web')->user();
    $isInvestor = $authUser && $authUser->role === 'Investor';
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen pt-28 pb-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="mb-12">
            <h1 class="text-5xl font-black text-light tracking-tight italic">
                INVESTMENT <span class="text-primary">PIPELINE</span>
            </h1>
            <p class="text-light/40 mt-2 uppercase tracking-[0.3em] text-xs font-bold flex items-center">
                <span class="w-12 h-[1px] bg-primary mr-4"></span>
                Active Academic Research Opportunities
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

            <aside class="lg:col-span-1">
                <div class="bg-slate-900/60 p-8 rounded-[2rem] border border-white/10 sticky top-32">
                    <h3 class="text-light font-bold mb-6 flex items-center">
                        <i class="fas fa-filter mr-3 text-primary text-xs"></i> FILTER
                    </h3>

                    <form action="{{ route('frontend.projects.index') }}" method="GET" class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-light/40 uppercase tracking-widest block mb-3">
                                Discipline
                            </label>

                            <select name="category" class="w-full bg-dark/50 border border-white/10 rounded-xl p-3 text-light text-sm focus:border-primary outline-none transition-all">
                                <option value="">All Fields</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-light/40 uppercase tracking-widest block mb-3">
                                Max Funding
                            </label>

                            <div class="flex justify-between text-primary font-mono text-xs mb-2">
                                <span>Selected:</span>
                                <span>${{ number_format(request('budget_max', 1000000)) }}</span>
                            </div>

                            <input
                                type="range"
                                name="budget_max"
                                min="1000"
                                max="1000000"
                                step="5000"
                                value="{{ request('budget_max', 1000000) }}"
                                class="w-full accent-primary bg-white/5 cursor-pointer"
                                oninput="this.previousElementSibling.lastElementChild.innerText = '$' + Number(this.value).toLocaleString()"
                            >
                        </div>

                        <div class="pt-4 space-y-3">
                            <button type="submit" class="w-full py-4 bg-primary text-dark font-black text-xs uppercase tracking-widest rounded-xl hover:bg-white transition-all shadow-lg shadow-primary/10">
                                Update Results
                            </button>

                            @if(request()->filled('category') || request()->filled('budget_max'))
                                <a href="{{ route('frontend.projects.index') }}" class="block text-center text-[10px] font-black text-light/30 uppercase tracking-widest hover:text-error transition-colors">
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </aside>

            <section class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($projects as $project)
                        @php
                            $image = $project->getFirstMediaUrl('images');
                            $video = $project->getFirstMediaUrl('videos');
                            $interestedCount = $project->investors->count();
                            $interestedUsers = $project->investors->take(3);
                            $hasInterest = $isInvestor ? $project->investors->contains('id', $authUser->id) : false;
                        @endphp

                        <div class="bg-slate-900/40 border border-white/5 rounded-[2.5rem] overflow-hidden hover:border-primary/40 transition-all group">
                            <div class="h-52 bg-black/20 overflow-hidden flex items-center justify-center">
                                @if($image)
                                    <img src="{{ $image }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-light/20 text-4xl">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-8">
                                <div class="flex justify-between items-start mb-6 gap-4">
                                    <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black rounded-lg border border-primary/20 uppercase tracking-widest">
                                        {{ $project->category ?? 'General' }}
                                    </span>

                                    <span class="text-success font-mono font-bold shrink-0">
                                        ${{ number_format($project->budget ?? 0) }}
                                    </span>
                                </div>

                                <h2 class="text-2xl font-bold text-light mb-4 leading-tight group-hover:text-primary transition-colors">
                                    {{ $project->name }}
                                </h2>

                                <p class="text-light/40 text-sm line-clamp-2 mb-6 italic">
                                    "{{ $project->description }}"
                                </p>

                                <div class="flex items-center gap-3 mb-4 flex-wrap">
                                    <span class="text-xs text-light/60 font-medium">
                                        {{ $project->student?->name ?? 'Researcher' }}
                                    </span>

                                    @if($video)
                                        <span class="text-xs text-primary flex items-center gap-1">
                                            <i class="fas fa-video"></i> Video
                                        </span>
                                    @endif
                                </div>

                                @if($interestedCount > 0)
                                    <div class="flex items-center gap-2 mb-6">
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

                                <div class="pt-6 border-t border-white/5 flex items-center justify-between gap-3">
                                    <a href="{{ route('frontend.projects.show', $project) }}" class="text-primary hover:text-light transition-colors text-sm font-bold">
                                        View Details
                                    </a>

                                    @if($isInvestor)
                                        @if(!$hasInterest)
                                            <form method="POST" action="{{ route('frontend.projects.invest', $project) }}">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-primary text-dark rounded-xl text-xs font-black uppercase tracking-wider hover:bg-white transition">
                                                    Express Interest
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('frontend.projects.interest.remove', $project) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-black uppercase tracking-wider hover:bg-red-500/20 hover:text-red-300 transition">
                                                    Interested
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-white/5 rounded-[2.5rem] border border-dashed border-white/10">
                            <p class="text-light/30 italic">No projects currently match these filters.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            </section>
        </div>
    </div>
</div>
@endsection