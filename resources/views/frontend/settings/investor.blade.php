@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $cardBg = '#1E293B';
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-10 border-b border-light/20 pb-4">
            <h1 class="text-4xl font-extrabold text-light">
                🏦 Investor Account Settings
            </h1>
            <p class="text-xl text-success mt-1">Manage your investment profile and deal flow preferences.</p>
        </header>

        <form action="/settings/investor/update" method="POST" class="space-y-8">
            @csrf
            
            {{-- Investor Profile Section --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-success mb-4">Fund & Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-light/80 mb-2">Primary Contact Name</label>
                        <input type="text" id="contact_name" name="contact_name" value="Sarah V. Kim" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="fund_name" class="block text-sm font-medium text-light/80 mb-2">Fund/Firm Name</label>
                        <input type="text" id="fund_name" name="fund_name" value="Venture Capital Fund" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            {{-- Investment Preferences --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-success mb-4">Investment Focus</h2>
                <p class="text-light/70 mb-4">Customize your deal flow based on your fund's mandate.</p>
                <div class="space-y-3">
                    <label for="min_investment" class="block text-sm font-medium text-light/80 mb-2">Preferred Investment Size (Min)</label>
                    <input type="number" id="min_investment" name="min_investment" value="250000" min="50000" step="10000"
                           class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">

                    <label for="disciplines" class="block text-sm font-medium text-light/80 mb-2 pt-4">Target Disciplines</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center text-light/80"><input type="checkbox" name="focus[]" value="ai" checked class="form-checkbox h-5 w-5 text-success border-primary/30 bg-dark rounded focus:ring-success"><span class="ml-3">AI & ML</span></label>
                        <label class="flex items-center text-light/80"><input type="checkbox" name="focus[]" value="biotech" checked class="form-checkbox h-5 w-5 text-success border-primary/30 bg-dark rounded focus:ring-success"><span class="ml-3">Biotech</span></label>
                        <label class="flex items-center text-light/80"><input type="checkbox" name="focus[]" value="energy" class="form-checkbox h-5 w-5 text-success border-primary/30 bg-dark rounded focus:ring-success"><span class="ml-3">Energy</span></label>
                        <label class="flex items-center text-light/80"><input type="checkbox" name="focus[]" value="quantum" checked class="form-checkbox h-5 w-5 text-success border-primary/30 bg-dark rounded focus:ring-success"><span class="ml-3">Quantum</span></label>
                    </div>
                </div>
            </div>

            {{-- Compliance & Documents --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-success mb-4">Compliance & Documentation</h2>
                <p class="text-light/70 mb-4">Your current accreditation status is: <strong class="text-success">Verified</strong>.</p>
                <a href="/settings/investor/compliance" class="text-primary hover:underline font-medium">
                    View / Update Accreditation Documents <i class="fas fa-file-upload ml-2"></i>
                </a>
            </div>

            {{-- Save Button --}}
            <div class="pt-4 text-right">
                <button type="submit" class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Save Deal Flow Preferences
                </button>
            </div>
        </form>

    </div>
</div>
@endsection