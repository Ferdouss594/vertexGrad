@php
    $design = config('design');
    $darkBg = $design['colors']['dark'] ?? '#0f172a';

    $authUser = auth('web')->user();
    $isInvestor = $authUser && $authUser->role === 'Investor';

    $currentInvestorRelation = null;
    $currentInvestorStatus = null;

    if ($isInvestor && isset($project)) {
        $currentInvestorRelation = $project->investors->firstWhere('id', $authUser->id);
        $currentInvestorStatus = $currentInvestorRelation?->pivot?->status;
    }

    $interestedCount = isset($project)
        ? $project->investors->where('pivot.status', 'interested')->count()
        : 0;

    $interestedUsers = isset($project)
        ? $project->investors->where('pivot.status', 'interested')->take(5)
        : collect();

    $requestedCount = isset($project)
        ? $project->investors->where('pivot.status', 'requested')->count()
        : 0;
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 pt-28" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4">

        <div class="mb-6">
            <a href="{{ route('frontend.projects.index') }}" class="text-primary hover:underline">
                <i class="fas fa-arrow-left mr-2"></i> Back to Projects
            </a>
        </div>

        @if(isset($project))
            @php
                $images = $project->getMedia('images');
                $videoUrl = $project->getFirstMediaUrl('videos');
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-8">
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

                        @if($interestedCount > 0)
                            <div class="mt-8 pt-6 border-t border-white/10">
                                <h3 class="text-light font-bold text-lg mb-4">Interested Investors</h3>

                                <div class="flex items-center gap-3 flex-wrap">
                                    <div class="flex -space-x-2">
                                        @foreach($interestedUsers as $investor)
                                            <div class="w-10 h-10 rounded-full bg-primary/20 border border-primary text-primary flex items-center justify-center text-sm font-black">
                                                {{ strtoupper(substr($investor->name ?? 'I', 0, 1)) }}
                                            </div>
                                        @endforeach
                                    </div>

                                    <span class="text-sm text-light/50">
                                        {{ $interestedCount }} interested investor{{ $interestedCount > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-slate-800/50 p-8 rounded-3xl border border-white/10 shadow-xl">
                        <h3 class="text-light font-bold text-xl mb-6">Project Images</h3>

                        @if($images->count())
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($images as $image)
                                    <a href="{{ $image->getUrl() }}" target="_blank" class="block rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition">
                                        <img src="{{ $image->getUrl() }}" alt="Project image" class="w-full h-52 object-cover">
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-light/30 italic">No images uploaded.</p>
                        @endif
                    </div>

                    <div class="bg-slate-800/50 p-8 rounded-3xl border border-white/10 shadow-xl">
                        <h3 class="text-light font-bold text-xl mb-6">Project Video</h3>

                        @if($videoUrl)
                            <video class="w-full rounded-2xl border border-white/10 bg-black" controls style="max-height: 500px;">
                                <source src="{{ $videoUrl }}">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <p class="text-light/30 italic">No video uploaded.</p>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-dark/50 p-8 rounded-3xl border border-success/30 shadow-lg">
                        <p class="text-light/50 text-xs uppercase font-bold mb-1">Requested Budget</p>
                        <h2 class="text-4xl font-black text-success">
                            ${{ is_numeric($project->budget) ? number_format($project->budget) : '0' }}
                        </h2>

                        <div class="mt-6 pt-6 border-t border-white/5 space-y-4">
                            <div class="flex justify-between gap-4">
                                <span class="text-light/40">Student Lead:</span>
                                <span class="text-primary font-bold text-right">{{ $project->student?->name ?? 'Unknown User' }}</span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-light/40">Status:</span>
                                <span class="text-warning font-bold text-right">{{ $project->status ?? 'pending' }}</span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-light/40">Interest Count:</span>
                                <span class="text-light font-bold text-right">{{ $interestedCount }}</span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-light/40">Funding Requests:</span>
                                <span class="text-light font-bold text-right">{{ $requestedCount }}</span>
                            </div>
                        </div>

                        @if($isInvestor)
                            @if(!$currentInvestorStatus)
                                <div class="mt-6 space-y-3">
                                    <form method="POST" action="{{ route('frontend.projects.invest', $project) }}">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-primary text-dark font-bold rounded-xl hover:bg-white transition">
                                            Express Investment Interest
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('frontend.projects.requestFunding', $project) }}" class="space-y-3">
                                        @csrf
                                        <input
                                            type="number"
                                            name="amount"
                                            min="1"
                                            step="0.01"
                                            placeholder="Funding amount"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-light placeholder:text-light/30 focus:outline-none focus:border-primary"
                                        >

                                        <textarea
                                            name="message"
                                            rows="4"
                                            placeholder="Why are you interested in funding this project?"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-light placeholder:text-light/30 focus:outline-none focus:border-primary"
                                        ></textarea>

                                        <button type="submit" class="w-full py-3 bg-green-500 text-dark font-bold rounded-xl hover:bg-green-400 transition">
                                            Request Funding
                                        </button>
                                    </form>
                                </div>

                            @elseif($currentInvestorStatus === 'interested')
                                <div class="mt-6 space-y-3">
                                    <div class="text-success font-bold text-center p-3 rounded-xl bg-green-500/10 border border-green-500/20">
                                        You already expressed interest in this project
                                    </div>

                                    <form method="POST" action="{{ route('frontend.projects.interest.remove', $project) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full py-3 bg-white/10 text-light font-bold rounded-xl hover:bg-red-500/20 hover:text-red-300 transition border border-white/10">
                                            Remove Interest
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('frontend.projects.requestFunding', $project) }}" class="space-y-3">
                                        @csrf
                                        <input
                                            type="number"
                                            name="amount"
                                            min="1"
                                            step="0.01"
                                            placeholder="Funding amount"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-light placeholder:text-light/30 focus:outline-none focus:border-primary"
                                        >

                                        <textarea
                                            name="message"
                                            rows="4"
                                            placeholder="Why are you interested in funding this project?"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-light placeholder:text-light/30 focus:outline-none focus:border-primary"
                                        ></textarea>

                                        <button type="submit" class="w-full py-3 bg-green-500 text-dark font-bold rounded-xl hover:bg-green-400 transition">
                                            Upgrade to Funding Request
                                        </button>
                                    </form>
                                </div>

                            @elseif($currentInvestorStatus === 'requested')
                                <div class="mt-6 text-center p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20 text-yellow-300 font-bold">
                                    Your funding request is currently under review.
                                </div>

                            @elseif($currentInvestorStatus === 'approved')
                                <div class="mt-6 text-center p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-300 font-bold">
                                    Your funding request has been approved.
                                </div>

                            @elseif($currentInvestorStatus === 'rejected')
                                <div class="mt-6 space-y-3">
                                    <div class="text-center p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-300 font-bold">
                                        Your funding request was rejected.
                                    </div>

                                    <form method="POST" action="{{ route('frontend.projects.requestFunding', $project) }}" class="space-y-3">
                                        @csrf
                                        <input
                                            type="number"
                                            name="amount"
                                            min="1"
                                            step="0.01"
                                            placeholder="New funding amount"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-light placeholder:text-light/30 focus:outline-none focus:border-primary"
                                        >

                                        <textarea
                                            name="message"
                                            rows="4"
                                            placeholder="You may submit a new request with more details"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-light placeholder:text-light/30 focus:outline-none focus:border-primary"
                                        ></textarea>

                                        <button type="submit" class="w-full py-3 bg-primary text-dark font-bold rounded-xl hover:bg-white transition">
                                            Submit New Funding Request
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="bg-slate-800/50 p-6 rounded-3xl border border-white/10">
                        <h3 class="text-light font-bold mb-4 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-primary"></i> Legacy Files
                        </h3>

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
                            <p class="text-light/30 italic text-sm text-center py-4">No legacy files found.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-500/10 border border-red-500/50 p-10 rounded-3xl text-center">
                <h2 class="text-2xl text-red-500 font-bold">Project Not Found</h2>
                <p class="text-light/60 mt-2">We couldn't retrieve the project data. Please try again.</p>
            </div>
        @endif
    </div>
</div>
@endsection