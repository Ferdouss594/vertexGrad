@php
    $projectData = session()->get('project_data', []);
    $userData = session()->get('user_data', []);
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-5xl mx-auto p-10 rounded-2xl theme-panel shadow-brand-soft">

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-theme-text mb-2">Step 5 of 5: Review & Start Technical Scan</h3>
            <div class="h-2 bg-theme-surface-2 rounded-full overflow-hidden">
                <div class="h-full bg-brand-accent" style="width: 100%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-theme-text mb-2">Review Your Submission</h2>
        <p class="text-lg text-theme-muted mb-10">
            Please review your project information carefully before starting the technical scan.
        </p>

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl border border-red-500/40 bg-red-500/10 text-red-600">
                <strong class="block font-bold mb-1">Error</strong>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl border border-green-500/40 bg-green-500/10 text-green-600">
                <strong class="block font-bold mb-1">Success</strong>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl border border-yellow-500/40 bg-yellow-500/10 text-yellow-700">
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
                <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-2xl font-semibold text-brand-accent">1. Project Information</h4>
                        <a href="{{ route('project.submit.step1') }}" class="text-brand-accent text-sm hover:underline">Edit</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-theme-text">
                        <p><strong>Project Title:</strong> {{ $projectData['project_title'] ?? 'N/A' }}</p>
                        <p><strong>Discipline:</strong> {{ $projectData['discipline'] ?? 'N/A' }}</p>
                        <p><strong>Project Type:</strong> {{ $projectData['project_type'] ?? 'N/A' }}</p>
                        <p><strong>Project Nature:</strong> {{ $projectData['project_nature'] ?? 'N/A' }}</p>
                    </div>

                    <div class="mt-4 space-y-3 text-theme-text">
                        <p><strong>Summary:</strong> {{ $projectData['abstract'] ?? 'N/A' }}</p>
                        <p><strong>Problem Statement:</strong> {{ $projectData['problem_statement'] ?? 'N/A' }}</p>
                        <p><strong>Target Beneficiaries:</strong> {{ $projectData['target_beneficiaries'] ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-2xl font-semibold text-brand-accent">2. Academic Information</h4>
                        <a href="{{ route('project.submit.step2') }}" class="text-brand-accent text-sm hover:underline">Edit</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-theme-text">
                        <p><strong>Student Name:</strong> {{ $projectData['student_name'] ?? 'N/A' }}</p>
                        <p><strong>Academic Level:</strong> {{ $projectData['academic_level'] ?? 'N/A' }}</p>
                        <p><strong>Supervisor Name:</strong> {{ $projectData['supervisor_name'] ?? 'N/A' }}</p>
                        <p><strong>Supervisor Title:</strong> {{ $projectData['supervisor_title'] ?? 'N/A' }}</p>
                        <p><strong>University:</strong> {{ $projectData['university_name'] ?? 'N/A' }}</p>
                        <p><strong>College:</strong> {{ $projectData['college_name'] ?? 'N/A' }}</p>
                        <p><strong>Department:</strong> {{ $projectData['department'] ?? 'N/A' }}</p>
                        <p><strong>Governorate:</strong> {{ $projectData['governorate'] ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-2xl font-semibold text-brand-accent">3. Feasibility & Execution Plan</h4>
                        <a href="{{ route('project.submit.step3') }}" class="text-brand-accent text-sm hover:underline">Edit</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-theme-text">
                        <p><strong>Project Feasibility:</strong> {{ $projectData['is_feasible'] ?? 'N/A' }}</p>
                        <p><strong>Implementable in Yemen:</strong> {{ $projectData['local_implementation'] ?? 'N/A' }}</p>
                        <p><strong>Needs Funding:</strong> {{ $projectData['needs_funding'] ?? 'N/A' }}</p>
                        <p><strong>Support Type:</strong> {{ $projectData['support_type'] ?? 'N/A' }}</p>
                        <p><strong>Estimated Funding:</strong> ${{ number_format((float) ($projectData['requested_amount'] ?? 0)) }}</p>
                        <p><strong>Estimated Duration:</strong> {{ $projectData['duration_months'] ?? '0' }} months</p>
                    </div>

                    <div class="mt-4 space-y-3 text-theme-text">
                        <p><strong>Expected Impact:</strong> {{ $projectData['expected_impact'] ?? 'N/A' }}</p>
                        <p><strong>Community Benefit:</strong> {{ $projectData['community_benefit'] ?? 'N/A' }}</p>
                        <p><strong>Budget / Resource Plan:</strong> {{ $projectData['budget_breakdown'] ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-2xl font-semibold text-brand-accent">4. Account & Confirmation</h4>
                        <a href="{{ route('project.submit.step4') }}" class="text-brand-accent text-sm hover:underline">Edit</a>
                    </div>

                    <div class="space-y-3 text-theme-text">
                        <p><strong>Account Email:</strong> {{ $userData['email'] ?? auth()->user()->email ?? 'N/A' }}</p>
                        <p><strong>Data Confirmation:</strong> {{ !empty($userData['data_confirmation']) ? 'Confirmed' : 'Confirmed during previous step' }}</p>
                        <p><strong>Terms Agreement:</strong> {{ !empty($userData['terms_agreement']) ? 'Accepted' : 'Accepted during previous step' }}</p>
                    </div>
                </div>

                <div class="p-5 rounded-xl border border-brand-accent/30 bg-brand-accent-soft text-theme-text">
                    <h5 class="text-lg font-semibold text-brand-accent mb-2">Important Note</h5>
                    <p class="leading-7">
                        By clicking <strong>Start Technical Scan</strong>, your project will be saved in the main platform and a technical scan request will be created in the scanner platform.
                    </p>
                </div>
            </div>

            <hr class="border-t border-theme-border my-8">

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('project.submit.step4') }}"
                   class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-bold bg-green-600 text-white hover:bg-green-700 transition duration-300 shadow-brand-soft">
                    <i class="fas fa-shield-alt mr-2"></i> Start Technical Scan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection