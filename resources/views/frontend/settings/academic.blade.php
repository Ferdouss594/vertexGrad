@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $cardBg = '#1E293B';
@endphp

@extends('frontend.layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-10 border-b border-light/20 pb-4">
            <h1 class="text-4xl font-extrabold text-light">
                👤 Academic Account Settings
            </h1>
            <p class="text-xl text-primary mt-1">Manage your profile, institution, and notifications.</p>
        </header>

        <form action="/settings/academic/update" method="POST" class="space-y-8">
            @csrf
            
            {{-- Personal Profile Section --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Personal & Contact Info</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-light/80 mb-2">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="Dr. Elias Thorne" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="academic_title" class="block text-sm font-medium text-light/80 mb-2">Academic Title</label>
                        <input type="text" id="academic_title" name="academic_title" value="Principal Investigator" 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-light/80 mb-2">Email Address (Login)</label>
                        <input type="email" id="email" name="email" value="thorne@uni.edu" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-light/80 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="+1-555-123-4567" 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            {{-- Institutional Section --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Institutional Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="institution" class="block text-sm font-medium text-light/80 mb-2">Institution Name</label>
                        <input type="text" id="institution" name="institution" value="Wageningen University & Research" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="department" class="block text-sm font-medium text-light/80 mb-2">Department / Lab</label>
                        <input type="text" id="department" name="department" value="Robotics and Sensing Lab" 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            {{-- Notifications Section --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Notification Preferences</h2>
                <div class="space-y-3">
                    <label class="flex items-center text-light/80">
                        <input type="checkbox" name="notif_status_change" checked 
                               class="form-checkbox h-5 w-5 text-primary border-primary/30 bg-dark rounded focus:ring-primary">
                        <span class="ml-3">Email me when my project status changes (e.g., Vetted, Rejected).</span>
                    </label>
                    <label class="flex items-center text-light/80">
                        <input type="checkbox" name="notif_investor_interest" 
                               class="form-checkbox h-5 w-5 text-primary border-primary/30 bg-dark rounded focus:ring-primary">
                        <span class="ml-3">Email me when an investor begins Due Diligence on my project.</span>
                    </label>
                </div>
            </div>

            {{-- Password & Security --}}
            <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                <h2 class="text-2xl font-semibold text-primary mb-4">Security</h2>
                <a href="/settings/password/change" class="text-primary hover:underline font-medium">
                    Change Password <i class="fas fa-lock ml-2"></i>
                </a>
            </div>

            {{-- Save Button --}}
            <div class="pt-4 text-right">
                <button type="submit" class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Save All Changes
                </button>
            </div>
        </form>

    </div>
</div>
@endsection