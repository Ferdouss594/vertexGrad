@php
    // Assuming these variables are available from a config or base layout
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary']; // Added for the new button
    $cardBg = '#1E293B';
@endphp

@extends('layouts.app')

@section('content')
<div class="min-h-screen py-16" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl border border-primary/30 
                shadow-[0_0_50px_rgba(30,227,247,0.2)]" 
           style="background-color: {{ $cardBg }};">
        
        {{-- Progress Bar (Optional, but highly recommended) --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-light mb-2">Step 1 of 4: Project Overview</h3>
            <div class="h-2 bg-dark rounded-full overflow-hidden">
                <div class="h-full bg-primary" style="width: 25%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-light mb-2">
            Submit Your Innovation
        </h2>
        <p class="text-lg text-light/70 mb-10">
            Tell us about the core idea.
        </p>

        {{-- NOTE: We use the same form action, but rely on the backend to redirect --}}
        <form action="/submit-project/step1" method="POST" class="space-y-6">
            @csrf
            
            {{-- Project Title, Abstract, Discipline Fields (Same as before) --}}
            {{-- ... All fields here ... --}}
            
            <div>
                <label for="project_title" class="block text-sm font-medium text-light/80 mb-2">
                    Project Title <span class="text-primary">*</span>
                </label>
                <input type="text" id="project_title" name="project_title" required 
                        placeholder="e.g., Quantum Machine Learning for Drug Discovery"
                        class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
                <p class="text-xs text-light/50 mt-1">Make it clear and impactful (Max 100 characters).</p>
            </div>

            <div>
                <label for="abstract" class="block text-sm font-medium text-light/80 mb-2">
                    Abstract / Summary <span class="text-primary">*</span>
                </label>
                <textarea id="abstract" name="abstract" required rows="6" 
                              placeholder="Provide a concise summary of the problem, the proposed solution, and the anticipated impact."
                              class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary"></textarea>
                <p class="text-xs text-light/50 mt-1">This will be used for initial screening (Max 1,000 characters).</p>
            </div>
            
            <div>
                <label for="discipline" class="block text-sm font-medium text-light/80 mb-2">
                    Primary Academic Discipline <span class="text-primary">*</span>
                </label>
                <select id="discipline" name="discipline" required 
                         class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    <option value="" disabled selected>Select the main field of research</option>
                    <option value="ai_ml">Artificial Intelligence & Machine Learning</option>
                    <option value="biotech">Biotechnology & Life Sciences</option>
                    <option value="materials">Advanced Materials & Nanotech</option>
                    <option value="energy">Renewable Energy & Sustainability</option>
                    <option value="quantum">Quantum Computing & Physics</option>
                    <option value="aero">Aerospace & Robotics</option>
                    <option value="other">Other</option>
                </select>
            </div>


            {{-- NEW NAVIGATION SECTION --}}
            <div class="flex justify-between pt-4">
                
                {{-- 1. SAVE DRAFT (Stays on this page) --}}
                <button type="submit" name="action" value="draft"
                        class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary">
                    <i class="fas fa-save mr-2"></i> Save Draft
                </button>

                {{-- 2. SAVE AND CONTINUE (Goes to Step 2) --}}
                <button type="submit" name="action" value="continue"
                        class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Save & Continue to Team Details <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection