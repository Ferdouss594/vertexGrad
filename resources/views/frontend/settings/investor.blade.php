@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="mb-10 border-b border-theme-border pb-4">
            <h1 class="text-4xl font-extrabold text-theme-text">
                Investor Account <span class="text-brand-accent">Settings</span>
            </h1>
            <p class="text-xl text-theme-muted mt-1">Manage your investment profile and deal flow preferences.</p>
        </header>

        <form action="/settings/investor/update" method="POST" class="space-y-8">
            @csrf

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">Fund & Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-theme-muted mb-2">Primary Contact Name</label>
                        <input type="text" id="contact_name" name="contact_name" value="Sarah V. Kim" required
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">
                    </div>
                    <div>
                        <label for="fund_name" class="block text-sm font-medium text-theme-muted mb-2">Fund/Firm Name</label>
                        <input type="text" id="fund_name" name="fund_name" value="Venture Capital Fund" required
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">
                    </div>
                </div>
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">Investment Focus</h2>
                <p class="text-theme-muted mb-4">Customize your deal flow based on your fund's mandate.</p>
                <div class="space-y-3">
                    <label for="min_investment" class="block text-sm font-medium text-theme-muted mb-2">Preferred Investment Size (Min)</label>
                    <input type="number" id="min_investment" name="min_investment" value="250000" min="50000" step="10000"
                           class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">

                    <label for="disciplines" class="block text-sm font-medium text-theme-muted mb-2 pt-4">Target Disciplines</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center text-theme-text"><input type="checkbox" name="focus[]" value="ai" checked class="form-checkbox h-5 w-5 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent"><span class="ml-3">AI & ML</span></label>
                        <label class="flex items-center text-theme-text"><input type="checkbox" name="focus[]" value="biotech" checked class="form-checkbox h-5 w-5 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent"><span class="ml-3">Biotech</span></label>
                        <label class="flex items-center text-theme-text"><input type="checkbox" name="focus[]" value="energy" class="form-checkbox h-5 w-5 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent"><span class="ml-3">Energy</span></label>
                        <label class="flex items-center text-theme-text"><input type="checkbox" name="focus[]" value="quantum" checked class="form-checkbox h-5 w-5 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent"><span class="ml-3">Quantum</span></label>
                    </div>
                </div>
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">Compliance & Documentation</h2>
                <p class="text-theme-muted mb-4">Your current accreditation status is: <strong class="text-green-600">Verified</strong>.</p>
                <a href="/settings/investor/compliance" class="text-brand-accent hover:underline font-medium">
                    View / Update Accreditation Documents <i class="fas fa-file-upload ml-2"></i>
                </a>
            </div>

            <div class="pt-4 text-right">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                    Save Deal Flow Preferences
                </button>
            </div>
        </form>

    </div>
</div>
@endsection