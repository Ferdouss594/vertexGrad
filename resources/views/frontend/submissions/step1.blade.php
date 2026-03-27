@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl theme-panel shadow-brand-soft">

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-theme-text mb-2">Step 1 of 5: Project Information</h3>
            <div class="h-2 bg-theme-surface-2 rounded-full overflow-hidden">
                <div class="h-full bg-brand-accent" style="width: 20%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-theme-text mb-2">Project Basic Information</h2>
        <p class="text-lg text-theme-muted mb-10">
            Enter the basic details that define your project and explain its main idea clearly.
        </p>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-600 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('project.submit.step1.post') }}" method="POST" class="space-y-8">
            @csrf

            <div>
                <label for="project_title" class="block text-sm font-medium text-theme-muted mb-2">
                    Project Title <span class="text-brand-accent">*</span>
                </label>
                <input
                    type="text"
                    id="project_title"
                    name="project_title"
                    required
                    value="{{ old('project_title', session('project_data.project_title')) }}"
                    placeholder="e.g., Smart Irrigation System for Water Saving"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label for="abstract" class="block text-sm font-medium text-theme-muted mb-2">
                    Project Summary <span class="text-brand-accent">*</span>
                </label>
                <textarea
                    id="abstract"
                    name="abstract"
                    required
                    rows="6"
                    placeholder="Write a clear summary of the project idea, its purpose, and what it aims to achieve..."
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >{{ old('abstract', session('project_data.abstract')) }}</textarea>
            </div>

            <div>
                <label for="discipline" class="block text-sm font-medium text-theme-muted mb-2">
                    Primary Discipline <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="discipline"
                    name="discipline"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled {{ old('discipline', session('project_data.discipline')) ? '' : 'selected' }}>
                        Select the project discipline
                    </option>
                    <option value="it" {{ old('discipline', session('project_data.discipline')) == 'it' ? 'selected' : '' }}>Information Technology</option>
                    <option value="software" {{ old('discipline', session('project_data.discipline')) == 'software' ? 'selected' : '' }}>Software Engineering</option>
                    <option value="ai_ml" {{ old('discipline', session('project_data.discipline')) == 'ai_ml' ? 'selected' : '' }}>Artificial Intelligence & Machine Learning</option>
                    <option value="medical" {{ old('discipline', session('project_data.discipline')) == 'medical' ? 'selected' : '' }}>Medical / Health</option>
                    <option value="electrical" {{ old('discipline', session('project_data.discipline')) == 'electrical' ? 'selected' : '' }}>Electrical Engineering</option>
                    <option value="energy" {{ old('discipline', session('project_data.discipline')) == 'energy' ? 'selected' : '' }}>Renewable Energy</option>
                    <option value="agriculture" {{ old('discipline', session('project_data.discipline')) == 'agriculture' ? 'selected' : '' }}>Agriculture</option>
                    <option value="education" {{ old('discipline', session('project_data.discipline')) == 'education' ? 'selected' : '' }}>Education</option>
                    <option value="business" {{ old('discipline', session('project_data.discipline')) == 'business' ? 'selected' : '' }}>Business / Management</option>
                    <option value="other" {{ old('discipline', session('project_data.discipline')) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label for="project_type" class="block text-sm font-medium text-theme-muted mb-2">
                    Project Type <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="project_type"
                    name="project_type"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled {{ old('project_type', session('project_data.project_type')) ? '' : 'selected' }}>
                        Select project type
                    </option>
                    <option value="graduation_project" {{ old('project_type', session('project_data.project_type')) == 'graduation_project' ? 'selected' : '' }}>Graduation Project</option>
                    <option value="research" {{ old('project_type', session('project_data.project_type')) == 'research' ? 'selected' : '' }}>Research</option>
                    <option value="innovation" {{ old('project_type', session('project_data.project_type')) == 'innovation' ? 'selected' : '' }}>Innovation</option>
                    <option value="application" {{ old('project_type', session('project_data.project_type')) == 'application' ? 'selected' : '' }}>Application</option>
                    <option value="platform" {{ old('project_type', session('project_data.project_type')) == 'platform' ? 'selected' : '' }}>Platform</option>
                    <option value="system" {{ old('project_type', session('project_data.project_type')) == 'system' ? 'selected' : '' }}>System</option>
                    <option value="prototype" {{ old('project_type', session('project_data.project_type')) == 'prototype' ? 'selected' : '' }}>Prototype</option>
                    <option value="other" {{ old('project_type', session('project_data.project_type')) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label for="problem_statement" class="block text-sm font-medium text-theme-muted mb-2">
                    Problem Statement <span class="text-brand-accent">*</span>
                </label>
                <textarea
                    id="problem_statement"
                    name="problem_statement"
                    required
                    rows="4"
                    placeholder="What problem does the project solve?"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >{{ old('problem_statement', session('project_data.problem_statement')) }}</textarea>
            </div>

            <div>
                <label for="target_beneficiaries" class="block text-sm font-medium text-theme-muted mb-2">
                    Target Beneficiaries <span class="text-brand-accent">*</span>
                </label>
                <input
                    type="text"
                    id="target_beneficiaries"
                    name="target_beneficiaries"
                    required
                    value="{{ old('target_beneficiaries', session('project_data.target_beneficiaries')) }}"
                    placeholder="e.g., Students, hospitals, farmers, universities, companies"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label for="project_nature" class="block text-sm font-medium text-theme-muted mb-2">
                    Project Nature <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="project_nature"
                    name="project_nature"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled {{ old('project_nature', session('project_data.project_nature')) ? '' : 'selected' }}>
                        Select project nature
                    </option>
                    <option value="theoretical" {{ old('project_nature', session('project_data.project_nature')) == 'theoretical' ? 'selected' : '' }}>Theoretical</option>
                    <option value="practical" {{ old('project_nature', session('project_data.project_nature')) == 'practical' ? 'selected' : '' }}>Practical</option>
                    <option value="research_practical" {{ old('project_nature', session('project_data.project_nature')) == 'research_practical' ? 'selected' : '' }}>Research + Practical</option>
                </select>
            </div>

            <div class="flex justify-end pt-4">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                >
                    Save & Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection