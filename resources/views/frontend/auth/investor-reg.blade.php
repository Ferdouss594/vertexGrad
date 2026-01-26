@php
    // Assuming these variables are available from a config or base layout
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
@endphp

@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-lg p-8 rounded-xl shadow-2xl border border-primary/20 bg-cardLight/70">
        
        <i class="fas fa-hand-holding-usd text-5xl text-primary mb-4" 
           style="filter: drop-shadow(0 0 8px {{ $primaryColor }});">
        </i>
        <h2 class="text-4xl font-bold text-center text-light mb-2">
            Investor Registration
        </h2>
        <p class="text-center text-light/70 mb-8">
            Please provide your details for institutional verification.
        </p>

        <form action="/register/investor" method="POST">
            @csrf
            
            {{-- Personal Details --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-light/80 mb-2">Full Name</label>
                <input type="text" id="name" name="name" required 
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-light/80 mb-2">Email Address (Business)</label>
                <input type="email" id="email" name="email" required 
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
            </div>

            <div class="mb-8 grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-light/80 mb-2">Password</label>
                    <input type="password" id="password" name="password" required 
                           class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-light/80 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required 
                           class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
                </div>
            </div>

            <hr class="border-t border-primary/20 my-6">

            {{-- Institutional Details --}}
            <div class="mb-6">
                <label for="company" class="block text-sm font-medium text-light/80 mb-2">Fund/Company Name</label>
                <input type="text" id="company" name="company" required 
                       class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
            </div>

            <div class="mb-8">
                <label for="fund_type" class="block text-sm font-medium text-light/80 mb-2">Investment Focus/Type</label>
                <select id="fund_type" name="fund_type" required 
                        class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    <option value="" disabled selected>Select focus area</option>
                    <option value="vc">Venture Capital</option>
                    <option value="pe">Private Equity</option>
                    <option value="angel">Angel Investor</option>
                    <option value="corp">Corporate VC/R&D</option>
                    <option value="family">Family Office</option>
                </select>
            </div>

            <button type="submit" 
                    class="w-full {{ $btnPrimaryClass }} text-lg py-3 shadow-neon_sm">
                <i class="fas fa-check-circle mr-2"></i> Register & Request Verification
            </button>
            
            <p class="mt-6 text-center text-light/60 text-xs">
                By registering, you agree to the <a href="/terms" class="text-primary hover:underline">Terms of Service</a> and Privacy Policy.
            </p>
        </form>

        <p class="mt-8 text-center text-light/60 text-sm">
            Are you a project creator?
            <a href="/submit-project" class="text-primary hover:text-light font-medium ml-1">
                Start Submission Here
            </a>
        </p>
    </div>
</div>
@endsection