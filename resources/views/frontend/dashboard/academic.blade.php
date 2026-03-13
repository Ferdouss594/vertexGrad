@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];

    $user = auth()->user();

    // Load all student projects
    $projects = \App\Models\Project::where('student_id', $user->id)
        ->with('media')
        ->latest('project_id')
        ->get();

    // Selected project from query ?project=ID, else latest
    $selectedId = (int) request()->query('project', 0);
    $currentProject = $selectedId ? $projects->firstWhere('project_id', $selectedId) : null;
    if (!$currentProject) $currentProject = $projects->first();

    // Progress based on current project
    $progress = 20;
    if ($currentProject) {
        if ($currentProject->status === 'Active') $progress = 60;
        if ($currentProject->status === 'Completed') $progress = 100;
    }

    $currentImages = $currentProject ? $currentProject->getMedia('images') : collect();
    $currentVideoUrl = $currentProject ? $currentProject->getFirstMediaUrl('videos') : null;
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen pt-28 pb-12"
     style="background-color: {{ $darkBg }}; background-image: radial-gradient(circle at 10% 20%, rgba(30, 227, 247, 0.05) 0%, transparent 40%);">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
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

            <div class="flex items-center gap-3">
                <a href="{{ route('project.submit.step1') }}"
                   class="{{ $btnPrimaryClass }} shadow-xl shadow-primary/20 hover:scale-105 transition-transform py-4 px-8 rounded-2xl">
                    <i class="fas fa-rocket mr-2"></i> Submit New Research
                </a>
            </div>
        </header>

        @if($currentProject)
            {{-- HERO (Selected Project) --}}
            <div class="relative overflow-hidden bg-slate-900/60 backdrop-blur-xl rounded-[2.5rem] border border-white/10 shadow-2xl mb-10 group transition-all hover:border-primary/30">
                <div class="absolute -right-10 -top-10 w-64 h-64 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors"></div>
                <div class="absolute left-0 bottom-0 w-full h-1 bg-gradient-to-r from-transparent via-primary/20 to-transparent"></div>

                <div class="p-8 md:p-12">
                    <div class="flex flex-col lg:flex-row justify-between gap-10">

                        {{-- Left --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="px-4 py-1.5 rounded-xl bg-primary/10 text-primary text-[10px] font-black uppercase tracking-[0.15em] border border-primary/20">
                                    {{ $currentProject->category ?? 'Uncategorized' }}
                                </span>
                                <span class="text-light/30 text-xs font-mono">REF: PRJ-{{ $currentProject->project_id + 1000 }}</span>
                            </div>

                            <h2 class="text-3xl md:text-5xl font-bold text-light mb-8 leading-[1.1] tracking-tight">
                                {{ $currentProject->name }}
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                                <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                    <p class="text-light/40 text-[10px] uppercase font-black mb-1 tracking-widest">Target Budget</p>
                                    <p class="text-2xl font-bold text-success">${{ number_format($currentProject->budget ?? 0) }}</p>
                                </div>

                                <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                    <p class="text-light/40 text-[10px] uppercase font-black mb-1 tracking-widest">Submission Date</p>
                                    <p class="text-xl text-light/90 font-semibold">{{ $currentProject->created_at->format('M d, Y') }}</p>
                                </div>

                                <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                                    <p class="text-light/40 text-[10px] uppercase font-black mb-1 tracking-widest">Vetting Status</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="flex h-2 w-2 relative">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-warning opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-warning"></span>
                                        </div>
                                        <span class="text-lg font-bold text-light italic">
                                            {{ $currentProject->status == 'Pending' ? 'Reviewing' : $currentProject->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Media Preview --}}
                            <div class="mt-10">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xs font-black text-light/80 uppercase tracking-[0.25em] flex items-center gap-3">
                                        <i class="fas fa-photo-video text-primary"></i> Media Preview
                                    </h3>
                                    <div class="text-xs text-light/30 font-mono">
                                        Images: {{ $currentImages->count() }} • Video: {{ $currentVideoUrl ? 'Yes' : 'No' }}
                                    </div>
                                </div>

                                @if($currentImages->count() > 0)
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                        @foreach($currentImages->take(4) as $m)
                                            <a href="{{ $m->getUrl() }}" target="_blank"
                                               class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 hover:border-primary/20 transition">
                                                <img src="{{ $m->getUrl() }}"
                                                     class="w-full h-28 object-cover opacity-90 hover:opacity-100 transition"
                                                     alt="Project image">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-transparent pointer-events-none"></div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-5 rounded-2xl border border-white/10 bg-white/5 text-light/40 text-sm">
                                        No images uploaded yet.
                                    </div>
                                @endif

                                @if($currentVideoUrl)
                                    <button type="button"
                                            onclick="openVideoModal('{{ $currentVideoUrl }}')"
                                            class="mt-4 w-full flex items-center justify-between p-5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl transition-all text-light/80">
                                        <span class="font-bold text-xs uppercase tracking-wider">Play Video</span>
                                        <i class="fas fa-play text-primary"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        {{-- Right actions --}}
                        <div class="flex flex-col justify-center gap-4 min-w-[260px]">
                            <a href="{{ route('projects.show', $currentProject->project_id) }}"
                               class="group/btn flex items-center justify-between p-5 bg-primary text-dark rounded-2xl transition-all hover:bg-white">
                                <span class="font-black uppercase text-xs tracking-wider">Project Portfolio</span>
                                <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>

                            <button type="button"
                                    onclick="openUploadModal('{{ route('projects.media.upload', $currentProject->project_id) }}')"
                                    class="flex items-center justify-between p-5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl transition-all group text-light/80">
                                <span class="font-bold text-xs uppercase tracking-wider">Upload Data</span>
                                <i class="fas fa-upload group-hover:-translate-y-1 transition-transform text-primary"></i>
                            </button>
                        </div>

                    </div>
                </div>

                {{-- Progress --}}
                <div class="h-1.5 w-full bg-white/5">
                    <div class="h-full bg-gradient-to-r from-primary to-cyan-400 transition-all duration-1000 shadow-[0_0_15px_rgba(30,227,247,0.5)]"
                         style="width: {{ $progress }}%"></div>
                </div>
            </div>

            {{-- Projects list (click -> updates hero) --}}
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-light uppercase tracking-[0.2em] flex items-center gap-3">
                        <i class="fas fa-layer-group text-primary"></i> Your Projects
                    </h2>
                    <div class="text-xs text-light/30 font-mono">Total: {{ $projects->count() }}</div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        @php
                            $thumb = $project->getFirstMediaUrl('images');
                            $imgCount = $project->getMedia('images')->count();
                            $hasVideo = (bool) $project->getFirstMediaUrl('videos');
                            $active = $project->project_id === $currentProject->project_id;
                        @endphp

                        <a href="{{ route('dashboard.academic', ['project' => $project->project_id]) }}"
                           class="block bg-slate-900/40 border rounded-[2rem] overflow-hidden transition
                                  {{ $active ? 'border-primary/40 shadow-[0_0_30px_rgba(0,224,255,0.12)]' : 'border-white/5 hover:border-primary/20' }}">
                            <div class="h-44 bg-white/5 relative">
                                @if($thumb)
                                    <img src="{{ $thumb }}" class="w-full h-full object-cover opacity-90" alt="Project thumbnail">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-light/30">
                                        <div class="text-center">
                                            <i class="fas fa-image text-3xl mb-2"></i>
                                            <div class="text-xs uppercase tracking-[0.2em] font-black">No Image</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="absolute top-4 left-4 flex gap-2">
                                    <span class="px-3 py-1 rounded-xl bg-primary/10 text-primary text-[10px] font-black uppercase tracking-[0.15em] border border-primary/20">
                                        {{ $project->category ?? 'General' }}
                                    </span>
                                    @if($hasVideo)
                                        <span class="px-3 py-1 rounded-xl bg-white/10 text-light text-[10px] font-black uppercase tracking-[0.15em] border border-white/10">
                                            Video
                                        </span>
                                    @endif
                                </div>

                                <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-transparent pointer-events-none"></div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-light/30 text-xs font-mono">PRJ-{{ $project->project_id + 1000 }}</span>
                                    <span class="text-light/30 text-xs font-mono">{{ $project->created_at?->format('M d, Y') }}</span>
                                </div>

                                <h3 class="text-light text-lg font-black leading-tight mb-3">
                                    {{ \Illuminate\Support\Str::limit($project->name, 60) }}
                                </h3>

                                <div class="flex items-center justify-between text-sm">
                                    <div class="text-light/60">
                                        <span class="text-light/40">Images:</span> <span class="font-bold text-light">{{ $imgCount }}</span>
                                    </div>
                                    <div class="text-light/60">
                                        <span class="text-light/40">Status:</span>
                                        <span class="font-bold text-light">{{ $project->status === 'Pending' ? 'Reviewing' : $project->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @else
            {{-- Empty --}}
            <div class="bg-slate-900/40 border-2 border-dashed border-white/10 rounded-[3rem] p-20 text-center mb-12">
                <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-8 text-primary text-4xl shadow-[0_0_30px_rgba(30,227,247,0.1)]">
                    <i class="fas fa-atom animate-spin-slow"></i>
                </div>
                <h2 class="text-3xl font-bold text-light mb-3">No Active Research Found</h2>
                <p class="text-light/40 mb-10 max-w-lg mx-auto leading-relaxed">
                    Your portal is empty. Take the first step by submitting your academic project.
                </p>
                <a href="{{ route('project.submit.step1') }}" class="{{ $btnPrimaryClass }} py-4 px-10 rounded-2xl">
                    Start Submission
                </a>
            </div>
        @endif

    </div>
</div>

{{-- VIDEO MODAL --}}
<div id="videoModal" class="fixed inset-0 z-[9999] hidden">
    <div class="absolute inset-0 bg-black/70" onclick="closeVideoModal()"></div>
    <div class="relative max-w-4xl mx-auto mt-20 bg-slate-900/95 border border-white/10 rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-5 border-b border-white/10 flex items-center justify-between">
            <div class="text-light font-black">Project Video</div>
            <button class="text-light/60 hover:text-light" onclick="closeVideoModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <video id="videoPlayer" class="w-full rounded-2xl border border-white/10 bg-black" controls playsinline>
                <source id="videoSource" src="" type="video/mp4">
            </video>
        </div>
    </div>
</div>

{{-- UPLOAD MODAL --}}
<div id="uploadModal" class="fixed inset-0 z-[9999] hidden">
    <div class="absolute inset-0 bg-black/70" onclick="closeUploadModal()"></div>
    <div class="relative max-w-2xl mx-auto mt-20 bg-slate-900/95 border border-white/10 rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-5 border-b border-white/10 flex items-center justify-between">
            <div>
                <div class="text-light font-black">Upload Data</div>
                <div class="text-light/40 text-xs font-mono">Add images/video to this project</div>
            </div>
            <button class="text-light/60 hover:text-light" onclick="closeUploadModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="uploadForm" class="p-6 space-y-5" method="POST" enctype="multipart/form-data" action="">
            @csrf

            <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                <label class="block text-sm font-bold text-light/80 mb-2">Add Photos (multiple)</label>
                <input type="file" name="project_photos[]" multiple accept="image/*"
                       class="w-full p-2 rounded-lg border border-white/10 bg-dark text-light">
            </div>

            <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                <label class="block text-sm font-bold text-light/80 mb-2">Add Video (single)</label>
                <input type="file" name="project_video" accept="video/*"
                       class="w-full p-2 rounded-lg border border-white/10 bg-dark text-light">
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeUploadModal()"
                        class="px-6 py-3 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 text-light/70 font-bold">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-3 rounded-2xl bg-primary text-dark font-black hover:bg-secondary transition">
                    Upload Now
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openVideoModal(url){
        const modal = document.getElementById('videoModal');
        const player = document.getElementById('videoPlayer');
        const source = document.getElementById('videoSource');

        source.src = url;
        player.load();
        modal.classList.remove('hidden');
    }

    function closeVideoModal(){
        const modal = document.getElementById('videoModal');
        const player = document.getElementById('videoPlayer');
        player.pause();
        modal.classList.add('hidden');
    }

    function openUploadModal(actionUrl){
        const modal = document.getElementById('uploadModal');
        const form = document.getElementById('uploadForm');
        form.action = actionUrl;
        modal.classList.remove('hidden');
    }

    function closeUploadModal(){
        const modal = document.getElementById('uploadModal');
        modal.classList.add('hidden');
    }
</script>

<style>
    @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .animate-spin-slow { animation: spin-slow 8s linear infinite; }
</style>
@endsection