@php
    // Assuming design variables are available
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
        
        {{-- Progress Bar (75% complete) --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-light mb-2">Step 3 of 4: Budget & Timeline</h3>
            <div class="h-2 bg-dark rounded-full overflow-hidden">
                {{-- Tailwind classes for 75% progress --}}
                <div class="h-full bg-primary" style="width: 75%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-light mb-2">
            Financials and Research Schedule
        </h2>
        <p class="text-lg text-light/70 mb-10">
            Provide a clear, defensible budget and your key measurable milestones.
        </p>

        <form action="/submit-project/step3" method="POST" class="space-y-8">
            @csrf
            
            {{-- Budget Request --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Investment Required</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="requested_amount" class="block text-sm font-medium text-light/80 mb-2">Total Funding Requested (USD) <span class="text-primary">*</span></label>
                        <input type="number" id="requested_amount" name="requested_amount" required min="10000" step="1000" 
                               placeholder="e.g., 500000"
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="duration_months" class="block text-sm font-medium text-light/80 mb-2">Project Duration (Months) <span class="text-primary">*</span></label>
                        <input type="number" id="duration_months" name="duration_months" required min="6" max="60" 
                               placeholder="e.g., 24"
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="budget_breakdown" class="block text-sm font-medium text-light/80 mb-2">
                        Budget Breakdown Summary <span class="text-primary">*</span>
                    </label>
                    <textarea id="budget_breakdown" name="budget_breakdown" required rows="4" 
                              placeholder="Briefly describe how funds will be allocated (e.g., 60% personnel, 30% equipment, 10% travel/publishing)."
                              class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"></textarea>
                </div>
            </div>

            {{-- Milestones --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Key Milestones</h4>
                <p class="text-sm text-light/70 mb-4">Define 3-5 critical, measurable outcomes investors can track.</p>
                
                <div class="space-y-4">
                    @for ($i = 1; $i <= 3; $i++)
                    <div class="flex space-x-4">
                        <label class="text-light/80 pt-2 w-10">M{{ $i }}:</label>
                        <input type="text" name="milestone_{{ $i }}" placeholder="Measurable Milestone Description (e.g., Prototype V1 validated by external lab)" required
                               class="flex-grow p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                        <input type="number" name="milestone_{{ $i }}_month" placeholder="Month" required min="1" max="60"
                               class="w-20 p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    @endfor
                </div>
                <p class="text-xs text-light/50 mt-4">*(Additional milestones can be detailed in supporting documents later.)</p>
            </div>
            
            {{-- Navigation Buttons --}}
            <div class="flex justify-between pt-4">
                {{-- Link back to Step 2 --}}
                <a href="/submit-project/step2" 
                   class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Team Details
                </a>
                
                {{-- Submit to Step 4 (Account Creation) --}}
                <button type="submit" 
                        class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Save & Proceed to Account Setup <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection