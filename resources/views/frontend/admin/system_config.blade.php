@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $cardBg = '#1E293B';
    
    // Placeholder Data for System Settings
    $currentTheme = 'dark_neon';
    $currentLanguage = 'en';
    $currentFee = 5; // percentage
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-10 border-b border-light/20 pb-4">
            <a href="/admin/dashboard" class="text-sm text-primary hover:text-light/80"><i class="fas fa-arrow-left mr-2"></i> Back to Admin Dashboard</a>
            <h1 class="text-4xl font-extrabold text-light mt-2">
                🌐 System & Platform Configuration
            </h1>
            <p class="text-xl text-danger mt-1">Manage global display settings, fees, and feature toggles.</p>
        </header>

        <form action="/admin/system/update" method="POST" class="space-y-8">
            @csrf
            
            {{-- Global Appearance Section --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Global Appearance & Localization</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="theme" class="block text-sm font-medium text-light/80 mb-2">Default Theme</label>
                        <select id="theme" name="theme" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                            <option value="dark_neon" {{ $currentTheme == 'dark_neon' ? 'selected' : '' }}>Dark Neon (Current)</option>
                            <option value="light_minimal">Light Minimal</option>
                        </select>
                        <p class="text-xs text-light/60 mt-1">Changes the default color scheme for all users.</p>
                    </div>
                    <div>
                        <label for="language" class="block text-sm font-medium text-light/80 mb-2">Default Language</label>
                        <select id="language" name="language" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                            <option value="en" {{ $currentLanguage == 'en' ? 'selected' : '' }}>English (EN)</option>
                            <option value="ar">Arabic (AR)</option>
                            <option value="fr">French (FR)</option>
                        </select>
                        <p class="text-xs text-light/60 mt-1">Sets the default localization for new users.</p>
                    </div>
                </div>
            </div>

            {{-- Financial & Policy Section --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Financial & Policy Settings</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="platform_fee" class="block text-sm font-medium text-light/80 mb-2">Platform Fee (%)</label>
                        <input type="number" id="platform_fee" name="platform_fee" value="{{ $currentFee }}" min="0" max="10" step="0.5" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                        <p class="text-xs text-light/60 mt-1">The percentage fee applied to all successfully funded projects.</p>
                    </div>
                    <div>
                        <label for="min_funding_limit" class="block text-sm font-medium text-light/80 mb-2">Minimum Funding Limit (USD)</label>
                        <input type="number" id="min_funding_limit" name="min_funding_limit" value="50000" min="10000" step="10000" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                        <p class="text-xs text-light/60 mt-1">Projects below this value are automatically flagged.</p>
                    </div>
                </div>
            </div>
            
            {{-- Feature Toggles --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Feature Toggles</h2>
                <div class="space-y-3">
                    <label class="flex items-center text-light/80">
                        <input type="checkbox" name="investor_signups_enabled" checked 
                               class="form-checkbox h-5 w-5 text-primary border-primary/30 bg-dark rounded focus:ring-primary">
                        <span class="ml-3">Enable Investor Sign-ups (Allow new investors to register).</span>
                    </label>
                    <label class="flex items-center text-light/80">
                        <input type="checkbox" name="academic_submissions_open" 
                               class="form-checkbox h-5 w-5 text-primary border-primary/30 bg-dark rounded focus:ring-primary">
                        <span class="ml-3">Open Project Submissions (Allow academics to start new projects).</span>
                    </label>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="pt-4 text-right">
                <button type="submit" class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Apply Global Settings
                </button>
            </div>
        </form>

    </div>
</div>
@endsection