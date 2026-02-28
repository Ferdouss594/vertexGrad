@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    
    $user = auth()->user();
    $latestProject = \App\Models\Project::where('student_id', $user->id)->latest()->first();

    // Calculate progress percentage based on status
    $progress = 20; // Default for Pending
    if($latestProject) {
        if($latestProject->status == 'Active') $progress = 60;
        if($latestProject->status == 'Completed') $progress = 100;
    }
@endphp

@extends('frontend.layouts.app')

@section('content')
{{-- PT-24 or PT-32 adds the necessary space so the content isn't under the navbar --}}
<div class="min-h-screen pt-28 pb-12" style="background-color: {{ $darkBg }}; background-image: radial-gradient(circle at 10% 20%, rgba(30, 227, 247, 0.05) 0%, transparent 40%);">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="relative">
                <h1 class="text-4xl md:text-6xl font-black text-light tracking-tight">
                    Welcome, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-400">{{ explode(' ', $user->name)[0] }}</span>
                </h1>
                <p class="text-light/50 mt-3 flex items-center tracking-[0.2em] uppercase text-xs font-bold">
                    <span class="w-10 h-[2px] bg-primary mr-3"></span>
                    Researcher Identity: {{ $user->id + 5000 }}
                </p>
            </div>
            <div>
                <a href="{{ route('project.submit.step1') }}" class="{{ $btnPrimaryClass }} shadow-xl shadow-primary/20 hover:scale-105 transition-transform py-4 px-8 rounded-2xl">
                    <i class="fas fa-rocket mr-2"></i> Submit New Research
                </a>
            </div>
        </header>

        @if($latestProject)
        {{-- Hero Project Card --}}
        <div class="relative overflow-hidden bg-slate-900/60 backdrop-blur-xl rounded-[2.5rem] border border-white/10 shadow-2xl mb-12 group transition-all hover:border-primary/30">
            {{-- Decorative Background Elements --}}
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors"></div>
            <div class="absolute left-0 bottom-0 w-full h-1 bg-gradient-to-r from-transparent via-primary/20 to-transparent"></div>

            <div class="p-8 md:p-12">
                <div class="flex flex-col lg:flex-row justify-between gap-10">
                    
                    {{-- Left: Project Info --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="px-4 py-1.5 rounded-xl bg-primary/10 text-primary text-[10px] font-black uppercase tracking-[0.15em] border border-primary/20">
                            {{ $latestProject->category ?? 'Uncategorized' }}                            </span>
                            <span class="text-light/30 text-xs font-mono">REF: PRJ-{{ $latestProject->project_id + 1000 }}</span>
                        </div>
                        <h2 class="text-3xl md:text-5xl font-bold text-light mb-8 leading-[1.1] tracking-tight">
                            {{ $latestProject->name }}
                        </h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <p class="text-light/40 text-[10px] uppercase font-black mb-1 tracking-widest">Target Budget</p>
                                <p class="text-2xl font-bold text-success">${{ number_format($latestProject->budget ?? 0) }}</p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <p class="text-light/40 text-[10px] uppercase font-black mb-1 tracking-widest">Submission Date</p>
                                <p class="text-xl text-light/90 font-semibold">{{ $latestProject->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                <p class="text-light/40 text-[10px] uppercase font-black mb-1 tracking-widest">Vetting Status</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex h-2 w-2 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-warning opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-warning"></span>
                                    </div>
                                    <span class="text-lg font-bold text-light italic">
                                        {{ $latestProject->status == 'Pending' ? 'Reviewing' : $latestProject->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex flex-col justify-center gap-4 min-w-[260px]">
                        <a href="{{ route('projects.show', $latestProject->project_id) }}"
                        class="group/btn flex items-center justify-between p-5 bg-primary text-dark rounded-2xl transition-all hover:bg-white">
                            <span class="font-black uppercase text-xs tracking-wider">Project Portfolio</span>
                            <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>

                        <button type="button"
                                class="flex items-center justify-between p-5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl transition-all group text-light/80">
                            <span class="font-bold text-xs uppercase tracking-wider">Upload Data</span>
                            <i class="fas fa-upload group-hover:-translate-y-1 transition-transform text-primary"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Dynamic Progress Bar --}}
            <div class="h-1.5 w-full bg-white/5">
                <div class="h-full bg-gradient-to-r from-primary to-cyan-400 transition-all duration-1000 shadow-[0_0_15px_rgba(30,227,247,0.5)]" 
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>
        @else
        {{-- Empty State --}}
        <div class="bg-slate-900/40 border-2 border-dashed border-white/10 rounded-[3rem] p-20 text-center mb-12">
            <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-8 text-primary text-4xl shadow-[0_0_30px_rgba(30,227,247,0.1)]">
                <i class="fas fa-atom animate-spin-slow"></i>
            </div>
            <h2 class="text-3xl font-bold text-light mb-3">No Active Research Found</h2>
            <p class="text-light/40 mb-10 max-w-lg mx-auto leading-relaxed">Your portal is empty. Take the first step by submitting your academic project for vetting and investment matching.</p>
            <a href="{{ route('project.submit.step1') }}" class="{{ $btnPrimaryClass }} py-4 px-10 rounded-2xl">Start Submission</a>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Timeline --}}
            <div class="lg:col-span-2 bg-slate-900/40 p-10 rounded-[2.5rem] border border-white/5">
                <h3 class="text-xl font-black text-light mb-10 flex items-center uppercase tracking-[0.2em]">
                    <i class="fas fa-project-diagram mr-4 text-primary"></i> Workflow Status
                </h3>
                
                <div class="space-y-10 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-white/5">
                    {{-- Item 1 --}}
                    <div class="relative flex items-start">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl border border-primary bg-primary/20 text-primary shadow-[0_0_15px_rgba(30,227,247,0.3)] z-10 shrink-0">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="ml-8">
                            <time class="text-[10px] font-black text-primary uppercase tracking-widest">Step 01</time>
                            <p class="text-light font-bold text-lg">Submission Finalized</p>
                            <p class="text-sm text-light/40 mt-1">Project metadata has been successfully indexed.</p>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="relative flex items-start opacity-40">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl border border-white/20 bg-dark text-white/20 z-10 shrink-0">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="ml-8">
                            <time class="text-[10px] font-black text-light/40 uppercase tracking-widest">Step 02</time>
                            <p class="text-light font-bold text-lg">AI Technical Analysis</p>
                            <p class="text-sm text-light/40 mt-1">Awaiting committee review assignment.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile Card --}}
            <div class="bg-slate-900/40 p-10 rounded-[2.5rem] border border-white/5 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-black text-light mb-8 flex items-center uppercase tracking-[0.2em]">
                        <i class="fas fa-fingerprint mr-4 text-primary"></i> Identity
                    </h3>
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-cyan-500 flex items-center justify-center text-dark text-2xl font-black shadow-lg shadow-primary/20">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-light text-xl font-bold">{{ $user->name }}</p>
                            <p class="text-sm text-light/40 font-mono">{{ $user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                            <p class="text-[10px] text-light/30 font-black uppercase mb-2 tracking-widest">Institutional Access</p>
                            <p class="text-primary text-sm font-bold italic">
                                <i class="fas fa-shield-alt mr-2"></i> {{ $user->role }} Level
                            </p>
                        </div>
                    </div>
                </div>

                <a href="/profile/edit" class="mt-10 group flex items-center justify-center gap-3 py-4 bg-white/5 hover:bg-white/10 rounded-2xl text-light/60 font-bold uppercase text-[10px] tracking-[0.3em] transition-all">
                    Update Profile <i class="fas fa-cog group-hover:rotate-90 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
</style>
@endsection