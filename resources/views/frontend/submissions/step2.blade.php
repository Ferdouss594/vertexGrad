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
        
        {{-- Progress Bar (50% complete) --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-light mb-2">Step 2 of 4: Team & Institution</h3>
            <div class="h-2 bg-dark rounded-full overflow-hidden">
                <div class="h-full bg-primary" style="width: 50%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-light mb-2">
            Academic Lead & Institutional Details
        </h2>
        <p class="text-lg text-light/70 mb-10">
            Who is the principal investigator and where is the research based?
        </p>

        <form action="/submit-project/step2" method="POST" class="space-y-8">
            @csrf
            
            {{-- Academic Lead Details --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Principal Investigator</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="lead_name" class="block text-sm font-medium text-light/80 mb-2">Full Name <span class="text-primary">*</span></label>
                        <input type="text" id="lead_name" name="lead_name" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="lead_title" class="block text-sm font-medium text-light/80 mb-2">Academic Title/Position <span class="text-primary">*</span></label>
                        <input type="text" id="lead_title" name="lead_title" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            {{-- Institutional Details --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Institution</h4>
                <div class="space-y-6">
                    <div>
                        <label for="institution_name" class="block text-sm font-medium text-light/80 mb-2">University / Research Body <span class="text-primary">*</span></label>
                        <input type="text" id="institution_name" name="institution_name" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="department" class="block text-sm font-medium text-light/80 mb-2">Department / Lab</label>
                        <input type="text" id="department" name="department" 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>
            
            {{-- Navigation Buttons --}}
            <div class="flex justify-between pt-4">
                {{-- Link back to Step 1 --}}
                <a href="/submit-project" 
                   class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                
                {{-- Submit to Step 3 --}}
                <button type="submit" 
                        class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Save & Continue to Budget <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection