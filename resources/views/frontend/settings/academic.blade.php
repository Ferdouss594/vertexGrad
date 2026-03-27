@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-10 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(isset($projects) && $projects->count())
            <div class="mb-10">
                <header class="mb-10 rounded-2xl p-8 border border-theme-border theme-panel shadow-brand-soft">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <h1 class="text-4xl font-extrabold text-theme-text mb-2">
                                Academic <span class="text-brand-accent">Dashboard</span>
                            </h1>
                            <p class="text-lg text-theme-muted">
                                Track your projects, scan results, and account settings in one professional workspace.
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 min-w-[260px]">
                            <div class="rounded-xl p-4 text-center border border-theme-border bg-theme-surface-2">
                                <div class="text-2xl font-extrabold text-theme-text">{{ isset($projects) ? $projects->count() : 0 }}</div>
                                <div class="text-sm text-theme-muted mt-1">Projects</div>
                            </div>
                            <div class="rounded-xl p-4 text-center border border-theme-border bg-theme-surface-2">
                                <div class="text-2xl font-extrabold text-theme-text">
                                    {{ isset($projects) ? $projects->where('status', 'awaiting_manual_review')->count() : 0 }}
                                </div>
                                <div class="text-sm text-theme-muted mt-1">Awaiting Approval</div>
                            </div>
                        </div>
                    </div>
                </header>

                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-green-500/30 bg-green-500/10 px-6 py-4 shadow-lg text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 px-6 py-4 shadow-lg text-red-600">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <form action="/settings/academic/update" method="POST" class="space-y-8">
            @csrf

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">Personal & Contact Info</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-theme-muted mb-2">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="Dr. Elias Thorne" required
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">
                    </div>
                    <div>
                        <label for="academic_title" class="block text-sm font-medium text-theme-muted mb-2">Academic Title</label>
                        <input type="text" id="academic_title" name="academic_title" value="Principal Investigator"
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-theme-muted mb-2">Email Address (Login)</label>
                        <input type="email" id="email" name="email" value="thorne@uni.edu" required
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-theme-muted mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="+1-555-123-4567"
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">
                    </div>
                </div>
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">Institutional Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="institution" class="block text-sm font-medium text-theme-muted mb-2">Institution Name</label>
                        <input type="text" id="institution" name="institution" value="Wageningen University & Research" required
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">
                    </div>
                    <div>
                        <label for="department" class="block text-sm font-medium text-theme-muted mb-2">Department / Lab</label>
                        <input type="text" id="department" name="department" value="Robotics and Sensing Lab"
                               class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent">
                    </div>
                </div>
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">Notification Preferences</h2>
                <div class="space-y-3">
                    <label class="flex items-center text-theme-text">
                        <input type="checkbox" name="notif_status_change" checked
                               class="form-checkbox h-5 w-5 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent">
                        <span class="ml-3">Email me when my project status changes.</span>
                    </label>
                    <label class="flex items-center text-theme-text">
                        <input type="checkbox" name="notif_investor_interest"
                               class="form-checkbox h-5 w-5 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent">
                        <span class="ml-3">Email me when an investor begins due diligence on my project.</span>
                    </label>
                </div>
            </div>

            <div class="theme-panel p-6 rounded-xl">
                <h2 class="text-2xl font-semibold text-brand-accent mb-4">Security</h2>
                <a href="/settings/password/change" class="text-brand-accent hover:underline font-medium">
                    Change Password <i class="fas fa-lock ml-2"></i>
                </a>
            </div>

            <div class="pt-4 text-right">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                    Save All Changes
                </button>
            </div>
        </form>

    </div>
</div>
@endsection