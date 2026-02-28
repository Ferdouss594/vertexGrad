@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
@endphp

@extends('frontend.layouts.app')

@section('content')
{{-- PT-28 fixes the navbar overlap --}}
<div class="min-h-screen pt-28 pb-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-12">
            <h1 class="text-5xl font-black text-light tracking-tight italic">
                INVESTMENT <span class="text-primary">PIPELINE</span>
            </h1>
            <p class="text-light/40 mt-2 uppercase tracking-[0.3em] text-xs font-bold flex items-center">
                <span class="w-12 h-[1px] bg-primary mr-4"></span>
                Vetted Academic Research Opportunities
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
            
            {{-- Sidebar Filters --}}
<aside class="lg:col-span-1">
    <div class="bg-slate-900/60 p-8 rounded-[2rem] border border-white/10 sticky top-32">
        <h3 class="text-light font-bold mb-6 flex items-center">
            <i class="fas fa-filter mr-3 text-primary text-xs"></i> FILTER
        </h3>
        
        <form action="{{ route('frontend.projects.index') }}" method="GET" class="space-y-6">
            {{-- Discipline Filter --}}
            <div>
                <label class="text-[10px] font-black text-light/40 uppercase tracking-widest block mb-3">Discipline</label>
                <select name="category" class="w-full bg-dark/50 border border-white/10 rounded-xl p-3 text-light text-sm focus:border-primary outline-none transition-all">
                    <option value="">All Fields</option>
                    {{-- 'selected' attribute keeps the choice visible after filtering --}}
                    <option value="AI & ML" {{ request('category') == 'AI & ML' ? 'selected' : '' }}>AI & ML</option>
                    <option value="Biotech" {{ request('category') == 'Biotech' ? 'selected' : '' }}>Biotech</option>
                    <option value="Energy" {{ request('category') == 'Energy' ? 'selected' : '' }}>Energy</option>
                </select>
            </div>

            {{-- Budget Filter --}}
            <div>
                <label class="text-[10px] font-black text-light/40 uppercase tracking-widest block mb-3">Max Funding</label>
                {{-- Show the current value to the user --}}
                <div class="flex justify-between text-primary font-mono text-xs mb-2">
                    <span>Selected:</span>
                    <span>${{ number_format(request('budget_max', 1000000)) }}</span>
                </div>
                <input type="range" 
                       name="budget_max" 
                       min="1000" 
                       max="1000000" 
                       step="5000" 
                       value="{{ request('budget_max', 1000000) }}"
                       class="w-full accent-primary bg-white/5 cursor-pointer"
                       oninput="this.previousElementSibling.lastElementChild.innerText = '$' + Number(this.value).toLocaleString()">
            </div>

            <div class="pt-4 space-y-3">
                <button type="submit" class="w-full py-4 bg-primary text-dark font-black text-xs uppercase tracking-widest rounded-xl hover:bg-white transition-all shadow-lg shadow-primary/10">
                    Update Results
                </button>
                
                @if(request()->hasAny(['category', 'budget_max']))
                    <a href="{{ route('frontend.projects.index') }}" class="block text-center text-[10px] font-black text-light/30 uppercase tracking-widest hover:text-error transition-colors">
                        Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </div>
</aside>

            {{-- Project Grid --}}
            <section class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($projects as $project)
                    <div class="bg-slate-900/40 border border-white/5 rounded-[2.5rem] p-8 hover:border-primary/40 transition-all group">
                        <div class="flex justify-between items-start mb-6">
                            <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black rounded-lg border border-primary/20 uppercase tracking-widest">
                                {{ $project->category ?? 'General' }}
                            </span>
                            <span class="text-success font-mono font-bold">${{ number_format($project->budget) }}</span>
                        </div>

                        <h2 class="text-2xl font-bold text-light mb-4 leading-tight group-hover:text-primary transition-colors">
                            {{ $project->name }}
                        </h2>

                        <p class="text-light/40 text-sm line-clamp-2 mb-8 italic">
                            "{{ $project->description }}"
                        </p>

                        <div class="pt-6 border-t border-white/5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-primary text-xs">
                                    <i class="fas fa-university"></i>
                                </div>
                                <span class="text-xs text-light/60 font-medium">{{ $project->student->name ?? 'Researcher' }}</span>
                            </div>
                            <a href="{{ route('project.details', $project->project_id) }}" class="text-primary hover:text-light transition-colors">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-20 text-center bg-white/5 rounded-[2.5rem] border border-dashed border-white/10">
                        <p class="text-light/30 italic">No projects currently matching these criteria.</p>
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