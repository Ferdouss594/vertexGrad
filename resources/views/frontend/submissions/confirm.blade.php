@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';
    
    // Placeholder data (In production, this would come from the Session/Database)
    $projectData = [
        'title' => 'Dynamic Quantum Encryption Protocol for Satellite Networks',
        'discipline' => 'Quantum Computing & Physics',
        'lead_name' => 'Dr. Elara Vance',
        'institution_name' => 'MIT Kavli Institute',
        'requested_amount' => '$750,000',
        'duration_months' => 36,
    ];
@endphp

@extends('layouts.app')

@section('content')
<div class="min-h-screen py-16" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl border border-primary/30 
                shadow-[0_0_50px_rgba(30,227,247,0.2)]" 
         style="background-color: {{ $cardBg }};">
        
        <h2 class="text-4xl font-bold text-light mb-2">
            Final Review and Submission
        </h2>
        <p class="text-lg text-light/70 mb-10">
            Please review all details before officially submitting your project for the vetting process.
        </p>

        <form action="/submit-project/final" method="POST" class="space-y-8">
            @csrf
            
            {{-- Review Section --}}
            <div class="space-y-6">
                
                {{-- 1. Project Overview --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <h4 class="text-2xl font-semibold text-primary mb-4">1. Project Overview (Step 1)</h4>
                    <div class="space-y-3">
                        <p class="text-light/80"><strong class="text-light">Title:</strong> {{ $projectData['title'] }} <a href="/submit-project" class="text-primary/70 text-sm ml-2 hover:underline">[Edit]</a></p>
                        <p class="text-light/80"><strong class="text-light">Discipline:</strong> {{ $projectData['discipline'] }}</p>
                        <p class="text-light/80"><strong class="text-light">Abstract:</strong> [Dynamically loaded abstract text...]</p>
                    </div>
                </div>

                {{-- 2. Team & Institution --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <h4 class="text-2xl font-semibold text-primary mb-4">2. Academic Lead & Institution (Step 2)</h4>
                    <div class="space-y-3">
                        <p class="text-light/80"><strong class="text-light">Lead PI:</strong> {{ $projectData['lead_name'] }} <a href="/submit-project/step2" class="text-primary/70 text-sm ml-2 hover:underline">[Edit]</a></p>
                        <p class="text-light/80"><strong class="text-light">Institution:</strong> {{ $projectData['institution_name'] }}</p>
                        <p class="text-light/80"><strong class="text-light">Department:</strong> [Dynamically loaded Department]</p>
                    </div>
                </div>

                {{-- 3. Budget & Timeline --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <h4 class="text-2xl font-semibold text-primary mb-4">3. Financials (Step 3)</h4>
                    <div class="space-y-3">
                        <p class="text-light/80"><strong class="text-light">Funding Requested:</strong> <span class="text-success font-bold">{{ $projectData['requested_amount'] }}</span> <a href="/submit-project/step3" class="text-primary/70 text-sm ml-2 hover:underline">[Edit]</a></p>
                        <p class="text-light/80"><strong class="text-light">Duration:</strong> {{ $projectData['duration_months'] }} Months</p>
                        <p class="text-light/80"><strong class="text-light">Key Milestones:</strong> [Dynamically loaded Milestone summary...]</p>
                    </div>
                </div>

                {{-- 4. Account Confirmation --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <h4 class="text-2xl font-semibold text-primary mb-4">4. Account Details (Step 4)</h4>
                    <p class="text-light/80"><strong class="text-light">Account Email:</strong> [Dynamically loaded Email Address] <a href="/submit-project/step4" class="text-primary/70 text-sm ml-2 hover:underline">[Edit]</a></p>
                    <p class="text-light/50 text-sm mt-2">Note: Your password is secure and not shown here.</p>
                </div>

            </div>
            
            <hr class="border-t border-primary/20 my-8">

            {{-- Final Call to Action --}}
            <div class="flex justify-between items-center pt-4">
                {{-- Link back to Step 4 (Account) --}}
                <a href="/submit-project/step4" 
                   class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary">
                    <i class="fas fa-arrow-left mr-2"></i> Make Changes
                </a>
                
                {{-- Final Submission Button --}}
                <button type="submit" 
                        class="{{ $btnPrimaryClass }} !bg-success text-dark text-lg py-3 px-8 font-bold shadow-neon_sm">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Project for Vetting
                </button>
            </div>
            <p class="text-center text-light/60 text-xs mt-6">
                Upon submission, your project status will be set to 'Pending Review' and you will be directed to your dashboard.
            </p>
        </form>
    </div>
</div>
@endsection