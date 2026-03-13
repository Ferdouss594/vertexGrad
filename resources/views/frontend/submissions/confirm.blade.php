@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';
    
    // FETCH REAL DATA FROM SESSION
    $projectData = session()->get('project_data', []);
    $userData = session()->get('user_data', []);
@endphp

@extends('frontend.layouts.app')

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

        {{-- ✅ FLASH + ERRORS (TEMP DEBUG + KEEP IT) --}}
        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl border border-red-500/40 bg-red-500/10 text-red-200">
                <strong class="block font-bold mb-1">Error</strong>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl border border-green-500/40 bg-green-500/10 text-green-200">
                <strong class="block font-bold mb-1">Success</strong>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl border border-yellow-500/40 bg-yellow-500/10 text-yellow-200">
                <strong class="block font-bold mb-1">Validation</strong>
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('project.submit.final') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                {{-- 1. Project Overview --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <h4 class="text-2xl font-semibold text-primary mb-4">1. Project Overview (Step 1)</h4>
                    <div class="space-y-3">
                        <p class="text-light/80"><strong class="text-light">Title:</strong> {{ $projectData['project_title'] ?? 'N/A' }} <a href="{{ route('project.submit.step1') }}" class="text-primary/70 text-sm ml-2 hover:underline">[Edit]</a></p>
                        <p class="text-light/80"><strong class="text-light">Discipline:</strong> {{ $projectData['discipline'] ?? 'N/A' }}</p>
                        <p class="text-light/80"><strong class="text-light">Abstract:</strong> {{ Str::limit($projectData['abstract'] ?? 'N/A', 150) }}</p>
                    </div>
                </div>

                {{-- 2. Team & Institution --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <h4 class="text-2xl font-semibold text-primary mb-4">2. Academic Lead & Institution (Step 2)</h4>
                    <div class="space-y-3">
                        <p class="text-light/80"><strong class="text-light">Lead PI:</strong> {{ $projectData['lead_name'] ?? 'N/A' }} <a href="{{ route('project.submit.step2') }}" class="text-primary/70 text-sm ml-2 hover:underline">[Edit]</a></p>
                        <p class="text-light/80"><strong class="text-light">Institution:</strong> {{ $projectData['institution_name'] ?? 'N/A' }}</p>
                        <p class="text-light/80"><strong class="text-light">Department:</strong> {{ $projectData['department'] ?? 'General' }}</p>
                    </div>
                </div>

                {{-- 3. Budget & Timeline --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <h4 class="text-2xl font-semibold text-primary mb-4">3. Financials (Step 3)</h4>
                    <div class="space-y-3">
                        <p class="text-light/80"><strong class="text-light">Funding Requested:</strong> <span class="text-success font-bold">${{ number_format($projectData['requested_amount'] ?? 0) }}</span> <a href="{{ route('project.submit.step3') }}" class="text-primary/70 text-sm ml-2 hover:underline">[Edit]</a></p>
                        <p class="text-light/80"><strong class="text-light">Duration:</strong> {{ $projectData['duration_months'] ?? '0' }} Months</p>
                    </div>
                </div>

                {{-- 4. Account Confirmation --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <h4 class="text-2xl font-semibold text-primary mb-4">4. Account Details (Step 4)</h4>
                    <p class="text-light/80"><strong class="text-light">Account Email:</strong> {{ $userData['email'] ?? auth()->user()->email ?? 'N/A' }} <a href="{{ route('project.submit.step4') }}" class="text-primary/70 text-sm ml-2 hover:underline">[Edit]</a></p>
                </div>
            </div>

            <hr class="border-t border-primary/20 my-8">

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('project.submit.step4') }}" class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary">
                    <i class="fas fa-arrow-left mr-2"></i> Make Changes
                </a>
                
                <button type="submit" class="{{ $btnPrimaryClass }} !bg-success text-dark text-lg py-3 px-8 font-bold shadow-neon_sm">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Project for Vetting
                </button>
            </div>
        </form>
    </div>
</div>
@endsection