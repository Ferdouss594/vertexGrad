@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl theme-panel shadow-brand-soft">

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-theme-text mb-2">{{ __('frontend.submit_step1.step_title') }}</h3>
            <div class="h-2 bg-theme-surface-2 rounded-full overflow-hidden">
                <div class="h-full bg-brand-accent" style="width: 20%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-theme-text mb-2">{{ __('frontend.submit_step1.page_title') }}</h2>
        <p class="text-lg text-theme-muted mb-10">
            {{ __('frontend.submit_step1.page_subtitle') }}
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
                    {{ __('frontend.submit_step1.project_title') }} <span class="text-brand-accent">*</span>
                </label>
                <input
                    type="text"
                    id="project_title"
                    name="project_title"
                    required
                    value="{{ old('project_title', session('project_data.project_title')) }}"
                    placeholder="{{ __('frontend.submit_step1.project_title_placeholder') }}"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label for="abstract" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.submit_step1.project_summary') }} <span class="text-brand-accent">*</span>
                </label>
                <textarea
                    id="abstract"
                    name="abstract"
                    required
                    rows="6"
                    placeholder="{{ __('frontend.submit_step1.project_summary_placeholder') }}"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >{{ old('abstract', session('project_data.abstract')) }}</textarea>
            </div>

            <div>
                <label for="discipline" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.submit_step1.primary_discipline') }} <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="discipline"
                    name="discipline"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled {{ old('discipline', session('project_data.discipline')) ? '' : 'selected' }}>
                        {{ __('frontend.submit_step1.select_discipline') }}
                    </option>
                    <option value="it" {{ old('discipline', session('project_data.discipline')) == 'it' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_it') }}</option>
                    <option value="software" {{ old('discipline', session('project_data.discipline')) == 'software' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_software') }}</option>
                    <option value="ai_ml" {{ old('discipline', session('project_data.discipline')) == 'ai_ml' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_ai_ml') }}</option>
                    <option value="medical" {{ old('discipline', session('project_data.discipline')) == 'medical' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_medical') }}</option>
                    <option value="electrical" {{ old('discipline', session('project_data.discipline')) == 'electrical' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_electrical') }}</option>
                    <option value="energy" {{ old('discipline', session('project_data.discipline')) == 'energy' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_energy') }}</option>
                    <option value="agriculture" {{ old('discipline', session('project_data.discipline')) == 'agriculture' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_agriculture') }}</option>
                    <option value="education" {{ old('discipline', session('project_data.discipline')) == 'education' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_education') }}</option>
                    <option value="business" {{ old('discipline', session('project_data.discipline')) == 'business' ? 'selected' : '' }}>{{ __('frontend.submit_step1.discipline_business') }}</option>
                    <option value="other" {{ old('discipline', session('project_data.discipline')) == 'other' ? 'selected' : '' }}>{{ __('frontend.common.other') }}</option>
                </select>
            </div>

            <div>
                <label for="project_type" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.submit_step1.project_type') }} <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="project_type"
                    name="project_type"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled {{ old('project_type', session('project_data.project_type')) ? '' : 'selected' }}>
                        {{ __('frontend.submit_step1.select_project_type') }}
                    </option>
                    <option value="graduation_project" {{ old('project_type', session('project_data.project_type')) == 'graduation_project' ? 'selected' : '' }}>{{ __('frontend.submit_step1.type_graduation_project') }}</option>
                    <option value="research" {{ old('project_type', session('project_data.project_type')) == 'research' ? 'selected' : '' }}>{{ __('frontend.submit_step1.type_research') }}</option>
                    <option value="innovation" {{ old('project_type', session('project_data.project_type')) == 'innovation' ? 'selected' : '' }}>{{ __('frontend.submit_step1.type_innovation') }}</option>
                    <option value="application" {{ old('project_type', session('project_data.project_type')) == 'application' ? 'selected' : '' }}>{{ __('frontend.submit_step1.type_application') }}</option>
                    <option value="platform" {{ old('project_type', session('project_data.project_type')) == 'platform' ? 'selected' : '' }}>{{ __('frontend.submit_step1.type_platform') }}</option>
                    <option value="system" {{ old('project_type', session('project_data.project_type')) == 'system' ? 'selected' : '' }}>{{ __('frontend.submit_step1.type_system') }}</option>
                    <option value="prototype" {{ old('project_type', session('project_data.project_type')) == 'prototype' ? 'selected' : '' }}>{{ __('frontend.submit_step1.type_prototype') }}</option>
                    <option value="other" {{ old('project_type', session('project_data.project_type')) == 'other' ? 'selected' : '' }}>{{ __('frontend.common.other') }}</option>
                </select>
            </div>

            <div>
                <label for="problem_statement" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.submit_step1.problem_statement') }} <span class="text-brand-accent">*</span>
                </label>
                <textarea
                    id="problem_statement"
                    name="problem_statement"
                    required
                    rows="4"
                    placeholder="{{ __('frontend.submit_step1.problem_statement_placeholder') }}"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >{{ old('problem_statement', session('project_data.problem_statement')) }}</textarea>
            </div>

            <div>
                <label for="target_beneficiaries" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.submit_step1.target_beneficiaries') }} <span class="text-brand-accent">*</span>
                </label>
                <input
                    type="text"
                    id="target_beneficiaries"
                    name="target_beneficiaries"
                    required
                    value="{{ old('target_beneficiaries', session('project_data.target_beneficiaries')) }}"
                    placeholder="{{ __('frontend.submit_step1.target_beneficiaries_placeholder') }}"
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                >
            </div>

            <div>
                <label for="project_nature" class="block text-sm font-medium text-theme-muted mb-2">
                    {{ __('frontend.submit_step1.project_nature') }} <span class="text-brand-accent">*</span>
                </label>
                <select
                    id="project_nature"
                    name="project_nature"
                    required
                    class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                >
                    <option value="" disabled {{ old('project_nature', session('project_data.project_nature')) ? '' : 'selected' }}>
                        {{ __('frontend.submit_step1.select_project_nature') }}
                    </option>
                    <option value="theoretical" {{ old('project_nature', session('project_data.project_nature')) == 'theoretical' ? 'selected' : '' }}>{{ __('frontend.submit_step1.nature_theoretical') }}</option>
                    <option value="practical" {{ old('project_nature', session('project_data.project_nature')) == 'practical' ? 'selected' : '' }}>{{ __('frontend.submit_step1.nature_practical') }}</option>
                    <option value="research_practical" {{ old('project_nature', session('project_data.project_nature')) == 'research_practical' ? 'selected' : '' }}>{{ __('frontend.submit_step1.nature_research_practical') }}</option>
                </select>
            </div>

            <div class="flex justify-end pt-4">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                >
                    {{ __('frontend.common.save_continue') }} <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection