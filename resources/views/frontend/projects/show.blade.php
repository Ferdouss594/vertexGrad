@php
    $design = config('design');
    $darkBg = $design['colors']['dark'] ?? '#0f172a';
    $primaryColor = $design['colors']['primary'] ?? '#38bdf8';
    $btnPrimaryClass = $design['classes']['btn_base'] ?? '' . ' ' . $design['classes']['btn_primary'] ?? '';
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4">
        
        {{-- Navigation --}}
        <div class="mb-6">
            <a href="{{ route('dashboard.academic') }}" class="text-primary hover:underline">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        @if(isset($project))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Side: Details --}}
            <div class="lg:col-span-2">
                <div class="bg-slate-800/50 p-8 rounded-3xl border border-white/10 shadow-xl">
                    <span class="text-primary font-bold uppercase tracking-widest text-xs">
                        {{ $project->category ?? 'Uncategorized' }}
                    </span>
                    <h1 class="text-4xl font-bold text-light mt-2">
                        {{ $project->name ?? 'Project Name Missing' }}
                    </h1>
                    
                    <div class="mt-8">
                        <h3 class="text-light font-bold text-xl mb-4">Description</h3>
                        <p class="text-light/70 leading-relaxed italic text-lg">
                            "{{ $project->description ?? 'No description provided.' }}"
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right Side: Stats & Files --}}
            <div class="space-y-6">
                {{-- Info Card --}}
                <div class="bg-dark/50 p-8 rounded-3xl border border-success/30 shadow-lg">
                    <p class="text-light/50 text-xs uppercase font-bold mb-1">Requested Budget</p>
                    <h2 class="text-4xl font-black text-success">
                        ${{ is_numeric($project->budget) ? number_format($project->budget) : '0' }}
                    </h2>
                    
                    <div class="mt-6 pt-6 border-t border-white/5 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-light/40">Student Lead:</span>
                            <span class="text-primary font-bold">{{ $project->student->name ?? 'Unknown User' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-light/40">Status:</span>
                            <span class="text-warning font-bold">{{ $project->status ?? 'Pending' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Files Card --}}
                <div class="bg-slate-800/50 p-6 rounded-3xl border border-white/10">
                    <h3 class="text-light font-bold mb-4 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-primary"></i> Supporting Files
                    </h3>
                    
                    {{-- Check if relationship exists and has items --}}
                    @if($project->files && $project->files->count() > 0)
                        @foreach($project->files as $file)
                            <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5 mb-2 hover:bg-white/10 transition-all">
                                <span class="text-light/80 text-sm font-semibold">
                                    {{ strtoupper($file->file_type ?? 'Document') }}
                                </span>
                                <a href="{{ asset('storage/' . ($file->file_path ?? '')) }}" target="_blank" class="text-primary hover:text-light">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-light/30 italic text-sm text-center py-4">No documents found.</p>
                    @endif
                </div>
            </div>
        </div>
        @else
            {{-- Error State --}}
            <div class="bg-red-500/10 border border-red-500/50 p-10 rounded-3xl text-center">
                <h2 class="text-2xl text-red-500 font-bold">Project Not Found</h2>
                <p class="text-light/60 mt-2">We couldn't retrieve the project data. Please try again.</p>
            </div>
        @endif

    </div>
</div>
@endsection