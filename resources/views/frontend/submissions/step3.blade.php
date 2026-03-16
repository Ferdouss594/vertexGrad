@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl border border-primary/30
                shadow-[0_0_50px_rgba(30,227,247,0.2)]"
         style="background-color: {{ $cardBg }};">

        {{-- Progress --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-light mb-2">Step 3 of 5: Feasibility & Execution Plan</h3>
            <div class="h-2 bg-dark rounded-full overflow-hidden">
                <div class="h-full bg-primary" style="width: 60%;"></div>
            </div>
        </div>

        {{-- Heading --}}
        <h2 class="text-4xl font-bold text-light mb-2">Project Feasibility and Execution Plan</h2>
        <p class="text-lg text-light/70 mb-10">
            Explain the practical value of your project, its expected impact, required support, and the implementation plan.
        </p>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/40 text-red-200 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('project.submit.step3.post') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Feasibility Information --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Feasibility Overview</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="is_feasible" class="block text-sm font-medium text-light/80 mb-2">
                            Is the project practically feasible? <span class="text-primary">*</span>
                        </label>
                        <select
                            id="is_feasible"
                            name="is_feasible"
                            required
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                            <option value="" disabled {{ old('is_feasible', session('project_data.is_feasible')) ? '' : 'selected' }}>
                                Select option
                            </option>
                            <option value="yes" {{ old('is_feasible', session('project_data.is_feasible')) == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="partially" {{ old('is_feasible', session('project_data.is_feasible')) == 'partially' ? 'selected' : '' }}>Partially</option>
                            <option value="no" {{ old('is_feasible', session('project_data.is_feasible')) == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div>
                        <label for="local_implementation" class="block text-sm font-medium text-light/80 mb-2">
                            Can it be implemented inside Yemen? <span class="text-primary">*</span>
                        </label>
                        <select
                            id="local_implementation"
                            name="local_implementation"
                            required
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                            <option value="" disabled {{ old('local_implementation', session('project_data.local_implementation')) ? '' : 'selected' }}>
                                Select option
                            </option>
                            <option value="yes" {{ old('local_implementation', session('project_data.local_implementation')) == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="partially" {{ old('local_implementation', session('project_data.local_implementation')) == 'partially' ? 'selected' : '' }}>Partially</option>
                            <option value="no" {{ old('local_implementation', session('project_data.local_implementation')) == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="expected_impact" class="block text-sm font-medium text-light/80 mb-2">
                        Expected Impact <span class="text-primary">*</span>
                    </label>
                    <textarea
                        id="expected_impact"
                        name="expected_impact"
                        required
                        rows="4"
                        placeholder="Explain the expected impact of the project on society, institutions, market, education, health, agriculture, or any relevant sector..."
                        class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                    >{{ old('expected_impact', session('project_data.expected_impact')) }}</textarea>
                </div>

                <div class="mt-6">
                    <label for="community_benefit" class="block text-sm font-medium text-light/80 mb-2">
                        Community Benefit <span class="text-primary">*</span>
                    </label>
                    <textarea
                        id="community_benefit"
                        name="community_benefit"
                        required
                        rows="4"
                        placeholder="How does this project benefit the local community or target sector?"
                        class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                    >{{ old('community_benefit', session('project_data.community_benefit')) }}</textarea>
                </div>
            </div>

            {{-- Funding Information --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Funding & Resources</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="needs_funding" class="block text-sm font-medium text-light/80 mb-2">
                            Does the project need funding? <span class="text-primary">*</span>
                        </label>
                        <select
                            id="needs_funding"
                            name="needs_funding"
                            required
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                            <option value="" disabled {{ old('needs_funding', session('project_data.needs_funding')) ? '' : 'selected' }}>
                                Select option
                            </option>
                            <option value="yes" {{ old('needs_funding', session('project_data.needs_funding')) == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('needs_funding', session('project_data.needs_funding')) == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div>
                        <label for="requested_amount" class="block text-sm font-medium text-light/80 mb-2">
                            Estimated Funding Amount (USD) <span class="text-primary">*</span>
                        </label>
                        <input
                            type="number"
                            id="requested_amount"
                            name="requested_amount"
                            required
                            min="0"
                            step="100"
                            value="{{ old('requested_amount', session('project_data.requested_amount')) }}"
                            placeholder="e.g., 5000"
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                    </div>

                    <div>
                        <label for="duration_months" class="block text-sm font-medium text-light/80 mb-2">
                            Estimated Duration (Months) <span class="text-primary">*</span>
                        </label>
                        <input
                            type="number"
                            id="duration_months"
                            name="duration_months"
                            required
                            min="1"
                            max="60"
                            value="{{ old('duration_months', session('project_data.duration_months')) }}"
                            placeholder="e.g., 6"
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                    </div>

                    <div>
                        <label for="support_type" class="block text-sm font-medium text-light/80 mb-2">
                            Type of Support Needed <span class="text-primary">*</span>
                        </label>
                        <select
                            id="support_type"
                            name="support_type"
                            required
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                            <option value="" disabled {{ old('support_type', session('project_data.support_type')) ? '' : 'selected' }}>
                                Select support type
                            </option>
                            <option value="financial" {{ old('support_type', session('project_data.support_type')) == 'financial' ? 'selected' : '' }}>Financial Support</option>
                            <option value="technical" {{ old('support_type', session('project_data.support_type')) == 'technical' ? 'selected' : '' }}>Technical Support</option>
                            <option value="partnership" {{ old('support_type', session('project_data.support_type')) == 'partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="incubation" {{ old('support_type', session('project_data.support_type')) == 'incubation' ? 'selected' : '' }}>Incubation</option>
                            <option value="mixed" {{ old('support_type', session('project_data.support_type')) == 'mixed' ? 'selected' : '' }}>Mixed Support</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="budget_breakdown" class="block text-sm font-medium text-light/80 mb-2">
                        Budget Breakdown / Resource Plan <span class="text-primary">*</span>
                    </label>
                    <textarea
                        id="budget_breakdown"
                        name="budget_breakdown"
                        required
                        rows="4"
                        placeholder="Explain how the budget or resources will be used..."
                        class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                    >{{ old('budget_breakdown', session('project_data.budget_breakdown')) }}</textarea>
                </div>
            </div>

            {{-- Milestones --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Execution Milestones</h4>
                <p class="text-sm text-light/70 mb-4">
                    Define the key phases of implementation in a clear and measurable way.
                </p>

                <div class="space-y-4">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="md:col-span-4">
                                <label for="milestone_{{ $i }}" class="block text-sm font-medium text-light/80 mb-2">
                                    Milestone {{ $i }} <span class="text-primary">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="milestone_{{ $i }}"
                                    name="milestone_{{ $i }}"
                                    required
                                    value="{{ old('milestone_'.$i, session('project_data.milestone_'.$i)) }}"
                                    placeholder="e.g., Build prototype / Complete testing / Deploy first version"
                                    class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                                >
                            </div>

                            <div class="md:col-span-1">
                                <label for="milestone_{{ $i }}_month" class="block text-sm font-medium text-light/80 mb-2">
                                    Month <span class="text-primary">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="milestone_{{ $i }}_month"
                                    name="milestone_{{ $i }}_month"
                                    required
                                    min="1"
                                    max="60"
                                    value="{{ old('milestone_'.$i.'_month', session('project_data.milestone_'.$i.'_month')) }}"
                                    class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                                >
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-between pt-4">
                <a
                    href="{{ route('project.submit.step2') }}"
                    class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary"
                >
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button
                    type="submit"
                    class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm"
                >
                    Save & Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
