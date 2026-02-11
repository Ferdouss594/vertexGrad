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
        
        {{-- Progress Bar (100% complete *for data entry*) --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-light mb-2">Step 4 of 4: Account Setup</h3>
            <div class="h-2 bg-dark rounded-full overflow-hidden">
                {{-- Tailwind classes for 100% progress --}}
                <div class="h-full bg-primary" style="width: 100%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-light mb-2">
            Create Your Academic Account
        </h2>
        <p class="text-lg text-light/70 mb-10">
            This account will allow you to track the progress of your submission and manage all future projects.
        </p>

        <form action="/submit-project/step4" method="POST" class="space-y-8">
            @csrf
            
            {{-- Account Credentials --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Login Credentials (Principal Investigator)</h4>
                <p class="text-sm text-light/70 mb-6">
                    Use your official institutional email for primary contact.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-light/80 mb-2">Email Address <span class="text-primary">*</span></label>
                        <input type="email" id="email" name="email" required 
                               placeholder="your.name@university.edu"
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-light/80 mb-2">Create Password <span class="text-primary">*</span></label>
                        <input type="password" id="password" name="password" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        {{-- Added to ensure the form has the necessary fields for Laravel's built-in validation --}}
                        <label for="password_confirmation" class="block text-sm font-medium text-light/80 mb-2">Confirm Password <span class="text-primary">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            {{-- Terms and Conditions Checkbox --}}
            <div class="mt-8">
                <label class="flex items-center text-light/80">
                    <input type="checkbox" name="terms_agreement" required 
                           class="form-checkbox h-5 w-5 text-primary border-primary/30 bg-dark rounded focus:ring-primary">
                    <span class="ml-3 text-sm">
                        I agree to the <a href="/terms" target="_blank" class="text-primary underline">Read Terms & Conditions</a> and confirm the data submitted is accurate. <span class="text-primary">*</span>
                    </span>
                </label>
            </div>
            
            {{-- Navigation Buttons --}}
            <div class="flex justify-between pt-4">
                {{-- Link back to Step 3 --}}
                <a href="/submit-project/step3" 
                   class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Budget
                </a>
                
                {{-- Submit to Final Confirmation --}}
                <button type="submit" 
                        class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Create Account & Review Submission <i class="fas fa-file-alt ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection