@php
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
<div class="min-h-screen py-10 pt-28 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-7xl mx-auto px-4">

        <div class="mb-6">
            <a href="{{ route('frontend.projects.index') }}" class="text-brand-accent hover:underline">
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
                    <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                        <span class="text-brand-accent font-bold uppercase tracking-widest text-xs">
                            {{ $project->category ?? 'Uncategorized' }}
                        </span>

                        <h1 class="text-4xl font-bold text-theme-text mt-2">
                            {{ $project->name ?? 'Project Name Missing' }}
                        </h1>

                        <div class="mt-8">
                            <h3 class="text-theme-text font-bold text-xl mb-4">Description</h3>
                            <p class="text-theme-muted leading-relaxed italic text-lg">
                                "{{ $project->description ?? 'No description provided.' }}"
                            </p>
                        </div>

                        @if($interestedCount > 0)
                            <div class="mt-8 pt-6 border-t border-theme-border">
                                <h3 class="text-theme-text font-bold text-lg mb-4">Interested Investors</h3>

                                <div class="flex items-center gap-3 flex-wrap">
                                    <div class="flex -space-x-2">
                                        @foreach($interestedUsers as $investor)
                                            <div class="w-10 h-10 rounded-full bg-brand-accent-soft border border-brand-accent text-brand-accent flex items-center justify-center text-sm font-black">
                                                {{ strtoupper(substr($investor->name ?? 'I', 0, 1)) }}
                                            </div>
                                        @endforeach
                                    </div>

                                    <span class="text-sm text-theme-muted">
                                        {{ $interestedCount }} interested investor{{ $interestedCount > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                        <h3 class="text-theme-text font-bold text-xl mb-6">Project Images</h3>

                        @if($images->count())
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($images as $image)
                                    <a href="{{ $image->getUrl() }}" target="_blank" class="block rounded-2xl overflow-hidden border border-theme-border hover:border-brand-accent/40 transition">
                                        <img src="{{ $image->getUrl() }}" alt="Project image" class="w-full h-52 object-cover">
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-theme-muted italic">No images uploaded.</p>
                        @endif
                    </div>

                    <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                        <h3 class="text-theme-text font-bold text-xl mb-6">Project Video</h3>

                        @if($videoUrl)
                            <video class="w-full rounded-2xl border border-theme-border bg-black" controls style="max-height: 500px;">
                                <source src="{{ $videoUrl }}">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <p class="text-theme-muted italic">No video uploaded.</p>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="theme-panel p-8 rounded-3xl shadow-brand-soft">
                        <p class="text-theme-muted text-xs uppercase font-bold mb-1">Requested Budget</p>
                        <h2 class="text-4xl font-black text-green-600">
                            ${{ is_numeric($project->budget) ? number_format($project->budget) : '0' }}
                        </h2>

                        <div class="mt-6 pt-6 border-t border-theme-border space-y-4">
                            <div class="flex justify-between gap-4">
                                <span class="text-theme-muted">Student Lead:</span>
                                <span class="text-brand-accent font-bold text-right">{{ $project->student?->name ?? 'Unknown User' }}</span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-theme-muted">Status:</span>
                                <span class="text-yellow-600 font-bold text-right">{{ $project->status ?? 'pending' }}</span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-theme-muted">Interest Count:</span>
                                <span class="text-theme-text font-bold text-right">{{ $interestedCount }}</span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-theme-muted">Funding Requests:</span>
                                <span class="text-theme-text font-bold text-right">{{ $requestedCount }}</span>
                            </div>
                        </div>

                        @if($isInvestor)
                            @if(!$currentInvestorStatus)
                                <div class="mt-6 space-y-3">
                                    <form method="POST" action="{{ route('frontend.projects.invest', $project) }}">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-brand-accent text-white font-bold rounded-xl hover:bg-brand-accent-strong transition">
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
                                            class="w-full px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent"
                                        >

                                        <textarea
                                            name="message"
                                            rows="4"
                                            placeholder="Why are you interested in funding this project?"
                                            class="w-full px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent"
                                        ></textarea>

                                        <button type="submit" class="w-full py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition">
                                            Request Funding
                                        </button>
                                    </form>
                                </div>

                            @elseif($currentInvestorStatus === 'interested')
                                <div class="mt-6 space-y-3">
                                    <div class="text-green-600 font-bold text-center p-3 rounded-xl bg-green-500/10 border border-green-500/20">
                                        You already expressed interest in this project
                                    </div>

                                    <form method="POST" action="{{ route('frontend.projects.interest.remove', $project) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full py-3 bg-theme-surface-2 text-theme-text font-bold rounded-xl hover:bg-red-500/10 hover:text-red-600 transition border border-theme-border">
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
                                            class="w-full px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent"
                                        >

                                        <textarea
                                            name="message"
                                            rows="4"
                                            placeholder="Why are you interested in funding this project?"
                                            class="w-full px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent"
                                        ></textarea>

                                        <button type="submit" class="w-full py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition">
                                            Upgrade to Funding Request
                                        </button>
                                    </form>
                                </div>

                            @elseif($currentInvestorStatus === 'requested')
                                <div class="mt-6 text-center p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20 text-yellow-700 font-bold">
                                    Your funding request is currently under review.
                                </div>

                            @elseif($currentInvestorStatus === 'approved')
                                <div class="mt-6 text-center p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-600 font-bold">
                                    Your funding request has been approved.
                                </div>

                            @elseif($currentInvestorStatus === 'rejected')
                                <div class="mt-6 space-y-3">
                                    <div class="text-center p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-600 font-bold">
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
                                            class="w-full px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent"
                                        >

                                        <textarea
                                            name="message"
                                            rows="4"
                                            placeholder="You may submit a new request with more details"
                                            class="w-full px-4 py-3 rounded-xl bg-theme-surface-2 border border-theme-border text-theme-text placeholder:text-theme-muted focus:outline-none focus:border-brand-accent"
                                        ></textarea>

                                        <button type="submit" class="w-full py-3 bg-brand-accent text-white font-bold rounded-xl hover:bg-brand-accent-strong transition">
                                            Submit New Funding Request
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="theme-panel p-6 rounded-3xl shadow-brand-soft">
                        <h3 class="text-theme-text font-bold mb-4 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-brand-accent"></i> Legacy Files
                        </h3>

                        @if($project->files && $project->files->count() > 0)
                            @foreach($project->files as $file)
                                <div class="flex items-center justify-between p-3 bg-theme-surface-2 rounded-xl border border-theme-border mb-2 hover:bg-brand-accent-soft transition-all">
                                    <span class="text-theme-text text-sm font-semibold">
                                        {{ strtoupper($file->file_type ?? 'Document') }}
                                    </span>
                                    <a href="{{ asset('storage/' . ($file->file_path ?? '')) }}" target="_blank" class="text-brand-accent hover:text-theme-text">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-theme-muted italic text-sm text-center py-4">No legacy files found.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-500/10 border border-red-500/40 p-10 rounded-3xl text-center">
                <h2 class="text-2xl text-red-600 font-bold">Project Not Found</h2>
                <p class="text-theme-muted mt-2">We couldn't retrieve the project data. Please try again.</p>
            </div>
        @endif
    </div>
</div>
@endsection