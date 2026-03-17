@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';

    $projectData = session()->get('project_data', []);
    $userData = session()->get('user_data', []);
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-5xl mx-auto p-10 rounded-2xl border border-primary/30
                shadow-[0_0_50px_rgba(30,227,247,0.2)]"
         style="background-color: {{ $cardBg }};">

        {{-- Progress --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-light mb-2">Step 5 of 5: Review & Start Technical Scan</h3>
            <div class="h-2 bg-dark rounded-full overflow-hidden">
                <div class="h-full bg-primary" style="width: 100%;"></div>
            </div>
        </div>

        {{-- Heading --}}
        <h2 class="text-4xl font-bold text-light mb-2">Review Your Submission</h2>
        <p class="text-lg text-light/70 mb-10">
            Please review your project information carefully before starting the technical scan. After the scan is completed, you will return later to complete media files and final presentation materials.
        </p>

        {{-- Flash Messages --}}
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
                {{-- Step 1 --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-2xl font-semibold text-primary">1. Project Information</h4>
                        <a href="{{ route('project.submit.step1') }}" class="text-primary/80 text-sm hover:underline">Edit</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-light/80">
                        <p><strong class="text-light">Project Title:</strong> {{ $projectData['project_title'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Discipline:</strong> {{ $projectData['discipline'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Project Type:</strong> {{ $projectData['project_type'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Project Nature:</strong> {{ $projectData['project_nature'] ?? 'N/A' }}</p>
                    </div>

                    <div class="mt-4 space-y-3 text-light/80">
                        <p><strong class="text-light">Summary:</strong> {{ $projectData['abstract'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Problem Statement:</strong> {{ $projectData['problem_statement'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Target Beneficiaries:</strong> {{ $projectData['target_beneficiaries'] ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-2xl font-semibold text-primary">2. Academic Information</h4>
                        <a href="{{ route('project.submit.step2') }}" class="text-primary/80 text-sm hover:underline">Edit</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-light/80">
                        <p><strong class="text-light">Student Name:</strong> {{ $projectData['student_name'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Academic Level:</strong> {{ $projectData['academic_level'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Supervisor Name:</strong> {{ $projectData['supervisor_name'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Supervisor Title:</strong> {{ $projectData['supervisor_title'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">University:</strong> {{ $projectData['university_name'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">College:</strong> {{ $projectData['college_name'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Department:</strong> {{ $projectData['department'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Governorate:</strong> {{ $projectData['governorate'] ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-2xl font-semibold text-primary">3. Feasibility & Execution Plan</h4>
                        <a href="{{ route('project.submit.step3') }}" class="text-primary/80 text-sm hover:underline">Edit</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-light/80">
                        <p><strong class="text-light">Project Feasibility:</strong> {{ $projectData['is_feasible'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Implementable in Yemen:</strong> {{ $projectData['local_implementation'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Needs Funding:</strong> {{ $projectData['needs_funding'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Support Type:</strong> {{ $projectData['support_type'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Estimated Funding:</strong> ${{ number_format((float) ($projectData['requested_amount'] ?? 0)) }}</p>
                        <p><strong class="text-light">Estimated Duration:</strong> {{ $projectData['duration_months'] ?? '0' }} months</p>
                    </div>

                    <div class="mt-4 space-y-3 text-light/80">
                        <p><strong class="text-light">Expected Impact:</strong> {{ $projectData['expected_impact'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Community Benefit:</strong> {{ $projectData['community_benefit'] ?? 'N/A' }}</p>
                        <p><strong class="text-light">Budget / Resource Plan:</strong> {{ $projectData['budget_breakdown'] ?? 'N/A' }}</p>
                    </div>

                    <div class="mt-4 text-light/80 space-y-2">
                        <p><strong class="text-light">Milestone 1:</strong> {{ $projectData['milestone_1'] ?? 'N/A' }} @if(!empty($projectData['milestone_1_month'])) (Month {{ $projectData['milestone_1_month'] }}) @endif</p>
                        <p><strong class="text-light">Milestone 2:</strong> {{ $projectData['milestone_2'] ?? 'N/A' }} @if(!empty($projectData['milestone_2_month'])) (Month {{ $projectData['milestone_2_month'] }}) @endif</p>
                        <p><strong class="text-light">Milestone 3:</strong> {{ $projectData['milestone_3'] ?? 'N/A' }} @if(!empty($projectData['milestone_3_month'])) (Month {{ $projectData['milestone_3_month'] }}) @endif</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-2xl font-semibold text-primary">4. Account & Confirmation</h4>
                        <a href="{{ route('project.submit.step4') }}" class="text-primary/80 text-sm hover:underline">Edit</a>
                    </div>

                    <div class="space-y-3 text-light/80">
                        <p><strong class="text-light">Account Email:</strong> {{ $userData['email'] ?? auth()->user()->email ?? 'N/A' }}</p>
                        <p><strong class="text-light">Data Confirmation:</strong> {{ !empty($userData['data_confirmation']) ? 'Confirmed' : 'Confirmed during previous step' }}</p>
                        <p><strong class="text-light">Terms Agreement:</strong> {{ !empty($userData['terms_agreement']) ? 'Accepted' : 'Accepted during previous step' }}</p>
                    </div>
                </div>

                {{-- Important Note --}}
                <div class="p-5 rounded-xl border border-primary/30 bg-primary/5 text-light/80">
                    <h5 class="text-lg font-semibold text-primary mb-2">Important Note</h5>
                    <p class="leading-7">
                        By clicking <strong class="text-light">Start Technical Scan</strong>, your project will be saved in the main platform and a technical scan request will be created in the scanner platform. After the scan is completed, you will return to complete media files, PDF, and presentation materials before administrative review.
                    </p>
                </div>
            </div>

            <hr class="border-t border-primary/20 my-8">

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('project.submit.step4') }}"
                   class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button type="submit"
                        class="{{ $btnPrimaryClass }} !bg-success text-dark text-lg py-3 px-8 font-bold shadow-neon_sm">
                    <i class="fas fa-shield-alt mr-2"></i> Start Technical Scan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
