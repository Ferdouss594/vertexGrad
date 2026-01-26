@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';
    
    // Placeholder Data for the Project Status (In production, this is fetched from the database)
    $projectStatus = 'Pending Review'; // Example initial status
    $submissionDate = 'December 12, 2025';
    $projectTitle = 'Dynamic Quantum Encryption Protocol for Satellite Networks';
    $nextAction = 'The Vetting Committee will perform an initial screening within 7-10 days.';
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-10 border-b border-light/20 pb-4">
            <h1 class="text-4xl font-extrabold text-light">
                👋 Welcome, Dr. Vance
            </h1>
            <p class="text-xl text-primary mt-1">Academic Project Dashboard</p>
        </header>

        {{-- Main Project Status Card --}}
        <div class="bg-cardLight/70 rounded-xl p-8 shadow-2xl border border-primary/30 mb-10">
            <h2 class="text-3xl font-bold text-light mb-4 flex items-center">
                <i class="fas fa-flask text-primary mr-3"></i> Current Project: {{ $projectTitle }}
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                
                {{-- Status Indicator --}}
                <div>
                    <p class="text-light/80 text-lg mb-2">Project Status</p>
                    <div class="text-3xl font-bold p-3 rounded-lg text-light bg-dark border border-primary/50">
                        <i class="fas fa-hourglass-half mr-2 text-primary"></i> {{ $projectStatus }}
                    </div>
                </div>

                {{-- Key Dates --}}
                <div class="border-l border-light/20 pl-6">
                    <p class="text-light/80 text-lg mb-2">Submission Details</p>
                    <p class="text-light text-xl"><strong class="text-primary">Submitted:</strong> {{ $submissionDate }}</p>
                    <p class="text-light text-xl mt-1"><strong class="text-primary">Tracking ID:</strong> XG-348-102</p>
                </div>

                {{-- Next Action Callout --}}
                <div class="bg-primary/10 p-4 rounded-lg border border-primary/30">
                    <p class="font-semibold text-primary mb-1">Next Expected Step:</p>
                    <p class="text-light/90 text-sm">{{ $nextAction }}</p>
                </div>
            </div>
            
            <hr class="border-t border-light/10 my-6">

            <div class="flex justify-end space-x-4">
                {{-- Button to view all submitted data --}}
                <a href="/project/348/details" class="{{ $btnSecondaryClass }} border border-light/30">
                    <i class="fas fa-eye mr-2"></i> View Full Submission
                </a>
                
                {{-- Button for future actions like uploading documents --}}
                <button class="{{ $btnPrimaryClass }} !bg-success">
                    <i class="fas fa-upload mr-2"></i> Upload Supporting Documents
                </button>
            </div>
        </div>
        
        {{-- Other Dashboard Sections (Placeholders) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Vetting Updates --}}
            <div class="lg:col-span-2 bg-card/50 p-6 rounded-xl border border-light/20">
                <h3 class="text-2xl font-semibold text-light mb-4"><i class="fas fa-bell mr-2 text-warning"></i> Vetting Timeline & Updates</h3>
                <ul class="space-y-4 text-light/80">
                    <li class="border-l-4 border-primary pl-4">
                        <span class="font-semibold">Today:</span> Project XG-348-102 received and logged.
                    </li>
                    <li class="border-l-4 border-light/30 pl-4 text-light/60">
                        <span class="font-semibold">Next Week:</span> Internal technical assessment scheduled.
                    </li>
                </ul>
            </div>

            {{-- Profile & Settings --}}
            <div class="bg-card/50 p-6 rounded-xl border border-light/20">
                <h3 class="text-2xl font-semibold text-light mb-4"><i class="fas fa-user-cog mr-2 text-primary"></i> Account Management</h3>
                <p class="text-light/80 mb-4">
                    Ensure your contact and institutional details are up to date.
                </p>
                <a href="/profile/edit" class="{{ $btnSecondaryClass }} w-full text-center">
                    Edit Profile Details
                </a>
            </div>
        </div>

    </div>
</div>
@endsection